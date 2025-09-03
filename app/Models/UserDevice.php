<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class UserDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device_name',
        'device_fingerprint',
        'ip_address',
        'user_agent',
        'session_token',
        'last_activity',
        'is_active',
        'trusted_until',
    ];

    protected $casts = [
        'last_activity' => 'datetime',
        'is_active' => 'boolean',
        'trusted_until' => 'datetime',
    ];

    /**
     * Maximum allowed devices per user
     */
    const MAX_DEVICES_PER_USER = 3;

    /**
     * Session timeout in minutes
     */
    const SESSION_TIMEOUT = 720; // 12 hours

    /**
     * Get the user that owns the device
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate device fingerprint
     */
    public static function generateFingerprint(string $userAgent, string $ipAddress): string
    {
        return hash('sha256', $userAgent . '|' . $ipAddress . '|' . config('app.key'));
    }

    /**
     * Generate unique session token
     */
    public static function generateSessionToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    /**
     * Create or update device for user
     */
    public static function createOrUpdate(int $userId, string $deviceFingerprint, array $deviceData): self
    {
        $device = static::where('user_id', $userId)
            ->where('device_fingerprint', $deviceFingerprint)
            ->first();

        if ($device) {
            $device->update([
                'ip_address' => $deviceData['ip_address'],
                'user_agent' => $deviceData['user_agent'],
                'session_token' => $deviceData['session_token'],
                'last_activity' => now(),
                'is_active' => true,
            ]);
            return $device;
        }

        return static::create(array_merge($deviceData, [
            'user_id' => $userId,
            'device_fingerprint' => $deviceFingerprint,
            'last_activity' => now(),
            'is_active' => true,
        ]));
    }

    /**
     * Check if user has reached maximum device limit
     */
    public static function hasReachedDeviceLimit(int $userId): bool
    {
        $activeDeviceCount = static::where('user_id', $userId)
            ->where('is_active', true)
            ->where('last_activity', '>', Carbon::now()->subMinutes(self::SESSION_TIMEOUT))
            ->count();

        return $activeDeviceCount >= self::MAX_DEVICES_PER_USER;
    }

    /**
     * Get active devices for user
     */
    public static function getActiveDevices(int $userId)
    {
        return static::where('user_id', $userId)
            ->where('is_active', true)
            ->where('last_activity', '>', Carbon::now()->subMinutes(self::SESSION_TIMEOUT))
            ->orderBy('last_activity', 'desc')
            ->get();
    }

    /**
     * Deactivate oldest device for user
     */
    public static function deactivateOldestDevice(int $userId): bool
    {
        $oldestDevice = static::where('user_id', $userId)
            ->where('is_active', true)
            ->orderBy('last_activity')
            ->first();

        if ($oldestDevice) {
            return $oldestDevice->update(['is_active' => false]);
        }

        return false;
    }

    /**
     * Update device activity
     */
    public function updateActivity(): void
    {
        $this->update(['last_activity' => now()]);
    }

    /**
     * Check if device session is valid
     */
    public function isSessionValid(): bool
    {
        return $this->is_active && 
               $this->last_activity->isAfter(Carbon::now()->subMinutes(self::SESSION_TIMEOUT));
    }

    /**
     * Deactivate device
     */
    public function deactivate(): bool
    {
        return $this->update(['is_active' => false]);
    }

    /**
     * Trust device for remember me functionality
     */
    public function trust(int $days = 30): bool
    {
        return $this->update([
            'trusted_until' => Carbon::now()->addDays($days)
        ]);
    }

    /**
     * Check if device is trusted
     */
    public function isTrusted(): bool
    {
        return $this->trusted_until && $this->trusted_until->isFuture();
    }

    /**
     * Clean up inactive devices
     */
    public static function cleanupInactiveDevices(): int
    {
        return static::where('last_activity', '<', Carbon::now()->subDays(30))
            ->delete();
    }

    /**
     * Get device display name
     */
    public function getDisplayName(): string
    {
        if ($this->device_name) {
            return $this->device_name;
        }

        // Extract browser and OS from user agent
        $userAgent = $this->user_agent;
        
        // Simple browser detection
        if (str_contains($userAgent, 'Chrome')) {
            $browser = 'Chrome';
        } elseif (str_contains($userAgent, 'Firefox')) {
            $browser = 'Firefox';
        } elseif (str_contains($userAgent, 'Safari')) {
            $browser = 'Safari';
        } elseif (str_contains($userAgent, 'Edge')) {
            $browser = 'Edge';
        } else {
            $browser = 'Unknown Browser';
        }

        // Simple OS detection
        if (str_contains($userAgent, 'Windows')) {
            $os = 'Windows';
        } elseif (str_contains($userAgent, 'Mac')) {
            $os = 'macOS';
        } elseif (str_contains($userAgent, 'Linux')) {
            $os = 'Linux';
        } elseif (str_contains($userAgent, 'Android')) {
            $os = 'Android';
        } elseif (str_contains($userAgent, 'iPhone') || str_contains($userAgent, 'iPad')) {
            $os = 'iOS';
        } else {
            $os = 'Unknown OS';
        }

        return "$browser on $os";
    }
}
