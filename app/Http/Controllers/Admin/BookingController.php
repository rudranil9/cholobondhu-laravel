<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Modules\Booking\Services\BookingService;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService = null)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Display all bookings for admin
     */
    public function index(Request $request)
    {
        $query = Booking::with('user')
            ->orderBy('booking_date', 'desc');

        // Apply status filter if provided
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Apply search filter if provided
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'LIKE', "%{$search}%")
                  ->orWhere('customer_email', 'LIKE', "%{$search}%")
                  ->orWhere('destination', 'LIKE', "%{$search}%")
                  ->orWhere('notes', 'LIKE', "%{$search}%");
            });
        }

        $bookings = $query->paginate(15);

        // Get booking statistics
        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'in_process' => Booking::where('status', 'in_process')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
            'rejected' => Booking::where('status', 'rejected')->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'stats'));
    }

    /**
     * Show booking details for admin
     */
    public function show(Booking $booking)
    {
        $booking->load('user');
        
        // Extract ticket number from notes
        $ticketNumber = null;
        if (preg_match('/Ticket Number: ([A-Z0-9]+)/', $booking->notes, $matches)) {
            $ticketNumber = $matches[1];
        }
        
        return view('admin.bookings.show', compact('booking', 'ticketNumber'));
    }

    /**
     * Update booking status
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,in_process,confirmed,rejected,cancelled',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $oldStatus = $booking->status;
        $newStatus = $request->status;
        
        // Add admin notes to booking notes
        $adminNotes = '';
        if ($request->admin_notes) {
            $adminNotes = ' | Admin Notes (' . now()->format('Y-m-d H:i:s') . '): ' . $request->admin_notes;
        }

        $booking->update([
            'status' => $newStatus,
            'notes' => $booking->notes . ' | Status updated from ' . $oldStatus . ' to ' . $newStatus . ' on ' . now()->format('Y-m-d H:i:s') . ' by ' . auth()->user()->name . $adminNotes
        ]);

        // Send status update notification emails
        $this->sendStatusUpdateEmails($booking, $oldStatus, $newStatus, $request->admin_notes);

        return back()->with('success', 'Booking status updated successfully from ' . ucfirst($oldStatus) . ' to ' . ucfirst($newStatus));
    }

    /**
     * Send status update notification emails
     */
    private function sendStatusUpdateEmails($booking, $oldStatus, $newStatus, $adminNotes = null)
    {
        // Extract ticket number from notes
        $ticketNumber = null;
        if (preg_match('/Ticket Number: ([A-Z0-9]+)/', $booking->notes, $matches)) {
            $ticketNumber = $matches[1];
        }
        
        try {
            // Send customer notification
            $this->sendCustomerStatusUpdateEmail($booking, $ticketNumber, $oldStatus, $newStatus, $adminNotes);
            
            \Illuminate\Support\Facades\Log::info("Status update email sent for booking ID: {$booking->id}, Ticket: {$ticketNumber}");
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send status update email: ' . $e->getMessage());
        }
    }

    /**
     * Send customer status update email
     */
    private function sendCustomerStatusUpdateEmail($booking, $ticketNumber, $oldStatus, $newStatus, $adminNotes = null)
    {
        if (!class_exists('\PHPMailer\PHPMailer\PHPMailer')) {
            // Fallback: Save email to file
            $this->saveStatusUpdateEmailToFile($booking, $ticketNumber, $oldStatus, $newStatus, $adminNotes);
            return;
        }

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        
        // Server settings
        $mail->isSMTP();
        $mail->Host = env('MAIL_HOST', 'smtp.gmail.com');
        $mail->SMTPAuth = true;
        $mail->Username = env('MAIL_USERNAME');
        $mail->Password = env('MAIL_PASSWORD');
        $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = env('MAIL_PORT', 587);
        
        // Set charset
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        
        // Recipients
        $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME', 'Cholo Bondhu Tour'));
        $mail->addAddress($booking->customer_email, $booking->customer_name);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Booking Update - Ticket #' . $ticketNumber . ' Status: ' . ucfirst($newStatus);
        $mail->Body = $this->buildStatusUpdateEmailContent($booking, $ticketNumber, $oldStatus, $newStatus, $adminNotes);
        
        $mail->send();
    }

    /**
     * Save status update email to file as fallback
     */
    private function saveStatusUpdateEmailToFile($booking, $ticketNumber, $oldStatus, $newStatus, $adminNotes = null)
    {
        $emailDir = storage_path('emails');
        if (!file_exists($emailDir)) {
            mkdir($emailDir, 0755, true);
        }
        
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "status_update_{$ticketNumber}_{$timestamp}.html";
        $filepath = $emailDir . '/' . $filename;
        
        $content = $this->buildStatusUpdateEmailContent($booking, $ticketNumber, $oldStatus, $newStatus, $adminNotes);
        
        file_put_contents($filepath, $content);
        
        \Illuminate\Support\Facades\Log::info("Status update email saved to file: {$filepath}");
    }

    /**
     * Build status update email content
     */
    private function buildStatusUpdateEmailContent($booking, $ticketNumber, $oldStatus, $newStatus, $adminNotes = null)
    {
        $statusColor = [
            'pending' => '#f59e0b',
            'in_process' => '#3b82f6', 
            'confirmed' => '#10b981',
            'rejected' => '#ef4444',
            'cancelled' => '#6b7280'
        ];

        $statusEmoji = [
            'pending' => '🕐',
            'in_process' => '⚙️', 
            'confirmed' => '✅',
            'rejected' => '❌',
            'cancelled' => '🚫'
        ];

        $content = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Booking Status Update</title>
        </head>
        <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f8fafc;">
            <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
                
                <!-- Header -->
                <div style="background: linear-gradient(135deg, ' . ($statusColor[$newStatus] ?? '#3b82f6') . ', #1e40af); color: white; padding: 30px; border-radius: 8px; text-align: center; margin-bottom: 20px;">
                    <h1 style="margin: 0 0 15px 0; font-size: 28px;">' . ($statusEmoji[$newStatus] ?? '📋') . ' Booking Status Update</h1>
                    <p style="margin: 0; font-size: 16px;">Your booking status has been updated</p>
                    <div style="background: rgba(255,255,255,0.2); padding: 12px 20px; border-radius: 25px; display: inline-block; margin-top: 20px; font-family: monospace; font-size: 18px; font-weight: 600;">' . htmlspecialchars($ticketNumber) . '</div>
                </div>
                
                <div style="background: #f9fafb; padding: 25px; border-radius: 8px;">
                    <p>Dear <strong>' . htmlspecialchars($booking->customer_name) . '</strong>,</p>
                    <p>We wanted to update you on the status of your booking for <strong>' . htmlspecialchars($booking->destination) . '</strong>.</p>
                    
                    <!-- Status Update Card -->
                    <div style="background: white; border-radius: 12px; padding: 25px; margin: 20px 0; border: 2px solid #e5e7eb;">
                        <h3 style="color: #1f2937; margin-top: 0; font-size: 18px;">📋 Status Update</h3>
                        
                        <div style="display: flex; align-items: center; justify-content: space-between; margin: 20px 0;">
                            <div style="text-align: center; flex: 1;">
                                <p style="margin: 0; font-size: 12px; color: #6b7280; text-transform: uppercase;">Previous Status</p>
                                <span style="display: inline-block; padding: 8px 16px; margin-top: 5px; border-radius: 20px; background: #f3f4f6; color: #4b5563; font-size: 14px; font-weight: 600;">' . ucfirst($oldStatus) . '</span>
                            </div>
                            <div style="text-align: center; padding: 0 20px;">
                                <span style="font-size: 24px;">→</span>
                            </div>
                            <div style="text-align: center; flex: 1;">
                                <p style="margin: 0; font-size: 12px; color: #6b7280; text-transform: uppercase;">Current Status</p>
                                <span style="display: inline-block; padding: 8px 16px; margin-top: 5px; border-radius: 20px; background: ' . ($statusColor[$newStatus] ?? '#3b82f6') . '; color: white; font-size: 14px; font-weight: 600;">' . ucfirst($newStatus) . '</span>
                            </div>
                        </div>';

        if ($adminNotes) {
            $content .= '
                        <div style="background: #f0f9ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 15px; margin-top: 20px;">
                            <p style="margin: 0; font-size: 14px; color: #1e40af; font-weight: 600;">💬 Message from our team:</p>
                            <p style="margin: 5px 0 0 0; font-size: 14px; color: #374151;">' . htmlspecialchars($adminNotes) . '</p>
                        </div>';
        }

        $content .= '
                    </div>';

        // Status-specific messages
        if ($newStatus === 'confirmed') {
            $content .= '
                    <div style="background: #d1fae5; border: 2px solid #10b981; border-radius: 8px; padding: 20px; margin: 20px 0;">
                        <h4 style="color: #047857; margin: 0 0 10px 0;">🎉 Great News!</h4>
                        <p style="margin: 0; color: #047857; font-size: 15px;">Your booking has been confirmed! Our team will contact you soon with detailed itinerary and payment instructions.</p>
                    </div>';
        } elseif ($newStatus === 'in_process') {
            $content .= '
                    <div style="background: #dbeafe; border: 2px solid #3b82f6; border-radius: 8px; padding: 20px; margin: 20px 0;">
                        <h4 style="color: #1e40af; margin: 0 0 10px 0;">⚙️ In Process</h4>
                        <p style="margin: 0; color: #1e40af; font-size: 15px;">We are currently processing your booking. Our team is working on your itinerary and will update you shortly.</p>
                    </div>';
        } elseif ($newStatus === 'rejected') {
            $content .= '
                    <div style="background: #fee2e2; border: 2px solid #ef4444; border-radius: 8px; padding: 20px; margin: 20px 0;">
                        <h4 style="color: #dc2626; margin: 0 0 10px 0;">😔 Booking Update</h4>
                        <p style="margin: 0; color: #dc2626; font-size: 15px;">Unfortunately, we cannot proceed with this booking at this time. Please contact us for alternative options.</p>
                    </div>';
        }
        
        // Contact buttons
        $content .= '
                    <div style="text-align: center; margin: 30px 0;">
                        <a href="https://wa.me/918100282665" style="display: inline-block; padding: 12px 24px; background: #25d366; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; margin: 10px 5px;">📱 WhatsApp Us</a>
                        <a href="tel:+918100282665" style="display: inline-block; padding: 12px 24px; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; margin: 10px 5px;">📞 Call Us</a>
                    </div>
                </div>
                
                <!-- Footer -->
                <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 2px solid #e5e7eb; color: #6b7280; font-size: 14px;">
                    <p style="font-weight: 600; color: #374151; margin-bottom: 5px;">Cholo Bondhu Tour & Travels</p>
                    <p style="margin: 5px 0;">📞 +91 81002 82665 | 📧 cholo.bondhu.noreply@gmail.com</p>
                    <p style="margin: 5px 0;">📍 Bagnan, Howrah 711303, West Bengal, India</p>
                </div>
            </div>
        </body>
        </html>';
        
        return $content;
    }

    /**
     * Get booking statistics for dashboard
     */
    public function getStats()
    {
        $stats = [
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            'cancelled_bookings' => Booking::where('status', 'cancelled')->count(),
            'recent_bookings' => Booking::where('booking_date', '>=', now()->subDays(7))->count(),
            'total_revenue' => 0, // Calculate based on confirmed bookings if you track revenue
        ];

        return response()->json($stats);
    }

    /**
     * Delete a booking
     */
    public function destroy(Booking $booking)
    {
        try {
            $customerName = $booking->customer_name;
            $destination = $booking->destination;
            $ticketNumber = null;
            
            // Extract ticket number from notes
            if (preg_match('/Ticket Number: ([A-Z0-9]+)/', $booking->notes, $matches)) {
                $ticketNumber = $matches[1];
            }
            
            // Delete the booking
            $booking->delete();
            
            \Illuminate\Support\Facades\Log::info("Booking deleted by admin: ID {$booking->id}, Customer: {$customerName}, Destination: {$destination}, Ticket: {$ticketNumber}");
            
            return redirect()->route('admin.bookings.index')->with('success', "Booking deleted successfully! Customer: {$customerName}, Destination: {$destination}" . ($ticketNumber ? ", Ticket: {$ticketNumber}" : ''));
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to delete booking: ' . $e->getMessage());
            
            return redirect()->route('admin.bookings.index')->with('error', 'Failed to delete booking. Please try again.');
        }
    }
}
