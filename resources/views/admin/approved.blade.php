<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Forms – LeaveGo</title>
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

        .type-badge { display:inline-block; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600; }
        .type-leave { background:#E0F2FE; color:#0284C7; }
        .type-travel { background:#DCFCE7; color:#16A34A; }

        .btn-download { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:10px; font-size:14px; font-weight:600; text-decoration:none; background:#007AFF; color:#fff; transition: all 0.2s; box-shadow:0 4px 12px rgba(0,122,255,0.2); }
        .btn-download:hover { background:#005CC5; transform: translateY(-1px); }
    </style>
</head>
<body>

@include('admin.partials.sidebar')

<main class="main">
    <div class="content">
        <div class="header-section">
            <h1 class="page-title">Approved Forms</h1>
            <p class="page-subtitle">View and download all officially approved leave and travel documents.</p>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Office</th>
                        <th>Date Filed</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($approved as $req)
                    <tr>
                        <td style="font-weight:600;">{{ $req->name }}</td>
                        <td>
                            <span class="type-badge {{ $req->type === 'travel' ? 'type-travel' : 'type-leave' }}">
                                {{ $req->type === 'travel' ? 'TRAVEL' : 'LEAVE' }}
                            </span>
                        </td>
                        <td style="color:#8E8E93;">{{ $req->office }}</td>
                        <td style="color:#8E8E93;">{{ $req->date_filling ? $req->date_filling->format('M d, Y') : '—' }}</td>
                        <td style="text-align:right;">
                            <a href="{{ route('admin.request.pdf', $req->id) }}" class="btn btn-download" target="_blank">
                                📥 PDF Download
                            </a>
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
