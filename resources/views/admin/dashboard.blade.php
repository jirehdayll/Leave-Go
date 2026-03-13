<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard – LeaveGo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:-apple-system,BlinkMacSystemFont,'SF Pro Text','Helvetica Neue',sans-serif; background:#F2F2F7; min-height:100vh; display:flex; }

        /* ── Sidebar ─────────────────────────────────── */
        .sidebar { width:260px; min-height:100vh; background:#fff; border-right:1px solid #E5E5EA; display:flex; flex-direction:column; flex-shrink:0; position:fixed; top:0; left:0; bottom:0; overflow-y:auto; }
        .sidebar-header { padding:28px 20px 20px; border-bottom:1px solid #F2F2F7; }
        .sidebar-logo { font-size:24px; font-weight:700; color:#007AFF; letter-spacing:-0.5px; }
        .sidebar-subtitle { font-size:12px; color:#8E8E93; margin-top:2px; }
        .sidebar-nav { padding:12px 0; flex:1; }
        .nav-section { font-size:11px; font-weight:600; color:#8E8E93; text-transform:uppercase; letter-spacing:0.8px; padding:14px 20px 6px; }
        .nav-item { display:flex; align-items:center; gap:12px; padding:11px 20px; text-decoration:none; color:#1C1C1E; font-size:15px; font-weight:400; transition:background 0.15s; }
        .nav-item:hover { background:#F2F2F7; }
        .nav-item.active { background:#EBF4FF; color:#007AFF; font-weight:500; }
        .nav-icon { width:34px; height:34px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:16px; background:#F2F2F7; }
        .nav-item.active .nav-icon { background:#007AFF; color:#fff; }
        .badge { background:#FF3B30; color:#fff; font-size:11px; font-weight:700; padding:2px 7px; border-radius:20px; margin-left:auto; }
        .sidebar-footer { padding:16px 20px; border-top:1px solid #F2F2F7; font-size:13px; color:#8E8E93; }
        .sidebar-footer strong { color:#1C1C1E; display:block; font-size:14px; margin-bottom:2px; }

        /* ── Main ─────────────────────────────────────── */
        .main { margin-left:260px; flex:1; display:flex; flex-direction:column; min-height:100vh; }
        .topbar { background:#fff; border-bottom:1px solid #E5E5EA; padding:16px 28px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:10; }
        .topbar-title { font-size:20px; font-weight:600; color:#1C1C1E; }
        .live-dot { display:flex; align-items:center; gap:6px; font-size:13px; color:#8E8E93; }
        .live-dot span { width:8px; height:8px; background:#34C759; border-radius:50%; display:inline-block; animation:pulse 2s infinite; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.4} }
        .content { padding:28px; }

        /* ── Stat Cards ──────────────────────────────── */
        .stats-row { display:grid; grid-template-columns:1fr 1fr 2fr; gap:16px; margin-bottom:28px; }
        .stat-card { background:#fff; border-radius:16px; padding:22px 24px; box-shadow:0 2px 12px rgba(0,0,0,0.05); }
        .stat-card.wide { display:flex; align-items:center; gap:0; }
        .stat-number { font-size:40px; font-weight:700; letter-spacing:-1.5px; }
        .stat-label { font-size:13px; color:#8E8E93; margin-top:4px; font-weight:500; }
        .stat-card.blue .stat-number { color:#007AFF; }
        .stat-card.teal .stat-number { color:#30B0C7; }
        .wide-item { flex:1; text-align:center; padding:0 16px; }
        .wide-item .stat-number { font-size:34px; color:#34C759; }
        .wide-divider { width:1px; height:60px; background:#F2F2F7; flex-shrink:0; }

        /* ── Table ───────────────────────────────────── */
        .table-card { background:#fff; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.05); overflow:hidden; }
        .table-header { padding:16px 20px; border-bottom:1px solid #F2F2F7; display:flex; align-items:center; justify-content:space-between; }
        .table-title { font-size:15px; font-weight:600; color:#1C1C1E; }
        table { width:100%; border-collapse:collapse; }
        th { font-size:11px; font-weight:600; color:#8E8E93; text-transform:uppercase; letter-spacing:0.5px; padding:10px 18px; text-align:left; background:#FAFAFA; border-bottom:1px solid #F2F2F7; }
        td { padding:0; border-bottom:1px solid #F2F2F7; font-size:14px; color:#1C1C1E; vertical-align:middle; }
        .td-inner { padding:14px 18px; display:flex; align-items:center; gap:10px; }
        tr:last-child td { border-bottom:none; }
        .row-clickable { cursor:pointer; }
        .row-clickable:hover td { background:#F4F8FF; }

        .type-badge { display:inline-block; padding:4px 11px; border-radius:20px; font-size:12px; font-weight:500; }
        .type-leave { background:#EBF4FF; color:#007AFF; }
        .type-travel { background:#E8FBF0; color:#34C759; }

        /* Action Buttons */
        .actions-cell { white-space:nowrap; }
        .star-btn { background:none; border:none; cursor:pointer; font-size:20px; padding:4px 6px; border-radius:6px; transition:background 0.15s; line-height:1; }
        .star-btn:hover { background:#FFF8EC; }
        .star-btn.starred { color:#FF9500; }
        .star-btn:not(.starred) { color:#D1D1D6; }
        .approve-btn, .reject-btn, .restore-btn, .trash-btn {
            display:inline-flex; align-items:center; gap:5px;
            border:none; cursor:pointer; padding:8px 16px;
            border-radius:10px; font-size:13px; font-weight:600;
            font-family:inherit; transition:transform 0.1s, box-shadow 0.1s;
        }
        .approve-btn { background:#34C759; color:#fff; box-shadow:0 3px 10px rgba(52,199,89,0.3); }
        .approve-btn:hover { background:#28A745; transform:translateY(-1px); }
        .reject-btn { background:#FF3B30; color:#fff; box-shadow:0 3px 10px rgba(255,59,48,0.25); }
        .reject-btn:hover { background:#CC0000; transform:translateY(-1px); }
        .restore-btn { background:#007AFF; color:#fff; box-shadow:0 3px 10px rgba(0,122,255,0.25); }
        .restore-btn:hover { transform:translateY(-1px); }
        .trash-btn { background:#F2F2F7; color:#FF3B30; }
        .trash-btn:hover { background:#FFE0DE; }

        .empty-state { text-align:center; padding:60px 20px; color:#8E8E93; }
        .empty-icon { font-size:48px; margin-bottom:12px; }

        /* ── Gmail-style Detail Modal ─────────────────── */
        .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:1000; align-items:center; justify-content:center; padding:20px; }
        .modal-overlay.open { display:flex; }
        .modal { background:#fff; border-radius:20px; width:100%; max-width:700px; max-height:90vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,0.2); }
        .modal-header { padding:20px 24px 16px; border-bottom:1px solid #F2F2F7; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; background:#fff; z-index:1; border-radius:20px 20px 0 0; }
        .modal-header-title { font-size:18px; font-weight:600; color:#1C1C1E; }
        .modal-close { background:none; border:none; cursor:pointer; font-size:22px; color:#8E8E93; line-height:1; padding:4px; }
        .modal-close:hover { color:#1C1C1E; }
        .modal-body { padding:24px; }
        .modal-section-title { font-size:11px; font-weight:600; color:#8E8E93; text-transform:uppercase; letter-spacing:0.6px; margin-bottom:12px; margin-top:20px; }
        .modal-section-title:first-child { margin-top:0; }
        .modal-field { display:flex; justify-content:space-between; align-items:flex-start; padding:11px 0; border-bottom:1px solid #F2F2F7; gap:16px; }
        .modal-field:last-child { border-bottom:none; }
        .modal-field-label { font-size:14px; color:#8E8E93; flex-shrink:0; min-width:160px; }
        .modal-field-value { font-size:14px; color:#1C1C1E; font-weight:500; text-align:right; line-height:1.5; }
        .modal-chip { display:inline-block; padding:2px 10px; border-radius:20px; font-size:12px; font-weight:500; background:#EBF4FF; color:#007AFF; }
        .modal-footer { padding:16px 24px; border-top:1px solid #F2F2F7; display:flex; gap:10px; justify-content:flex-end; position:sticky; bottom:0; background:#fff; border-radius:0 0 20px 20px; }

        /* Fade-in animation for new rows */
        @keyframes fadeIn { from{opacity:0;transform:translateY(-6px)} to{opacity:1;transform:translateY(0)} }
        .new-row td { animation:fadeIn 0.4s ease; }
    </style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">LeaveGo</div>
        <div class="sidebar-subtitle">Admin Panel</div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">Applications</div>
        <a href="{{ route('admin.dashboard', ['tab'=>'pending']) }}" class="nav-item {{ $tab === 'pending' ? 'active' : '' }}">
            <div class="nav-icon">📥</div>
            Pending
            <span class="badge" id="sidebar-badge" style="{{ ($allStats['travel_pending'] + $allStats['leave_pending']) === 0 ? 'display:none' : '' }}">{{ $allStats['travel_pending'] + $allStats['leave_pending'] }}</span>
        </a>
        <a href="{{ route('admin.dashboard', ['tab'=>'important']) }}" class="nav-item {{ $tab === 'important' ? 'active' : '' }}">
            <div class="nav-icon">⭐</div>
            Important
        </a>
        <a href="{{ route('admin.dashboard', ['tab'=>'trash']) }}" class="nav-item {{ $tab === 'trash' ? 'active' : '' }}">
            <div class="nav-icon">🗑</div>
            Trash
        </a>
        <div class="nav-section" style="margin-top:8px;">Reports</div>
        <a href="{{ route('admin.monthly') }}" class="nav-item {{ isset($activeNav) && $activeNav === 'monthly' ? 'active' : '' }}">
            <div class="nav-icon">📊</div>
            Monthly Summary
        </a>
        <div class="nav-section" style="margin-top:8px;">Manage</div>
        <a href="{{ route('admin.create-account') }}" class="nav-item">
            <div class="nav-icon">👤</div>
            Create Account
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

<!-- Main -->
<main class="main">
    <div class="topbar">
        <div class="topbar-title">
            @if($tab === 'pending') 📥 Pending Applications
            @elseif($tab === 'important') ⭐ Important
            @else 🗑 Trash
            @endif
        </div>
        <div class="live-dot"><span></span> Live updates on</div>
    </div>

    <div class="content">
        @if($tab === 'pending')
        <div class="stats-row">
            <div class="stat-card blue">
                <div class="stat-number" id="stat-travel">{{ $allStats['travel_pending'] }}</div>
                <div class="stat-label">✈️ Pending Travel Orders</div>
            </div>
            <div class="stat-card teal">
                <div class="stat-number" id="stat-leave">{{ $allStats['leave_pending'] }}</div>
                <div class="stat-label">📝 Pending Leave Applications</div>
            </div>
            <div class="stat-card wide">
                <div class="wide-item">
                    <div class="stat-number" id="stat-ap-leave" style="color:#34C759;">{{ $allStats['approved_leave'] }}</div>
                    <div class="stat-label">✅ Approved Leave</div>
                </div>
                <div class="wide-divider"></div>
                <div class="wide-item">
                    <div class="stat-number" id="stat-ap-travel" style="color:#34C759;">{{ $allStats['approved_travel'] }}</div>
                    <div class="stat-label">✅ Approved Travel</div>
                </div>
                <div class="wide-divider"></div>
                <div class="wide-item">
                    <div class="stat-number" id="stat-ap-total" style="color:#34C759;font-size:44px;">{{ $allStats['approved_leave'] + $allStats['approved_travel'] }}</div>
                    <div class="stat-label">Total Approved</div>
                </div>
            </div>
        </div>
        @endif

        <div class="table-card">
            <div class="table-header">
                <div class="table-title" id="table-count">{{ $requests->count() }} {{ Str::plural('application', $requests->count()) }}</div>
            </div>
            @if($requests->count() === 0)
            <div class="empty-state" id="empty-state">
                <div class="empty-icon">
                    @if($tab === 'pending') 📭
                    @elseif($tab === 'important') 🌟
                    @else 🗑
                    @endif
                </div>
                <p>No applications here</p>
            </div>
            @endif
            <table>
                <thead>
                    <tr>
                        <th style="width:40px;"></th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Office</th>
                        <th>Date Filed</th>
                        <th>Days</th>
                        @if($tab !== 'trash')
                        <th style="text-align:right;min-width:220px;">Actions</th>
                        @else
                        <th style="text-align:right;">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody id="requests-tbody">
                    @foreach($requests as $req)
                    <tr class="row-clickable" data-id="{{ $req->id }}" onclick="openModal({{ $req->id }})">
                        <td onclick="event.stopPropagation()">
                            <div class="td-inner">
                                <button class="star-btn {{ $req->is_starred ? 'starred' : '' }}"
                                    onclick="toggleStar({{ $req->id }}, this)" title="Mark Important">★</button>
                            </div>
                        </td>
                        <td><div class="td-inner" style="font-weight:500;">{{ $req->name }}</div></td>
                        <td>
                            <div class="td-inner">
                                <span class="type-badge {{ $req->type === 'travel' ? 'type-travel' : 'type-leave' }}">
                                    {{ $req->type === 'travel' ? '✈️ Travel' : '📝 Leave' }}
                                </span>
                            </div>
                        </td>
                        <td><div class="td-inner" style="color:#8E8E93;">{{ $req->office }}</div></td>
                        <td><div class="td-inner" style="color:#8E8E93;">{{ $req->date_filling ? $req->date_filling->format('M d, Y') : '—' }}</div></td>
                        <td><div class="td-inner" style="color:#8E8E93;">{{ $req->details['working_days_applied'] ?? '—' }}</div></td>
                        <td class="actions-cell" onclick="event.stopPropagation()">
                            <div class="td-inner" style="justify-content:flex-end;gap:8px;">
                                @if($tab !== 'trash')
                                <button class="approve-btn" onclick="doAction('approve', {{ $req->id }}, this)">✓ Approve</button>
                                <button class="reject-btn" onclick="doAction('reject', {{ $req->id }}, this)">✕ Reject</button>
                                <button class="trash-btn" onclick="doAction('trash', {{ $req->id }}, this)">🗑</button>
                                @else
                                <button class="restore-btn" onclick="doAction('restore', {{ $req->id }}, this)">↩ Restore</button>
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

<!-- Detail Modal -->
<div class="modal-overlay" id="detailModal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-header-title" id="modal-title">Application Details</div>
            <button class="modal-close" onclick="closeModal()">×</button>
        </div>
        <div class="modal-body" id="modal-body">
            <p style="color:#8E8E93;text-align:center;">Loading...</p>
        </div>
        <div class="modal-footer" id="modal-footer"></div>
    </div>
</div>

<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;
const H    = {'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json'};
const TAB  = '{{ $tab }}';
let lastPollTime = new Date().toISOString();
let rowCount = parseInt('{{ $requests->count() }}') || 0;
let currentModalId = null;

// ── Actions ──────────────────────────────────────────────────────────────
function doAction(action, id, btn) {
    fetch(`/admin/requests/${id}/${action}`, {method:'POST', headers:H})
    .then(r => r.json()).then(() => {
        const tr = btn.closest('tr');
        tr.style.transition = 'opacity 0.3s';
        tr.style.opacity = '0';
        setTimeout(() => { tr.remove(); rowCount--; updateCount(); }, 300);
        if (currentModalId === id) closeModal();
    });
}

function toggleStar(id, btn) {
    fetch(`/admin/requests/${id}/star`, {method:'POST', headers:H})
    .then(r => r.json()).then(d => { btn.classList.toggle('starred', d.is_starred); });
}

function updateCount() {
    const el = document.getElementById('table-count');
    if (el) el.textContent = `${rowCount} application${rowCount !== 1 ? 's' : ''}`;
    if (rowCount === 0) {
        const es = document.getElementById('empty-state');
        if (es) es.style.display = 'block';
    }
}

// ── Modal ─────────────────────────────────────────────────────────────────
function openModal(id) {
    currentModalId = id;
    document.getElementById('detailModal').classList.add('open');
    document.getElementById('modal-body').innerHTML = '<p style="color:#8E8E93;text-align:center;padding:20px;">Loading…</p>';
    document.getElementById('modal-footer').innerHTML = '';
    document.body.style.overflow = 'hidden';

    fetch(`/admin/requests/${id}`, {headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(r => r.json()).then(req => renderModal(req));
}

function renderModal(req) {
    document.getElementById('modal-title').textContent =
        (req.type === 'travel' ? '✈️ Travel Order' : '📝 Application for Leave') + ' — ' + req.name;

    const details = req.details || {};
    let html = '';

    // ── Employee Info ──
    html += `<div class="modal-section-title">Employee Information</div>`;
    html += field('Name', req.name);
    html += field('Office / Department', req.office);
    html += field('Position', req.position);
    html += field('Salary', req.salary);
    html += field('Date of Filing', req.date_filling);

    if (req.type === 'travel') {
        html += `<div class="modal-section-title" style="margin-top:20px;">Travel Details</div>`;
        html += field('Departure Date', details.departure_date || '—');
        html += field('Arrival Date', details.arrival_date || '—');
        html += field('Official Station', details.official_station || '—');
        html += field('Destination', details.destination || '—');
        html += field('Purpose', details.purpose || '—');
        html += field('Per Diems / Expenses', details.expenses_allowed || '—');
        html += field('Appropriations Charged', details.appropriations || '—');
        html += field('Remarks', details.remarks || '—');
    } else {
        html += `<div class="modal-section-title" style="margin-top:20px;">Details of Application (6A – Type)</div>`;
        const leaveLabels = {
            vacation:'Vacation Leave', mandatory:'Mandatory / Forced Leave', sick:'Sick Leave',
            maternity:'Maternity Leave', paternity:'Paternity Leave', special_priv:'Special Privilege Leave',
            solo_parent:'Solo Parent Leave', study:'Study Leave', vawc:'10-Day VAWC Leave',
            rehab:'Rehabilitation Privilege', women:'Special Leave Benefits for Women',
            calamity:'Special Emergency (Calamity) Leave', adoption:'Adoption Leave'
        };
        let checkedLeaves = [];
        for (let [key, label] of Object.entries(leaveLabels)) {
            if (details['leave_type_' + key]) checkedLeaves.push(label);
        }
        if (details.leave_type_others) checkedLeaves.push('Others: ' + details.leave_type_others);
        html += field('Type of Leave', checkedLeaves.length ? checkedLeaves.join(', ') : '—');

        html += `<div class="modal-section-title" style="margin-top:20px;">6B – Details of Leave</div>`;
        if (details.leave_vacation_within) html += field('', '<span class="modal-chip">Within the Philippines</span>');
        if (details.leave_vacation_abroad) html += field('Abroad', details.leave_vacation_abroad);
        if (details.leave_sick_hospital) html += field('In Hospital (Illness)', details.leave_sick_hospital);
        if (details.leave_sick_outpatient) html += field('Out Patient (Illness)', details.leave_sick_outpatient);
        if (details.leave_women_illness) html += field('Women Special Illness', details.leave_women_illness);
        if (details.leave_study_master) html += field('', '<span class="modal-chip">Completion of Master\'s Degree</span>');
        if (details.leave_study_bar) html += field('', '<span class="modal-chip">BAR / Board Examination Review</span>');
        if (details.leave_other_monetization) html += field('', '<span class="modal-chip">Monetization of Leave Credits</span>');
        if (details.leave_other_terminal) html += field('', '<span class="modal-chip">Terminal Leave</span>');

        html += `<div class="modal-section-title" style="margin-top:20px;">6C & 6D – Schedule</div>`;
        html += field('Working Days Applied', details.working_days_applied || '—');
        html += field('Inclusive Dates', details.inclusive_dates || '—');
        html += field('Commutation', details.commutation || '—');
    }

    document.getElementById('modal-body').innerHTML = html;

    // Footer action buttons (only if pending)
    if (req.status === 'pending') {
        document.getElementById('modal-footer').innerHTML = `
            <button class="reject-btn" onclick="doAction('reject', ${req.id}, this); closeModal();">✕ Reject</button>
            <button class="approve-btn" onclick="doAction('approve', ${req.id}, this); closeModal();">✓ Approve</button>
        `;
    }
}

function field(label, value) {
    return `<div class="modal-field">
        <span class="modal-field-label">${label}</span>
        <span class="modal-field-value">${value}</span>
    </div>`;
}

function closeModal() {
    document.getElementById('detailModal').classList.remove('open');
    document.body.style.overflow = '';
    currentModalId = null;
}

// Close on overlay click
document.getElementById('detailModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

// ── Real-time Polling ─────────────────────────────────────────────────────
function buildRow(r) {
    const isTrash = TAB === 'trash';
    const typeClass = r.type === 'travel' ? 'type-travel' : 'type-leave';
    const typeName  = r.type === 'travel' ? '✈️ Travel' : '📝 Leave';
    const actions   = isTrash
        ? `<button class="restore-btn" onclick="doAction('restore',${r.id},this)">↩ Restore</button>`
        : `<button class="approve-btn" onclick="doAction('approve',${r.id},this)">✓ Approve</button>
           <button class="reject-btn" onclick="doAction('reject',${r.id},this)">✕ Reject</button>
           <button class="trash-btn" onclick="doAction('trash',${r.id},this)">🗑</button>`;
    return `<tr class="row-clickable new-row" data-id="${r.id}" onclick="openModal(${r.id})">
        <td onclick="event.stopPropagation()"><div class="td-inner"><button class="star-btn ${r.is_starred?'starred':''}" onclick="toggleStar(${r.id},this)">★</button></div></td>
        <td><div class="td-inner" style="font-weight:500;">${r.name}</div></td>
        <td><div class="td-inner"><span class="type-badge ${typeClass}">${typeName}</span></div></td>
        <td><div class="td-inner" style="color:#8E8E93;">${r.office}</div></td>
        <td><div class="td-inner" style="color:#8E8E93;">${r.date_filling}</div></td>
        <td><div class="td-inner" style="color:#8E8E93;">${r.days}</div></td>
        <td class="actions-cell" onclick="event.stopPropagation()"><div class="td-inner" style="justify-content:flex-end;gap:8px;">${actions}</div></td>
    </tr>`;
}

function poll() {
    fetch(`/admin/poll?since=${encodeURIComponent(lastPollTime)}&tab=${TAB}`, {
        headers:{'X-Requested-With':'XMLHttpRequest'}
    })
    .then(r => r.json()).then(data => {
        lastPollTime = data.server_time;

        // Prepend new rows
        if (data.requests && data.requests.length > 0) {
            const tbody = document.getElementById('requests-tbody');
            const es = document.getElementById('empty-state');
            if (es) es.style.display = 'none';
            data.requests.forEach(r => {
                // Only add if not already in table
                if (!document.querySelector(`tr[data-id="${r.id}"]`)) {
                    tbody.insertAdjacentHTML('afterbegin', buildRow(r));
                    rowCount++;
                }
            });
            updateCount();
        }

        // Update stats
        if (data.stats) {
            const s = data.stats;
            const set = (id, val) => { const el = document.getElementById(id); if(el) el.textContent = val; };
            set('stat-travel', s.travel_pending);
            set('stat-leave', s.leave_pending);
            set('stat-ap-leave', s.approved_leave);
            set('stat-ap-travel', s.approved_travel);
            set('stat-ap-total', (s.approved_leave||0) + (s.approved_travel||0));
            const total = (s.travel_pending||0) + (s.leave_pending||0);
            const badge = document.getElementById('sidebar-badge');
            if (badge) { badge.textContent = total; badge.style.display = total > 0 ? '' : 'none'; }
        }
    }).catch(() => {}); // Silently fail if offline
}

// Poll every 30 seconds
setInterval(poll, 30000);
</script>
</body>
</html>
