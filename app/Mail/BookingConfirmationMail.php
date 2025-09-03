<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Booking;

class BookingConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $isAdmin;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking, $isAdmin = false)
    {
        $this->booking = $booking;
        $this->isAdmin = $isAdmin;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->isAdmin 
            ? 'New Booking Request - ' . $this->booking->booking_number
            : 'Booking Confirmation - ' . $this->booking->booking_number;
            
        return new Envelope(
            subject: $subject,
            replyTo: $this->booking->customer_email,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $view = $this->isAdmin ? 'emails.booking-admin' : 'emails.booking-confirmation';
        
        return new Content(
            view: $view,
            with: [
                'booking' => $this->booking,
                'ticket_number' => $this->booking->booking_number,
                'isAdmin' => $this->isAdmin
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
