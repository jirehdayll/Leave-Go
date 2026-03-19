<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account – LeaveGo Admin</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:-apple-system,BlinkMacSystemFont,'SF Pro Text','Helvetica Neue',sans-serif; background:#F2F2F7; min-height:100vh; display:flex; }

        .sidebar { width:260px; min-height:100vh; background:#fff; border-right:1px solid #E5E5EA; display:flex; flex-direction:column; flex-shrink:0; position:fixed; top:0; left:0; bottom:0; }
        .sidebar-header { padding:28px 20px 20px; border-bottom:1px solid #F2F2F7; }
        .sidebar-logo { font-size:24px; font-weight:700; color:#007AFF; }
        .sidebar-subtitle { font-size:12px; color:#8E8E93; margin-top:2px; }
        .sidebar-nav { padding:12px 0; flex:1; }
        .nav-section-title { font-size:11px; font-weight:600; color:#8E8E93; text-transform:uppercase; letter-spacing:0.8px; padding:12px 20px 6px; }
        .nav-item { display:flex; align-items:center; gap:12px; padding:11px 20px; text-decoration:none; color:#1C1C1E; font-size:15px; transition:background 0.15s; }
        .nav-item:hover { background:#F2F2F7; }
        .nav-item.active { background:#EBF4FF; color:#007AFF; font-weight:500; }
        .nav-icon { width:34px; height:34px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:16px; background:#F2F2F7; }
        .nav-item.active .nav-icon { background:#007AFF; color:#fff; }
        .sidebar-footer { padding:16px 20px; border-top:1px solid #F2F2F7; font-size:13px; color:#8E8E93; }
        .sidebar-footer strong { color:#1C1C1E; display:block; font-size:14px; margin-bottom:2px; }

        .main { margin-left:260px; flex:1; min-height:100vh; }
        .topbar { background:#fff; border-bottom:1px solid #E5E5EA; padding:16px 28px; display:flex; align-items:center; }
        .topbar-title { font-size:20px; font-weight:600; color:#1C1C1E; }
        .content { padding:40px 48px; display: flex; justify-content: center; }
        .form-container { width:100%; max-width:1000px; }

        .form-header { margin-bottom: 32px; }
        .form-title { font-size:32px; font-weight:700; color:#1C1C1E; margin-bottom:8px; letter-spacing:-0.5px; }
        .form-subtitle { font-size:16px; color:#8E8E93; }

        .ios-card { background:#fff; border-radius:20px; box-shadow:0 4px 24px rgba(0,0,0,0.04); overflow:hidden; margin-bottom:24px; border: 1px solid #E5E5EA; }
        .ios-card-header { padding:18px 24px; border-bottom:1px solid #F2F2F7; font-size:13px; font-weight:600; color:#8E8E93; text-transform:uppercase; letter-spacing:0.8px; background: #FAFAFA; }
        
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 0; }
        .ios-row { display:flex; flex-direction: column; padding:18px 24px; border-bottom:1px solid #F2F2F7; border-right: 1px solid #F2F2F7; }
        .ios-row.full-width { grid-column: span 2; border-right: none; }
        .ios-row:nth-child(even) { border-right: none; }
        .ios-row:last-child { border-bottom:none; }
        
        .ios-row label { font-size:13px; font-weight: 600; color:#8E8E93; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.4px; }
        .ios-row input, .ios-row select { width: 100%; border:none; outline:none; font-size:17px; color:#1C1C1E; font-family:inherit; background:transparent; }
        .ios-row input::placeholder { color:#C7C7CC; }
        .ios-row select { appearance: none; cursor: pointer; }

        .submit-btn { width:auto; min-width: 200px; background:#007AFF; color:#fff; font-size:17px; font-weight:600; padding:16px 32px; border:none; border-radius:16px; cursor:pointer; font-family:inherit; box-shadow:0 8px 20px rgba(0,122,255,0.25); transition: all 0.2s ease; display: block; margin-left: auto; }
        .submit-btn:hover { background:#005CC5; transform: translateY(-1px); box-shadow:0 10px 24px rgba(0,122,255,0.3); }
        .submit-btn:active { transform: translateY(0); }

        .alert-success { background:#E8FBF0; color:#1A7A3E; border-radius:14px; padding:16px 20px; margin-bottom:28px; font-size:15px; font-weight:500; border: 1px solid rgba(26,122,62,0.1); }
        .alert-error { background:#FFF0F0; color:#CC0000; border-radius:14px; padding:16px 20px; margin-bottom:28px; font-size:15px; border: 1px solid rgba(204,0,0,0.1); }
        
        @media (max-width: 768px) {
            .form-grid { grid-template-columns: 1fr; }
            .ios-row { grid-column: span 1; border-right: none; }
            .content { padding: 24px; }
        }
    </style>
</head>
<body>

@include('admin.partials.sidebar')

<main class="main">
    <div class="content">
        <div class="form-container">
            <div class="form-header">
                <h1 class="form-title">Create New Account</h1>
                <p class="form-subtitle">Register a new team member and grant system access.</p>
            </div>

            @if(session('success'))
            <div class="alert-success">✅ {{ session('success') }}</div>
            @endif

            @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
            @endif

            <form action="{{ route('admin.store-account') }}" method="POST">
                @csrf
                <div class="ios-card">
                    <div class="ios-card-header">Account Information</div>
                    <div class="form-grid">
                        <div class="ios-row full-width">
                            <label>Full Name</label>
                            <input type="text" name="name" required placeholder="John Doe" value="{{ old('name') }}">
                        </div>
                        <div class="ios-row full-width">
                            <label>Email Address</label>
                            <input type="email" name="email" required placeholder="john@cenro.gov.ph" value="{{ old('email') }}">
                        </div>
                        <div class="ios-row">
                            <label>Password</label>
                            <input type="password" name="password" required placeholder="Min. 8 characters">
                        </div>
                        <div class="ios-row">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" required placeholder="Repeat password">
                        </div>
                        <div class="ios-row full-width">
                            <label>Account Role</label>
                            <select name="is_admin">
                                <option value="0" {{ old('is_admin') == '0' ? 'selected' : '' }}>Employee (Standard Access)</option>
                                <option value="1" {{ old('is_admin') == '1' ? 'selected' : '' }}>Administrator (Elevated Privileges)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="submit-btn">Register Account</button>
            </form>
        </div>
    </div>
</main>
</body>
</html>
