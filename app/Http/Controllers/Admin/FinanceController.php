<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TransactionType;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Rt;
use App\Models\Rw;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FinanceController extends Controller
{
    /**
     * Display finance overview.
     */
    public function index(Request $request)
    {
        $selectedRtId = $request->input('rt_id');
        $selectedRwId = $request->input('rw_id');

        // Get categories with transaction counts
        $categories = Category::withCount('transactions')->get();

        // Calculate balance based on filter
        $totalBalance = $this->calculateBalance($selectedRtId, $selectedRwId);

        // Recent transactions with optional filter
        $recentTransactionsQuery = Transaction::with(['category', 'user', 'rt.rw'])
            ->latest('transaction_date');

        if ($selectedRtId) {
            $recentTransactionsQuery->where('rt_id', $selectedRtId);
        } elseif ($selectedRwId) {
            $recentTransactionsQuery->whereHas('rt', fn($q) => $q->where('rw_id', $selectedRwId));
        }

        $recentTransactions = $recentTransactionsQuery->take(10)->get();

        // RT breakdown (filtered by RW if selected)
        $rtQuery = Rt::with('rw');
        if ($selectedRwId) {
            $rtQuery->where('rw_id', $selectedRwId);
        }
        $rtBreakdown = $rtQuery->get()->map(function ($rt) {
            $income = Transaction::where('rt_id', $rt->id)->where('type', 'income')->sum('amount');
            $expense = Transaction::where('rt_id', $rt->id)->where('type', 'expense')->sum('amount');
            return [
                'id' => $rt->id,
                'name' => $rt->full_name,
                'income' => $income,
                'expense' => $expense,
                'balance' => $income - $expense,
                'formatted_balance' => 'Rp ' . number_format($income - $expense, 0, ',', '.'),
            ];
        });

        // Category breakdown with balance per category
        $categoryBreakdown = $categories->map(function ($category) use ($selectedRtId, $selectedRwId) {
            $query = $category->transactions();

            if ($selectedRtId) {
                $query->where('rt_id', $selectedRtId);
            } elseif ($selectedRwId) {
                $query->whereHas('rt', fn($q) => $q->where('rw_id', $selectedRwId));
            }

            $income = (clone $query)->where('type', 'income')->sum('amount');
            $expense = (clone $query)->where('type', 'expense')->sum('amount');

            return [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'icon' => $category->icon,
                'color' => $category->color,
                'income' => $income,
                'expense' => $expense,
                'balance' => $income - $expense,
                'formatted_balance' => 'Rp ' . number_format($income - $expense, 0, ',', '.'),
                'transaction_count' => $category->transactions_count,
            ];
        });

        $rws = Rw::with('rts')->get();
        $rts = Rt::with('rw')->get();

        return view('admin.finance.index', compact(
            'categories',
            'totalBalance',
            'recentTransactions',
            'rtBreakdown',
            'categoryBreakdown',
            'rws',
            'rts',
            'selectedRtId',
            'selectedRwId'
        ));
    }

    /**
     * Display printable finance report.
     */
    public function report(Request $request)
    {
        $query = Transaction::with(['category', 'user', 'rt.rw']);

        // Filter by RT
        if ($request->filled('rt_id')) {
            $query->where('rt_id', $request->rt_id);
        }

        // Filter by date range
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        $query->byDateRange($startDate, $endDate);

        $transactions = $query->orderBy('transaction_date', 'asc')->get();

        // Calculate summary
        $summary = [
            'total_income' => $transactions->where('type', TransactionType::INCOME)->sum('amount'),
            'total_expense' => $transactions->where('type', TransactionType::EXPENSE)->sum('amount'),
            'initial_balance' => 0,
        ];
        $summary['net_change'] = $summary['total_income'] - $summary['total_expense'];

        $rts = Rt::with('rw')->get();
        $selectedRtId = $request->rt_id;

        return view('admin.finance.report', compact('transactions', 'summary', 'startDate', 'endDate', 'rts', 'selectedRtId'));
    }

    /**
     * Display transactions for a specific category.
     */
    public function category(Request $request, Category $category)
    {
        $query = $category->transactions()->with(['user', 'rt.rw']);

        // Filter by RT
        if ($request->filled('rt_id')) {
            $query->where('rt_id', $request->rt_id);
        }

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
        $types = TransactionType::cases();
        $rts = Rt::with('rw')->get();

        return view('admin.finance.category', compact('category', 'transactions', 'types', 'rts'));
    }

    /**
     * Show form to create a new transaction.
     */
    public function create(Request $request)
    {
        $categories = Category::all();
        $types = TransactionType::cases();
        $rts = Rt::with('rw')->get();
        $selectedCategory = $request->category;
        $selectedRtId = $request->rt_id;

        return view('admin.finance.create', compact('categories', 'types', 'rts', 'selectedCategory', 'selectedRtId'));
    }

    /**
     * Store a new transaction.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'rt_id' => ['required', 'exists:rts,id'],
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
        $types = TransactionType::cases();
        $rts = Rt::with('rw')->get();

        return view('admin.finance.edit', compact('transaction', 'categories', 'types', 'rts'));
    }

    /**
     * Update a transaction.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'rt_id' => ['required', 'exists:rts,id'],
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

        \App\Services\ActivityLogger::log('delete', $description, $transaction);

        $transaction->delete();

        return back()->with('success', 'Transaksi berhasil dihapus.');
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
