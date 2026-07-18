<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Check that the logged-in user has one of the allowed roles.
     *
     * Usage in routes: middleware('role:admin') or middleware('role:customer,seller')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $userRole = $request->session()->get('role');

        if (!$userRole || !in_array($userRole, $roles)) {
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
