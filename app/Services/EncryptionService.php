<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;

class EncryptionService
{
    /**
     * Encrypt sensitive data using AES
     */
    public static function encrypt(array $data): string
    {
        return Crypt::encrypt($data);
    }

    /**
     * Decrypt sensitive data
     */
    public static function decrypt(string $encryptedData): array
    {
        try {
            return Crypt::decrypt($encryptedData);
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Store encrypted user data
     */
    public static function storeUserData($user, array $sensitiveData): void
    {
        $user->update([
            'encrypted_data' => self::encrypt($sensitiveData)
        ]);
    }

    /**
     * Retrieve encrypted user data
     */
    public static function getUserData($user): array
    {
        if (!$user->encrypted_data) {
            return [];
        }

        return self::decrypt($user->encrypted_data);
    }
}