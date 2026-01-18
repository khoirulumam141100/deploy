<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Gender;
use App\Enums\ResidenceStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\Rt;
use App\Models\Rw;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            // Check if user is approved
            if (!$user->isAdmin() && !$user->isApproved()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $message = $user->isPending()
                    ? 'Akun Anda masih menunggu persetujuan dari admin.'
                    : 'Akun Anda tidak aktif. Silakan hubungi admin.';

                return back()->with('error', $message);
            }

            $request->session()->regenerate();

            // Redirect based on role
            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('warga.dashboard'));
        }

        return back()->with('error', 'Email atau password salah.');
    }

    /**
     * Show registration form.
     */
    public function showRegistrationForm()
    {
        $rws = Rw::with('rts')->get();
        $genders = Gender::cases();
        $residenceStatuses = ResidenceStatus::cases();

        return view('auth.register', compact('rws', 'genders', 'residenceStatuses'));
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nik' => ['required', 'string', 'size:16', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'birth_date' => ['required', 'date', 'before:today'],
            'gender' => ['required', Rule::enum(Gender::class)],
            'rt_id' => ['required', 'exists:rts,id'],
            'residence_status' => ['required', Rule::enum(ResidenceStatus::class)],
            'occupation' => ['nullable', 'string', 'max:100'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.before' => 'Tanggal lahir tidak valid.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'rt_id.required' => 'RT/RW wajib dipilih.',
            'rt_id.exists' => 'RT/RW tidak valid.',
            'residence_status.required' => 'Status kependudukan wajib dipilih.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Get RW from RT
        $rt = Rt::find($validated['rt_id']);

        User::create([
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
            'status' => UserStatus::PENDING,
            'waste_balance' => 0,
        ]);

        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil! Akun Anda akan diverifikasi oleh admin RT/RW. Silakan tunggu hingga akun disetujui.');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
