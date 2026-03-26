<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (settings('maintenance_mode', '0') == '1') {
            // Allow admins to pass
            if (Auth::check() && Auth::user()->isAdmin()) {
                return $next($request);
            }

            // Also allow the admin routes specifically to ensure we can turn it off
            if ($request->is('admin/*') || $request->is('admin')) {
                return $next($request);
            }

            // Allow login/logout/register to allow admins to log in or users to logout
            if ($request->is('login') || $request->is('logout') || $request->is('register')) {
                return $next($request);
            }

            // Check if it's a JSON request (API or AJAX)
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Site is under maintenance.'], 503);
            }

            abort(503, 'The site is currently under maintenance. Please check back later.');
        }

        return $next($request);
    }
}
