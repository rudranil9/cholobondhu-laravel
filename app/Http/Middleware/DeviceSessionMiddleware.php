<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\UserDevice;

class DeviceSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only check for authenticated users
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();
        $sessionToken = session('device_session_token');
        
        // If no device session token, create one for this session
        if (!$sessionToken) {
            $deviceFingerprint = UserDevice::generateFingerprint(
                $request->userAgent(),
                $request->ip()
            );
            
            // Check if user has reached device limit
            if (UserDevice::hasReachedDeviceLimit($user->id)) {
                // Check for existing device with same fingerprint
                $existingDevice = UserDevice::where('user_id', $user->id)
                    ->where('device_fingerprint', $deviceFingerprint)
                    ->where('is_active', true)
                    ->first();
                
                if (!$existingDevice) {
                    // Force logout if device limit exceeded and no matching device
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    
                    if ($request->expectsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Device limit exceeded. Please log out from another device.',
                            'redirect' => route('login')
                        ], 429);
                    }
                    
                    return redirect()->route('login')
                        ->withErrors(['device_limit' => 'Maximum device limit reached. Please log out from another device first.']);
                }
                
                $sessionToken = $existingDevice->session_token;
            } else {
                // Create new device session
                $newSessionToken = UserDevice::generateSessionToken();
                
                $device = UserDevice::createOrUpdate($user->id, $deviceFingerprint, [
                    'device_name' => null,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'session_token' => $newSessionToken,
                ]);
                
                $sessionToken = $newSessionToken;
            }
            
            session(['device_session_token' => $sessionToken]);
        }
        
        // Validate existing session token
        $device = UserDevice::where('session_token', $sessionToken)
            ->where('is_active', true)
            ->first();
        
        if (!$device || !$device->isSessionValid()) {
            // Invalid or expired session
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please log in again.',
                    'redirect' => route('login')
                ], 401);
            }
            
            return redirect()->route('login')
                ->withErrors(['session' => 'Your session has expired. Please log in again.']);
        }
        
        // Update device activity
        $device->updateActivity();
        
        return $next($request);
    }
}
