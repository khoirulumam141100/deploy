<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    /**
     * Display finance overview (read-only for warga).
     */
    public function index()
    {
        $user = auth()->user();

        // Categories with balance (as collection of objects with methods)
        $categories = Category::all()->map(function ($category) use ($user) {
            // Calculate based on user's RT if available
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

        // Total income and expense
        $totalIncome = Transaction::when($user->rt_id, fn($q) => $q->where('rt_id', $user->rt_id))
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = Transaction::when($user->rt_id, fn($q) => $q->where('rt_id', $user->rt_id))
            ->where('type', 'expense')
            ->sum('amount');

        $formattedBalance = 'Rp ' . number_format($totalIncome - $totalExpense, 0, ',', '.');

        // Recent transactions
        $recentTransactions = Transaction::with(['category'])
            ->when($user->rt_id, fn($q) => $q->where('rt_id', $user->rt_id))
            ->latest('transaction_date')
            ->take(10)
            ->get();

        return view('warga.finance.index', compact('user', 'categories', 'totalIncome', 'totalExpense', 'formattedBalance', 'recentTransactions'));
    }

    /**
     * Display transactions for a specific category.
     */
    public function category(Request $request, Category $category)
    {
        $user = auth()->user();

        $query = $category->transactions()->with('user');

        // Filter by user's RT
        if ($user->rt_id) {
            $query->where('rt_id', $user->rt_id);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by month
        if ($request->filled('month')) {
            $month = $request->month;
            $query->whereYear('transaction_date', substr($month, 0, 4))
                ->whereMonth('transaction_date', substr($month, 5, 2));
        }

        $transactions = $query->latest('transaction_date')->paginate(15)->withQueryString();

        // Calculate category stats
        $totalIncome = $category->transactions()->when($user->rt_id, fn($q) => $q->where('rt_id', $user->rt_id))->where('type', 'income')->sum('amount');
        $totalExpense = $category->transactions()->when($user->rt_id, fn($q) => $q->where('rt_id', $user->rt_id))->where('type', 'expense')->sum('amount');

        return view('warga.finance.category', compact('category', 'transactions', 'totalIncome', 'totalExpense'));
    }
}
