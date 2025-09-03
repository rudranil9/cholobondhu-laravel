<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'code',
        'type',
        'expires_at',
        'used',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];

    // OTP types
    const TYPE_REGISTRATION = 'registration';
    const TYPE_LOGIN = 'login';
    const TYPE_FORGOT_PASSWORD = 'forgot_password';

    /**
     * Generate a new OTP (keep previous ones valid if within 10 minutes)
     */
    public static function generate(string $email, string $type, string $ipAddress = null, string $userAgent = null): self
    {
        // Only invalidate OTPs that are older than 10 minutes (expired ones)
        // Keep valid OTPs within the last 10 minutes active
        self::where('email', $email)
            ->where('type', $type)
            ->where('expires_at', '<', Carbon::now())
            ->update(['used' => true]);

        // Generate new 6-digit OTP
        $otpCode = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        // Create new OTP with exactly 10 minutes expiry
        $newOtp = self::create([
            'email' => $email,
            'code' => $otpCode,
            'type' => $type,
            'expires_at' => Carbon::now()->addMinutes(10), // Exactly 10 minutes from now
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ]);

        \Log::info('New OTP generated (keeping valid previous OTPs)', [
            'email' => $email,
            'type' => $type,
            'code' => $otpCode,
            'expires_at' => $newOtp->expires_at->toDateTimeString(),
            'current_time' => Carbon::now()->toDateTimeString()
        ]);

        return $newOtp;
    }

    /**
     * Verify OTP - accepts any unused OTP from the last 10 minutes
     */
    public static function verify(string $email, string $otp, string $type): bool
    {
        // Find ANY unused OTP for this email, code, and type that hasn't expired
        $otpRecord = self::where('email', $email)
            ->where('code', $otp)
            ->where('type', $type)
            ->where('used', false)
            ->where('expires_at', '>', Carbon::now()) // Still valid (within 10 minutes)
            ->first();

        if (!$otpRecord) {
            \Log::info('OTP verification failed: No valid OTP found', [
                'email' => $email,
                'code' => $otp,
                'type' => $type,
                'current_time' => Carbon::now()->toDateTimeString()
            ]);
            return false;
        }

        // OTP is valid, mark THIS specific OTP as used
        $otpRecord->update(['used' => true]);
        
        \Log::info('OTP verification successful', [
            'email' => $email,
            'code' => $otp,
            'type' => $type,
            'expires_at' => $otpRecord->expires_at->toDateTimeString(),
            'created_at' => $otpRecord->created_at->toDateTimeString()
        ]);
        
        return true;
    }

    /**
     * Check if OTP is valid
     */
    public function isValid(): bool
    {
        return !$this->used && $this->expires_at->isFuture();
    }

    /**
     * Scope for active OTPs
     */
    public function scopeActive($query)
    {
        return $query->where('used', false)
                    ->where('expires_at', '>', Carbon::now());
    }

    /**
     * Clean up expired OTPs
     */
    public static function cleanupExpired(): int
    {
        return self::where('expires_at', '<', Carbon::now()->subHours(24))->delete();
    }

    /**
     * Create a new OTP for the given email and type (keep valid previous OTPs)
     */
    public static function createForEmail(string $email, string $type, int $expiryMinutes = 10): self
    {
        // Only invalidate expired OTPs, keep valid ones within the expiry window
        static::where('email', $email)
            ->where('type', $type)
            ->where('expires_at', '<', Carbon::now())
            ->update(['used' => true]);

        $otpCode = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        $newOtp = static::create([
            'email' => $email,
            'code' => $otpCode,
            'type' => $type,
            'expires_at' => Carbon::now()->addMinutes($expiryMinutes),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        \Log::info('New OTP created via createForEmail (keeping valid previous OTPs)', [
            'email' => $email,
            'type' => $type,
            'code' => $otpCode,
            'expires_at' => $newOtp->expires_at->toDateTimeString(),
            'expiry_minutes' => $expiryMinutes
        ]);

        return $newOtp;
    }

    /**
     * Mark OTP as used
     */
    public function markAsUsed(): bool
    {
        return $this->update(['used' => true]);
    }

    /**
     * Check if OTP is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Get remaining attempts for email and type
     */
    public static function getRemainingAttempts(string $email, string $type): int
    {
        $maxAttempts = 10; // Increased from 5 to 10
        $timeWindow = 15; // Reduced from 60 to 15 minutes
        
        $attemptCount = static::where('email', $email)
            ->where('type', $type)
            ->where('created_at', '>', Carbon::now()->subMinutes($timeWindow))
            ->count();

        return max(0, $maxAttempts - $attemptCount);
    }

    /**
     * Check if email is rate limited
     */
    public static function isRateLimited(string $email, string $type): bool
    {
        return static::getRemainingAttempts($email, $type) <= 0;
    }

    /**
     * Get minutes until rate limit resets
     */
    public static function getMinutesUntilReset(string $email, string $type): int
    {
        $timeWindow = 15; // Same as in getRemainingAttempts
        
        $oldestAttempt = static::where('email', $email)
            ->where('type', $type)
            ->where('created_at', '>', Carbon::now()->subMinutes($timeWindow))
            ->orderBy('created_at', 'asc')
            ->first();

        if (!$oldestAttempt) {
            return 0;
        }

        $resetTime = $oldestAttempt->created_at->addMinutes($timeWindow);
        return max(0, $resetTime->diffInMinutes(Carbon::now()));
    }

    /**
     * Clear rate limiting for an email/type (for admin/testing purposes)
     */
    public static function clearRateLimit(string $email, string $type): int
    {
        $timeWindow = 15;
        return static::where('email', $email)
            ->where('type', $type)
            ->where('created_at', '>', Carbon::now()->subMinutes($timeWindow))
            ->delete();
    }
}
