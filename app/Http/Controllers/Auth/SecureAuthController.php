<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Otp;
use App\Models\UserDevice;
use App\Services\OtpEmailService;
use App\Services\AesEncryptionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;

class SecureAuthController extends Controller
{
    protected OtpEmailService $otpService;
    protected AesEncryptionService $encryptionService;

    public function __construct(OtpEmailService $otpService, AesEncryptionService $encryptionService)
    {
        $this->otpService = $otpService;
        $this->encryptionService = $encryptionService;
    }
    /**
     * Initiate secure registration process
     */
    public function initiateRegistration(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'string', 'max:15'],
                'password' => ['required', 'confirmed', 'min:6'],
            ]);

            // Store registration data temporarily in cache (more suitable for API)
            $registrationData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ];

            // Store in cache with email as key for 15 minutes
            cache()->put("registration_data:{$request->email}", $registrationData, now()->addMinutes(15));

            // Send OTP
            $result = $this->otpService->sendRegistrationOtp($request->email, $request->name);
            
            return response()->json($result);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Registration initiation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again.',
            ], 500);
        }
    }

    /**
     * Step 2: Verify OTP and complete registration (Web Form)
     */
    public function verifyRegistration(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        $email = $request->email;
        $otp = $request->otp;

        // Verify OTP
        if (!Otp::verify($email, $otp, 'registration')) {
            return back()
                ->withInput()
                ->with('error', 'Invalid or expired OTP. Please try again.');
        }

        // Get registration data from cache
        $registrationData = cache()->get("registration_data:{$email}");

        if (!$registrationData) {
            return redirect()->route('secure.register')
                ->with('error', 'Registration session expired. Please start again.');
        }

        DB::beginTransaction();

        try {
            // Create user
            $user = User::create([
                'name' => $registrationData['name'],
                'email' => $registrationData['email'],
                'password' => Hash::make($registrationData['password']),
                'phone' => $registrationData['phone'],
                'role' => 'user',
                'email_verified' => true,
                'email_verified_at' => now(),
                'is_active' => true,
            ]);

            // Create device session
            $deviceFingerprint = UserDevice::generateFingerprint(
                $request->userAgent(),
                $request->ip()
            );

            $sessionToken = UserDevice::generateSessionToken();

            UserDevice::createOrUpdate($user->id, $deviceFingerprint, [
                'device_name' => null,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'session_token' => $sessionToken,
            ]);

            // Clear cache
            cache()->forget("registration_data:{$email}");

            DB::commit();

            // Log the user in
            Auth::login($user, true);

            return redirect()->route('dashboard')
                ->with('success', 'Registration completed successfully! Welcome to Cholo Bondhu!');

        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Registration verification failed: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Registration failed. Please try again.');
        }
    }

    /**
     * Step 1: Initiate login with credentials
     */
    public function initiateLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $email = $request->email;
        $password = $request->password;
        $rateLimitKey = 'login-attempts:' . $email;

        // Rate limiting: 5 attempts per 15 minutes
        if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return response()->json([
                'success' => false,
                'message' => "Too many login attempts. Please try again in {$seconds} seconds."
            ], 429);
        }

        // Find user
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            RateLimiter::hit($rateLimitKey, 900); // 15 minutes
            
            if ($user) {
                $user->incrementFailedAttempts();
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials.'
            ], 401);
        }

        // Check if account is locked
        if ($user->isLocked()) {
            return response()->json([
                'success' => false,
                'message' => 'Account is temporarily locked due to multiple failed attempts.'
            ], 423);
        }

        // Check if account is active
        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Account is deactivated. Please contact support.'
            ], 403);
        }

        // Check if email is verified
        if (!$user->email_verified) {
            return response()->json([
                'success' => false,
                'message' => 'Email not verified. Please complete registration first.'
            ], 403);
        }

        // For backward compatibility with old system - this method uses OTP
        // The new system uses secureLogin() method without OTP

        // Send login OTP (this method is for compatibility with old system)
        // For the new system, we don't use OTP for normal login
        // $otpSent = $this->otpService->sendLoginOtp($email, $user->name);
        //
        // if (!$otpSent) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Failed to send OTP. Please try again.'
        //     ], 500);
        // }

        // Store login session temporarily
        cache()->put("login_session:{$email}", [
            'user_id' => $user->id,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ], now()->addMinutes(15));

        return response()->json([
            'success' => true,
            'message' => 'OTP sent to your email. Please verify to complete login.',
            'email' => $email
        ]);
    }

    /**
     * Complete registration with OTP verification
     */
    public function completeRegistration(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'email' => ['required', 'email'],
                'otp_code' => ['required', 'string', 'size:6'],
            ]);

            // Verify OTP
            $verification = $this->otpService->verifyOtp(
                $request->email,
                $request->otp_code,
                Otp::TYPE_REGISTRATION
            );

            if (!$verification['success']) {
                return response()->json($verification, 400);
            }

            // Get registration data from cache
            $registrationData = cache()->get("registration_data:{$request->email}");
            if (!$registrationData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registration session expired. Please start again.',
                ], 400);
            }

            DB::beginTransaction();

            try {
                // Create user
                $user = User::create([
                    'name' => $registrationData['name'],
                    'email' => $registrationData['email'],
                    'phone' => $registrationData['phone'],
                    'password' => Hash::make($registrationData['password']),
                    'email_verified' => true,
                    'is_active' => true,
                    'role' => 'user',
                ]);

                // Create device session
                $deviceFingerprint = UserDevice::generateFingerprint(
                    $request->userAgent(),
                    $request->ip()
                );
                
                $sessionToken = UserDevice::generateSessionToken();
                
                UserDevice::createOrUpdate($user->id, $deviceFingerprint, [
                    'device_name' => null,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'session_token' => $sessionToken,
                ]);

                // For API, we don't log in the user automatically
                // The frontend will handle login separately if needed

                // Clear registration data from cache
                cache()->forget("registration_data:{$request->email}");

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Registration completed successfully! You can now log in.',
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                    ],
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Registration completion failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again.',
            ], 500);
        }
    }

    /**
     * Secure login with device management (NO OTP for normal login)
     */
    public function secureLogin(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
            ]);

            // Find user
            $user = User::where('email', $request->email)->first();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials.',
                ], 401);
            }

            // Check if account is locked
            if ($user->isLocked()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Account is temporarily locked due to multiple failed attempts.',
                ], 423);
            }

            // Verify password
            if (!Hash::check($request->password, $user->password)) {
                $user->incrementFailedAttempts();
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials.',
                ], 401);
            }

            // Check if user is active
            if (!$user->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Account is deactivated. Please contact support.',
                ], 403);
            }

            // Generate device fingerprint
            $deviceFingerprint = UserDevice::generateFingerprint(
                $request->userAgent(),
                $request->ip()
            );

            // Check existing device
            $existingDevice = UserDevice::where('user_id', $user->id)
                ->where('device_fingerprint', $deviceFingerprint)
                ->where('is_active', true)
                ->first();

            if ($existingDevice && $existingDevice->isTrusted()) {
                // Trusted device - login directly
                return $this->completeLogin($user, $deviceFingerprint, $request);
            }

            // Check device limit
            if (!$existingDevice && UserDevice::hasReachedDeviceLimit($user->id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maximum device limit reached. Please log out from another device first.',
                    'show_device_management' => true,
                ], 429);
            }

            // For new or untrusted devices, complete login immediately
            // (No OTP for normal login as per requirements)
            return $this->completeLogin($user, $deviceFingerprint, $request);

        } catch (\Exception $e) {
            Log::error('Secure login failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Login failed. Please try again.',
            ], 500);
        }
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.'
        ]);
    }

    /**
     * Complete login process
     */
    private function completeLogin(User $user, string $deviceFingerprint, Request $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            // Create or update device session
            $sessionToken = UserDevice::generateSessionToken();
            
            $device = UserDevice::createOrUpdate($user->id, $deviceFingerprint, [
                'device_name' => null,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'session_token' => $sessionToken,
            ]);

            // Trust device if remember me is checked
            if ($request->has('remember')) {
                $device->trust(30);
            }

            // Reset failed attempts and update login info
            $user->resetFailedAttempts();
            $user->updateLastLogin($request->ip());

            // Store device session token
            session(['device_session_token' => $sessionToken]);

            // Log in user
            Auth::login($user, $request->has('remember'));
            $request->session()->regenerate();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Login successful!',
                'redirect_url' => route('dashboard'),
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Initiate forgot password process
     */
    public function initiateForgotPassword(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'email' => ['required', 'email'],
            ]);

            $user = User::where('email', $request->email)->first();
            
            // Send OTP (always return success for security)
            $result = $this->otpService->sendForgotPasswordOtp(
                $request->email,
                $user ? $user->name : null
            );
            
            // For API, we don't need to store in session

            return response()->json([
                'success' => true,
                'message' => 'If an account exists with this email, a reset code will be sent.',
            ]);

        } catch (\Exception $e) {
            Log::error('Forgot password initiation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Request failed. Please try again.',
            ], 500);
        }
    }

    /**
     * Complete forgot password with OTP verification
     */
    public function completeForgotPassword(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'email' => ['required', 'email'],
                'otp_code' => ['required', 'string', 'size:6'],
                'password' => ['required', 'confirmed', Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()],
            ]);

            // Verify OTP
            $verification = $this->otpService->verifyOtp(
                $request->email,
                $request->otp_code,
                Otp::TYPE_FORGOT_PASSWORD
            );

            if (!$verification['success']) {
                return response()->json($verification, 400);
            }

            // Find user and update password
            $user = User::where('email', $request->email)->first();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.',
                ], 404);
            }

            DB::beginTransaction();

            try {
                // Update password
                $user->update([
                    'password' => Hash::make($request->password)
                ]);

                // Deactivate all user devices for security
                UserDevice::where('user_id', $user->id)
                    ->update(['is_active' => false]);

                // Reset account locks
                $user->resetFailedAttempts();

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Password reset successful! Please log in with your new password.',
                    'redirect_url' => route('login'),
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Forgot password completion failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Password reset failed. Please try again.',
            ], 500);
        }
    }

    /**
     * Get user active devices
     */
    public function getUserDevices(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $devices = UserDevice::getActiveDevices($user->id);

            $deviceData = $devices->map(function ($device) {
                return [
                    'id' => $device->id,
                    'name' => $device->getDisplayName(),
                    'ip_address' => $device->ip_address,
                    'last_activity' => $device->last_activity->format('M j, Y g:i A'),
                    'is_current' => $device->session_token === session('device_session_token'),
                    'is_trusted' => $device->isTrusted(),
                ];
            });

            return response()->json([
                'success' => true,
                'devices' => $deviceData,
                'max_devices' => UserDevice::MAX_DEVICES_PER_USER,
            ]);

        } catch (\Exception $e) {
            Log::error('Get user devices failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load devices.',
            ], 500);
        }
    }

    /**
     * Deactivate a specific device
     */
    public function deactivateDevice(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'device_id' => ['required', 'integer'],
            ]);

            $user = Auth::user();
            $device = UserDevice::where('id', $request->device_id)
                ->where('user_id', $user->id)
                ->first();

            if (!$device) {
                return response()->json([
                    'success' => false,
                    'message' => 'Device not found.',
                ], 404);
            }

            $isCurrentDevice = $device->session_token === session('device_session_token');
            
            $device->deactivate();

            $message = $isCurrentDevice 
                ? 'Current device deactivated. You will be logged out.'
                : 'Device deactivated successfully.';

            return response()->json([
                'success' => true,
                'message' => $message,
                'logout_required' => $isCurrentDevice,
            ]);

        } catch (\Exception $e) {
            Log::error('Device deactivation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to deactivate device.',
            ], 500);
        }
    }

    /**
     * Resend OTP
     */
    public function resendOtp(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'email' => ['required', 'email'],
                'type' => ['required', 'in:registration,forgot_password'],
            ]);

            $result = match($request->type) {
                'registration' => $this->otpService->sendRegistrationOtp($request->email),
                'forgot_password' => $this->otpService->sendForgotPasswordOtp($request->email),
            };

            return response()->json($result);

        } catch (\Exception $e) {
            Log::error('Resend OTP failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to resend code.',
            ], 500);
        }
    }

    /**
     * Get authenticated user profile
     */
    public function profile(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            
            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'role' => $user->role,
                    'is_active' => $user->is_active,
                    'last_login' => $user->last_login_at ? $user->last_login_at->format('M j, Y g:i A') : null,
                    'created_at' => $user->created_at->format('M j, Y'),
                ],
            ]);
            
        } catch (\Exception $e) {
            Log::error('Get profile failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load profile.',
            ], 500);
        }
    }

    /**
     * Validate current session token
     */
    public function validateSession(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $sessionToken = session('device_session_token');
            
            if (!$sessionToken) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active session found.',
                    'logout_required' => true,
                ], 401);
            }
            
            $device = UserDevice::where('user_id', $user->id)
                ->where('session_token', $sessionToken)
                ->where('is_active', true)
                ->first();
                
            if (!$device) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid session. Please log in again.',
                    'logout_required' => true,
                ], 401);
            }
            
            // Update last activity
            $device->updateActivity();
            
            return response()->json([
                'success' => true,
                'message' => 'Session is valid.',
                'device' => [
                    'id' => $device->id,
                    'name' => $device->getDisplayName(),
                    'last_activity' => $device->last_activity->format('M j, Y g:i A'),
                ],
            ]);
            
        } catch (\Exception $e) {
            Log::error('Session validation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Session validation failed.',
                'logout_required' => true,
            ], 500);
        }
    }
}
