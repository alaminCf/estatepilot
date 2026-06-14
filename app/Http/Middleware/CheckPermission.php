<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission, ?string $action = null): Response
    {
        $user = Auth::user();

        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        // When an action is supplied (e.g. "manage_plots", "add") require the
        // granular "module.action" permission; otherwise check section access.
        $required = $action ? "{$permission}.{$action}" : $permission;

        if (!$user->hasPermission($required)) {
            abort(403, 'You do not have permission to access this section.');
        }

        return $next($request);
    }
}
