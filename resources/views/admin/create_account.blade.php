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
        .content { padding:40px 28px; }
        .form-container { max-width:520px; }

        .form-title { font-size:28px; font-weight:700; color:#1C1C1E; margin-bottom:6px; letter-spacing:-0.5px; }
        .form-subtitle { font-size:15px; color:#8E8E93; margin-bottom:28px; }

        .ios-card { background:#fff; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.06); overflow:hidden; margin-bottom:20px; }
        .ios-card-header { padding:14px 18px; border-bottom:1px solid #F2F2F7; font-size:12px; font-weight:600; color:#8E8E93; text-transform:uppercase; letter-spacing:0.6px; }
        .ios-row { display:flex; align-items:center; padding:14px 18px; border-bottom:1px solid #F2F2F7; }
        .ios-row:last-child { border-bottom:none; }
        .ios-row label { font-size:15px; color:#1C1C1E; min-width:130px; flex-shrink:0; }
        .ios-row input, .ios-row select { flex:1; border:none; outline:none; font-size:15px; color:#1C1C1E; text-align:right; font-family:inherit; background:transparent; min-width:0; }
        .ios-row input::placeholder { color:#C7C7CC; }

        .submit-btn { width:100%; background:#007AFF; color:#fff; font-size:17px; font-weight:600; padding:16px; border:none; border-radius:14px; cursor:pointer; font-family:inherit; box-shadow:0 4px 16px rgba(0,122,255,0.3); transition:background 0.2s; }
        .submit-btn:hover { background:#005CC5; }

        .alert-success { background:#E8FBF0; color:#1A7A3E; border-radius:12px; padding:14px 18px; margin-bottom:20px; font-size:14px; font-weight:500; }
        .alert-error { background:#FFF0F0; color:#CC0000; border-radius:12px; padding:14px 18px; margin-bottom:20px; font-size:14px; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">LeaveGo</div>
        <div class="sidebar-subtitle">Admin Panel</div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section-title">Applications</div>
        <a href="{{ route('admin.dashboard', ['tab'=>'pending']) }}" class="nav-item">
            <div class="nav-icon">📥</div> Pending
        </a>
        <a href="{{ route('admin.dashboard', ['tab'=>'important']) }}" class="nav-item">
            <div class="nav-icon">⭐</div> Important
        </a>
        <a href="{{ route('admin.dashboard', ['tab'=>'trash']) }}" class="nav-item">
            <div class="nav-icon">🗑</div> Trash
        </a>
        <div class="nav-section-title" style="margin-top:8px;">Reports</div>
        <a href="{{ route('admin.monthly') }}" class="nav-item">
            <div class="nav-icon">📊</div> Monthly Summary
        </a>
        <div class="nav-section-title" style="margin-top:8px;">Manage</div>
        <a href="{{ route('admin.create-account') }}" class="nav-item active">
            <div class="nav-icon">👤</div> Create Account
        </a>
    </nav>
    <div class="sidebar-footer">
        <strong>{{ Auth::user()->name }}</strong>
        {{ Auth::user()->email }}
        <form action="{{ route('logout') }}" method="POST" style="margin-top:10px;">
            @csrf
            <button type="submit" style="background:none;border:none;color:#FF3B30;cursor:pointer;font-size:13px;padding:0;font-family:inherit;font-weight:500;">Sign Out</button>
        </form>
    </div>
</aside>

<main class="main">
    <div class="topbar">
        <div class="topbar-title">👤 Create Account</div>
    </div>
    <div class="content">
        <div class="form-container">
            <h1 class="form-title">New Account</h1>
            <p class="form-subtitle">Create a login for a new employee.</p>

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
                    <div class="ios-card-header">Account Details</div>
                    <div class="ios-row">
                        <label>Full Name</label>
                        <input type="text" name="name" required placeholder="John Doe" value="{{ old('name') }}">
                    </div>
                    <div class="ios-row">
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
                    <div class="ios-row">
                        <label>Role</label>
                        <select name="is_admin">
                            <option value="0">Employee</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="submit-btn">Create Account</button>
            </form>
        </div>
    </div>
</main>
</body>
</html>
