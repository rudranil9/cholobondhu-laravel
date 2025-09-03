<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Use AuthController for registration with OTP
    Route::get('register', [App\Http\Controllers\Auth\AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [App\Http\Controllers\Auth\AuthController::class, 'register']);

    // Verification routes
    Route::get('verify-registration', [App\Http\Controllers\Auth\AuthController::class, 'showRegistrationVerification'])->name('auth.verify-registration');
    Route::post('verify-registration', [App\Http\Controllers\Auth\AuthController::class, 'verifyRegistration'])->name('verify.registration.post');
    
    // Forgot password routes with OTP
    Route::get('forgot-password', [App\Http\Controllers\Auth\AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('forgot-password', [App\Http\Controllers\Auth\AuthController::class, 'forgotPassword'])->name('password.email');
    Route::get('verify-password-reset', [App\Http\Controllers\Auth\AuthController::class, 'showPasswordResetVerification'])->name('auth.verify-password-reset');
    Route::post('verify-password-reset', [App\Http\Controllers\Auth\AuthController::class, 'verifyPasswordReset'])->name('verify.password.post');
    Route::get('reset-password', [App\Http\Controllers\Auth\AuthController::class, 'showResetPasswordForm'])->name('auth.reset-password');
    Route::post('reset-password', [App\Http\Controllers\Auth\AuthController::class, 'resetPassword'])->name('password.store');
    
    // OTP utility routes
    Route::post('resend-otp', [App\Http\Controllers\Auth\AuthController::class, 'resendOtp'])->name('auth.resend-otp');
    Route::get('resend-otp', [App\Http\Controllers\Auth\AuthController::class, 'resendOtp'])->name('auth.resend-otp-get');

    // Login routes
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
