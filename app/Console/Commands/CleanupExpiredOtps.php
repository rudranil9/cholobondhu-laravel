<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Otp;

class CleanupExpiredOtps extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'otp:cleanup';

    /**
     * The console command description.
     */
    protected $description = 'Clean up expired OTP records';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deletedCount = Otp::cleanupExpired();
        
        $this->info("Cleaned up {$deletedCount} expired OTP records.");
        
        return 0;
    }
}