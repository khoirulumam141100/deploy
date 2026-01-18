<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use App\Models\WasteDeposit;

class DashboardController extends Controller
{
    /**
     * Display warga dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        $user->load(['rt.rw', 'wasteDeposits.wasteType']);

        // Personal waste balance
        $wasteBalance = $user->waste_balance ?? 0;
        $formattedWasteBalance = 'Rp ' . number_format($wasteBalance, 0, ',', '.');

        // Waste deposit stats
        $wasteStats = [
            'total_deposits' => $user->wasteDeposits()->count(),
            'total_weight' => $user->wasteDeposits()->sum('weight'),
            'total_earned' => $user->wasteDeposits()->sum('total_amount'),
            'formatted_earned' => 'Rp ' . number_format($user->wasteDeposits()->sum('total_amount'), 0, ',', '.'),
        ];

        // Recent waste deposits
        $recentDeposits = $user->wasteDeposits()
            ->with('wasteType')
            ->latest('deposit_date')
            ->take(5)
            ->get();

        // Stats
        $upcomingEventsCount = Event::upcoming()->count();
        $totalBalance = Category::getTotalBalance();
        $formattedBalance = Category::getFormattedTotalBalance();
        $totalActiveResidents = User::residents()->active()->count();

        // RT-specific resident count
        $rtResidentCount = 0;
        if ($user->rt_id) {
            $rtResidentCount = User::residents()->active()->where('rt_id', $user->rt_id)->count();
        }

        // Upcoming events (next 5)
        $upcomingEvents = Event::upcoming()->take(5)->get();

        // Finance summary by RT (if user has RT)
        $rtFinance = null;
        if ($user->rt) {
            $income = $user->rt->transactions()->where('type', 'income')->sum('amount');
            $expense = $user->rt->transactions()->where('type', 'expense')->sum('amount');
            $rtFinance = [
                'name' => $user->rt->full_name,
                'income' => $income,
                'expense' => $expense,
                'balance' => $income - $expense,
                'formatted_balance' => 'Rp ' . number_format($income - $expense, 0, ',', '.'),
            ];
        }

        // Finance categories with calculated balance per RT
        $categories = Category::all()->map(function ($category) use ($user) {
            $query = $category->transactions();

            if ($user->rt_id) {
                $query->where('rt_id', $user->rt_id);
            }

            $income = (clone $query)->where('type', 'income')->sum('amount');
            $expense = (clone $query)->where('type', 'expense')->sum('amount');

            $category->calculated_balance = $income - $expense;
            $category->formatted_balance = 'Rp ' . number_format($income - $expense, 0, ',', '.');

            return $category;
        });

        return view('warga.dashboard', compact(
            'user',
            'wasteBalance',
            'formattedWasteBalance',
            'wasteStats',
            'recentDeposits',
            'upcomingEventsCount',
            'totalBalance',
            'formattedBalance',
            'totalActiveResidents',
            'rtResidentCount',
            'upcomingEvents',
            'rtFinance',
            'categories'
        ));
    }
}
