<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Booking;
use App\Mail\BookingConfirmationMail;

class TestEmail extends Command
{
    protected $signature = 'test:email {email}';
    protected $description = 'Test email functionality';

    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info('Testing email functionality...');
        
        // Create a test booking using the Booking service
        $testData = [
            'customer_name' => 'Test Customer',
            'customer_email' => $email,
            'customer_phone' => '+91 1234567890',
            'destination' => 'Test Destination',
            'number_of_travelers' => 2,
            'budget_range' => '₹5,000 - ₹10,000',
            'special_requirements' => 'This is a test booking'
        ];
        
        // Create a test user if needed
        $user = \App\Models\User::first();
        if (!$user) {
            $user = \App\Models\User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now()
            ]);
        }
        
        auth()->login($user);
        
        try {
            $bookingService = new \Modules\Booking\Services\BookingService();
            $booking = $bookingService->createBooking($testData);
            $ticketNumber = $bookingService->getTicketNumber($booking);
            
            $this->info('✅ Test booking created successfully!');
            $this->info('Ticket Number: ' . $ticketNumber);
            $this->info('Booking ID: ' . $booking->id);
            
            // Check if emails were saved to files
            $emailsDir = storage_path('emails');
            $queueDir = storage_path('email_queue');
            
            if (file_exists($emailsDir)) {
                $emailFiles = glob($emailsDir . '/*.html');
                $this->info('Email files created: ' . count($emailFiles));
                foreach ($emailFiles as $file) {
                    $this->info('  - ' . basename($file));
                }
            }
            
            if (file_exists($queueDir)) {
                $queueFiles = glob($queueDir . '/*.json');
                $this->info('Queue files created: ' . count($queueFiles));
                foreach ($queueFiles as $file) {
                    $this->info('  - ' . basename($file));
                }
            }
            
            $this->info('Check storage/logs/laravel.log for detailed email logs.');
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('❌ Test failed: ' . $e->getMessage());
            return 1;
        }
    }
    
    private function buildTestEmailContent($booking)
    {
        return '<html><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
            <h2 style="color: #2563eb;">Test Email - Booking Confirmation</h2>
            <p>This is a test email to verify the email functionality.</p>
            
            <div style="background: #f8fafc; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h3 style="margin-top: 0; color: #1f2937;">Test Booking Details</h3>
                <p><strong>Ticket Number:</strong> ' . htmlspecialchars($booking->booking_number) . '</p>
                <p><strong>Customer:</strong> ' . htmlspecialchars($booking->customer_name) . '</p>
                <p><strong>Email:</strong> ' . htmlspecialchars($booking->customer_email) . '</p>
                <p><strong>Destination:</strong> ' . htmlspecialchars($booking->destination) . '</p>
                <p><strong>Travelers:</strong> ' . $booking->number_of_travelers . '</p>
            </div>
            
            <p>If you received this email, the email functionality is working correctly!</p>
            
            <hr style="margin: 30px 0; border: none; border-top: 1px solid #e5e7eb;">
            <p style="font-size: 12px; color: #6b7280;">Best regards,<br>Cholo Bondhu Tour and Travels<br>Email: rudraxyt@gmail.com</p>
        </body></html>';
    }
}
