<?php

namespace App\Http\Middleware;

use App\Enums\UserStatus;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApprovedMiddleware
{
    /**
     * Handle an incoming request.
     * Ensures user is approved (active status).
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = auth()->user();

        if ($user->isAdmin()) {
            return $next($request);
        }

        if (!$user->isApproved()) {
            \Illuminate\Support\Facades\Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $message = $user->isPending()
                ? 'Akun Anda masih menunggu persetujuan dari admin RT/RW.'
                : 'Akun Anda tidak aktif. Silakan hubungi admin RT/RW.';

            return redirect()->route('login')->with('error', $message);
        }

        return $next($request);
    }
}
