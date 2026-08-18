<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
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
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Support both variadic args and comma-separated string: 'admin,author'
        $allowedRoles = [];
        foreach ($roles as $roleGroup) {
            foreach (explode(',', $roleGroup) as $r) {
                $allowedRoles[] = trim($r);
            }
        }

        if (! in_array($user->role, $allowedRoles)) {
            abort(403, 'You do not have permission to access this area.');
        }

        // If author role is accessed, check that the author is not suspended
        if ($user->isAuthor() && $user->author_status === User::STATUS_SUSPENDED) {
            abort(403, 'Your author account has been temporarily suspended. Please contact administration.');
        }

        return $next($request);
    }
}
