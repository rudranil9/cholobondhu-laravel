<?php

/**
 * Test script for Secure Authentication System
 * 
 * This script demonstrates how to use the secure authentication API endpoints
 * Run this after setting up the database and configuring mail settings
 */

// Base URL for your Laravel application
$baseUrl = 'http://localhost:8000/api';

// Test data
$testUser = [
    'name' => 'John Doe',
    'email' => 'john.doe@example.com',
    'password' => 'SecurePass123!',
    'password_confirmation' => 'SecurePass123!',
    'phone' => '+1234567890'
];

echo "=== Secure Authentication System Test ===\n\n";

// Function to make HTTP requests
function makeRequest($url, $data = null, $method = 'GET', $headers = []) {
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $headers[] = 'Content-Type: application/json';
        }
    }
    
    if (!empty($headers)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return [
        'status' => $httpCode,
        'body' => json_decode($response, true)
    ];
}

// Test 1: Initiate Registration
echo "1. Testing Registration Initiation...\n";
$response = makeRequest($baseUrl . '/auth/register/initiate', $testUser, 'POST');

if ($response['status'] === 200 && $response['body']['success']) {
    echo "✓ Registration OTP sent successfully!\n";
    echo "Message: " . $response['body']['message'] . "\n\n";
    
    // In a real scenario, you would get the OTP from email
    echo "Please check your email for the OTP and enter it here: ";
    $otp = trim(fgets(STDIN));
    
    // Test 2: Verify Registration
    echo "\n2. Testing Registration Verification...\n";
    $verifyData = [
        'email' => $testUser['email'],
        'otp' => $otp
    ];
    
    $response = makeRequest($baseUrl . '/auth/register/verify', $verifyData, 'POST');
    
    if ($response['status'] === 200 && $response['body']['success']) {
        echo "✓ Registration completed successfully!\n";
        echo "User ID: " . $response['body']['user']['id'] . "\n";
        echo "Token: " . substr($response['body']['token'], 0, 20) . "...\n\n";
        
        $authToken = $response['body']['token'];
        
        // Test 3: Initiate Login
        echo "3. Testing Login Initiation...\n";
        $loginData = [
            'email' => $testUser['email'],
            'password' => $testUser['password']
        ];
        
        $response = makeRequest($baseUrl . '/auth/login/initiate', $loginData, 'POST');
        
        if ($response['status'] === 200 && $response['body']['success']) {
            echo "✓ Login OTP sent successfully!\n";
            echo "Message: " . $response['body']['message'] . "\n\n";
            
            echo "Please check your email for the login OTP and enter it here: ";
            $loginOtp = trim(fgets(STDIN));
            
            // Test 4: Verify Login
            echo "\n4. Testing Login Verification...\n";
            $verifyLoginData = [
                'email' => $testUser['email'],
                'otp' => $loginOtp
            ];
            
            $response = makeRequest($baseUrl . '/auth/login/verify', $verifyLoginData, 'POST');
            
            if ($response['status'] === 200 && $response['body']['success']) {
                echo "✓ Login completed successfully!\n";
                echo "Welcome back: " . $response['body']['user']['name'] . "\n";
                echo "Last login: " . $response['body']['user']['last_login_at'] . "\n\n";
                
                $newAuthToken = $response['body']['token'];
                
                // Test 5: Get User Profile
                echo "5. Testing User Profile Retrieval...\n";
                $response = makeRequest($baseUrl . '/user', null, 'GET', [
                    'Authorization: Bearer ' . $newAuthToken
                ]);
                
                if ($response['status'] === 200 && $response['body']['success']) {
                    echo "✓ Profile retrieved successfully!\n";
                    echo "Name: " . $response['body']['user']['name'] . "\n";
                    echo "Email: " . $response['body']['user']['email'] . "\n";
                    echo "Role: " . $response['body']['user']['role'] . "\n\n";
                } else {
                    echo "✗ Failed to retrieve profile\n";
                    echo "Error: " . ($response['body']['message'] ?? 'Unknown error') . "\n\n";
                }
                
                // Test 6: Logout
                echo "6. Testing Logout...\n";
                $response = makeRequest($baseUrl . '/auth/logout', null, 'POST', [
                    'Authorization: Bearer ' . $newAuthToken
                ]);
                
                if ($response['status'] === 200 && $response['body']['success']) {
                    echo "✓ Logout successful!\n";
                } else {
                    echo "✗ Logout failed\n";
                    echo "Error: " . ($response['body']['message'] ?? 'Unknown error') . "\n";
                }
                
            } else {
                echo "✗ Login verification failed\n";
                echo "Error: " . ($response['body']['message'] ?? 'Unknown error') . "\n";
            }
            
        } else {
            echo "✗ Login initiation failed\n";
            echo "Error: " . ($response['body']['message'] ?? 'Unknown error') . "\n";
        }
        
    } else {
        echo "✗ Registration verification failed\n";
        echo "Error: " . ($response['body']['message'] ?? 'Unknown error') . "\n";
    }
    
} else {
    echo "✗ Registration initiation failed\n";
    echo "Error: " . ($response['body']['message'] ?? 'Unknown error') . "\n";
    echo "Status: " . $response['status'] . "\n";
}

echo "\n=== Test Complete ===\n";

// Instructions
echo "\nSetup Instructions:\n";
echo "1. Run: php artisan migrate\n";
echo "2. Configure mail settings in .env file\n";
echo "3. Start Laravel server: php artisan serve\n";
echo "4. Run this test: php test_secure_auth.php\n";
echo "\nAPI Endpoints:\n";
echo "POST /api/auth/register/initiate - Start registration with OTP\n";
echo "POST /api/auth/register/verify - Complete registration with OTP\n";
echo "POST /api/auth/login/initiate - Start login with credentials\n";
echo "POST /api/auth/login/verify - Complete login with OTP\n";
echo "GET /api/user - Get authenticated user profile\n";
echo "POST /api/auth/logout - Logout user\n";