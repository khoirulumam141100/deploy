<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RedemptionStatus;
use App\Http\Controllers\Controller;
use App\Models\Rt;
use App\Models\User;
use App\Models\WasteDeposit;
use App\Models\WasteRedemption;
use App\Models\WasteType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class WasteBankController extends Controller
{
    /**
     * Display waste bank dashboard.
     */
    public function index()
    {
        // Statistics
        $stats = [
            'total_deposits' => WasteDeposit::count(),
            'total_weight' => WasteDeposit::sum('weight'),
            'total_value' => WasteDeposit::sum('total_amount'),
            'formatted_value' => 'Rp ' . number_format(WasteDeposit::sum('total_amount'), 0, ',', '.'),
            'active_depositors' => WasteDeposit::distinct('user_id')->count('user_id'),
            'pending_redemptions' => WasteRedemption::pending()->count(),
        ];

        // Stats by waste type
        $wasteTypeStats = WasteType::withCount('deposits')
            ->withSum('deposits', 'weight')
            ->withSum('deposits', 'total_amount')
            ->get()
            ->map(function ($type) {
                return [
                    'id' => $type->id,
                    'name' => $type->name,
                    'icon' => $type->icon,
                    'price_per_kg' => $type->price_per_kg,
                    'formatted_price' => $type->formatted_price,
                    'deposit_count' => $type->deposits_count,
                    'total_weight' => $type->deposits_sum_weight ?? 0,
                    'total_value' => $type->deposits_sum_total_amount ?? 0,
                    'formatted_value' => 'Rp ' . number_format($type->deposits_sum_total_amount ?? 0, 0, ',', '.'),
                ];
            });

        // Recent deposits
        $recentDeposits = WasteDeposit::with(['user.rt.rw', 'wasteType', 'recorder'])
            ->latest('deposit_date')
            ->take(10)
            ->get();

        // Top depositors
        $topDepositors = User::residents()
            ->active()
            ->withSum('wasteDeposits', 'total_amount')
            ->withSum('wasteDeposits', 'weight')
            ->orderByDesc('waste_deposits_sum_total_amount')
            ->take(5)
            ->get();

        // Monthly deposit chart data
        $monthlyDeposits = WasteDeposit::selectRaw('MONTH(deposit_date) as month, SUM(weight) as total_weight, SUM(total_amount) as total_value')
            ->whereYear('deposit_date', date('Y'))
            ->groupBy('month')
            ->get()
            ->keyBy('month');

        $months = [];
        $weightData = [];
        $valueData = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[] = \Carbon\Carbon::create()->month($i)->translatedFormat('M');
            $weightData[] = (float) ($monthlyDeposits[$i]->total_weight ?? 0);
            $valueData[] = (float) ($monthlyDeposits[$i]->total_value ?? 0);
        }

        return view('admin.waste-bank.index', compact(
            'stats',
            'wasteTypeStats',
            'recentDeposits',
            'topDepositors',
            'months',
            'weightData',
            'valueData'
        ));
    }

    /**
     * Display all deposits.
     */
    public function deposits(Request $request)
    {
        $query = WasteDeposit::with(['user.rt.rw', 'wasteType', 'recorder']);

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by waste type
        if ($request->filled('waste_type_id')) {
            $query->where('waste_type_id', $request->waste_type_id);
        }

        // Filter by date range
        if ($request->filled('from')) {
            $query->where('deposit_date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->where('deposit_date', '<=', $request->to);
        }

        // Filter by RT
        if ($request->filled('rt_id')) {
            $query->whereHas('user', fn($q) => $q->where('rt_id', $request->rt_id));
        }

        $deposits = $query->latest('deposit_date')->paginate(15)->withQueryString();

        // Summary
        $summary = [
            'total_deposits' => WasteDeposit::count(),
            'total_weight' => WasteDeposit::sum('weight'),
            'total_value' => WasteDeposit::sum('total_amount'),
            'formatted_value' => 'Rp ' . number_format(WasteDeposit::sum('total_amount'), 0, ',', '.'),
        ];

        $wasteTypes = WasteType::active()->get();
        $users = User::residents()->active()->orderBy('name')->get();
        $rts = Rt::with('rw')->get();

        return view('admin.waste-bank.deposits', compact('deposits', 'summary', 'wasteTypes', 'users', 'rts'));
    }

    /**
     * Show form to create a new deposit.
     */
    public function createDeposit()
    {
        $wasteTypes = WasteType::active()->get();
        $users = User::residents()->active()->with('rt.rw')->orderBy('name')->get();

        return view('admin.waste-bank.deposits-create', compact('wasteTypes', 'users'));
    }

    /**
     * Store a new deposit.
     */
    public function storeDeposit(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'waste_type_id' => ['required', 'exists:waste_types,id'],
            'weight' => ['required', 'numeric', 'min:0.1'],
            'deposit_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        // Get waste type for price
        $wasteType = WasteType::findOrFail($validated['waste_type_id']);
        $pricePerKg = $wasteType->price_per_kg;
        $totalAmount = $validated['weight'] * $pricePerKg;

        // Create deposit
        $deposit = WasteDeposit::create([
            'user_id' => $validated['user_id'],
            'waste_type_id' => $validated['waste_type_id'],
            'weight' => $validated['weight'],
            'price_per_kg' => $pricePerKg,
            'total_amount' => $totalAmount,
            'deposit_date' => $validated['deposit_date'],
            'notes' => $validated['notes'],
            'recorded_by' => auth()->id(),
        ]);

        // Update user's waste balance
        $user = User::find($validated['user_id']);
        $user->addWasteBalance($totalAmount);

        \App\Services\ActivityLogger::log(
            'create',
            "Mencatat setoran sampah: {$user->name} - {$wasteType->name} ({$deposit->formatted_weight})",
            $deposit
        );

        return redirect()->route('admin.waste-bank.deposits')
            ->with('success', "Setoran sampah berhasil dicatat. Saldo {$user->name} bertambah Rp " . number_format($totalAmount, 0, ',', '.'));
    }

    /**
     * Display waste types management.
     */
    public function wasteTypes()
    {
        $wasteTypes = WasteType::withCount('deposits as waste_deposits_count')
            ->withSum('deposits', 'weight')
            ->withSum('deposits', 'total_amount')
            ->get();

        return view('admin.waste-bank.types', compact('wasteTypes'));
    }

    /**
     * Store a new waste type.
     */
    public function storeWasteType(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'price_per_kg' => ['required', 'numeric', 'min:0'],
            'unit' => ['required', 'string', 'max:20'],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        WasteType::create($validated);

        return redirect()->route('admin.waste-bank.types')
            ->with('success', 'Jenis sampah berhasil ditambahkan.');
    }

    /**
     * Update a waste type.
     */
    public function updateWasteType(Request $request, WasteType $wasteType)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'price_per_kg' => ['required', 'numeric', 'min:0'],
            'unit' => ['required', 'string', 'max:20'],
            'icon' => ['nullable', 'string', 'max:50'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $wasteType->update($validated);

        return redirect()->route('admin.waste-bank.types')
            ->with('success', 'Jenis sampah berhasil diperbarui.');
    }

    /**
     * Delete a waste type.
     */
    public function destroyWasteType(WasteType $wasteType)
    {
        if ($wasteType->deposits()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus jenis sampah yang sudah memiliki setoran.');
        }

        $wasteType->delete();

        return redirect()->route('admin.waste-bank.types')
            ->with('success', 'Jenis sampah berhasil dihapus.');
    }

    /**
     * Display redemptions list.
     */
    public function redemptions(Request $request)
    {
        $query = WasteRedemption::with(['user.rt.rw', 'processor']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $redemptions = $query->latest()->paginate(15)->withQueryString();

        // Stats
        $stats = [
            'total' => WasteRedemption::count(),
            'pending' => WasteRedemption::pending()->count(),
            'completed' => WasteRedemption::where('status', RedemptionStatus::COMPLETED)->count(),
            'rejected' => WasteRedemption::where('status', RedemptionStatus::REJECTED)->count(),
        ];

        $statuses = RedemptionStatus::cases();
        $users = User::residents()->active()->orderBy('name')->get();

        return view('admin.waste-bank.redemptions', compact('redemptions', 'stats', 'statuses', 'users'));
    }

    /**
     * Process a redemption (approve/reject).
     */
    public function processRedemption(Request $request, WasteRedemption $redemption)
    {
        $action = $request->input('action');

        if ($action === 'approve') {
            $status = RedemptionStatus::COMPLETED;
            // Deduct balance
            $redemption->user->deductWasteBalance($redemption->amount);
        } elseif ($action === 'reject') {
            $status = RedemptionStatus::REJECTED;
        } else {
            return back()->with('error', 'Aksi tidak valid.');
        }

        $redemption->update([
            'status' => $status,
            'processed_by' => auth()->id(),
            'processed_at' => now(),
        ]);

        \App\Services\ActivityLogger::log(
            'update',
            "Memproses penukaran saldo: {$redemption->user->name} - {$redemption->formatted_amount} ({$status->label()})",
            $redemption
        );

        return back()->with('success', "Penukaran berhasil diproses. Status: {$status->label()}");
    }
}
