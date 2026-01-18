<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Gender;
use App\Enums\ResidenceStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\Rt;
use App\Models\Rw;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ResidentController extends Controller
{
    /**
     * Display a listing of residents.
     */
    public function index(Request $request)
    {
        $query = User::residents()->with(['rt.rw']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by RT
        if ($request->filled('rt_id')) {
            $query->where('rt_id', $request->rt_id);
        }

        // Filter by RW
        if ($request->filled('rw_id')) {
            $query->whereHas('rt', function ($q) use ($request) {
                $q->where('rw_id', $request->rw_id);
            });
        }

        // Filter by residence status
        if ($request->filled('residence_status')) {
            $query->where('residence_status', $request->residence_status);
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $residents = $query->latest()->paginate(15)->withQueryString();

        // Stats
        $stats = [
            'total' => User::residents()->count(),
            'active' => User::residents()->active()->count(),
            'pending' => User::residents()->pending()->count(),
            'rejected' => User::residents()->where('status', UserStatus::INACTIVE)->count(),
        ];

        $statuses = UserStatus::cases();
        $residenceStatuses = ResidenceStatus::cases();
        $rws = Rw::with('rts')->get();
        $rts = Rt::with('rw')->get();

        return view('admin.residents.index', compact(
            'residents',
            'stats',
            'statuses',
            'residenceStatuses',
            'rws',
            'rts'
        ));
    }

    /**
     * Display pending residents.
     */
    public function pending()
    {
        $residents = User::residents()
            ->pending()
            ->with(['rt.rw'])
            ->latest()
            ->paginate(15);

        return view('admin.residents.pending', compact('residents'));
    }

    /**
     * Show the form for creating a new resident.
     */
    public function create()
    {
        $genders = Gender::cases();
        $statuses = UserStatus::cases();
        $residenceStatuses = ResidenceStatus::cases();
        $rws = Rw::with('rts')->get();
        $rts = Rt::with('rw')->get();

        return view('admin.residents.create', compact('genders', 'statuses', 'residenceStatuses', 'rws', 'rts'));
    }

    /**
     * Store a newly created resident.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'nik' => ['required', 'string', 'size:16', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'birth_date' => ['required', 'date', 'before:today'],
            'gender' => ['required', Rule::enum(Gender::class)],
            'rt_id' => ['required', 'exists:rts,id'],
            'residence_status' => ['required', Rule::enum(ResidenceStatus::class)],
            'occupation' => ['nullable', 'string', 'max:100'],
            'password' => ['required', 'min:8'],
        ]);

        // Get RW from RT
        $rt = Rt::find($validated['rt_id']);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nik' => $validated['nik'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'rt_id' => $validated['rt_id'],
            'rw_id' => $rt->rw_id,
            'residence_status' => $validated['residence_status'],
            'occupation' => $validated['occupation'],
            'password' => Hash::make($validated['password']),
            'role' => UserRole::ANGGOTA,
            'status' => UserStatus::ACTIVE,
            'joined_at' => now(),
            'waste_balance' => 0,
        ]);

        \App\Services\ActivityLogger::log('create', "Menambahkan warga baru: {$user->name}", $user);

        return redirect()->route('admin.residents.index')
            ->with('success', 'Warga berhasil ditambahkan.');
    }

    /**
     * Display the specified resident.
     */
    public function show(User $resident)
    {
        $resident->load(['rt.rw', 'wasteDeposits.wasteType']);

        // Get waste deposit stats
        $totalEarned = $resident->wasteDeposits()->sum('total_amount');
        $wasteStats = [
            'total_deposits' => $resident->wasteDeposits()->count(),
            'total_weight' => $resident->wasteDeposits()->sum('weight'),
            'total_earned' => $totalEarned,
            'formatted_earned' => 'Rp ' . number_format($totalEarned, 0, ',', '.'),
        ];

        // Recent deposits
        $recentDeposits = $resident->wasteDeposits()
            ->with('wasteType')
            ->latest('deposit_date')
            ->take(5)
            ->get();

        return view('admin.residents.show', compact('resident', 'wasteStats', 'recentDeposits'));
    }

    /**
     * Show the form for editing the specified resident.
     */
    public function edit(User $resident)
    {
        $genders = Gender::cases();
        $statuses = UserStatus::cases();
        $residenceStatuses = ResidenceStatus::cases();
        $rws = Rw::with('rts')->get();
        $rts = Rt::with('rw')->get();

        return view('admin.residents.edit', compact(
            'resident',
            'genders',
            'statuses',
            'residenceStatuses',
            'rws',
            'rts'
        ));
    }

    /**
     * Update the specified resident.
     */
    public function update(Request $request, User $resident)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($resident->id)],
            'nik' => ['required', 'string', 'size:16', Rule::unique('users')->ignore($resident->id)],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'birth_date' => ['required', 'date', 'before:today'],
            'gender' => ['required', Rule::enum(Gender::class)],
            'rt_id' => ['required', 'exists:rts,id'],
            'residence_status' => ['required', Rule::enum(ResidenceStatus::class)],
            'occupation' => ['nullable', 'string', 'max:100'],
            'status' => ['required', Rule::enum(UserStatus::class)],
        ]);

        // Get RW from RT
        $rt = Rt::find($validated['rt_id']);
        $validated['rw_id'] = $rt->rw_id;

        // Set joined_at if status changed to active
        if ($resident->status !== UserStatus::ACTIVE && $validated['status'] === UserStatus::ACTIVE->value) {
            $validated['joined_at'] = now();
        }

        $resident->update($validated);

        \App\Services\ActivityLogger::log('update', "Mengubah data warga: {$resident->name}", $resident);

        return redirect()->route('admin.residents.index')
            ->with('success', 'Data warga berhasil diperbarui.');
    }

    /**
     * Remove the specified resident.
     */
    public function destroy(User $resident)
    {
        if ($resident->isAdmin()) {
            return back()->with('error', 'Tidak dapat menghapus admin.');
        }

        \App\Services\ActivityLogger::log('delete', "Menghapus warga: {$resident->name}", $resident);

        $resident->delete();

        return redirect()->route('admin.residents.index')
            ->with('success', 'Warga berhasil dihapus.');
    }

    /**
     * Approve a pending resident.
     */
    public function approve(User $user)
    {
        $user->update([
            'status' => UserStatus::ACTIVE,
            'joined_at' => now(),
        ]);

        \App\Services\ActivityLogger::log('update', "Menyetujui pendaftaran warga: {$user->name}", $user);

        return back()->with('success', "Warga {$user->name} berhasil disetujui.");
    }

    /**
     * Reject a pending resident.
     */
    public function reject(Request $request, User $user)
    {
        $user->update([
            'status' => UserStatus::INACTIVE,
            'rejection_reason' => $request->input('reason', 'Ditolak oleh admin'),
        ]);

        \App\Services\ActivityLogger::log('update', "Menolak pendaftaran warga: {$user->name}", $user);

        return back()->with('success', "Pendaftaran {$user->name} ditolak.");
    }
}
