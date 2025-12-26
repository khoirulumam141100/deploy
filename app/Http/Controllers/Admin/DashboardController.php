<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard.
     */
    public function index()
    {
        // Statistics
        $stats = [
            'total_members' => User::members()->active()->count(),
            'pending_members' => User::members()->pending()->count(),
            'total_balance' => Category::getTotalBalance(),
            'formatted_balance' => Category::getFormattedTotalBalance(),
            'events_this_month' => Event::thisMonth()->count(),
        ];

        // Pending approvals (latest 5)
        $pendingMembers = User::members()
            ->pending()
            ->latest()
            ->take(5)
            ->get();

        // Finance summary by category
        $categories = Category::all();

        // Chart Data: Income vs Expense per Month (Current Year)
        $monthlyStats = \App\Models\Transaction::selectRaw('MONTH(transaction_date) as month, type, SUM(amount) as total')
            ->whereYear('transaction_date', date('Y'))
            ->groupBy('month', 'type')
            ->get();

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
        $categoryStats = \App\Models\Category::withCount('transactions')
            ->get()
            ->map(function ($category) {
                return [
                    'name' => $category->name,
                    'count' => $category->transactions_count,
                    'color' => $category->color, // Assuming color is like 'blue', 'green'
                ];
            });

        // Upcoming events (latest 5)
        $upcomingEvents = Event::upcoming()
            ->take(5)
            ->get();

        // Fix: Reset array keys to ensure JSON array [0,1,2...] instead of object {"1":0}
        $incomeData = array_values($incomeData);
        $expenseData = array_values($expenseData);

        return view('admin.dashboard', compact(
            'stats',
            'pendingMembers',
            'categories',
            'upcomingEvents',
            'months',
            'incomeData',
            'expenseData',
            'categoryStats'
        ));
    }
}
