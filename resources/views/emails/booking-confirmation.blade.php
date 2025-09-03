<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Confirmation - {{ $ticket_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #059669, #3b82f6); color: white; padding: 30px; border-radius: 8px 8px 0 0; text-align: center; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 8px 8px; }
        .booking-card { background: white; border-radius: 12px; padding: 25px; margin: 20px 0; border: 2px solid #e5e7eb; }
        .info-row { margin: 12px 0; display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f3f4f6; }
        .label { font-weight: bold; color: #374151; }
        .value { color: #6b7280; }
        .status-badge { display: inline-block; padding: 6px 12px; background: #fef3c7; color: #d97706; border-radius: 20px; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 2px solid #e5e7eb; color: #6b7280; font-size: 14px; }
        .cta-button { display: inline-block; padding: 12px 24px; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; margin: 10px 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Booking Confirmation</h1>
            <p>Thank you for choosing Cholo Bondhu!</p>
            <h2>{{ $ticket_number }}</h2>
        </div>
        
        <div class="content">
            <p>Dear {{ $booking->customer_name }},</p>
            
            <p>We're excited to confirm that we've received your booking request! Our team will review your details and contact you within 24 hours to finalize your travel arrangements.</p>
            
            <div class="booking-card">
                <h3 style="color: #1f2937; margin-bottom: 20px;">📋 Booking Details</h3>
                
                <div class="info-row">
                    <span class="label">🎫 Ticket Number:</span>
                    <span class="value">{{ $ticket_number }}</span>
                </div>
                
                <div class="info-row">
                    <span class="label">📍 Destination:</span>
                    <span class="value">{{ $booking->destination }}</span>
                </div>
                
                @if($booking->start_date)
                <div class="info-row">
                    <span class="label">📅 Travel Dates:</span>
                    <span class="value">{{ $booking->start_date->format('M d, Y') }} @if($booking->end_date) to {{ $booking->end_date->format('M d, Y') }}@endif</span>
                </div>
                @endif
                
                <div class="info-row">
                    <span class="label">👥 Travelers:</span>
                    <span class="value">{{ $booking->number_of_travelers }}</span>
                </div>
                
                @if($booking->budget_range)
                <div class="info-row">
                    <span class="label">💰 Budget Range:</span>
                    <span class="value">{{ $booking->budget_range }}</span>
                </div>
                @endif
                
                <div class="info-row">
                    <span class="label">📅 Booking Date:</span>
                    <span class="value">{{ $booking->booking_date->format('M d, Y \a\t g:i A') }}</span>
                </div>
                
                <div class="info-row">
                    <span class="label">📊 Status:</span>
                    <span class="status-badge">{{ ucfirst($booking->status) }}</span>
                </div>
                
                @if($booking->special_requirements)
                <div style="margin-top: 20px; padding: 15px; background: #f3f4f6; border-radius: 8px;">
                    <span class="label">📝 Special Requirements:</span>
                    <div style="margin-top: 8px; color: #6b7280;">{{ $booking->special_requirements }}</div>
                </div>
                @endif
            </div>

            <div style="background: #dbeafe; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h4 style="color: #1e40af; margin-bottom: 10px;">📞 What's Next?</h4>
                <ul style="color: #3730a3; margin: 0; padding-left: 20px;">
                    <li>Our travel expert will contact you within 24 hours</li>
                    <li>We'll discuss your itinerary and finalize the package details</li>
                    <li>Payment and booking confirmation will follow</li>
                    <li>You'll receive a detailed travel guide before your trip</li>
                </ul>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="https://wa.me/918100282665" class="cta-button" style="background: #25d366;">
                    💬 WhatsApp Us
                </a>
                <a href="tel:+918100282665" class="cta-button">
                    📞 Call Us
                </a>
            </div>
        </div>
        
        <div class="footer">
            <p><strong>Cholo Bondhu Tour & Travels</strong></p>
            <p>📞 +91 81002 82665 | 📧 cholobondhutour@gmail.com</p>
            <p>📍 Bagnan, Howrah 711303, West Bengal, India</p>
            <p style="margin-top: 15px; font-size: 12px; color: #9ca3af;">
                This is an automated confirmation. Please don't reply to this email.
            </p>
        </div>
    </div>
</body>
</html>
