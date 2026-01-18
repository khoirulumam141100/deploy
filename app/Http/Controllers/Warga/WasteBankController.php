<?php

namespace App\Http\Controllers\Warga;

use App\Enums\RedemptionStatus;
use App\Enums\RedemptionType;
use App\Http\Controllers\Controller;
use App\Models\WasteDeposit;
use App\Models\WasteRedemption;
use App\Models\WasteType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WasteBankController extends Controller
{
    /**
     * Display waste bank overview for warga.
     */
    public function index()
    {
        $user = auth()->user();

        // Balance
        $wasteBalance = $user->waste_balance ?? 0;
        $formattedBalance = 'Rp ' . number_format($wasteBalance, 0, ',', '.');

        // Stats
        $stats = [
            'total_deposits' => $user->wasteDeposits()->count(),
            'total_weight' => $user->wasteDeposits()->sum('weight'),
            'total_earned' => $user->wasteDeposits()->sum('total_amount'),
            'formatted_earned' => 'Rp ' . number_format($user->wasteDeposits()->sum('total_amount'), 0, ',', '.'),
            'pending_redemptions' => $user->wasteRedemptions()->pending()->count(),
        ];

        // Recent deposits
        $recentDeposits = $user->wasteDeposits()
            ->with('wasteType')
            ->latest('deposit_date')
            ->take(5)
            ->get();

        // Pending redemptions
        $pendingRedemptions = $user->wasteRedemptions()
            ->pending()
            ->latest()
            ->get();

        // Deposit breakdown by type
        $depositsByType = WasteDeposit::where('user_id', $user->id)
            ->selectRaw('waste_type_id, SUM(weight) as total_weight, SUM(total_amount) as total_value')
            ->groupBy('waste_type_id')
            ->with('wasteType')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->wasteType->name,
                    'icon' => $item->wasteType->icon,
                    'total_weight' => $item->total_weight,
                    'total_value' => $item->total_value,
                    'formatted_value' => 'Rp ' . number_format($item->total_value, 0, ',', '.'),
                ];
            });

        // Waste types with prices
        $wasteTypes = WasteType::active()->get();

        return view('warga.waste-bank.index', compact(
            'wasteBalance',
            'formattedBalance',
            'stats',
            'recentDeposits',
            'pendingRedemptions',
            'depositsByType',
            'wasteTypes'
        ));
    }

    /**
     * Display deposit history.
     */
    public function history(Request $request)
    {
        $user = auth()->user();

        $query = $user->wasteDeposits()->with('wasteType');

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

        $deposits = $query->latest('deposit_date')->paginate(15)->withQueryString();
        $wasteTypes = WasteType::active()->get();

        // Summary
        $summary = [
            'total_deposits' => (clone $query)->count(),
            'total_weight' => (clone $query)->sum('weight'),
            'total_earned' => (clone $query)->sum('total_amount'),
        ];

        return view('warga.waste-bank.history', compact('deposits', 'wasteTypes', 'summary'));
    }

    /**
     * Display redemption page.
     */
    public function redeem()
    {
        $user = auth()->user();

        $wasteBalance = $user->waste_balance ?? 0;
        $formattedBalance = 'Rp ' . number_format($wasteBalance, 0, ',', '.');

        // Redemption types
        $redemptionTypes = RedemptionType::cases();

        // Redemption history
        $redemptions = $user->wasteRedemptions()
            ->latest()
            ->paginate(10);

        return view('warga.waste-bank.redeem', compact(
            'wasteBalance',
            'formattedBalance',
            'redemptionTypes',
            'redemptions'
        ));
    }

    /**
     * Store a redemption request.
     */
    public function storeRedemption(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:10000', 'max:' . ($user->waste_balance ?? 0)],
            'redemption_type' => ['required', Rule::enum(RedemptionType::class)],
            'notes' => ['nullable', 'string', 'max:500'],
        ], [
            'amount.required' => 'Jumlah penukaran wajib diisi.',
            'amount.min' => 'Jumlah penukaran minimal Rp 10.000.',
            'amount.max' => 'Jumlah penukaran tidak boleh melebihi saldo Anda.',
            'redemption_type.required' => 'Jenis penukaran wajib dipilih.',
        ]);

        WasteRedemption::create([
            'user_id' => $user->id,
            'amount' => $validated['amount'],
            'redemption_type' => $validated['redemption_type'],
            'status' => RedemptionStatus::PENDING,
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('warga.waste-bank.redeem')
            ->with('success', 'Permintaan penukaran berhasil diajukan. Silakan tunggu konfirmasi dari admin.');
    }
}
