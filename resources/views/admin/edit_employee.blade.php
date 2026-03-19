<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account – LeaveGo</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:-apple-system,BlinkMacSystemFont,'SF Pro Text','Helvetica Neue',sans-serif; background:#F2F2F7; min-height:100vh; display:flex; }
        .main { margin-left:260px; flex:1; display:flex; flex-direction:column; min-height:100vh; }
        .content { padding:60px; display: flex; justify-content: center; }
        
        .form-container { width:100%; max-width:600px; }
        .header-section { margin-bottom: 32px; }
        .page-title { font-size:32px; font-weight:700; color:#1C1C1E; letter-spacing:-0.5px; }

        .ios-card { background:#fff; border-radius:20px; box-shadow:0 4px 24px rgba(0,0,0,0.04); overflow:hidden; border: 1px solid #E5E5EA; margin-bottom: 24px; }
        .ios-row { padding:18px 24px; border-bottom:1px solid #F2F2F7; display: flex; flex-direction: column; }
        .ios-row:last-child { border-bottom:none; }
        .ios-row label { font-size:13px; font-weight: 600; color:#8E8E93; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.4px; }
        .ios-row input, .ios-row select { width: 100%; border:none; outline:none; font-size:17px; color:#1C1C1E; font-family:inherit; background:transparent; }

        .btn-row { display: flex; gap: 12px; justify-content: flex-end; }
        .btn { padding:14px 24px; border-radius:12px; font-size:16px; font-weight:600; text-decoration:none; transition: all 0.2s; border:none; cursor:pointer; font-family: inherit; }
        .btn-save { background:#007AFF; color:#fff; box-shadow:0 4px 12px rgba(0,122,255,0.25); }
        .btn-save:hover { background:#005CC5; transform: translateY(-1px); }
        .btn-cancel { background:#F2F2F7; color:#1C1C1E; }
        .btn-cancel:hover { background:#E5E5EA; }
    </style>
</head>
<body>

@include('admin.partials.sidebar')

<main class="main">
    <div class="content">
        <div class="form-container">
            <div class="header-section">
                <h1 class="page-title">Edit Account</h1>
            </div>

            <form action="{{ route('admin.employees.update', $user->id) }}" method="POST">
                @csrf
                <div class="ios-card">
                    <div class="ios-row">
                        <label>Full Name</label>
                        <input type="text" name="name" value="{{ $user->name }}" required placeholder="John Doe">
                    </div>
                    <div class="ios-row">
                        <label>Email Address</label>
                        <input type="email" name="email" value="{{ $user->email }}" required placeholder="john@cenro.gov.ph">
                    </div>
                    <div class="ios-row">
                        <label>Account Role</label>
                        <select name="is_admin">
                            <option value="0" @if(!$user->is_admin) selected @endif>Employee (Standard Access)</option>
                            <option value="1" @if($user->is_admin) selected @endif>Administrator (Elevated Privileges)</option>
                        </select>
                    </div>
                </div>

                <div class="btn-row">
                    <a href="{{ route('admin.employees') }}" class="btn btn-cancel">Cancel</a>
                    <button type="submit" class="btn btn-save">Update Account</button>
                </div>
            </form>
        </div>
    </div>
</main>
</body>
</html>
