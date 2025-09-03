# Secure Authentication System

A comprehensive Laravel-based authentication system with OTP verification, AES encryption, and advanced security features.

## Features

### 🔐 Security Features
- **Two-Factor Authentication**: OTP verification for both registration and login
- **AES Encryption**: Sensitive user data encrypted using Laravel's built-in encryption
- **Rate Limiting**: Protection against brute force attacks
- **Account Locking**: Automatic account lockout after failed attempts
- **Password Strength**: Enforced strong password requirements
- **Security Headers**: Comprehensive HTTP security headers
- **IP Tracking**: Login attempt monitoring with IP address logging

### 📧 Email Integration
- **OTP Delivery**: Secure OTP codes sent via email
- **Professional Templates**: Beautiful, responsive email templates
- **Multiple OTP Types**: Registration, login, and password reset OTPs
- **Expiry Management**: Time-limited OTP codes (10 minutes default)

### 🛡️ Advanced Protection
- **Session Management**: Secure session handling with Laravel Sanctum
- **CSRF Protection**: Built-in CSRF token validation
- **SQL Injection Prevention**: Eloquent ORM protection
- **XSS Protection**: Input sanitization and output encoding

## Installation & Setup

### 1. Database Migration
```bash
php artisan migrate
```

### 2. Mail Configuration
Update your `.env` file with mail settings:

```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-email-password
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Your App Name"
```

### 3. Security Configuration
Add these optional security settings to `.env`:

```env
OTP_EXPIRY_MINUTES=10
MAX_LOGIN_ATTEMPTS=5
ACCOUNT_LOCK_MINUTES=30
OTP_RATE_LIMIT_ATTEMPTS=3
OTP_RATE_LIMIT_MINUTES=2
```

### 4. Scheduled Tasks
Add OTP cleanup to your scheduler in `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('otp:cleanup')->daily();
}
```

## API Endpoints

### Registration Flow

#### 1. Initiate Registration
```http
POST /api/auth/register/initiate
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "SecurePass123!",
    "password_confirmation": "SecurePass123!",
    "phone": "+1234567890"
}
```

**Response:**
```json
{
    "success": true,
    "message": "OTP sent to your email. Please verify to complete registration.",
    "email": "john@example.com"
}
```

#### 2. Verify Registration
```http
POST /api/auth/register/verify
Content-Type: application/json

{
    "email": "john@example.com",
    "otp": "123456"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Registration completed successfully!",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "phone": "+1234567890",
        "role": "user"
    },
    "token": "your-auth-token"
}
```

### Login Flow

#### 1. Initiate Login
```http
POST /api/auth/login/initiate
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "SecurePass123!"
}
```

#### 2. Verify Login
```http
POST /api/auth/login/verify
Content-Type: application/json

{
    "email": "john@example.com",
    "otp": "654321"
}
```

### Protected Routes

#### Get User Profile
```http
GET /api/user
Authorization: Bearer your-auth-token
```

#### Logout
```http
POST /api/auth/logout
Authorization: Bearer your-auth-token
```

## Password Requirements

Passwords must contain:
- At least 8 characters
- At least one lowercase letter
- At least one uppercase letter
- At least one number
- At least one special character (@$!%*?&)

## Security Features Details

### Rate Limiting
- **Registration OTP**: 3 attempts per 10 minutes per email
- **Login Attempts**: 5 attempts per 15 minutes per email
- **OTP Requests**: 3 OTPs per 2 minutes per email/type

### Account Locking
- Accounts are locked for 30 minutes after 5 failed login attempts
- Failed attempt counter resets on successful login
- Locked accounts cannot receive login OTPs

### OTP Security
- 6-digit numeric codes
- 10-minute expiry time
- Single-use only
- Secure random generation
- Email delivery with professional templates

### Data Encryption
- User sensitive data encrypted using AES-256
- Laravel's built-in encryption service
- Secure key management through APP_KEY

## Database Schema

### Users Table Extensions
- `email_verified`: Boolean flag for email verification status
- `last_login_at`: Timestamp of last successful login
- `last_login_ip`: IP address of last login
- `failed_login_attempts`: Counter for failed login attempts
- `locked_until`: Timestamp until which account is locked
- `encrypted_data`: AES encrypted sensitive user data

### OTPs Table
- `email`: User email address
- `otp`: 6-digit OTP code
- `type`: OTP type (registration, login, password_reset)
- `expires_at`: OTP expiry timestamp
- `is_used`: Boolean flag for OTP usage status
- `ip_address`: IP address of OTP request
- `user_agent`: User agent of OTP request

## Testing

Run the included test script:
```bash
php test_secure_auth.php
```

This will test the complete authentication flow including:
1. Registration initiation
2. OTP verification
3. Login initiation
4. Login verification
5. Profile retrieval
6. Logout

## Maintenance

### Cleanup Expired OTPs
```bash
php artisan otp:cleanup
```

### Monitor Security Logs
Check `storage/logs/laravel.log` for security events:
- OTP generation and verification
- Failed login attempts
- Account lockouts
- Rate limit violations

## Customization

### OTP Email Template
Modify `resources/views/emails/otp.blade.php` to customize the email appearance.

### Security Settings
Adjust security parameters in:
- `app/Services/OtpService.php` - OTP generation and validation
- `app/Models/User.php` - Account locking logic
- `app/Http/Controllers/Auth/SecureAuthController.php` - Rate limiting

### Encryption
Customize encryption in `app/Services/EncryptionService.php` for additional data types.

## Production Considerations

1. **HTTPS Only**: Always use HTTPS in production
2. **Mail Queue**: Use queue workers for email sending
3. **Redis Cache**: Use Redis for better caching performance
4. **Log Monitoring**: Set up log monitoring for security events
5. **Backup Strategy**: Regular database backups including encrypted data
6. **Key Rotation**: Regular APP_KEY rotation strategy

## Support

For issues or questions regarding the secure authentication system, please check:
1. Laravel documentation for framework-specific issues
2. PHPMailer documentation for email delivery issues
3. Application logs for debugging information

## License

This secure authentication system is built on Laravel and follows the same MIT license.