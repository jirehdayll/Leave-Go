<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Management – LeaveGo</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:-apple-system,BlinkMacSystemFont,'SF Pro Text','Helvetica Neue',sans-serif; background:#F2F2F7; min-height:100vh; display:flex; }
        .main { margin-left:260px; flex:1; display:flex; flex-direction:column; min-height:100vh; }
        .content { padding:40px; }
        
        .header-section { margin-bottom: 32px; }
        .page-title { font-size:32px; font-weight:700; color:#1C1C1E; letter-spacing:-0.5px; }
        .page-subtitle { font-size:16px; color:#8E8E93; margin-top:4px; }

        .table-card { background:#fff; border-radius:20px; box-shadow:0 4px 24px rgba(0,0,0,0.04); overflow:hidden; border: 1px solid #E5E5EA; }
        table { width:100%; border-collapse:collapse; }
        th { font-size:11px; font-weight:600; color:#8E8E93; text-transform:uppercase; letter-spacing:0.8px; padding:16px 24px; text-align:left; background:#FAFAFA; border-bottom:1px solid #F2F2F7; }
        td { padding:18px 24px; border-bottom:1px solid #F2F2F7; font-size:15px; color:#1C1C1E; }
        tr:last-child td { border-bottom:none; }

        .role-badge { display:inline-block; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600; }
        .role-admin { background:#FEE2E2; color:#DC2626; }
        .role-employee { background:#E0F2FE; color:#0284C7; }

        .status-dot { display:inline-block; width:8px; height:8px; border-radius:50%; margin-right:6px; }
        .status-active { background:#22C55E; }
        .status-inactive { background:#EF4444; }

        .btn { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:10px; font-size:14px; font-weight:600; text-decoration:none; transition: all 0.2s; border:none; cursor:pointer; }
        .btn-edit { background:#F2F2F7; color:#007AFF; }
        .btn-edit:hover { background:#E5E5EA; }
        .btn-deactivate { background:#FFF0F0; color:#FF3B30; }
        .btn-deactivate:hover { background:#FFE0DE; }

        .alert-success { background:#E8FBF0; color:#1A7A3E; border-radius:14px; padding:16px 20px; margin-bottom:28px; font-size:15px; font-weight:500; border: 1px solid rgba(26,122,62,0.1); }
    </style>
</head>
<body>

@include('admin.partials.sidebar')

<main class="main">
    <div class="content">
        <div class="header-section">
            <h1 class="page-title">Account Management</h1>
            <p class="page-subtitle">Manage system users, roles, and access permissions.</p>
        </div>

        @if(session('success'))
            <div class="alert-success">✅ {{ session('success') }}</div>
        @endif

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($employees as $emp)
                    <tr>
                        <td style="font-weight:600;">{{ $emp->name }}</td>
                        <td style="color:#8E8E93;">{{ $emp->email }}</td>
                        <td>
                            <span class="role-badge {{ $emp->is_admin ? 'role-admin' : 'role-employee' }}">
                                {{ $emp->is_admin ? 'ADMIN' : 'EMPLOYEE' }}
                            </span>
                        </td>
                        <td>
                            <span class="status-dot {{ $emp->is_active ? 'status-active' : 'status-inactive' }}"></span>
                            {{ $emp->is_active ? 'Active' : 'Inactive' }}
                        </td>
                        <td style="text-align:right;">
                            <div style="display:flex; justify-content:flex-end; gap:8px;">
                                <a href="{{ route('admin.employees.edit', $emp->id) }}" class="btn btn-edit">Edit</a>
                                @if($emp->is_active)
                                <form action="{{ route('admin.employees.deactivate', $emp->id) }}" method="POST" onsubmit="return confirm('Deactivate this account?')">
                                    @csrf
                                    <button type="submit" class="btn btn-deactivate">Deactivate</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>
</body>
</html>
