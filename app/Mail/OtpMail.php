<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $userName;
    public $type;

    /**
     * Create a new message instance.
     */
    public function __construct(string $otp, string $userName, string $type)
    {
        $this->otp = $otp;
        $this->userName = $userName;
        $this->type = $type;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subjects = [
            'registration' => 'Complete Your Registration - OTP Verification',
            'login' => 'Secure Login - OTP Verification',
            'password_reset' => 'Password Reset - OTP Verification'
        ];

        return new Envelope(
            subject: $subjects[$this->type] ?? 'OTP Verification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.otp',
            with: [
                'otp' => $this->otp,
                'userName' => $this->userName,
                'type' => $this->type,
                'expiryMinutes' => 10
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