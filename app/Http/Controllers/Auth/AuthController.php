<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Otp;
use App\Services\OtpEmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $otpEmailService;

    public function __construct(OtpEmailService $otpEmailService)
    {
        $this->otpEmailService = $otpEmailService;
    }

    /**
     * Show registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration form submission
     */
    public function register(Request $request)
    {
        // Debug: Log the request
        \Log::info('Registration request received', ['email' => $request->email, 'name' => $request->name]);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if ($validator->fails()) {
            \Log::error('Registration validation failed', ['errors' => $validator->errors()]);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Store registration data in session
        $registrationData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password, // Don't hash it yet
        ];

        Session::put('registration_data', $registrationData);
        Session::put('registration_email', $request->email);

        // Generate and send OTP using the service
        try {
            \Log::info('Attempting to send OTP', ['email' => $request->email]);
            $result = $this->otpEmailService->sendRegistrationOtp($request->email, $request->name);
            
            \Log::info('OTP service result', ['result' => $result]);
            
            if (!$result['success']) {
                return redirect()->back()
                    ->withErrors(['email' => $result['message']])
                    ->withInput();
            }

            return redirect()->route('auth.verify-registration')
                ->with('success', $result['message'])
                ->with('email', $request->email);

        } catch (\Exception $e) {
            \Log::error('Registration failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()
                ->withErrors(['email' => 'Failed to send OTP. Please try again. Error: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Show OTP verification form for registration
     */
    public function showRegistrationVerification()
    {
        // Allow access if there's registration data or registration email in session
        if (!Session::has('registration_data') && !Session::has('registration_email')) {
            return redirect()->route('register')
                ->withErrors(['error' => 'Registration session expired. Please try again.']);
        }

        return view('auth.verify-registration');
    }

    /**
     * Verify registration OTP
     */
    public function verifyRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => ['required', 'string', 'size:6'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $registrationData = Session::get('registration_data');
        if (!$registrationData) {
            return redirect()->route('register')
                ->withErrors(['error' => 'Registration session expired. Please try again.']);
        }

        // Verify OTP using the service
        $email = $registrationData['email'];
        $verification = $this->otpEmailService->verifyOtp($email, $request->otp, Otp::TYPE_REGISTRATION);

        if (!$verification['success']) {
            return redirect()->back()
                ->withErrors(['otp' => $verification['message']]);
        }

        // Create user
        try {
            $user = User::create([
                'name' => $registrationData['name'],
                'email' => $registrationData['email'],
                'phone' => $registrationData['phone'],
                'password' => Hash::make($registrationData['password']),
                'role' => 'user',
                'email_verified' => true,
                'email_verified_at' => now(),
                'is_active' => true,
            ]);
            
            // Clear session data
            Session::forget(['registration_data', 'registration_email']);
            
            // Log in the user
            Auth::login($user);
            
            return redirect()->route('dashboard')
                ->with('success', 'Registration completed successfully! Welcome to Cholo Bondhu!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to complete registration. Please try again.']);
        }
    }

    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle forgot password form submission
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'exists:users,email'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('email', $request->email)->first();

        // Generate and send OTP using the service
        try {
            $result = $this->otpEmailService->sendForgotPasswordOtp($request->email, $user->name);
            
            if (!$result['success']) {
                return redirect()->back()
                    ->withErrors(['email' => $result['message']])
                    ->withInput();
            }

            // Store the email in session for the verification step
            Session::put('forgot_password_email', $request->email);

            return redirect()->route('auth.verify-password-reset')
                ->with('success', $result['message'])
                ->with('email', $request->email);

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['email' => 'Failed to send OTP. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Show password reset OTP verification form
     */
    public function showPasswordResetVerification()
    {
        // Allow access if there's a forgot_password_email in session or email parameter or success message
        if (!Session::has('success') && !Session::has('forgot_password_email') && !request()->has('email')) {
            return redirect()->route('password.request')
                ->withErrors(['error' => 'Password reset session expired. Please try again.']);
        }

        return view('auth.verify-forgot-password');
    }

    /**
     * Verify password reset OTP and show reset form
     */
    public function verifyPasswordReset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'otp' => ['required', 'string', 'size:6'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        // Verify OTP using the service
        $verification = $this->otpEmailService->verifyOtp($request->email, $request->otp, Otp::TYPE_FORGOT_PASSWORD);

        if (!$verification['success']) {
            return redirect()->back()
                ->withErrors(['otp' => $verification['message']]);
        }

        // Store verified email in session for password reset
        Session::put('password_reset_email', $request->email);
        Session::put('password_reset_verified', true);

        return redirect()->route('auth.reset-password')
            ->with('success', 'OTP verified. You can now reset your password.');
    }

    /**
     * Show reset password form
     */
    public function showResetPasswordForm()
    {
        if (!Session::get('password_reset_verified')) {
            return redirect()->route('password.request')
                ->withErrors(['error' => 'Please verify your OTP first.']);
        }

        return view('auth.reset-password');
    }

    /**
     * Handle password reset
     */
    public function resetPassword(Request $request)
    {
        if (!Session::get('password_reset_verified')) {
            return redirect()->route('password.request')
                ->withErrors(['error' => 'Please verify your OTP first.']);
        }

        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $email = Session::get('password_reset_email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.request')
                ->withErrors(['error' => 'User not found.']);
        }

        try {
            $user->password = Hash::make($request->password);
            $user->save();

            // Clear used OTPs for this email and type
            Otp::where('email', $email)->where('type', Otp::TYPE_FORGOT_PASSWORD)->delete();

            // Clear session
            Session::forget(['password_reset_email', 'password_reset_verified', 'forgot_password_email']);

            return redirect()->route('login')
                ->with('success', 'Password reset successfully. You can now login with your new password.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to reset password. Please try again.']);
        }
    }

    /**
     * Resend OTP
     */
    public function resendOtp(Request $request)
    {
        $email = $request->email;
        $type = $request->type; // 'registration' or 'password_reset'

        if (!$email || !$type) {
            return redirect()->back()
                ->withErrors(['error' => 'Invalid request.']);
        }

        try {
            // Use the service to resend OTP
            if ($type === 'registration') {
                $registrationData = Session::get('registration_data');
                $userName = $registrationData ? $registrationData['name'] : 'User';
                $result = $this->otpEmailService->sendRegistrationOtp($email, $userName);
                
                // Maintain registration session data
                if (!Session::has('registration_email')) {
                    Session::put('registration_email', $email);
                }
                
            } else if ($type === 'password_reset') {
                $user = User::where('email', $email)->first();
                if (!$user) {
                    return redirect()->back()
                        ->withErrors(['error' => 'User not found.']);
                }
                
                $userName = $user->name;
                $result = $this->otpEmailService->sendForgotPasswordOtp($email, $userName);
                
                // Maintain forgot password session data
                Session::put('forgot_password_email', $email);
                
            } else {
                return redirect()->back()
                    ->withErrors(['error' => 'Invalid OTP type.']);
            }

            if ($result['success']) {
                return redirect()->back()
                    ->with('success', 'OTP resent successfully. Please check your email.')
                    ->with('email', $email);
            } else {
                return redirect()->back()
                    ->withErrors(['error' => $result['message']]);
            }

        } catch (\Exception $e) {
            \Log::error('Resend OTP failed', ['error' => $e->getMessage(), 'email' => $email, 'type' => $type]);
            return redirect()->back()
                ->withErrors(['error' => 'Failed to send OTP. Please try again.']);
        }
    }
}
