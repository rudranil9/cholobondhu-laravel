<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only check for authenticated users
        if (Auth::check()) {
            $user = Auth::user();
            
            // Check if the user is inactive
            if (!$user->is_active) {
                // Log the user out
                Auth::logout();
                
                // Clear session
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                // Redirect to login with error message
                return redirect()->route('login')
                    ->withErrors([
                        'email' => 'Your account has been deactivated by the administrator. Please contact customer support for assistance.'
                    ])
                    ->with('deactivated_user', true);
            }
        }

        return $next($request);
    }
}
