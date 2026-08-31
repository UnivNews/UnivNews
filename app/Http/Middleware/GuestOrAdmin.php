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
 * 
 * Logika:
 * - Untuk route admin (/admin/sign-in): selalu izinkan, KECUALI admin sudah
 *   login via admin guard → redirect ke admin dashboard.
 * - Untuk route publik (login/register): izinkan guest dan admin yang sudah
 *   login (agar admin tidak terdeteksi di navbar publik). Redirect author/reader
 *   yang sudah login ke dashboard mereka.
 */
class GuestOrAdmin
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // Deteksi apakah ini route admin (prefix /admin)
        $isAdminRoute = $request->is('admin/*') || $request->is('admin');

        if ($isAdminRoute) {
            // Untuk route admin login: hanya blokir jika admin sudah login via admin guard
            if (Auth::guard('admin')->check()) {
                return redirect(route('admin.dashboard'));
            }
            // Izinkan semua orang lain (termasuk author/reader yang login) mengakses admin login
            return $next($request);
        }

        // Untuk route publik (login/register/google OAuth)
        // Jika admin sudah login via admin guard, tetap izinkan (admin tersembunyi di navbar publik)
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Jika author/reader sudah login via web guard, redirect ke dashboard
        if (Auth::guard('web')->check()) {
            return redirect(route('dashboard'));
        }

        // Guest → izinkan
        return $next($request);
    }
}

