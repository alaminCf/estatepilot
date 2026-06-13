<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Redirect commission users to their panel
        if ($user->isCommissionUser()) {
            return redirect()->route('commission.dashboard')
                ->with('info', 'You have been redirected to your commission panel.');
        }

        // Redirect regular users to their account dashboard
        if ($user->isUser()) {
            return redirect()->route('account.dashboard')
                ->with('info', 'You have been redirected to your account dashboard.');
        }

        // Only allow admin role
        if (!$user->isAdmin()) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['error' => 'You do not have permission to access this area.']);
        }

        return $next($request);
    }
}
