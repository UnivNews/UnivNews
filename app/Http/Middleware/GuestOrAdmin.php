<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware: Guest atau Admin
 * 
 * Middleware ini menggantikan middleware 'guest' standar pada route login/register.
 * Tujuannya adalah fitur keamanan:
 * - Jika user BELUM login → lanjutkan (akses halaman login/register)
 * - Jika user adalah ADMIN → lanjutkan juga (admin dianggap tamu di halaman publik)
 * - Jika user biasa/author sudah login → redirect ke dashboard mereka
 * 
 * Dengan ini, admin yang sudah login tetap bisa mengklik tombol Login/Register
 * di navbar publik tanpa ter-redirect, sehingga tidak ada indikasi bahwa
 * admin sudah login di perangkat tersebut.
 */
class GuestOrAdmin
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                // Admin diizinkan lewat (dianggap guest untuk keamanan)
                if ($user && $user->isAdmin()) {
                    return $next($request);
                }
                
                // User biasa/author yang sudah login di-redirect ke dashboard
                return redirect(route('dashboard'));
            }
        }

        return $next($request);
    }
}
