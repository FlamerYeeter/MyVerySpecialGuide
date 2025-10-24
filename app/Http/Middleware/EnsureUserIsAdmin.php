<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     * Requires authenticated user and role === 'admin' and admin_approved === true
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }

        // If the user is not an admin or not yet approved, block access.
        if (($user->role ?? null) !== 'admin' || !($user->admin_approved ?? false)) {
            abort(403, 'Admin access only');
        }

        return $next($request);
    }
}
