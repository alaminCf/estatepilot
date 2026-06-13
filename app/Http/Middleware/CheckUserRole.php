<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Redirect admins to admin dashboard
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('info', 'You have been redirected to your admin dashboard.');
        }

        // Redirect commission users to their panel
        if ($user->isCommissionUser()) {
            return redirect()->route('commission.dashboard')
                ->with('info', 'You have been redirected to your commission panel.');
        }

        // Only allow users with 'user' role
        if (!$user->isUser()) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['error' => 'You do not have customer access.']);
        }

        return $next($request);
    }
}
