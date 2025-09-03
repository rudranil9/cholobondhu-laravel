<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class TestPHPMailer extends Command
{
    protected $signature = 'test:phpmailer {email}';
    protected $description = 'Test PHPMailer email functionality';

    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info('Testing PHPMailer email functionality...');
        
        try {
            $mail = new PHPMailer(true);
            
            // Server settings
            $mail->isSMTP();
            $mail->Host = env('MAIL_HOST', 'smtp.gmail.com');
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD'); 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = env('MAIL_PORT', 587);
            
            // Enable verbose debug output (comment out for production)
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->Debugoutput = function($str, $level) {
                $this->info("Debug level $level: $str");
            };
            
            // Recipients
            $mail->setFrom(env('MAIL_FROM_ADDRESS', 'rudraxyt@gmail.com'), 'Cholo Bondhu Tour');
            $mail->addAddress($email, 'Test Customer');
            $mail->addReplyTo(env('MAIL_FROM_ADDRESS', 'rudraxyt@gmail.com'), 'Cholo Bondhu Tour');
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Test Email from Cholo Bondhu';
            $mail->Body = $this->buildTestEmailHTML();
            
            $mail->send();
            $this->info('✅ Email sent successfully via PHPMailer!');
            return 0;
            
        } catch (Exception $e) {
            $this->error('❌ PHPMailer failed: ' . $mail->ErrorInfo);
            $this->error('Exception: ' . $e->getMessage());
            
            // Check SMTP credentials
            $this->warn('Please verify your SMTP credentials in .env:');
            $this->warn('MAIL_USERNAME: ' . (env('MAIL_USERNAME') ? 'Set' : 'Not set'));
            $this->warn('MAIL_PASSWORD: ' . (env('MAIL_PASSWORD') && env('MAIL_PASSWORD') !== 'your_app_password' ? 'Set' : 'Not set or using placeholder'));
            
            return 1;
        }
    }
    
    private function buildTestEmailHTML()
    {
        return '
        <html>
        <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
            <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
                <div style="background: linear-gradient(135deg, #059669, #3b82f6); color: white; padding: 30px; border-radius: 8px; text-align: center; margin-bottom: 20px;">
                    <h1>✅ PHPMailer Test Email</h1>
                    <p>Cholo Bondhu Tour & Travels</p>
                </div>
                
                <div style="background: #f9fafb; padding: 20px; border-radius: 8px;">
                    <h2 style="color: #2563eb;">Email Test Successful!</h2>
                    <p>If you are reading this email, then PHPMailer is working correctly with your SMTP configuration.</p>
                    
                    <div style="background: white; padding: 15px; border-radius: 6px; margin: 15px 0;">
                        <h3>Test Details:</h3>
                        <p><strong>Date:</strong> ' . date('M d, Y H:i:s') . '</p>
                        <p><strong>Server:</strong> ' . env('MAIL_HOST') . '</p>
                        <p><strong>Port:</strong> ' . env('MAIL_PORT') . '</p>
                        <p><strong>From:</strong> ' . env('MAIL_FROM_ADDRESS') . '</p>
                    </div>
                    
                    <p>Your booking emails will now be sent successfully!</p>
                </div>
                
                <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 2px solid #e5e7eb; color: #6b7280; font-size: 14px;">
                    <p><strong>Cholo Bondhu Tour & Travels</strong></p>
                    <p>📧 rudraxyt@gmail.com | 📞 +91 81002 82665</p>
                </div>
            </div>
        </body>
        </html>';
    }
}
