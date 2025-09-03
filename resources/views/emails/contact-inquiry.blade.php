<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Inquiry - Cholo Bondhu</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #3b82f6, #8b5cf6); color: white; padding: 20px; border-radius: 8px 8px 0 0; text-align: center; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 8px 8px; }
        .info-row { margin: 15px 0; padding: 10px; background: white; border-radius: 6px; border-left: 4px solid #3b82f6; }
        .label { font-weight: bold; color: #374151; }
        .value { color: #6b7280; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 2px solid #e5e7eb; color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>🌟 New Contact Inquiry - Cholo Bondhu</h2>
            <p>A new travel inquiry has been received</p>
        </div>
        
        <div class="content">
            <div class="info-row">
                <span class="label">👤 Name:</span> 
                <span class="value">{{ $inquiry->name }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">📧 Email:</span> 
                <span class="value">{{ $inquiry->email }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">📞 Phone:</span> 
                <span class="value">{{ $inquiry->phone }}</span>
            </div>
            
            @if($inquiry->destination)
            <div class="info-row">
                <span class="label">📍 Destination:</span> 
                <span class="value">{{ $inquiry->destination }}</span>
            </div>
            @endif
            
            @if($inquiry->start_date)
            <div class="info-row">
                <span class="label">📅 Travel Dates:</span> 
                <span class="value">{{ $inquiry->start_date->format('M d, Y') }} @if($inquiry->end_date) to {{ $inquiry->end_date->format('M d, Y') }}@endif</span>
            </div>
            @endif
            
            <div class="info-row">
                <span class="label">👥 Travelers:</span> 
                <span class="value">{{ $inquiry->number_of_travelers }}</span>
            </div>
            
            @if($inquiry->budget_range)
            <div class="info-row">
                <span class="label">💰 Budget:</span> 
                <span class="value">{{ $inquiry->budget_range }}</span>
            </div>
            @endif
            
            <div class="info-row">
                <span class="label">📝 Message:</span> 
                <div class="value" style="margin-top: 10px; white-space: pre-wrap;">{{ $inquiry->message }}</div>
            </div>
            
            <div class="info-row">
                <span class="label">🏷️ Inquiry Type:</span> 
                <span class="value">{{ ucfirst($inquiry->inquiry_type) }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">⏰ Received:</span> 
                <span class="value">{{ $inquiry->created_at->format('M d, Y \a\t g:i A') }}</span>
            </div>
        </div>
        
        <div class="footer">
            <p><strong>Cholo Bondhu Tour & Travels</strong></p>
            <p>📞 +91 81002 82665 | 📧 cholo.bondhu.noreply@gmail.com</p>
            <p>📍 Bagnan, Howrah 711303, West Bengal, India</p>
        </div>
    </div>
</body>
</html>
