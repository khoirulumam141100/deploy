<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\Rt;
use App\Models\Rw;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WasteDeposit;
use App\Models\WasteType;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard.
     */
    public function index(Request $request)
    {
        // Get filter
        $selectedRtId = $request->input('rt_id');
        $selectedRwId = $request->input('rw_id');

        // Base queries with optional RT filter
        $residentQuery = User::residents();
        $transactionQuery = Transaction::query();

        if ($selectedRtId) {
            $residentQuery->where('rt_id', $selectedRtId);
            $transactionQuery->where('rt_id', $selectedRtId);
        } elseif ($selectedRwId) {
            $residentQuery->whereHas('rt', fn($q) => $q->where('rw_id', $selectedRwId));
            $transactionQuery->whereHas('rt', fn($q) => $q->where('rw_id', $selectedRwId));
        }

        // Statistics
        $stats = [
            'total_residents' => (clone $residentQuery)->active()->count(),
            'pending_residents' => User::residents()->pending()->count(),
            'total_balance' => $this->calculateBalance($selectedRtId, $selectedRwId),
            'formatted_balance' => 'Rp ' . number_format($this->calculateBalance($selectedRtId, $selectedRwId), 0, ',', '.'),
            'events_this_month' => Event::thisMonth()->count(),
        ];

        // Bank Sampah Statistics (filtered)
        $wasteDepositQuery = WasteDeposit::query();
        if ($selectedRtId) {
            $wasteDepositQuery->whereHas('user', fn($q) => $q->where('rt_id', $selectedRtId));
        } elseif ($selectedRwId) {
            $wasteDepositQuery->whereHas('user.rt', fn($q) => $q->where('rw_id', $selectedRwId));
        }

        $wasteStats = [
            'total_deposits' => (clone $wasteDepositQuery)->count(),
            'total_weight' => (clone $wasteDepositQuery)->sum('weight'),
            'total_value' => (clone $wasteDepositQuery)->sum('total_amount'),
            'formatted_value' => 'Rp ' . number_format((clone $wasteDepositQuery)->sum('total_amount'), 0, ',', '.'),
            'active_depositors' => (clone $wasteDepositQuery)->distinct('user_id')->count('user_id'),
            'pending_redemptions' => \App\Models\WasteRedemption::pending()->count(),
        ];

        // RT/RW Statistics (filtered by RW if selected)
        $rtStatsQuery = Rt::with('rw')
            ->withCount(['residents' => fn($q) => $q->active()]);

        if ($selectedRwId) {
            $rtStatsQuery->where('rw_id', $selectedRwId);
        }

        $rtStats = $rtStatsQuery->get()
            ->map(function ($rt) {
                return [
                    'id' => $rt->id,
                    'name' => $rt->full_name,
                    'resident_count' => $rt->residents_count,
                    'balance' => $rt->total_balance,
                    'formatted_balance' => $rt->formatted_balance,
                ];
            });

        // Pending approvals (latest 5)
        $pendingResidents = User::residents()
            ->pending()
            ->with(['rt.rw'])
            ->latest()
            ->take(5)
            ->get();

        // Finance summary by category
        $categories = Category::all();

        // Chart Data: Income vs Expense per Month (Current Year)
        $monthlyStatsQuery = Transaction::selectRaw('MONTH(transaction_date) as month, type, SUM(amount) as total')
            ->whereYear('transaction_date', date('Y'));

        if ($selectedRtId) {
            $monthlyStatsQuery->where('rt_id', $selectedRtId);
        } elseif ($selectedRwId) {
            $monthlyStatsQuery->whereHas('rt', fn($q) => $q->where('rw_id', $selectedRwId));
        }

        $monthlyStats = $monthlyStatsQuery->groupBy('month', 'type')->get();

        $months = [];
        $incomeData = [];
        $expenseData = [];

        // Initialize arrays with 0 for all 12 months
        for ($i = 1; $i <= 12; $i++) {
            $months[] = \Carbon\Carbon::create()->month($i)->translatedFormat('F');
            $incomeData[$i] = 0;
            $expenseData[$i] = 0;
        }

        foreach ($monthlyStats as $stat) {
            if ($stat->type === \App\Enums\TransactionType::INCOME) {
                $incomeData[$stat->month] = (float) $stat->total;
            } elseif ($stat->type === \App\Enums\TransactionType::EXPENSE) {
                $expenseData[$stat->month] = (float) $stat->total;
            }
        }

        // Chart Data: Transaction Breakdown by Category
        $categoryStats = Category::withCount('transactions')
            ->get()
            ->map(function ($category) {
                return [
                    'name' => $category->name,
                    'count' => $category->transactions_count,
                    'color' => $category->color,
                ];
            });

        // Upcoming events (latest 5)
        $upcomingEvents = Event::upcoming()
            ->take(5)
            ->get();

        // Recent waste deposits (filtered)
        $recentDepositsQuery = WasteDeposit::with(['user.rt', 'wasteType']);
        if ($selectedRtId) {
            $recentDepositsQuery->whereHas('user', fn($q) => $q->where('rt_id', $selectedRtId));
        } elseif ($selectedRwId) {
            $recentDepositsQuery->whereHas('user.rt', fn($q) => $q->where('rw_id', $selectedRwId));
        }
        $recentDeposits = $recentDepositsQuery->latest('deposit_date')->take(5)->get();

        // Fix: Reset array keys to ensure JSON array [0,1,2...] instead of object {"1":0}
        $incomeData = array_values($incomeData);
        $expenseData = array_values($expenseData);

        // Get RWs and RTs for filter (RTs filtered by selected RW)
        $rws = Rw::orderBy('name')->get();
        $rtsQuery = Rt::with('rw')->orderBy('name');
        if ($selectedRwId) {
            $rtsQuery->where('rw_id', $selectedRwId);
        }
        $rts = $rtsQuery->get();

        return view('admin.dashboard', compact(
            'stats',
            'wasteStats',
            'rtStats',
            'pendingResidents',
            'categories',
            'upcomingEvents',
            'recentDeposits',
            'months',
            'incomeData',
            'expenseData',
            'categoryStats',
            'rws',
            'rts',
            'selectedRtId',
            'selectedRwId'
        ));
    }

    /**
     * Calculate total balance with optional RT/RW filter.
     */
    private function calculateBalance(?int $rtId = null, ?int $rwId = null): float
    {
        $query = Transaction::query();

        if ($rtId) {
            $query->where('rt_id', $rtId);
        } elseif ($rwId) {
            $query->whereHas('rt', fn($q) => $q->where('rw_id', $rwId));
        }

        $income = (clone $query)->where('type', 'income')->sum('amount');
        $expense = (clone $query)->where('type', 'expense')->sum('amount');

        return (float) ($income - $expense);
    }
}
