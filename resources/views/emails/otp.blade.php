<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .otp-box {
            background: white;
            border: 2px solid #667eea;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            color: #667eea;
            letter-spacing: 8px;
            margin: 10px 0;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>
            @if($type === 'registration')
                Welcome to Our Platform!
            @elseif($type === 'login')
                Secure Login Verification
            @else
                Password Reset Verification
            @endif
        </h1>
    </div>

    <div class="content">
        <p>Hello {{ $userName }},</p>

        @if($type === 'registration')
            <p>Thank you for registering with us! To complete your registration and verify your email address, please use the OTP code below:</p>
        @elseif($type === 'login')
            <p>We received a login request for your account. To ensure your security, please use the OTP code below to complete your login:</p>
        @else
            <p>We received a request to reset your password. To proceed with the password reset, please use the OTP code below:</p>
        @endif

        <div class="otp-box">
            <p><strong>Your OTP Code:</strong></p>
            <div class="otp-code">{{ $otp }}</div>
            <p><small>This code will expire in {{ $expiryMinutes }} minutes</small></p>
        </div>

        <div class="warning">
            <strong>Security Notice:</strong>
            <ul>
                <li>Never share this OTP with anyone</li>
                <li>Our team will never ask for your OTP</li>
                <li>If you didn't request this, please ignore this email</li>
                <li>This code expires in {{ $expiryMinutes }} minutes</li>
            </ul>
        </div>

        @if($type === 'registration')
            <p>Once verified, you'll have full access to all our features and services.</p>
        @elseif($type === 'login')
            <p>If you didn't attempt to log in, please secure your account immediately by changing your password.</p>
        @else
            <p>After verification, you'll be able to set a new password for your account.</p>
        @endif

        <p>Best regards,<br>The Security Team</p>
    </div>

    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
        <p>&copy; {{ date('Y') }} Your Company Name. All rights reserved.</p>
    </div>
</body>
</html>