<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Gender;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    /**
     * Display a listing of members.
     */
    public function index(Request $request)
    {
        $query = User::members();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $members = $query->latest()->paginate(15)->withQueryString();
        $statuses = UserStatus::options();

        return view('admin.members.index', compact('members', 'statuses'));
    }

    /**
     * Display pending members.
     */
    public function pending()
    {
        $members = User::members()->pending()->latest()->paginate(15);
        return view('admin.members.pending', compact('members'));
    }

    /**
     * Show the form for creating a new member.
     */
    public function create()
    {
        $genders = Gender::options();
        return view('admin.members.create', compact('genders'));
    }

    /**
     * Store a newly created member.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'birth_date' => ['required', 'date', 'before:today'],
            'gender' => ['required', Rule::enum(Gender::class)],
            'password' => ['required', 'min:8'],
        ]);

        $user = User::create([
            ...$validated,
            'password' => Hash::make($validated['password']),
            'role' => UserRole::ANGGOTA,
            'status' => UserStatus::ACTIVE,
            'joined_at' => now(),
        ]);

        \App\Services\ActivityLogger::log('create', "Menambahkan anggota baru: {$user->name}", $user);

        return redirect()->route('admin.members.index')
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    /**
     * Display the specified member.
     */
    public function show(User $member)
    {
        return view('admin.members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified member.
     */
    public function edit(User $member)
    {
        $genders = Gender::options();
        $statuses = UserStatus::options();
        return view('admin.members.edit', compact('member', 'genders', 'statuses'));
    }

    /**
     * Update the specified member.
     */
    public function update(Request $request, User $member)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($member->id)],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'birth_date' => ['required', 'date', 'before:today'],
            'gender' => ['required', Rule::enum(Gender::class)],
            'status' => ['required', Rule::enum(UserStatus::class)],
        ]);

        // Set joined_at if status changed to active
        if ($member->status !== UserStatus::ACTIVE && $validated['status'] === UserStatus::ACTIVE->value) {
            $validated['joined_at'] = now();
        }

        $member->update($validated);

        \App\Services\ActivityLogger::log('update', "Mengubah data anggota: {$member->name}", $member);

        return redirect()->route('admin.members.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Remove the specified member.
     */
    public function destroy(User $member)
    {
        if ($member->isAdmin()) {
            return back()->with('error', 'Tidak dapat menghapus admin.');
        }

        \App\Services\ActivityLogger::log('delete', "Menghapus anggota: {$member->name}", $member);

        $member->delete();

        return redirect()->route('admin.members.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }

    /**
     * Approve a pending member.
     */
    public function approve(User $user)
    {
        $user->update([
            'status' => UserStatus::ACTIVE,
            'joined_at' => now(),
        ]);

        \App\Services\ActivityLogger::log('update', "Menyetujui pendaftaran anggota: {$user->name}", $user);

        return back()->with('success', "Anggota {$user->name} berhasil disetujui.");
    }

    /**
     * Reject a pending member.
     */
    public function reject(Request $request, User $user)
    {
        $user->update([
            'status' => UserStatus::INACTIVE,
            'rejection_reason' => $request->input('reason', 'Ditolak oleh admin'),
        ]);

        \App\Services\ActivityLogger::log('update', "Menolak pendaftaran anggota: {$user->name}", $user);

        return back()->with('success', "Pendaftaran {$user->name} ditolak.");
    }
}
