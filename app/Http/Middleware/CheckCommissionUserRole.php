<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCommissionUserRole
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

        // Redirect regular users to their account dashboard
        if ($user->isUser()) {
            return redirect()->route('account.dashboard')
                ->with('info', 'You have been redirected to your account dashboard.');
        }

        // Only allow commission users
        if (!$user->isCommissionUser()) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['error' => 'You do not have commission user access.']);
        }

        return $next($request);
    }
}
