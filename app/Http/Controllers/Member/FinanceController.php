<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    /**
     * Display finance overview (read-only).
     */
    public function index()
    {
        $categories = Category::all();
        $totalBalance = Category::getTotalBalance();
        $formattedBalance = Category::getFormattedTotalBalance();

        return view('member.finance.index', compact('categories', 'totalBalance', 'formattedBalance'));
    }

    /**
     * Display transactions for a specific category (read-only).
     */
    public function category(Request $request, Category $category)
    {
        $query = $category->transactions()->with('user');

        // Filter by date range
        if ($request->filled('from')) {
            $query->where('transaction_date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->where('transaction_date', '<=', $request->to);
        }

        $transactions = $query->latest('transaction_date')->paginate(15)->withQueryString();

        return view('member.finance.category', compact('category', 'transactions'));
    }
}
