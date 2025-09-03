<?php

// Test registration flow
require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use App\Models\Otp;
use App\Services\OtpEmailService;
use Illuminate\Support\Facades\Mail;

echo "=== Testing Registration Flow ===\n";

try {
    // Test 1: Create OTP
    echo "1. Testing OTP creation...\n";
    $email = 'test@example.com';
    $otp = Otp::createForEmail($email, Otp::TYPE_REGISTRATION, 10);
    echo "✓ OTP created successfully: {$otp->code}\n";
    echo "  Email: {$otp->email}\n";
    echo "  Type: {$otp->type}\n";
    echo "  Expires at: {$otp->expires_at}\n";

    // Test 2: Test OTP Service
    echo "\n2. Testing OTP Service...\n";
    $otpService = new OtpEmailService();
    
    // Test verification
    echo "3. Testing OTP verification...\n";
    $verification = $otpService->verifyOtp($email, $otp->code, Otp::TYPE_REGISTRATION);
    if ($verification['success']) {
        echo "✓ OTP verification successful\n";
    } else {
        echo "✗ OTP verification failed: {$verification['message']}\n";
    }

    echo "\n=== All tests completed ===\n";

} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
