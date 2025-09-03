<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Otp;
use App\Services\OtpEmailService;

class TestOtp extends Command
{
    protected $signature = 'test:otp {email}';
    protected $description = 'Test OTP functionality';

    public function handle()
    {
        $email = $this->argument('email');
        
        try {
            // Create OTP
            $otp = Otp::createForEmail($email, 'registration', 10);
            $this->info("OTP Created: {$otp->code} for {$otp->email}");
            
            // Test email service
            $otpService = app(OtpEmailService::class);
            $result = $otpService->sendRegistrationOtp($email, 'Test User');
            
            if ($result['success']) {
                $this->info("Email sent successfully!");
            } else {
                $this->error("Email failed: " . $result['message']);
            }
            
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }
}
