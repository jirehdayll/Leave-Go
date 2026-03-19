<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
    <style>
        body { font-family: 'Inter', Arial, sans-serif; background: #f7fafc; color: #22223b; }
        .email-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); max-width: 520px; margin: 40px auto; padding: 36px; }
        .email-title { font-size: 2rem; font-weight: 600; color: #2563eb; margin-bottom: 18px; }
        .email-body { font-size: 1.1rem; color: #22223b; margin-bottom: 32px; }
        .email-btn { display: inline-block; background: #2563eb; color: #fff; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 1.1rem; margin-top: 18px; }
        .email-btn:hover { background: #1d4ed8; }
        .email-footer { margin-top: 32px; color: #6b7280; font-size: 0.95rem; }
    </style>
</head>
<body>
    <div class="email-card">
        <div class="email-title">Welcome to LeaveGo!</div>
        <div class="email-body">
            Hi {{ $user->name }},<br><br>
            Thank you for registering your account. To complete your registration and access your account, please verify your email address by clicking the button below.<br><br>
            If you did not create this account, please ignore this email.
        </div>
        <a href="{{ $verificationUrl }}" class="email-btn">Verify Email</a>
        <div class="email-footer">
            This link will expire in 24 hours.<br>
            If you have any questions, reply to this email.
        </div>
    </div>
</body>
</html>