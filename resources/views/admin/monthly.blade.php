<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Summary – LeaveGo Admin</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:-apple-system,BlinkMacSystemFont,'SF Pro Text','Helvetica Neue',sans-serif; background:#F2F2F7; min-height:100vh; display:flex; }

        /* Sidebar */
        .sidebar { width:220px; min-height:100vh; background:#fff; border-right:1px solid #E5E5EA; display:flex; flex-direction:column; flex-shrink:0; position:fixed; top:0; left:0; bottom:0; }
        .sidebar-header { padding:22px 16px 16px; border-bottom:1px solid #F2F2F7; }
        .sidebar-logo { font-size:22px; font-weight:700; color:#007AFF; }
        .sidebar-subtitle { font-size:11px; color:#8E8E93; margin-top:2px; }
        .sidebar-nav { padding:10px 0; flex:1; }
        .nav-section { font-size:10px; font-weight:600; color:#8E8E93; text-transform:uppercase; letter-spacing:1px; padding:12px 16px 5px; }
        .nav-item { display:flex; align-items:center; gap:10px; padding:10px 16px; text-decoration:none; color:#1C1C1E; font-size:14px; transition:background 0.15s; }
        .nav-item:hover { background:#F2F2F7; }
        .nav-item.active { background:#EBF4FF; color:#007AFF; font-weight:500; }
        .nav-icon { width:30px; height:30px; border-radius:7px; display:flex; align-items:center; justify-content:center; font-size:15px; background:#F2F2F7; flex-shrink:0; }
        .nav-item.active .nav-icon { background:#007AFF; color:#fff; }
        .sidebar-footer { padding:14px 16px; border-top:1px solid #F2F2F7; font-size:12px; color:#8E8E93; }
        .sidebar-footer strong { color:#1C1C1E; display:block; font-size:13px; margin-bottom:1px; }

        /* Main */
        .main { margin-left:220px; flex:1; min-height:100vh; display:flex; flex-direction:column; }
        .topbar { background:#fff; border-bottom:1px solid #E5E5EA; padding:14px 24px; display:flex; align-items:center; justify-content:space-between; }
        .topbar-title { font-size:18px; font-weight:600; color:#1C1C1E; }
        .content { padding:20px 24px; overflow-x:auto; flex:1; }

        /* Filter bar */
        .filter-bar { display:flex; gap:10px; margin-bottom:18px; align-items:center; flex-wrap:wrap; }
        .filter-bar select { background:#fff; border:1px solid #E5E5EA; border-radius:10px; padding:8px 14px; font-size:13px; font-family:inherit; color:#1C1C1E; outline:none; cursor:pointer; }
        .filter-bar select:focus { border-color:#007AFF; }
        .filter-btn { background:#007AFF; color:#fff; border:none; border-radius:10px; padding:8px 16px; font-size:13px; font-family:inherit; font-weight:600; cursor:pointer; }

        /* Legend */
        .legend { display:flex; gap:16px; margin-bottom:16px; flex-wrap:wrap; align-items:center; }
        .legend-item { display:flex; align-items:center; gap:6px; font-size:12px; color:#1C1C1E; }
        .legend-dot { width:14px; height:14px; border-radius:3px; flex-shrink:0; }
        .c-weekend  { background:#9B59B6; }
        .c-sick     { background:#E74C3C; color:#fff; }
        .c-maternity { background:#27AE60; color:#fff; }
        .c-ob       { background:#F1C40F; }
        .c-vacation { background:#3498DB; color:#fff; }
        .c-other    { background:#BDC3C7; }

        /* Calendar Table */
        .cal-wrap { background:#fff; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.06); overflow:hidden; min-width:1000px; }
        .cal-caption { text-align:center; font-weight:700; font-size:14px; padding:14px; border-bottom:1px solid #F2F2F7; letter-spacing:0.5px; text-transform:uppercase; color:#1C1C1E; }

        .cal-table { width:100%; border-collapse:collapse; table-layout:fixed; }
        .cal-table th { font-size:10px; font-weight:600; color:#8E8E93; text-align:center; padding:6px 2px; background:#FAFAFA; border:1px solid #F2F2F7; }
        .cal-table th.name-col { text-align:left; padding:6px 10px; min-width:180px; width:180px; }
        .cal-table td { font-size:10px; text-align:center; padding:2px; border:1px solid #F2F2F7; height:32px; position:relative; }
        .cal-table td.name-td { text-align:left; padding:6px 10px; font-size:12px; font-weight:500; color:#1C1C1E; white-space:nowrap; background:#fff; }
        .cal-table td.name-td span { font-size:10px; color:#8E8E93; display:block; font-weight:400; }
        .cal-table tr:hover td { filter:brightness(0.97); }

        /* Day cells colored */
        .day-weekend  { background:#D7BDE2; }
        .day-sick     { background:#FADBD8; }
        .day-maternity { background:#ABEBC6; }
        .day-ob       { background:#FDEBD0; }
        .day-vacation { background:#AED6F1; }
        .day-other    { background:#E8E8E8; }
        .day-active   { border-radius:4px; }
        .day-label    { font-size:9px; font-weight:600; color:#555; line-height:1; padding:2px; }

        /* Row number */
        .row-num { font-size:11px; color:#8E8E93; text-align:center; border:1px solid #F2F2F7; padding:6px 4px; }

        /* Footer signatures */
        .cal-footer { padding:24px 20px 16px; border-top:1px solid #F2F2F7; display:flex; justify-content:space-between; }
        .sig-block { text-align:center; }
        .sig-role { font-size:11px; color:#8E8E93; margin-bottom:4px; }
        .sig-name { font-size:13px; font-weight:700; color:#1C1C1E; border-top:1px solid #1C1C1E; padding-top:4px; min-width:200px; }

        .empty-state { text-align:center; padding:50px 20px; color:#8E8E93; font-size:15px; }
    </style>
</head>
<body>
@php
use Carbon\Carbon;

$daysInMonth  = Carbon::createFromDate($year, $month, 1)->daysInMonth;
$firstDay     = Carbon::createFromDate($year, $month, 1);
$monthLabel   = $firstDay->format('F Y');

// Philippine public holidays (simple hardcoded for year, expandable)
$phHolidays = [];

// Map leave types to color classes
function leaveColorClass($type, $leaveDetails) {
    $details = $leaveDetails ?? [];
    if (!empty($details['leave_type_maternity'])) return 'day-maternity';
    if (!empty($details['leave_type_sick'])) return 'day-sick';
    if ($type === 'travel') return 'day-ob';
    if (!empty($details['leave_type_vacation']) || !empty($details['leave_vacation_within'])) return 'day-vacation';
    return 'day-other';
}
function leaveLabelShort($type, $details) {
    $d = $details ?? [];
    if (!empty($d['leave_type_maternity'])) return 'ML';
    if (!empty($d['leave_type_sick'])) return 'SL';
    if ($type === 'travel') return 'OB';
    if (!empty($d['leave_vacation_within'])) return 'VL';
    return 'OL';
}
@endphp

<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">LeaveGo</div>
        <div class="sidebar-subtitle">Admin Panel</div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">Applications</div>
        <a href="{{ route('admin.dashboard', ['tab'=>'pending']) }}" class="nav-item">
            <div class="nav-icon">📥</div> Pending
        </a>
        <a href="{{ route('admin.dashboard', ['tab'=>'important']) }}" class="nav-item">
            <div class="nav-icon">⭐</div> Important
        </a>
        <a href="{{ route('admin.dashboard', ['tab'=>'trash']) }}" class="nav-item">
            <div class="nav-icon">🗑</div> Trash
        </a>
        <div class="nav-section" style="margin-top:8px;">Reports</div>
        <a href="{{ route('admin.monthly') }}" class="nav-item active">
            <div class="nav-icon">📊</div> Monthly Summary
        </a>
        <div class="nav-section" style="margin-top:8px;">Manage</div>
        <a href="{{ route('admin.create-account') }}" class="nav-item">
            <div class="nav-icon">👤</div> Create Account
        </a>
    </nav>
    <div class="sidebar-footer">
        <strong>{{ Auth::user()->name }}</strong>
        {{ Auth::user()->email }}
        <form action="{{ route('logout') }}" method="POST" style="margin-top:10px;">
            @csrf
            <button type="submit" style="background:none;border:none;color:#FF3B30;cursor:pointer;font-size:12px;padding:0;font-family:inherit;font-weight:500;">Sign Out</button>
        </form>
    </div>
</aside>

<!-- Main -->
<main class="main">
    <div class="topbar">
        <div class="topbar-title">📊 Monthly Calendar Summary</div>
    </div>
    <div class="content">
        <form method="GET" action="{{ route('admin.monthly') }}" class="filter-bar">
            <select name="month">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ date('F', mktime(0,0,0,$m,1)) }}</option>
                @endfor
            </select>
            <select name="year">
                @for($y = date('Y'); $y >= date('Y')-3; $y--)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="filter-btn">Apply</button>
        </form>

        <!-- Legend -->
        <div class="legend">
            <div class="legend-item"><div class="legend-dot c-weekend"></div> Sat / Sun / Holiday</div>
            <div class="legend-item"><div class="legend-dot c-sick"></div> Sick Leave (SL)</div>
            <div class="legend-item"><div class="legend-dot c-maternity"></div> Maternity Leave (ML)</div>
            <div class="legend-item"><div class="legend-dot c-ob"></div> Official Business / Travel (OB)</div>
            <div class="legend-item"><div class="legend-dot c-vacation"></div> Vacation / Other Leave (VL)</div>
        </div>

        @if($approved->count() === 0)
        <div class="cal-wrap">
            <div class="empty-state">📊 No approved applications for {{ $monthLabel }}. Approve some applications first.</div>
        </div>
        @else

        @php
        // Build per-person, per-day map
        // Parse inclusive_dates or use date_filling
        $personMap = [];
        foreach($approved as $req) {
            $name = $req->name;
            $office = $req->office;
            $details = $req->details ?? [];
            if (!isset($personMap[$name])) {
                $personMap[$name] = ['office' => $office, 'days' => []];
            }
            // Try to parse inclusive_dates e.g. "Oct 1 – Oct 9" or just mark date_filling
            $colorClass = leaveColorClass($req->type, $details);
            $labelShort = leaveLabelShort($req->type, $details);
            $dRange = $details['inclusive_dates'] ?? null;
            $start = $req->date_filling ? clone $req->date_filling : null;
            $end   = $start;
            // If inclusive_dates parses as a range, try to parse start/end
            if ($dRange && str_contains($dRange, '–')) {
                $parts = array_map('trim', explode('–', $dRange));
                try { $start = \Carbon\Carbon::parse($parts[0] . ' ' . $year); } catch(Exception $e) {}
                try { $end   = \Carbon\Carbon::parse($parts[1]); } catch(Exception $e) {}
            }
            if ($start) {
                $cur = $start->copy()->startOfDay();
                $endDay = $end ? $end->copy()->startOfDay() : $cur;
                while ($cur->lte($endDay)) {
                    if ($cur->month == $month && $cur->year == $year) {
                        $personMap[$name]['days'][$cur->day] = ['class' => $colorClass, 'label' => $labelShort];
                    }
                    $cur->addDay();
                }
            }
        }
        ksort($personMap);
        @endphp

        <div class="cal-wrap">
            <div class="cal-caption">REPORT OF ATTENDANCE — CENRO OLONGAPO CITY<br>
                <span style="font-size:12px;font-weight:500;">For the Month of {{ strtoupper($monthLabel) }}</span>
            </div>
            <table class="cal-table">
                <thead>
                    <tr>
                        <th class="name-col">NAME OF PERSONNEL</th>
                        @for($d = 1; $d <= $daysInMonth; $d++)
                            @php
                                $dow = \Carbon\Carbon::createFromDate($year, $month, $d)->dayOfWeek;
                                $isWeekend = ($dow === 0 || $dow === 6);
                            @endphp
                            <th style="{{ $isWeekend ? 'background:#EDE0F5;color:#7D3C98;' : '' }}">{{ $d }}</th>
                        @endfor
                        <th style="min-width:60px;">Under-<br>time</th>
                        <th style="min-width:80px;">Remarks</th>
                    </tr>
                    <tr>
                        <th class="name-col" style="background:#F8F8F8;font-size:9px;color:#8E8E93;">Day of week</th>
                        @for($d = 1; $d <= $daysInMonth; $d++)
                            @php $dow2 = \Carbon\Carbon::createFromDate($year, $month, $d)->dayOfWeek; @endphp
                            <th style="font-size:9px;{{ ($dow2===0||$dow2===6) ? 'background:#EDE0F5;color:#7D3C98;' : '' }}">
                                {{ ['Su','Mo','Tu','We','Th','Fr','Sa'][$dow2] }}
                            </th>
                        @endfor
                        <th></th><th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($personMap as $personName => $data)
                    <tr>
                        <td class="name-td">
                            {{ $personName }}
                            <span>{{ $data['office'] }}</span>
                        </td>
                        @for($d = 1; $d <= $daysInMonth; $d++)
                            @php
                                $dow3 = \Carbon\Carbon::createFromDate($year, $month, $d)->dayOfWeek;
                                $isWknd = ($dow3 === 0 || $dow3 === 6);
                                $hasLeave = isset($data['days'][$d]);
                            @endphp
                            @if($isWknd && !$hasLeave)
                                <td class="day-weekend"></td>
                            @elseif($hasLeave)
                                <td class="{{ $data['days'][$d]['class'] }} day-active">
                                    <div class="day-label">{{ $data['days'][$d]['label'] }}</div>
                                </td>
                            @else
                                <td></td>
                            @endif
                        @endfor
                        <td></td>
                        <td></td>
                    </tr>
                    @endforeach

                    <!-- Legend row at bottom like the template -->
                    <tr>
                        <td class="name-td" style="background:#D7BDE2;font-size:10px;font-weight:700;color:#6C3483;">SATURDAY / SUNDAY / HOLIDAY</td>
                        @php $leaveSpan = intdiv($daysInMonth, 4); @endphp
                        <td colspan="{{ $leaveSpan }}" class="day-sick" style="padding:6px;font-size:10px;font-weight:700;color:#7B241C;text-align:center;">SL / SL-EAVE</td>
                        <td colspan="{{ $leaveSpan }}" class="day-maternity" style="padding:6px;font-size:10px;font-weight:700;color:#1D6A39;text-align:center;">MATERNITY</td>
                        <td colspan="{{ $leaveSpan }}" class="day-ob" style="padding:6px;font-size:10px;font-weight:700;color:#784212;text-align:center;">OFFICIAL BUSINESS</td>
                        <td colspan="{{ $daysInMonth - $leaveSpan*3 }}" class="day-vacation" style="padding:6px;font-size:10px;font-weight:700;color:#1A5276;text-align:center;">FL/VL/SL</td>
                        <td></td><td></td>
                    </tr>
                </tbody>
            </table>

            <div class="cal-footer">
                <div class="sig-block">
                    <div class="sig-role">Prepared / Reviewed by:</div>
                    <div style="height:36px;"></div>
                    <div class="sig-name">MARICA PIA R. DIMALANTA-LICO</div>
                    <div style="font-size:11px;color:#8E8E93;margin-top:3px;">FIII/Chief, CDS and in concurrent capacity as Chief, PSU</div>
                </div>
                <div class="sig-block">
                    <div class="sig-role">Approved By:</div>
                    <div style="height:36px;"></div>
                    <div class="sig-name">EDWARD V. SERNADILLA, RPF, DPA</div>
                    <div style="font-size:11px;color:#8E8E93;margin-top:3px;">CENRO</div>
                </div>
            </div>
        </div>
        @endif
    </div>
</main>
</body>
</html>
