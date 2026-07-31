<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if the user is authenticated
        if (auth()->check()) {

            $role = auth()->user()->role;

            $hasAccess = in_array($role, $roles);

            if (! $hasAccess) {
                abort(403);
            }
        } else {
            abort(401);
        }

        // User has access
        return $next($request);
    }
}
