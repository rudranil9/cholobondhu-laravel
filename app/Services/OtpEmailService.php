<?php

namespace App\Services;

use App\Models\Otp;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OtpEmailService
{
    /**
     * Send OTP for registration
     */
    public function sendRegistrationOtp(string $email, string $name = null): array
    {
        if (Otp::isRateLimited($email, Otp::TYPE_REGISTRATION)) {
            $remainingMinutes = Otp::getMinutesUntilReset($email, Otp::TYPE_REGISTRATION);
            $remainingMinutes = max(1, $remainingMinutes); // At least 1 minute
            return [
                'success' => false,
                'message' => "Too many OTP requests. Please wait $remainingMinutes minutes before requesting again.",
            ];
        }

        try {
            $otp = Otp::createForEmail($email, Otp::TYPE_REGISTRATION, 10);
            
            $this->sendOtpEmail($email, $otp->code, 'registration', $name);
            
            return [
                'success' => true,
                'message' => 'Verification code sent to your email.',
                'expires_in' => 10 // minutes
            ];
        } catch (\Exception $e) {
            Log::error('Failed to send registration OTP: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to send verification code. Please try again.',
            ];
        }
    }

    /**
     * Send OTP for forgot password
     */
    public function sendForgotPasswordOtp(string $email, string $name = null): array
    {
        if (Otp::isRateLimited($email, Otp::TYPE_FORGOT_PASSWORD)) {
            $remainingMinutes = Otp::getMinutesUntilReset($email, Otp::TYPE_FORGOT_PASSWORD);
            $remainingMinutes = max(1, $remainingMinutes); // At least 1 minute
            return [
                'success' => false,
                'message' => "Too many OTP requests. Please wait $remainingMinutes minutes before requesting again.",
            ];
        }

        try {
            $otp = Otp::createForEmail($email, Otp::TYPE_FORGOT_PASSWORD, 15);
            
            $this->sendOtpEmail($email, $otp->code, 'password_reset', $name);
            
            return [
                'success' => true,
                'message' => 'Password reset code sent to your email.',
                'expires_in' => 15 // minutes
            ];
        } catch (\Exception $e) {
            Log::error('Failed to send forgot password OTP: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to send reset code. Please try again.',
            ];
        }
    }

    /**
     * Verify OTP code
     */
    /**
     * Verify OTP - accepts any valid OTP from the last 10 minutes
     */
    public function verifyOtp(string $email, string $code, string $type): array
    {
        // Check if there are any OTPs for this email and type
        $allOtps = Otp::where('email', $email)
            ->where('type', $type)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($allOtps->isEmpty()) {
            return [
                'success' => false,
                'message' => 'No verification code found. Please request a new one.',
            ];
        }

        // Find any unused OTP with the provided code that hasn't expired
        $validOtp = $allOtps->where('code', $code)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$validOtp) {
            // Check if code exists but is used or expired
            $existingOtp = $allOtps->where('code', $code)->first();
            
            if (!$existingOtp) {
                return [
                    'success' => false,
                    'message' => 'Invalid verification code. Please check and try again.',
                ];
            } elseif ($existingOtp->used) {
                return [
                    'success' => false,
                    'message' => 'This verification code has already been used.',
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Verification code has expired. Please request a new one.',
                ];
            }
        }

        // Mark this specific OTP as used
        $validOtp->update(['used' => true]);
        
        return [
            'success' => true,
            'message' => 'Verification successful.',
        ];
    }

    /**
     * Send OTP email using OtpMail class (same pattern as BookingConfirmationMail)
     */
    public function sendOtpEmail(string $email, string $code, string $type, string $name = null): void
    {
        $userName = $name ?: 'User';
        
        // Use the OtpMail class like BookingConfirmationMail
        Mail::to($email)->send(new OtpMail($code, $userName, $type));
    }

    /**
     * Send OTP email (legacy method for compatibility with AuthController)
     */
    public function sendOtpEmailLegacy(string $email, string $name, string $otp, string $type): bool
    {
        try {
            Mail::to($email)->send(new OtpMail($otp, $name, $type));
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send OTP email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get remaining attempts for email
     */
    public function getRemainingAttempts(string $email, string $type): int
    {
        return Otp::getRemainingAttempts($email, $type);
    }

    /**
     * Check if email can request OTP
     */
    public function canRequestOtp(string $email, string $type): bool
    {
        return !Otp::isRateLimited($email, $type);
    }
}
