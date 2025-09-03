<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\TourPackage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmationMail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Show the booking form
     */
    public function index(Request $request)
    {
        // Get auto-fill data from URL parameters
        $autoFillData = [];
        if ($request->has('package_name')) {
            $autoFillData['package_name'] = $request->get('package_name');
        }
        if ($request->has('destination')) {
            $autoFillData['destination'] = $request->get('destination');
        }
        if ($request->has('price')) {
            $autoFillData['price'] = $request->get('price');
        }
        if ($request->has('duration')) {
            $autoFillData['duration'] = $request->get('duration');
        }
        if ($request->has('package_type')) {
            $autoFillData['package_type'] = $request->get('package_type');
        }

        return view('booking.create', compact('autoFillData'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tour_package_id' => 'nullable|exists:tour_packages,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|regex:/^[\d\s\-\+\(\)]+$/',
            'destination' => 'required|string|max:255',
            'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'nullable|date|after:start_date',
            'number_of_travelers' => 'required|integer|min:1|max:50',
            'budget_range' => 'nullable|string|max:255',
            'special_requirements' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'tour_package_id' => $request->tour_package_id,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'destination' => $request->destination,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'number_of_travelers' => $request->number_of_travelers,
            'budget_range' => $request->budget_range,
            'special_requirements' => $request->special_requirements,
            'booking_date' => Carbon::now(),
            'status' => 'pending'
        ]);

        // Send booking notification email to admin only
        $this->sendAdminBookingNotification($booking);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Booking request submitted successfully! We will contact you soon.',
                'booking_number' => $booking->booking_number
            ]);
        }

        return redirect()->route('booking.index')->with([
            'success' => 'Booking request submitted successfully! We will contact you soon.',
            'ticket_number' => $booking->booking_number,
            'show_popup' => true
        ]);
    }

    public function myBookings()
    {
        $bookings = Auth::user()->bookings()->latest()->paginate(10);
        
        return view('booking.my-bookings', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        // Ensure user can only view their own bookings
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('bookings.show', compact('booking'));
    }

    /**
     * Cancel a booking with reason
     */
    public function cancel(Request $request, Booking $booking)
    {
        // Ensure user can only cancel their own bookings
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'You can only cancel your own bookings.');
        }

        // Check if booking can be cancelled
        if ($booking->status === 'cancelled') {
            return redirect()->back()->with('error', 'This booking is already cancelled.');
        }

        // Validate cancellation reason
        $request->validate([
            'cancellation_reason' => 'required|string|max:1000'
        ]);

        // Update booking status and add cancellation note
        $booking->status = 'cancelled';
        $cancellationNote = "\n\n[" . now()->format('Y-m-d H:i:s') . "] Booking cancelled by customer.\nCancellation Reason: " . $request->cancellation_reason;
        $booking->notes = ($booking->notes ?? '') . $cancellationNote;
        $booking->save();

        // Send cancellation emails
        $this->sendCancellationEmails($booking, $request->cancellation_reason);

        return redirect()->route('booking.my-bookings')->with('success', 'Booking cancelled successfully.');
    }

    /**
     * Send cancellation notification to admin only
     */
    private function sendCancellationEmails($booking, $reason)
    {
        $adminEmail = env('MAIL_COMPANY_EMAIL', 'cholo.bondhu.noreply@gmail.com');
        
        try {
            $subject = '❌ Booking Cancelled - Ticket #' . $booking->booking_number;
            
            // Email content for admin only
            $adminMessage = $this->buildCancellationEmailContent($booking, $reason, true);
            
            // Use Laravel's Mail facade instead of PHP mail()
            Mail::send([], [], function ($message) use ($adminEmail, $subject, $adminMessage) {
                $message->to($adminEmail)
                        ->subject($subject)
                        ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                        ->html($adminMessage);
            });
            
            \Log::info('Admin cancellation notification sent successfully to: ' . $adminEmail);
            $this->saveEmailBackup($booking, $adminMessage, 'cancellation');
            
        } catch (\Exception $e) {
            \Log::error('Failed to send admin cancellation notification: ' . $e->getMessage());
        }
    }

    /**
     * Build cancellation email content
     */
    private function buildCancellationEmailContent($booking, $reason, $isAdmin = false)
    {
        $content = '<html><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">';
        
        if ($isAdmin) {
            $content .= '<h2 style="color: #dc2626;">Booking Cancellation Notice</h2>';
            $content .= '<p>A booking has been cancelled by the customer.</p>';
        } else {
            $content .= '<h2 style="color: #dc2626;">Booking Cancellation Confirmation</h2>';
            $content .= '<p>Dear ' . htmlspecialchars($booking->customer_name) . ',</p>';
            $content .= '<p>Your booking has been successfully cancelled as requested.</p>';
        }
        
        $content .= '<div style="background: #fef2f2; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #dc2626;">';
        $content .= '<h3 style="margin-top: 0; color: #dc2626;">Cancelled Booking Details</h3>';
        $content .= '<p><strong>Ticket Number:</strong> ' . htmlspecialchars($booking->booking_number ?? $booking->id) . '</p>';
        $content .= '<p><strong>Customer:</strong> ' . htmlspecialchars($booking->customer_name) . '</p>';
        $content .= '<p><strong>Destination:</strong> ' . htmlspecialchars($booking->destination) . '</p>';
        $content .= '<p><strong>Travelers:</strong> ' . $booking->number_of_travelers . '</p>';
        $content .= '<p><strong>Cancellation Date:</strong> ' . now()->format('M d, Y H:i') . '</p>';
        $content .= '<p><strong>Cancellation Reason:</strong> ' . htmlspecialchars($reason) . '</p>';
        $content .= '</div>';
        
        if (!$isAdmin) {
            $content .= '<p>If you have any questions about this cancellation, please contact us.</p>';
            $content .= '<p>We hope to serve you again in the future!</p>';
        }
        
        $content .= '<hr style="margin: 30px 0; border: none; border-top: 1px solid #e5e7eb;">';
        $content .= '<p style="font-size: 12px; color: #6b7280;">Best regards,<br>Cholo Bondhu Tour and Travels<br>Email: rudraxyt@gmail.com</p>';
        $content .= '</body></html>';
        
        return $content;
    }

    private function sendAdminBookingNotification($booking)
    {
        // Use the admin email from .env file
        $adminEmail = env('MAIL_COMPANY_EMAIL', 'cholo.bondhu.noreply@gmail.com');
        
        try {
            // Send only to admin using Laravel Mail - no email to customer
            $subject = '🎫 New Booking Received - Ticket #' . $booking->booking_number;
            $adminMessage = $this->buildAdminEmailContent($booking);
            
            // Use Laravel's Mail facade instead of PHP mail()
            Mail::send([], [], function ($message) use ($adminEmail, $subject, $adminMessage) {
                $message->to($adminEmail)
                        ->subject($subject)
                        ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                        ->html($adminMessage);
            });
            
            \Log::info('Admin booking notification sent successfully to: ' . $adminEmail);
            
            // Also save email to storage for backup
            $this->saveEmailBackup($booking, $adminMessage, 'booking');
            
            return true;
            
        } catch (\Exception $e) {
            \Log::error('Admin booking notification failed: ' . $e->getMessage());
            return false;
        }
    }
    

    
    private function buildAdminEmailContent($booking)
    {
        $content = '<html><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">';
        
        $content .= '<div style="background: #2563eb; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0;">';
        $content .= '<h1 style="margin: 0; font-size: 24px;">🎫 New Booking Received</h1>';
        $content .= '<p style="margin: 10px 0 0 0; opacity: 0.9;">Cholo Bondhu Tour and Travels</p>';
        $content .= '</div>';
        
        $content .= '<div style="background: #f8fafc; padding: 30px; border-radius: 0 0 8px 8px; border: 1px solid #e5e7eb;">';
        
        // Ticket Number Highlight
        $content .= '<div style="background: #dbeafe; border: 2px solid #3b82f6; padding: 15px; border-radius: 8px; text-align: center; margin-bottom: 25px;">';
        $content .= '<h2 style="margin: 0; color: #1e40af; font-size: 20px;">Ticket Number: ' . htmlspecialchars($booking->booking_number) . '</h2>';
        $content .= '</div>';
        
        // Customer Information
        $content .= '<div style="background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #10b981;">';
        $content .= '<h3 style="margin-top: 0; color: #1f2937; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px;">👤 Customer Information</h3>';
        $content .= '<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">';
        $content .= '<div><strong>Name:</strong><br>' . htmlspecialchars($booking->customer_name) . '</div>';
        $content .= '<div><strong>Email:</strong><br><a href="mailto:' . htmlspecialchars($booking->customer_email) . '" style="color: #2563eb;">' . htmlspecialchars($booking->customer_email) . '</a></div>';
        $content .= '<div><strong>Phone:</strong><br><a href="tel:' . htmlspecialchars($booking->customer_phone) . '" style="color: #2563eb;">' . htmlspecialchars($booking->customer_phone) . '</a></div>';
        $content .= '<div><strong>Travelers:</strong><br>' . $booking->number_of_travelers . ' person(s)</div>';
        $content .= '</div>';
        $content .= '</div>';
        
        // Trip Information
        $content .= '<div style="background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #f59e0b;">';
        $content .= '<h3 style="margin-top: 0; color: #1f2937; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px;">🏖️ Trip Information</h3>';
        $content .= '<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">';
        $content .= '<div><strong>Destination:</strong><br>' . htmlspecialchars($booking->destination) . '</div>';
        
        if ($booking->start_date) {
            $content .= '<div><strong>Start Date:</strong><br>' . $booking->start_date->format('M d, Y') . '</div>';
        }
        if ($booking->end_date) {
            $content .= '<div><strong>End Date:</strong><br>' . $booking->end_date->format('M d, Y') . '</div>';
        }
        if ($booking->budget_range) {
            $content .= '<div><strong>Budget Range:</strong><br>' . htmlspecialchars($booking->budget_range) . '</div>';
        }
        
        $content .= '<div><strong>Booking Date:</strong><br>' . $booking->created_at->format('M d, Y H:i A') . '</div>';
        $content .= '<div><strong>Status:</strong><br><span style="background: #fef3c7; color: #92400e; padding: 4px 8px; border-radius: 4px; font-weight: bold;">' . ucfirst($booking->status) . '</span></div>';
        $content .= '</div>';
        $content .= '</div>';
        
        // Special Requirements
        if ($booking->special_requirements) {
            $content .= '<div style="background: #fef7ff; padding: 20px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #a855f7;">';
            $content .= '<h3 style="margin-top: 0; color: #1f2937;">📝 Special Requirements</h3>';
            $content .= '<p style="margin: 0; color: #6b7280;">' . nl2br(htmlspecialchars($booking->special_requirements)) . '</p>';
            $content .= '</div>';
        }
        
        // Action Required
        $content .= '<div style="background: #fee2e2; padding: 20px; border-radius: 8px; border-left: 4px solid #ef4444;">';
        $content .= '<h3 style="margin-top: 0; color: #dc2626;">⚡ Action Required</h3>';
        $content .= '<p style="margin: 0; color: #7f1d1d;">Please contact the customer within 24 hours to confirm booking details and payment information.</p>';
        $content .= '</div>';
        
        $content .= '</div>';
        
        // Footer
        $content .= '<div style="text-align: center; padding: 20px; color: #6b7280; font-size: 12px;">';
        $content .= '<p>This is an automated notification from Cholo Bondhu Tour and Travels</p>';
        $content .= '<p>Admin Panel: <a href="' . url('/admin/bookings') . '" style="color: #2563eb;">View All Bookings</a></p>';
        $content .= '</div>';
        
        $content .= '</body></html>';
        
        return $content;
    }

    /**
     * Save email backup to storage
     */
    private function saveEmailBackup($booking, $emailContent, $type = 'booking')
    {
        try {
            $filename = $type . '_' . $booking->booking_number . '_' . now()->format('Y-m-d_H-i-s') . '.html';
            $path = storage_path('emails/' . $filename);
            
            // Create directory if it doesn't exist
            if (!file_exists(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }
            
            file_put_contents($path, $emailContent);
            \Log::info('Email backup saved: ' . $filename);
        } catch (\Exception $e) {
            \Log::error('Failed to save email backup: ' . $e->getMessage());
        }
    }

    /**
     * Test email functionality
     */
    public function testEmail()
    {
        $adminEmail = env('MAIL_COMPANY_EMAIL', 'cholo.bondhu.noreply@gmail.com');
        
        try {
            $subject = '✅ Email Test - Cholo Bondhu Booking System';
            $message = '
            <html>
            <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
                <div style="background: #2563eb; color: white; padding: 20px; text-align: center; border-radius: 8px;">
                    <h1 style="margin: 0;">✅ Email Test Successful</h1>
                    <p style="margin: 10px 0 0 0;">Cholo Bondhu Booking System</p>
                </div>
                <div style="padding: 20px;">
                    <p>This is a test email to verify that the booking notification system is working correctly.</p>
                    <p><strong>Test Details:</strong></p>
                    <ul>
                        <li>Date: ' . now()->format('M d, Y H:i A') . '</li>
                        <li>To: ' . $adminEmail . '</li>
                        <li>System: Laravel Mail with Gmail SMTP</li>
                        <li>PHP Version: ' . phpversion() . '</li>
                    </ul>
                    <p>If you receive this email, the booking notification system is configured correctly!</p>
                </div>
            </body>
            </html>';
            
            // Use Laravel's Mail facade
            Mail::send([], [], function ($mailMessage) use ($adminEmail, $subject, $message) {
                $mailMessage->to($adminEmail)
                           ->subject($subject)
                           ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                           ->html($message);
            });
            
            return response()->json(['success' => true, 'message' => 'Test email sent successfully to ' . $adminEmail]);
            
        } catch (\Exception $e) {
            \Log::error('Test email failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send test email: ' . $e->getMessage()]);
        }
    }

}
