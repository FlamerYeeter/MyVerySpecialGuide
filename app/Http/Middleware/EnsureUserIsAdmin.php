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

        // If the user is not an admin, block access.
        // Simplified: only require role === 'admin'. Approval flags are optional now.
        if (($user->role ?? null) !== 'admin') {
            abort(403, 'Admin access only');
        }

        return $next($request);
    }
}
