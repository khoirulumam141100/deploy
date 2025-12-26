<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TransactionType;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FinanceController extends Controller
{
    /**
     * Display finance overview.
     */
    public function index()
    {
        $categories = Category::withCount('transactions')->get();
        $totalBalance = Category::getTotalBalance();
        $recentTransactions = Transaction::with(['category', 'user'])
            ->latest('transaction_date')
            ->take(10)
            ->get();

        return view('admin.finance.index', compact('categories', 'totalBalance', 'recentTransactions'));
    }

    /**
     * Display printable finance report.
     */
    public function report(Request $request)
    {
        $query = Transaction::with(['category', 'user']);

        // Filter by date range
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        $query->byDateRange($startDate, $endDate);

        $transactions = $query->orderBy('transaction_date', 'asc')->get();

        // Calculate summary
        $summary = [
            'total_income' => $transactions->where('type', TransactionType::INCOME)->sum('amount'),
            'total_expense' => $transactions->where('type', TransactionType::EXPENSE)->sum('amount'),
            'initial_balance' => 0, // In complex apps, calculate previous balance. Assume 0 or period-based for now.
        ];
        $summary['net_change'] = $summary['total_income'] - $summary['total_expense'];

        return view('admin.finance.report', compact('transactions', 'summary', 'startDate', 'endDate'));
    }

    /**
     * Display transactions for a specific category.
     */
    public function category(Request $request, Category $category)
    {
        $query = $category->transactions()->with('user');

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by date range
        if ($request->filled('from')) {
            $query->where('transaction_date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->where('transaction_date', '<=', $request->to);
        }

        $transactions = $query->latest('transaction_date')->paginate(15)->withQueryString();
        $types = TransactionType::options();

        return view('admin.finance.category', compact('category', 'transactions', 'types'));
    }

    /**
     * Show form to create a new transaction.
     */
    public function create(Request $request)
    {
        $categories = Category::all();
        $types = TransactionType::options();
        $selectedCategory = $request->category;

        return view('admin.finance.create', compact('categories', 'types', 'selectedCategory'));
    }

    /**
     * Store a new transaction.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'type' => ['required', Rule::enum(TransactionType::class)],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
            'transaction_date' => ['required', 'date'],
        ]);

        $transaction = Transaction::create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

        \App\Services\ActivityLogger::log(
            'create',
            "Menambahkan transaksi baru: {$transaction->formatted_amount} ({$transaction->description})",
            $transaction
        );

        return redirect()->route('admin.finance.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    /**
     * Show form to edit a transaction.
     */
    public function edit(Transaction $transaction)
    {
        $categories = Category::all();
        $types = TransactionType::options();

        return view('admin.finance.edit', compact('transaction', 'categories', 'types'));
    }

    /**
     * Update a transaction.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'type' => ['required', Rule::enum(TransactionType::class)],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
            'transaction_date' => ['required', 'date'],
        ]);

        $transaction->update($validated);

        \App\Services\ActivityLogger::log(
            'update',
            "Mengubah transaksi: {$transaction->formatted_amount} ({$transaction->description})",
            $transaction
        );

        return redirect()->route('admin.finance.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Delete a transaction.
     */
    public function destroy(Transaction $transaction)
    {
        $description = "Menghapus transaksi: {$transaction->formatted_amount} ({$transaction->description})";

        // Log before delete
        \App\Services\ActivityLogger::log('delete', $description, $transaction);

        $transaction->delete();

        return back()->with('success', 'Transaksi berhasil dihapus.');
    }
}
