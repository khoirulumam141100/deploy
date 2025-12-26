<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApproved
{
    /**
     * Handle an incoming request.
     * Check if user is approved (active status) before allowing access.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Admin bypass - always allowed
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Check if member is approved
        if (!$user->isApproved()) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $message = $user->isPending()
                ? 'Akun Anda masih menunggu persetujuan dari admin. Silakan tunggu hingga akun Anda disetujui.'
                : 'Akun Anda tidak aktif. Silakan hubungi admin untuk informasi lebih lanjut.';

            return redirect()->route('login')
                ->with('error', $message);
        }

        return $next($request);
    }
}
