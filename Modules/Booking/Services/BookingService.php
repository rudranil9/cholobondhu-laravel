<?php

namespace Modules\Booking\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BookingService
{
    /**
     * Create a new booking with ticket generation
     */
    public function createBooking(array $data): Booking
    {
        // Generate unique ticket number
        $ticketNumber = $this->generateTicketNumber();

        // Prepare booking data
        $bookingData = array_merge($data, [
            'user_id' => auth()->id(),
            'booking_date' => now(),
            'status' => 'pending',
            'payment_status' => 'pending',
            'notes' => 'Ticket Number: ' . $ticketNumber . (isset($data['special_requirements']) && $data['special_requirements'] ? ' | Special Requirements: ' . $data['special_requirements'] : ''),
        ]);

        // Create the booking
        $booking = Booking::create($bookingData);

        // Send email notifications
        $this->sendBookingNotifications($booking, $ticketNumber);

        return $booking;
    }

    /**
     * Generate unique ticket number
     */
    protected function generateTicketNumber(): string
    {
        $prefix = 'CB'; // Cholo Bondhu
        $date = now()->format('Ymd');
        $random = strtoupper(substr(md5(uniqid()), 0, 4));
        
        $ticketNumber = $prefix . $date . $random;

        // Ensure uniqueness
        while (Booking::where('notes', 'LIKE', '%' . $ticketNumber . '%')->exists()) {
            $random = strtoupper(substr(md5(uniqid()), 0, 4));
            $ticketNumber = $prefix . $date . $random;
        }

        return $ticketNumber;
    }

    /**
     * Send booking notifications with fallback
     */
    protected function sendBookingNotifications(Booking $booking, string $ticketNumber): void
    {
        $this->sendRobustEmail($booking, $ticketNumber);
    }
    
    private function sendRobustEmail($booking, $ticketNumber)
    {
        $customerEmail = $booking->customer_email;
        $adminEmail = env('MAIL_COMPANY_EMAIL', 'rudraxyt@gmail.com');
        
        // Save email to file (always works)
        $this->saveEmailToFile($booking, $ticketNumber, $customerEmail, $adminEmail);
        
        // Try to send via PHPMailer if available
        try {
            $this->sendViaPHPMailer($booking, $ticketNumber, $customerEmail, $adminEmail);
            Log::info('Booking emails sent successfully via PHPMailer');
        } catch (\Exception $e) {
            Log::info('PHPMailer not available, email saved to file: ' . $e->getMessage());
        }
    }
    
    private function sendNativeEmail($booking, $ticketNumber, $customerEmail, $adminEmail)
    {
        $subject = 'Booking Confirmation - Ticket #' . $ticketNumber;
        
        // Email content
        $customerMessage = $this->buildEmailContent($booking, $ticketNumber, false);
        $adminMessage = $this->buildEmailContent($booking, $ticketNumber, true);
        
        // Headers
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            'From: Cholo Bondhu Tour <rudraxyt@gmail.com>',
            'Reply-To: rudraxyt@gmail.com',
            'X-Mailer: PHP/' . phpversion()
        ];
        $headerString = implode("\r\n", $headers);
        
        // Send to customer
        $customerSent = mail($customerEmail, $subject, $customerMessage, $headerString);
        
        // Send to admin
        $adminSent = mail($adminEmail, 'New Booking - ' . $subject, $adminMessage, $headerString);
        
        if (!$customerSent && !$adminSent) {
            throw new \Exception('Failed to send emails via PHP native mail');
        }
    }
    
    private function buildEmailContent($booking, $ticketNumber, $isAdmin = false)
    {
        if ($isAdmin) {
            return $this->buildAdminEmailContent($booking, $ticketNumber);
        } else {
            return $this->buildCustomerEmailContent($booking, $ticketNumber);
        }
    }
    
    private function buildAdminEmailContent($booking, $ticketNumber)
    {
        // Convert budget to proper rupee format
        $budgetFormatted = $booking->budget_range;
        if ($budgetFormatted) {
            $budgetFormatted = str_replace(['Rs.', 'rs.', 'RS.', 'rupees', 'Rupees'], '₹', $budgetFormatted);
        }
        
        $content = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>New Booking Alert</title>
            <style>
                @import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap");
                body { font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; margin: 0; padding: 0; background-color: #f8fafc; }
                .email-container { max-width: 650px; margin: 30px auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
                .header { background: linear-gradient(135deg, #1e40af 0%, #7c3aed 50%, #ec4899 100%); color: white; padding: 40px 30px; text-align: center; }
                .header h1 { margin: 0 0 15px 0; font-size: 28px; font-weight: 700; letter-spacing: -0.5px; }
                .header p { margin: 0; font-size: 16px; opacity: 0.9; font-weight: 400; }
                .ticket-badge { background: rgba(255,255,255,0.2); padding: 12px 20px; border-radius: 25px; display: inline-block; margin-top: 20px; font-family: "Courier New", monospace; font-size: 18px; font-weight: 600; letter-spacing: 1px; }
                .content { padding: 40px 30px; }
                .alert-box { background: linear-gradient(135deg, #fee2e2, #fef3c7); border: 2px solid #f59e0b; border-radius: 12px; padding: 25px; margin-bottom: 30px; }
                .alert-title { color: #dc2626; font-size: 22px; font-weight: 700; margin: 0 0 15px 0; }
                .customer-info { background: #f1f5f9; border-radius: 12px; padding: 25px; margin: 25px 0; }
                .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px; }
                .info-item { }
                .info-label { font-size: 13px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px; }
                .info-value { font-size: 16px; color: #1e293b; font-weight: 600; }
                .details-table { width: 100%; border-collapse: separate; border-spacing: 0; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
                .details-table th { background: #3b82f6; color: white; padding: 15px; text-align: left; font-weight: 600; }
                .details-table td { padding: 15px; border-bottom: 1px solid #e2e8f0; }
                .details-table tr:last-child td { border-bottom: none; }
                .status-badge { background: #fbbf24; color: #92400e; padding: 8px 16px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
                .action-box { background: linear-gradient(135deg, #fee2e2, #fef3c7); border-left: 6px solid #dc2626; padding: 25px; margin: 30px 0; border-radius: 8px; }
                .action-title { color: #dc2626; font-size: 18px; font-weight: 700; margin: 0 0 12px 0; }
                .footer { text-align: center; padding: 30px; background: #f8fafc; color: #64748b; font-size: 14px; }
                .rupee { color: #059669; font-weight: 600; }
            </style>
        </head>
        <body>
            <div class="email-container">
                <!-- Header -->
                <div class="header">
                    <h1>&#127760; New Booking Alert</h1>
                    <p><strong>' . htmlspecialchars($booking->customer_name) . '</strong> has booked a trip to <strong>' . htmlspecialchars($booking->destination) . '</strong></p>
                    <div class="ticket-badge">Ticket: ' . htmlspecialchars($ticketNumber) . '</div>
                </div>
                
                <!-- Content -->
                <div class="content">
                    <!-- Alert Box -->
                    <div class="alert-box">
                        <div class="alert-title">
                            &#9888;&#65039; Immediate Action Required
                        </div>
                        <p style="margin: 0; font-size: 16px; color: #92400e; font-weight: 500;">A new customer has made a booking and is waiting for confirmation. Please contact them within 24 hours.</p>
                    </div>
                    
                    <!-- Customer Information -->
                    <div class="customer-info">
                        <h3 style="color: #1e293b; font-size: 20px; font-weight: 700; margin: 0 0 20px 0;">
                            &#128100; Customer Information
                        </h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Full Name</div>
                                <div class="info-value">' . htmlspecialchars($booking->customer_name) . '</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Email Address</div>
                                <div class="info-value">' . htmlspecialchars($booking->customer_email) . '</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Phone Number</div>
                                <div class="info-value">' . htmlspecialchars($booking->customer_phone) . '</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Number of Travelers</div>
                                <div class="info-value">' . $booking->number_of_travelers . ' Person' . ($booking->number_of_travelers > 1 ? 's' : '') . '</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Booking Details Table -->
                    <table class="details-table">
                        <thead>
                            <tr>
                                <th colspan="2" style="text-align: center; font-size: 18px;">&#128203; Complete Booking Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="font-weight: 600; color: #475569;">&#127915; Ticket Number</td>
                                <td style="font-family: monospace; font-weight: 700; color: #1e40af;">' . htmlspecialchars($ticketNumber) . '</td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600; color: #475569;">&#127757; Destination</td>
                                <td style="font-weight: 600;">' . htmlspecialchars($booking->destination) . '</td>
                            </tr>';
                            
        if ($booking->start_date) {
            $content .= '<tr>
                                <td style="font-weight: 600; color: #475569;">&#128197; Travel Start Date</td>
                                <td>' . $booking->start_date->format('l, F j, Y') . '</td>
                            </tr>';
        }
        
        if ($booking->end_date) {
            $content .= '<tr>
                                <td style="font-weight: 600; color: #475569;">&#128197; Travel End Date</td>
                                <td>' . $booking->end_date->format('l, F j, Y') . '</td>
                            </tr>';
        }
        
        if ($budgetFormatted) {
            $content .= '<tr>
                                <td style="font-weight: 600; color: #475569;">&#128176; Budget Range</td>
                                <td><span class="rupee">' . htmlspecialchars($budgetFormatted) . '</span></td>
                            </tr>';
        }
        
        $content .= '<tr>
                                <td style="font-weight: 600; color: #475569;">&#128221; Booking Date</td>
                                <td>' . $booking->booking_date->format('l, F j, Y \a\t g:i A') . '</td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600; color: #475569;">&#128202; Current Status</td>
                                <td><span class="status-badge">' . strtoupper($booking->status) . '</span></td>
                            </tr>
                        </tbody>
                    </table>';
        
        if ($booking->special_requirements) {
            $content .= '<div style="background: #fffbeb; border: 2px solid #f59e0b; border-radius: 12px; padding: 20px; margin: 25px 0;">
                            <h4 style="color: #d97706; margin: 0 0 12px 0; font-size: 16px; font-weight: 700;">
                                &#128221; Special Requirements
                            </h4>
                            <p style="margin: 0; color: #92400e; font-size: 15px; line-height: 1.6;">' . htmlspecialchars($booking->special_requirements) . '</p>
                        </div>';
        }
        
        $content .= '<!-- Action Required -->
                    <div class="action-box">
                        <div class="action-title">&#9889; Immediate Action Required</div>
                        <ul style="margin: 10px 0 0 20px; color: #92400e; font-size: 15px;">
                            <li>Contact the customer within <strong>24 hours</strong></li>
                            <li>Confirm travel dates and itinerary details</li>
                            <li>Discuss payment options and arrangements</li>
                            <li>Send detailed travel package information</li>
                        </ul>
                    </div>
                </div>';
                
        $content .= '<!-- Footer -->
                <div class="footer">
                    <p style="margin: 0 0 10px 0; font-weight: 600; color: #374151;">Cholo Bondhu Tour & Travels</p>
                    <p style="margin: 0; font-size: 13px;">Administrative Notification System</p>
                </div>
            </div>
        </body>
        </html>';
        
        return $content;
    }
    
    private function buildCustomerEmailContent($booking, $ticketNumber)
    {
        $content = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Booking Confirmation</title>
        </head>
        <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f8fafc;">
            <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
                
                <!-- Header -->
                <div style="background: linear-gradient(135deg, #059669, #3b82f6); color: white; padding: 30px; border-radius: 8px; text-align: center; margin-bottom: 20px;">
                    <h1 style="margin: 0 0 15px 0; font-size: 28px;">&#9989; Booking Confirmation</h1>
                    <p style="margin: 0; font-size: 16px;">Thank you for choosing Cholo Bondhu!</p>
                    <div style="background: rgba(255,255,255,0.2); padding: 12px 20px; border-radius: 25px; display: inline-block; margin-top: 20px; font-family: monospace; font-size: 18px; font-weight: 600;">' . htmlspecialchars($ticketNumber) . '</div>
                </div>
                
                <div style="background: #f9fafb; padding: 25px; border-radius: 8px;">
                    <p>Dear <strong>' . htmlspecialchars($booking->customer_name) . '</strong>,</p>
                    <p>We are excited to confirm that we have received your booking request! Our team will review your details and contact you within 24 hours to finalize your travel arrangements.</p>
                    
                    <!-- Booking Details Card -->
                    <div style="background: white; border-radius: 12px; padding: 25px; margin: 20px 0; border: 2px solid #e5e7eb;">
                        <h3 style="color: #1f2937; margin-top: 0; font-size: 18px;">&#128203; Your Booking Details</h3>
                        
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr><td style="padding: 8px 0; font-weight: bold; color: #374151;">&#127915; Ticket Number:</td><td style="padding: 8px 0; color: #6b7280;">' . htmlspecialchars($ticketNumber) . '</td></tr>
                            <tr><td style="padding: 8px 0; font-weight: bold; color: #374151;">&#127757; Destination:</td><td style="padding: 8px 0; color: #6b7280;">' . htmlspecialchars($booking->destination) . '</td></tr>';
        
        if ($booking->start_date) {
            $dateText = $booking->start_date->format('M d, Y');
            if ($booking->end_date) {
                $dateText .= ' to ' . $booking->end_date->format('M d, Y');
            }
            $content .= '<tr><td style="padding: 8px 0; font-weight: bold; color: #374151;">&#128197; Travel Dates:</td><td style="padding: 8px 0; color: #6b7280;">' . $dateText . '</td></tr>';
        }
        
        $content .= '<tr><td style="padding: 8px 0; font-weight: bold; color: #374151;">&#128101; Travelers:</td><td style="padding: 8px 0; color: #6b7280;">' . $booking->number_of_travelers . ' person(s)</td></tr>';
        
        if ($booking->budget_range) {
            $content .= '<tr><td style="padding: 8px 0; font-weight: bold; color: #374151;">&#128176; Budget:</td><td style="padding: 8px 0; color: #6b7280;">' . htmlspecialchars($booking->budget_range) . '</td></tr>';
        }
        
        $content .= '<tr><td style="padding: 8px 0; font-weight: bold; color: #374151;">&#128197; Booking Date:</td><td style="padding: 8px 0; color: #6b7280;">' . $booking->booking_date->format('M d, Y \\a\\t g:i A') . '</td></tr>';
        $content .= '<tr><td style="padding: 8px 0; font-weight: bold; color: #374151;">&#128202; Status:</td><td style="padding: 8px 0;"><span style="background: #fef3c7; color: #d97706; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: bold;">' . strtoupper($booking->status) . '</span></td></tr>';
        $content .= '</table>';
        
        if ($booking->special_requirements) {
            $content .= '<div style="background: #f3f4f6; border-radius: 8px; padding: 15px; margin-top: 20px;">';
            $content .= '<div style="font-weight: bold; color: #374151; margin-bottom: 8px;">&#128221; Special Requirements:</div>';
            $content .= '<div style="color: #6b7280;">' . htmlspecialchars($booking->special_requirements) . '</div>';
            $content .= '</div>';
        }
        
        $content .= '</div>';
        
        // What's Next section
        $content .= '<div style="background: #dbeafe; padding: 20px; border-radius: 8px; margin: 20px 0;">';
        $content .= '<h3 style="color: #1e40af; margin-top: 0;">&#128222; What\'s Next?</h3>';
        $content .= '<ul style="color: #3730a3; margin: 0; padding-left: 20px;">';
        $content .= '<li>Our travel expert will contact you within 24 hours</li>';
        $content .= '<li>We will discuss your itinerary and finalize the package details</li>';
        $content .= '<li>Payment and booking confirmation will follow</li>';
        $content .= '<li>You will receive a detailed travel guide before your trip</li>';
        $content .= '</ul>';
        $content .= '</div>';
        
        // Contact buttons
        $content .= '<div style="text-align: center; margin: 30px 0;">';
        $content .= '<a href="https://wa.me/918100282665" style="display: inline-block; padding: 12px 24px; background: #25d366; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; margin: 10px 5px;">&#128172; WhatsApp Us</a>';
        $content .= '<a href="tel:+918100282665" style="display: inline-block; padding: 12px 24px; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; margin: 10px 5px;">&#128222; Call Us</a>';
        $content .= '</div>';
        
        $content .= '</div>';
        
        // Footer
        $content .= '<div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 2px solid #e5e7eb; color: #6b7280; font-size: 14px;">';
        $content .= '<p style="font-weight: 600; color: #374151; margin-bottom: 5px;">Cholo Bondhu Tour & Travels</p>';
        $content .= '<p style="margin: 5px 0;">&#128222; +91 81002 82665 | &#128231; cholo.bondhu.noreply@gmail.com</p>';
        $content .= '<p style="margin: 5px 0;">&#128205; Bagnan, Howrah 711303, West Bengal, India</p>';
        $content .= '<p style="margin-top: 15px; font-size: 12px; color: #9ca3af;">This is an automated confirmation. Please do not reply to this email.</p>';
        $content .= '</div>';
        
        $content .= '</div>
        </body>
        </html>';
        
        return $content;
    }
    
    private function saveEmailToFile($booking, $ticketNumber, $customerEmail, $adminEmail)
    {
        $emailDir = storage_path('emails');
        if (!file_exists($emailDir)) {
            mkdir($emailDir, 0755, true);
        }
        
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "booking_{$ticketNumber}_{$timestamp}.html";
        $filepath = $emailDir . '/' . $filename;
        
        $content = $this->buildEmailContent($booking, $ticketNumber, false);
        
        file_put_contents($filepath, $content);
        
        Log::info("Booking email saved to file: {$filepath}");
        Log::info("Email details - Customer: {$customerEmail}, Admin: {$adminEmail}, Ticket: {$ticketNumber}");
    }
    
    private function sendViaPHPMailer($booking, $ticketNumber, $customerEmail, $adminEmail)
    {
        // Send customer email
        $this->sendCustomerEmailViaPHPMailer($booking, $ticketNumber, $customerEmail);
        
        // Send admin email
        $this->sendAdminEmailViaPHPMailer($booking, $ticketNumber, $adminEmail);
    }
    
    private function sendCustomerEmailViaPHPMailer($booking, $ticketNumber, $customerEmail)
    {
        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            
            // Server settings
            $mail->isSMTP();
            $mail->Host = env('MAIL_HOST', 'smtp.gmail.com');
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = env('MAIL_PORT', 587);
            
            // Set charset to UTF-8 explicitly
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            
            // Recipients
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME', 'Cholo Bondhu Tour'));
            $mail->addAddress($customerEmail, $booking->customer_name);
            $mail->addReplyTo(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME', 'Cholo Bondhu Tour'));
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Booking Confirmation - Ticket #' . $ticketNumber;
            $mail->Body = $this->buildEmailContent($booking, $ticketNumber, false);
            
            $mail->send();
            Log::info('Customer booking email sent successfully via PHPMailer to: ' . $customerEmail);
            
        } catch (\Exception $e) {
            Log::error('Customer PHPMailer failed: ' . $e->getMessage());
            throw $e;
        }
    }
    
    private function sendAdminEmailViaPHPMailer($booking, $ticketNumber, $adminEmail)
    {
        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            
            // Server settings
            $mail->isSMTP();
            $mail->Host = env('MAIL_HOST', 'smtp.gmail.com');
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = env('MAIL_PORT', 587);
            
            // Set charset to UTF-8 explicitly
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            
            // Recipients
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME', 'Cholo Bondhu Tour'));
            $mail->addAddress($adminEmail, 'Cholo Bondhu Admin');
            $mail->addReplyTo($booking->customer_email, $booking->customer_name);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'New Booking Alert - ' . $booking->customer_name . ' booked ' . $booking->destination;
            $mail->Body = $this->buildEmailContent($booking, $ticketNumber, true);
            
            $mail->send();
            Log::info('Admin booking email sent successfully via PHPMailer to: ' . $adminEmail);
            
        } catch (\Exception $e) {
            Log::error('Admin PHPMailer failed: ' . $e->getMessage());
            throw $e;
        }
    }
    
    private function sendViaWebhook($booking, $ticketNumber, $customerEmail, $adminEmail)
    {
        // Create email data
        $emailData = [
            'to' => $customerEmail,
            'admin_to' => $adminEmail,
            'subject' => 'Booking Confirmation - Ticket #' . $ticketNumber,
            'ticket_number' => $ticketNumber,
            'customer_name' => $booking->customer_name,
            'destination' => $booking->destination,
            'travelers' => $booking->number_of_travelers,
            'phone' => $booking->customer_phone,
            'booking_date' => $booking->booking_date->format('M d, Y H:i'),
            'start_date' => $booking->start_date ? $booking->start_date->format('M d, Y') : 'TBD',
            'end_date' => $booking->end_date ? $booking->end_date->format('M d, Y') : 'TBD',
            'budget' => $booking->budget_range ?? 'Not specified',
            'special_requirements' => $booking->special_requirements ?? 'None'
        ];
        
        // Save to a JSON file that can be processed by an external script
        $emailQueueDir = storage_path('email_queue');
        if (!file_exists($emailQueueDir)) {
            mkdir($emailQueueDir, 0755, true);
        }
        
        $queueFile = $emailQueueDir . '/booking_' . $ticketNumber . '_' . time() . '.json';
        file_put_contents($queueFile, json_encode($emailData, JSON_PRETTY_PRINT));
        
        Log::info("Email queued for external processing: {$queueFile}");
    }


    /**
     * Get user's booking history
     */
    public function getUserBookingHistory(int $userId, int $perPage = 10)
    {
        return Booking::where('user_id', $userId)
            ->with('tourPackage')
            ->orderBy('booking_date', 'desc')
            ->paginate($perPage);
    }

    /**
     * Extract ticket number from booking notes
     */
    public function getTicketNumber(Booking $booking): ?string
    {
        if (preg_match('/Ticket Number: ([A-Z0-9]+)/', $booking->notes, $matches)) {
            return $matches[1];
        }
        
        return null;
    }
    
    /**
     * Cancel a booking with email notifications
     */
    public function cancelBooking(Booking $booking, string $reason = 'No reason provided'): bool
    {
        $ticketNumber = $this->getTicketNumber($booking);
        
        // Update booking status
        $booking->update([
            'status' => 'cancelled',
            'notes' => $booking->notes . ' | Cancelled on: ' . now()->format('Y-m-d H:i:s') . ' | Reason: ' . $reason,
        ]);
        
        // Send cancellation emails
        $this->sendCancellationEmails($booking, $ticketNumber, $reason);
        
        return true;
    }
    
    /**
     * Send cancellation email notifications
     */
    private function sendCancellationEmails($booking, $ticketNumber, $reason = 'No reason provided')
    {
        $customerEmail = $booking->customer_email;
        $adminEmail = env('MAIL_COMPANY_EMAIL', 'cholo.bondhu.noreply@gmail.com');
        
        try {
            // Send customer cancellation email
            $this->sendCustomerCancellationEmail($booking, $ticketNumber, $customerEmail, $reason);
            
            // Send admin cancellation email  
            $this->sendAdminCancellationEmail($booking, $ticketNumber, $adminEmail, $reason);
            
            Log::info('Cancellation emails sent successfully for ticket: ' . $ticketNumber . ' with reason: ' . $reason);
        } catch (\Exception $e) {
            Log::error('Failed to send cancellation emails: ' . $e->getMessage());
        }
    }
    
    private function sendCustomerCancellationEmail($booking, $ticketNumber, $customerEmail, $reason = 'No reason provided')
    {
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        
        // Server settings
        $mail->isSMTP();
        $mail->Host = env('MAIL_HOST', 'smtp.gmail.com');
        $mail->SMTPAuth = true;
        $mail->Username = env('MAIL_USERNAME');
        $mail->Password = env('MAIL_PASSWORD');
        $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = env('MAIL_PORT', 587);
        
        // Recipients
        $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME', 'Cholo Bondhu Tour'));
        $mail->addAddress($customerEmail, $booking->customer_name);
        $mail->addReplyTo(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME', 'Cholo Bondhu Tour'));
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Booking Cancelled - Ticket #' . $ticketNumber;
        $mail->Body = $this->buildCancellationEmailContent($booking, $ticketNumber, false, $reason);
        
        $mail->send();
    }
    
    private function sendAdminCancellationEmail($booking, $ticketNumber, $adminEmail, $reason = 'No reason provided')
    {
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        
        // Server settings
        $mail->isSMTP();
        $mail->Host = env('MAIL_HOST', 'smtp.gmail.com');
        $mail->SMTPAuth = true;
        $mail->Username = env('MAIL_USERNAME');
        $mail->Password = env('MAIL_PASSWORD');
        $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = env('MAIL_PORT', 587);
        
        // Recipients
        $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME', 'Cholo Bondhu Tour'));
        $mail->addAddress($adminEmail, 'Cholo Bondhu Admin');
        $mail->addReplyTo($booking->customer_email, $booking->customer_name);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Booking Cancelled - ' . $booking->customer_name . ' cancelled ' . $booking->destination;
        $mail->Body = $this->buildCancellationEmailContent($booking, $ticketNumber, true, $reason);
        
        $mail->send();
    }
    
    private function buildCancellationEmailContent($booking, $ticketNumber, $isAdmin = false, $reason = 'No reason provided')
    {
        if ($isAdmin) {
            // Admin cancellation email with professional formatting
            $budgetFormatted = $booking->budget_range;
            if ($budgetFormatted) {
                $budgetFormatted = str_replace(['Rs.', 'rs.', 'RS.', 'rupees', 'Rupees'], '₹', $budgetFormatted);
            }
            
            $content = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Booking Cancellation Alert</title>
                <style>
                    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap");
                    body { font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; margin: 0; padding: 0; background-color: #f8fafc; }
                    .email-container { max-width: 650px; margin: 30px auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
                    .header { background: linear-gradient(135deg, #dc2626 0%, #991b1b 50%, #7f1d1d 100%); color: white; padding: 40px 30px; text-align: center; }
                    .content { padding: 40px 30px; }
                    .cancellation-info { background: #fef2f2; border: 2px solid #f87171; border-radius: 12px; padding: 25px; margin: 25px 0; }
                    .footer { text-align: center; padding: 30px; background: #f8fafc; color: #64748b; font-size: 14px; }
                </style>
            </head>
            <body>
                <div class="email-container">
                    <div class="header">
                        <h1>&#10060; Booking Cancellation Alert</h1>
                        <p><strong>' . htmlspecialchars($booking->customer_name) . '</strong> has cancelled their booking for <strong>' . htmlspecialchars($booking->destination) . '</strong></p>
                        <div style="background: rgba(255,255,255,0.2); padding: 12px 20px; border-radius: 25px; display: inline-block; margin-top: 20px; font-family: monospace; font-size: 18px; font-weight: 600;">Ticket: ' . htmlspecialchars($ticketNumber) . '</div>
                    </div>
                    
                    <div class="content">
                        <div class="cancellation-info">
                            <h3 style="color: #dc2626; margin: 0 0 15px 0; font-size: 20px;">&#128203; Cancelled Booking Details</h3>
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr><td style="padding: 8px 0; font-weight: 600; color: #475569;">Customer Name:</td><td style="padding: 8px 0; color: #1e293b;">' . htmlspecialchars($booking->customer_name) . '</td></tr>
                                <tr><td style="padding: 8px 0; font-weight: 600; color: #475569;">Email:</td><td style="padding: 8px 0; color: #1e293b;">' . htmlspecialchars($booking->customer_email) . '</td></tr>
                                <tr><td style="padding: 8px 0; font-weight: 600; color: #475569;">Phone:</td><td style="padding: 8px 0; color: #1e293b;">' . htmlspecialchars($booking->customer_phone) . '</td></tr>
                                <tr><td style="padding: 8px 0; font-weight: 600; color: #475569;">Destination:</td><td style="padding: 8px 0; color: #1e293b;">' . htmlspecialchars($booking->destination) . '</td></tr>
                                <tr><td style="padding: 8px 0; font-weight: 600; color: #475569;">Travelers:</td><td style="padding: 8px 0; color: #1e293b;">' . $booking->number_of_travelers . ' person' . ($booking->number_of_travelers > 1 ? 's' : '') . '</td></tr>';
            
            if ($budgetFormatted) {
                $content .= '<tr><td style="padding: 8px 0; font-weight: 600; color: #475569;">Budget:</td><td style="padding: 8px 0; color: #059669; font-weight: 600;">' . htmlspecialchars($budgetFormatted) . '</td></tr>';
            }
            
            $content .= '<tr><td style="padding: 8px 0; font-weight: 600; color: #475569;">Cancellation Date:</td><td style="padding: 8px 0; color: #dc2626; font-weight: 600;">' . now()->format('l, F j, Y \a\t g:i A') . '</td></tr>
                                <tr><td style="padding: 8px 0; font-weight: 600; color: #475569;">Cancellation Reason:</td><td style="padding: 8px 0; color: #dc2626; font-style: italic;">' . htmlspecialchars($reason) . '</td></tr>
                            </table>
                        </div>
                        
                        <div style="background: #f0f9ff; border: 2px solid #3b82f6; border-radius: 12px; padding: 20px; margin: 25px 0;">
                            <h4 style="color: #1e40af; margin: 0 0 10px 0; font-size: 16px;">📝 Note for Admin</h4>
                            <p style="margin: 0; color: #1e40af; font-size: 14px;">This booking has been cancelled by the customer. No further action is required unless the customer contacts you for a new booking.</p>
                        </div>
                    </div>
                    
                    <div class="footer">
                        <p style="margin: 0 0 10px 0; font-weight: 600; color: #374151;">Cholo Bondhu Tour & Travels</p>
                        <p style="margin: 0; font-size: 13px;">Administrative Notification System</p>
                    </div>
                </div>
            </body>
            </html>';
        } else {
            // Customer cancellation email - simple and clean
            $content = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Booking Cancelled</title>
            </head>
            <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f8fafc;">
                <div style="max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <div style="background: linear-gradient(135deg, #dc2626, #991b1b); color: white; padding: 40px 30px; text-align: center;">
                        <h1 style="margin: 0 0 15px 0; font-size: 28px;">&#10060; Booking Cancelled</h1>
                        <p style="margin: 0; font-size: 16px; opacity: 0.9;">Your booking has been successfully cancelled</p>
                        <div style="background: rgba(255,255,255,0.2); padding: 12px 20px; border-radius: 25px; display: inline-block; margin-top: 20px; font-family: monospace; font-size: 18px; font-weight: 600;">' . htmlspecialchars($ticketNumber) . '</div>
                    </div>
                    
                    <div style="padding: 40px 30px;">
                        <p style="font-size: 16px; margin-bottom: 20px;">Dear <strong>' . htmlspecialchars($booking->customer_name) . '</strong>,</p>
                        <p style="font-size: 16px; margin-bottom: 25px;">We have successfully cancelled your booking. If you have any questions or need assistance with a new booking, please don\'t hesitate to contact us.</p>
                        
                        <div style="background: #f1f5f9; border-radius: 12px; padding: 20px; margin: 25px 0;">
                            <h3 style="color: #1f2937; margin-top: 0; font-size: 18px;">&#128203; Cancelled Booking Summary</h3>
                            <p><strong>Destination:</strong> ' . htmlspecialchars($booking->destination) . '</p>
                            <p><strong>Travelers:</strong> ' . $booking->number_of_travelers . ' person' . ($booking->number_of_travelers > 1 ? 's' : '') . '</p>
                            <p><strong>Cancellation Date:</strong> ' . now()->format('F j, Y \a\t g:i A') . '</p>
                        </div>
                        
                        <p style="font-size: 16px; margin: 25px 0;">Thank you for choosing Cholo Bondhu Tour & Travels. We look forward to serving you in the future!</p>
                        
                        <div style="text-align: center; margin: 30px 0;">
                            <a href="https://wa.me/918100282665" style="display: inline-block; padding: 12px 24px; background: #25d366; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; margin: 5px;">&#128172; WhatsApp</a>
                            <a href="tel:+918100282665" style="display: inline-block; padding: 12px 24px; background: #3b82f6; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; margin: 5px;">&#128222; Call Us</a>
                        </div>
                    </div>
                    
                    <div style="text-align: center; padding: 30px; background: #f8fafc; color: #64748b; font-size: 14px;">
                        <p style="margin: 0 0 5px 0; font-weight: 600; color: #374151;">Cholo Bondhu Tour & Travels</p>
                        <p style="margin: 0;">&#128222; +91 81002 82665 | &#128231; cholo.bondhu.noreply@gmail.com</p>
                    </div>
                </div>
            </body>
            </html>';
        }
        
        return $content;
    }
}
