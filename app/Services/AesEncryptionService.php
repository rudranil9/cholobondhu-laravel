<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class AesEncryptionService
{
    private string $cipher = 'AES-256-CBC';
    
    /**
     * Encrypt data using AES-256-CBC
     */
    public function encrypt(string $data, string $key = null): array
    {
        try {
            $key = $key ?: $this->generateKey();
            $iv = openssl_random_pseudo_bytes(16);
            
            $encryptedData = openssl_encrypt(
                $data,
                $this->cipher,
                $key,
                OPENSSL_RAW_DATA,
                $iv
            );
            
            if ($encryptedData === false) {
                throw new \Exception('Encryption failed');
            }
            
            return [
                'encrypted' => base64_encode($encryptedData),
                'iv' => base64_encode($iv),
                'key' => base64_encode($key),
                'cipher' => $this->cipher
            ];
            
        } catch (\Exception $e) {
            throw new \Exception('Encryption error: ' . $e->getMessage());
        }
    }

    /**
     * Decrypt data using AES-256-CBC
     */
    public function decrypt(string $encryptedData, string $iv, string $key): string
    {
        try {
            $decryptedData = openssl_decrypt(
                base64_decode($encryptedData),
                $this->cipher,
                base64_decode($key),
                OPENSSL_RAW_DATA,
                base64_decode($iv)
            );
            
            if ($decryptedData === false) {
                throw new \Exception('Decryption failed');
            }
            
            return $decryptedData;
            
        } catch (\Exception $e) {
            throw new \Exception('Decryption error: ' . $e->getMessage());
        }
    }

    /**
     * Encrypt user session data
     */
    public function encryptSessionData(array $sessionData): string
    {
        try {
            return Crypt::encryptString(json_encode($sessionData));
        } catch (\Exception $e) {
            throw new \Exception('Session encryption error: ' . $e->getMessage());
        }
    }

    /**
     * Decrypt user session data
     */
    public function decryptSessionData(string $encryptedSessionData): array
    {
        try {
            $decrypted = Crypt::decryptString($encryptedSessionData);
            return json_decode($decrypted, true);
        } catch (\Exception $e) {
            throw new \Exception('Session decryption error: ' . $e->getMessage());
        }
    }

    /**
     * Encrypt sensitive user data for database storage
     */
    public function encryptUserData(array $userData): string
    {
        try {
            $serializedData = json_encode($userData);
            $encryption = $this->encrypt($serializedData);
            
            // Store encryption metadata with the data
            return json_encode([
                'data' => $encryption['encrypted'],
                'iv' => $encryption['iv'],
                'key_hash' => hash('sha256', $encryption['key']), // For key verification
                'timestamp' => time()
            ]);
            
        } catch (\Exception $e) {
            throw new \Exception('User data encryption error: ' . $e->getMessage());
        }
    }

    /**
     * Generate a secure encryption key
     */
    public function generateKey(): string
    {
        return openssl_random_pseudo_bytes(32);
    }

    /**
     * Generate secure session token
     */
    public function generateSessionToken(): string
    {
        return hash('sha256', Str::random(64) . time() . uniqid());
    }

    /**
     * Hash password with additional security
     */
    public function hashPassword(string $password, string $salt = null): array
    {
        $salt = $salt ?: bin2hex(random_bytes(16));
        $hash = hash_pbkdf2('sha256', $password, $salt, 10000, 64);
        
        return [
            'hash' => $hash,
            'salt' => $salt,
            'algorithm' => 'PBKDF2-SHA256',
            'iterations' => 10000
        ];
    }

    /**
     * Verify password hash
     */
    public function verifyPassword(string $password, string $hash, string $salt): bool
    {
        $computedHash = hash_pbkdf2('sha256', $password, $salt, 10000, 64);
        return hash_equals($hash, $computedHash);
    }

    /**
     * Generate device fingerprint
     */
    public function generateDeviceFingerprint(string $userAgent, string $ipAddress): string
    {
        $data = [
            'user_agent' => $userAgent,
            'ip_subnet' => $this->getIpSubnet($ipAddress),
            'timestamp' => date('Y-m-d'), // Changes daily for security
            'app_key' => config('app.key')
        ];
        
        return hash('sha256', implode('|', $data));
    }

    /**
     * Get IP subnet for fingerprinting
     */
    private function getIpSubnet(string $ipAddress): string
    {
        if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $parts = explode('.', $ipAddress);
            return $parts[0] . '.' . $parts[1] . '.' . $parts[2] . '.0';
        }
        
        // For IPv6, return first 4 groups
        if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $parts = explode(':', $ipAddress);
            return implode(':', array_slice($parts, 0, 4)) . '::';
        }
        
        return $ipAddress;
    }

    /**
     * Encrypt sensitive form data before processing
     */
    public function encryptFormData(array $formData): array
    {
        $encryptedData = [];
        $sensitiveFields = ['password', 'password_confirmation', 'phone'];
        
        foreach ($formData as $key => $value) {
            if (in_array($key, $sensitiveFields)) {
                $encryptedData[$key] = Crypt::encryptString($value);
            } else {
                $encryptedData[$key] = $value;
            }
        }
        
        return $encryptedData;
    }

    /**
     * Decrypt sensitive form data
     */
    public function decryptFormData(array $encryptedData): array
    {
        $decryptedData = [];
        $sensitiveFields = ['password', 'password_confirmation', 'phone'];
        
        foreach ($encryptedData as $key => $value) {
            if (in_array($key, $sensitiveFields)) {
                try {
                    $decryptedData[$key] = Crypt::decryptString($value);
                } catch (\Exception $e) {
                    $decryptedData[$key] = $value; // Fallback for unencrypted data
                }
            } else {
                $decryptedData[$key] = $value;
            }
        }
        
        return $decryptedData;
    }
}
