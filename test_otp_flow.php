<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Otp;
use App\Services\OtpEmailService;
use Illuminate\Support\Facades\Log;

// Initialize Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->boot();

echo "=== Testing OTP Functionality ===\n\n";

// Test 1: Create OTP for registration
echo "1. Testing OTP Creation for Registration:\n";
try {
    $email = 'test@example.com';
    $otp = Otp::createForEmail($email, Otp::TYPE_REGISTRATION, 10);
    echo "✓ OTP created successfully: " . $otp->code . "\n";
    echo "  - Email: " . $otp->email . "\n";
    echo "  - Type: " . $otp->type . "\n";
    echo "  - Expires: " . $otp->expires_at . "\n";
} catch (Exception $e) {
    echo "✗ Failed to create OTP: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: Verify OTP
echo "2. Testing OTP Verification:\n";
try {
    if (isset($otp)) {
        $isValid = Otp::verify($email, $otp->code, Otp::TYPE_REGISTRATION);
        echo $isValid ? "✓ OTP verification successful\n" : "✗ OTP verification failed\n";
    } else {
        echo "✗ No OTP to verify\n";
    }
} catch (Exception $e) {
    echo "✗ OTP verification error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Test OTP Service
echo "3. Testing OTP Email Service:\n";
try {
    $otpService = app(OtpEmailService::class);
    $result = $otpService->sendRegistrationOtp('test@example.com', 'Test User');
    echo $result['success'] ? "✓ OTP service working: " . $result['message'] . "\n" : "✗ OTP service failed: " . $result['message'] . "\n";
} catch (Exception $e) {
    echo "✗ OTP service error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 4: Test Rate Limiting
echo "4. Testing Rate Limiting:\n";
try {
    $remainingAttempts = Otp::getRemainingAttempts('test@example.com', Otp::TYPE_REGISTRATION);
    $isRateLimited = Otp::isRateLimited('test@example.com', Otp::TYPE_REGISTRATION);
    echo "  - Remaining attempts: " . $remainingAttempts . "\n";
    echo "  - Rate limited: " . ($isRateLimited ? "Yes" : "No") . "\n";
} catch (Exception $e) {
    echo "✗ Rate limiting test error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 5: Check database connection
echo "5. Testing Database Connection:\n";
try {
    $otpCount = Otp::count();
    echo "✓ Database connected. Total OTPs in database: " . $otpCount . "\n";
} catch (Exception $e) {
    echo "✗ Database connection error: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";
