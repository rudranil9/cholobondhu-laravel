<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Booking Received - {{ $ticket_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            text-align: center;
            margin: -20px -20px 20px -20px;
        }
        .ticket-number {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #495057;
            margin: 20px 0;
        }
        .booking-details {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 8px;
        }
        .detail-label {
            font-weight: bold;
            color: #495057;
        }
        .detail-value {
            color: #6c757d;
        }
        .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .footer {
            text-align: center;
            color: #6c757d;
            font-size: 12px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }
        .urgent {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎯 New Booking Received!</h1>
            <p>Cholo Bondhu Travel - Admin Notification</p>
        </div>

        <div class="urgent">
            <strong>⚡ Action Required:</strong> A new booking has been submitted and requires your attention.
        </div>

        <div class="ticket-number">
            🎫 Ticket Number: <span style="color: #667eea;">{{ $ticket_number }}</span>
        </div>

        <div class="booking-details">
            <h3 style="margin-top: 0; color: #495057;">📋 Booking Details</h3>
            
            <div class="detail-row">
                <span class="detail-label">Customer Name:</span>
                <span class="detail-value">{{ $booking->customer_name }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Email:</span>
                <span class="detail-value">{{ $booking->customer_email }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Phone:</span>
                <span class="detail-value">{{ $booking->customer_phone }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Destination:</span>
                <span class="detail-value">{{ $booking->destination }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Travel Date:</span>
                <span class="detail-value">
                    {{ $booking->start_date ? $booking->start_date->format('M d, Y') : 'Not specified' }}
                    @if($booking->end_date)
                        - {{ $booking->end_date->format('M d, Y') }}
                    @endif
                </span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Travelers:</span>
                <span class="detail-value">{{ $booking->number_of_travelers }} person(s)</span>
            </div>
            
            @if($booking->budget_range)
            <div class="detail-row">
                <span class="detail-label">Budget Range:</span>
                <span class="detail-value">{{ $booking->budget_range }}</span>
            </div>
            @endif
            
            <div class="detail-row">
                <span class="detail-label">Status:</span>
                <span class="detail-value">
                    <span class="status status-pending">{{ ucfirst($booking->status) }}</span>
                </span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Booking Date:</span>
                <span class="detail-value">{{ $booking->booking_date->format('M d, Y - h:i A') }}</span>
            </div>
        </div>

        @if($booking->special_requirements)
        <div class="booking-details">
            <h3 style="margin-top: 0; color: #495057;">📝 Special Requirements</h3>
            <p style="margin: 0;">{{ $booking->special_requirements }}</p>
        </div>
        @endif

        <div style="text-align: center; margin: 30px 0;">
            <p style="color: #6c757d;">Please review this booking and contact the customer to confirm details and arrange payment.</p>
        </div>

        <div class="footer">
            <p>This is an automated notification from Cholo Bondhu Travel booking system.</p>
            <p>Generated on {{ now()->format('M d, Y - h:i A') }}</p>
        </div>
    </div>
</body>
</html>
