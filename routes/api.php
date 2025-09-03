<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SecureAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public authentication routes
Route::prefix('auth')->group(function () {
    // Registration with OTP
    Route::post('/register/initiate', [SecureAuthController::class, 'initiateRegistration']);
    Route::post('/register/complete', [SecureAuthController::class, 'completeRegistration']);
    Route::post('/register/verify', [SecureAuthController::class, 'verifyRegistration']); // Keep for backward compatibility
    
    // Secure login with device management (no OTP for normal login)
    Route::post('/login', [SecureAuthController::class, 'secureLogin']);
    Route::post('/login/initiate', [SecureAuthController::class, 'initiateLogin']); // Keep for backward compatibility
    Route::post('/login/verify', [SecureAuthController::class, 'verifyLogin']); // Keep for backward compatibility
    
    // Forgot password with OTP
    Route::post('/forgot-password/initiate', [SecureAuthController::class, 'initiateForgotPassword']);
    Route::post('/forgot-password/complete', [SecureAuthController::class, 'completeForgotPassword']);
    
    // OTP utilities
    Route::post('/resend-otp', [SecureAuthController::class, 'resendOtp']);
});

// Debug and test routes (remove in production)
Route::get('/test-otp-email', function (Request $request) {
    $email = $request->get('email', 'test@example.com');
    $name = $request->get('name', 'Test User');
    
    try {
        // Test basic mail configuration
        $subject = 'Test Email - Cholo Bondhu';
        $message = '<h1>Test Email</h1><p>If you receive this, mail is working!</p>';
        
        \Illuminate\Support\Facades\Mail::send([], [], function ($mailMessage) use ($email, $subject, $message) {
            $mailMessage->to($email)
                       ->subject($subject)
                       ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                       ->html($message);
        });
        
        return response()->json([
            'success' => true,
            'message' => 'Basic test email sent successfully!',
            'email' => $email,
            'mail_config' => [
                'mailer' => env('MAIL_MAILER'),
                'host' => env('MAIL_HOST'),
                'port' => env('MAIL_PORT'),
                'from' => env('MAIL_FROM_ADDRESS')
            ]
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Email test failed: ' . $e->getMessage(),
            'email' => $email,
            'error_details' => [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]
        ]);
    }
});

Route::get('/debug-registration', function (Request $request) {
    $email = $request->get('email', 'test@example.com');
    
    try {
        // Test OTP generation
        $otp = \App\Models\Otp::generate($email, 'registration', '127.0.0.1', 'test-agent');
        
        return response()->json([
            'success' => true,
            'message' => 'OTP generated successfully',
            'otp_code' => $otp->otp,
            'expires_at' => $otp->expires_at,
            'email' => $email
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'OTP generation failed: ' . $e->getMessage(),
            'error_details' => [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]
        ]);
    }
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // User profile and logout
    Route::get('/user', [SecureAuthController::class, 'profile']);
    Route::post('/auth/logout', [SecureAuthController::class, 'logout']);
    
    // Device management
    Route::get('/auth/devices', [SecureAuthController::class, 'getUserDevices']);
    Route::post('/auth/devices/deactivate', [SecureAuthController::class, 'deactivateDevice']);
    Route::post('/auth/session/validate', [SecureAuthController::class, 'validateSession']);
});
