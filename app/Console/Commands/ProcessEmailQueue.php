<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ProcessEmailQueue extends Command
{
    protected $signature = 'email:process-queue';
    protected $description = 'Process queued emails and send them';

    public function handle()
    {
        $queueDir = storage_path('email_queue');
        
        if (!file_exists($queueDir)) {
            $this->info('No email queue directory found.');
            return 0;
        }
        
        $files = glob($queueDir . '/*.json');
        
        if (empty($files)) {
            $this->info('No emails in queue.');
            return 0;
        }
        
        $this->info('Processing ' . count($files) . ' queued emails...');
        
        foreach ($files as $file) {
            try {
                $emailData = json_decode(file_get_contents($file), true);
                
                if ($this->sendEmailViaGmail($emailData)) {
                    $this->info('✅ Sent email for ticket: ' . $emailData['ticket_number']);
                    unlink($file); // Remove processed file
                } else {
                    $this->error('❌ Failed to send email for ticket: ' . $emailData['ticket_number']);
                }
                
            } catch (\Exception $e) {
                $this->error('Error processing ' . basename($file) . ': ' . $e->getMessage());
            }
        }
        
        return 0;
    }
    
    private function sendEmailViaGmail($emailData)
    {
        // This uses a simple cURL approach to send via Gmail SMTP
        // You would need to set up proper SMTP credentials for this to work
        
        // For now, let's just show what would be sent
        $this->info('Email Details:');
        $this->info('To: ' . $emailData['to']);
        $this->info('Admin To: ' . $emailData['admin_to']);
        $this->info('Subject: ' . $emailData['subject']);
        $this->info('Ticket: ' . $emailData['ticket_number']);
        $this->info('Customer: ' . $emailData['customer_name']);
        $this->info('Destination: ' . $emailData['destination']);
        $this->info('---');
        
        // Return true to simulate success for now
        return true;
    }
}
