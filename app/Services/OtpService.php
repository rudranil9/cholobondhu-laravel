<?php

namespace App\Services;

use App\Models\Otp;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OtpService
{
    /**
     * Send OTP for registration
     */
    public static function sendRegistrationOtp(string $email, string $name, string $ipAddress = null, string $userAgent = null): bool
    {
        try {
            $otp = Otp::generate($email, 'registration', $ipAddress, $userAgent);
            
            $subject = 'Complete Your Registration - OTP Verification';
            $message = self::buildOtpEmailContent($otp->otp, $name, 'registration');
            
            // Use the same Mail pattern as your booking system
            Mail::send([], [], function ($mailMessage) use ($email, $subject, $message) {
                $mailMessage->to($email)
                           ->subject($subject)
                           ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                           ->html($message);
            });
            
            Log::info('Registration OTP sent', ['email' => $email, 'ip' => $ipAddress]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send registration OTP', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Send OTP for login
     */
    public static function sendLoginOtp(string $email, string $name, string $ipAddress = null, string $userAgent = null): bool
    {
        try {
            $otp = Otp::generate($email, 'login', $ipAddress, $userAgent);
            
            $subject = 'Secure Login - OTP Verification';
            $message = self::buildOtpEmailContent($otp->otp, $name, 'login');
            
            // Use the same Mail pattern as your booking system
            Mail::send([], [], function ($mailMessage) use ($email, $subject, $message) {
                $mailMessage->to($email)
                           ->subject($subject)
                           ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                           ->html($message);
            });
            
            Log::info('Login OTP sent', ['email' => $email, 'ip' => $ipAddress]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send login OTP', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Send OTP for password reset
     */
    public static function sendPasswordResetOtp(string $email, string $name, string $ipAddress = null, string $userAgent = null): bool
    {
        try {
            $otp = Otp::generate($email, 'password_reset', $ipAddress, $userAgent);
            
            $subject = 'Password Reset - OTP Verification';
            $message = self::buildOtpEmailContent($otp->otp, $name, 'password_reset');
            
            // Use the same Mail pattern as your booking system
            Mail::send([], [], function ($mailMessage) use ($email, $subject, $message) {
                $mailMessage->to($email)
                           ->subject($subject)
                           ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                           ->html($message);
            });
            
            Log::info('Password reset OTP sent', ['email' => $email, 'ip' => $ipAddress]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send password reset OTP', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Build OTP email content (same style as your booking emails)
     */
    private static function buildOtpEmailContent(string $otp, string $userName, string $type): string
    {
        $titles = [
            'registration' => 'Welcome to Cholo Bondhu Tour And Travels!',
            'login' => 'Secure Login Verification',
            'password_reset' => 'Password Reset Verification'
        ];

        $messages = [
            'registration' => 'Thank you for registering with us! To complete your registration and verify your email address, please use the OTP code below:',
            'login' => 'We received a login request for your account. To ensure your security, please use the OTP code below to complete your login:',
            'password_reset' => 'We received a request to reset your password. To proceed with the password reset, please use the OTP code below:'
        ];

        $content = '<html><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">';
        
        // Header
        $content .= '<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">';
        $content .= '<h1 style="margin: 0; font-size: 24px;">' . $titles[$type] . '</h1>';
        $content .= '<p style="margin: 10px 0 0 0; opacity: 0.9;">Cholo Bondhu Tour And Travels</p>';
        $content .= '</div>';
        
        // Content
        $content .= '<div style="background: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px;">';
        $content .= '<p>Hello ' . htmlspecialchars($userName) . ',</p>';
        $content .= '<p>' . $messages[$type] . '</p>';
        
        // OTP Box
        $content .= '<div style="background: white; border: 2px solid #667eea; border-radius: 8px; padding: 20px; text-align: center; margin: 20px 0;">';
        $content .= '<p style="margin: 0; font-size: 16px;"><strong>Your OTP Code:</strong></p>';
        $content .= '<div style="font-size: 32px; font-weight: bold; color: #667eea; letter-spacing: 8px; margin: 10px 0;">' . $otp . '</div>';
        $content .= '<p style="margin: 0; font-size: 14px; color: #666;"><small>This code will expire in 10 minutes</small></p>';
        $content .= '</div>';
        
        // Security Warning
        $content .= '<div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 5px; padding: 15px; margin: 20px 0;">';
        $content .= '<strong>Security Notice:</strong>';
        $content .= '<ul style="margin: 10px 0;">';
        $content .= '<li>Never share this OTP with anyone</li>';
        $content .= '<li>Our team will never ask for your OTP</li>';
        $content .= '<li>If you didn\'t request this, please ignore this email</li>';
        $content .= '<li>This code expires in 10 minutes</li>';
        $content .= '</ul>';
        $content .= '</div>';
        
        // Additional message based on type
        if ($type === 'registration') {
            $content .= '<p>Once verified, you\'ll have full access to all our tour packages and services.</p>';
        } elseif ($type === 'login') {
            $content .= '<p>If you didn\'t attempt to log in, please secure your account immediately by changing your password.</p>';
        } else {
            $content .= '<p>After verification, you\'ll be able to set a new password for your account.</p>';
        }
        
        $content .= '<p>Best regards,<br>The Cholo Bondhu Team</p>';
        $content .= '</div>';
        
        // Footer
        $content .= '<div style="text-align: center; padding: 20px; color: #666; font-size: 12px;">';
        $content .= '<p>This is an automated message. Please do not reply to this email.</p>';
        $content .= '<p>&copy; ' . date('Y') . ' Cholo Bondhu Tour And Travels. All rights reserved.</p>';
        $content .= '</div>';
        
        $content .= '</body></html>';
        
        return $content;
    }

    /**
     * Verify OTP
     */
    public static function verifyOtp(string $email, string $otp, string $type): bool
    {
        $isValid = Otp::verify($email, $otp, $type);
        
        if ($isValid) {
            Log::info('OTP verified successfully', ['email' => $email, 'type' => $type]);
        } else {
            Log::warning('Invalid OTP attempt', ['email' => $email, 'type' => $type, 'otp' => $otp]);
        }
        
        return $isValid;
    }

    /**
     * Check rate limiting for OTP requests
     */
    public static function canSendOtp(string $email, string $type): bool
    {
        $recentOtps = Otp::where('email', $email)
            ->where('type', $type)
            ->where('created_at', '>', now()->subMinutes(2))
            ->count();

        return $recentOtps < 3; // Max 3 OTPs per 2 minutes
    }

    /**
     * Test OTP email functionality
     */
    public static function testOtpEmail(string $email, string $name = 'Test User'): bool
    {
        try {
            $testOtp = '123456';
            $subject = 'Test OTP Email - Cholo Bondhu';
            $message = self::buildOtpEmailContent($testOtp, $name, 'registration');
            
            Mail::send([], [], function ($mailMessage) use ($email, $subject, $message) {
                $mailMessage->to($email)
                           ->subject($subject)
                           ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                           ->html($message);
            });
            
            Log::info('Test OTP email sent successfully', ['email' => $email]);
            return true;
            
        } catch (\Exception $e) {
            Log::error('Test OTP email failed', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}