<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Support both variadic args and comma-separated string: 'admin,author'
        $allowedRoles = [];
        foreach ($roles as $roleGroup) {
            foreach (explode(',', $roleGroup) as $r) {
                $allowedRoles[] = trim($r);
            }
        }

        // Tentukan guard mana yang dipakai berdasarkan role yang diminta
        $needsAdmin = in_array('admin', $allowedRoles);

        if ($needsAdmin) {
            // Untuk route admin, cek admin guard
            $user = Auth::guard('admin')->user();
            
            if (!$user) {
                return redirect()->route('admin.login');
            }

            if (!in_array($user->role, $allowedRoles)) {
                abort(403, 'You do not have permission to access this area.');
            }
        } else {
            // Untuk route non-admin (author, public), cek web guard
            $user = $request->user();

            if (!$user) {
                return redirect()->route('login');
            }

            if (!in_array($user->role, $allowedRoles)) {
                abort(403, 'You do not have permission to access this area.');
            }

            // If author role is accessed, check that the author is not suspended
            if ($user->isAuthor() && $user->author_status === User::STATUS_SUSPENDED) {
                abort(403, 'Your author account has been temporarily suspended. Please contact administration.');
            }

            // If author hasn't set password yet (has pending approval token)
            if ($user->isAuthor() && $user->approvalToken()->exists()) {
                return redirect()->route('author.apply.confirmation');
            }
        }

        return $next($request);
    }
}

