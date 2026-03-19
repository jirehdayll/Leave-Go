<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success - LeaveGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #f7fafc 0%, #e3e6f3 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .success-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 6px 32px 0 rgba(60,72,100,0.10), 0 1.5px 6px 0 rgba(60,72,100,0.06);
            padding: 48px 36px 36px 36px;
            max-width: 420px;
            width: 100%;
            text-align: center;
            animation: fadeIn 0.7s cubic-bezier(.4,0,.2,1);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: none; }
        }
        .success-icon {
            font-size: 72px;
            color: #22c55e;
            margin-bottom: 18px;
        }
        .success-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: #22223b;
        }
        .success-desc {
            color: #6b7280;
            font-size: 1.08rem;
            margin-bottom: 32px;
        }
        .success-actions {
            display: flex;
            gap: 16px;
            justify-content: center;
        }
        .btn-modern {
            padding: 0.7em 1.6em;
            border-radius: 8px;
            border: none;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
            box-shadow: 0 1px 4px 0 rgba(60,72,100,0.07);
        }
        .btn-modern-primary {
            background: #2563eb;
            color: #fff;
        }
        .btn-modern-primary:hover {
            background: #1d4ed8;
        }
        .btn-modern-outline {
            background: #fff;
            color: #2563eb;
            border: 1.5px solid #2563eb;
        }
        .btn-modern-outline:hover {
            background: #f1f5f9;
        }
    </style>
</head>
<body>
    <div class="success-card">
        <div class="success-icon">✅</div>
        <div class="success-title">Form Submitted</div>
        <div class="success-desc">Your application has been successfully submitted and is now pending review by the administrator. You will be notified once a decision has been made.</div>
        <div class="success-actions">
            <a href="{{ route('selection') }}" class="btn-modern btn-modern-primary">New Application</a>
            <a href="{{ route('login') }}" class="btn-modern btn-modern-outline">Back to Home</a>
        </div>
    </div>
</body>
</html>
