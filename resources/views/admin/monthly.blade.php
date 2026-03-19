<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Summary – LeaveGo Admin</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:-apple-system,BlinkMacSystemFont,'SF Pro Text','Helvetica Neue',sans-serif; background:#F2F2F7; min-height:100vh; display:flex; }

        /* Main */
        .main { margin-left:260px; flex:1; min-height:100vh; display:flex; flex-direction:column; overflow-x: hidden; }
        .content { padding:30px 40px; flex:1; width: 100%; max-width: calc(100vw - 260px); }

        .report-header { display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:30px; }
        .report-title { font-size:32px; font-weight:700; color:#1C1C1E; letter-spacing:-0.5px; }
        .report-subtitle { font-size:16px; color:#8E8E93; margin-top:4px; }

        .filter-select { background:#fff; border:1px solid #E5E5EA; border-radius:10px; padding:10px 16px; font-size:14px; font-family:inherit; color:#1C1C1E; outline:none; cursor:pointer; min-width: 140px; }
        
        /* Legend - Matching PDF Colors */
        .legend { display:flex; gap:20px; margin-bottom:24px; flex-wrap:wrap; align-items:center; background:#fff; padding:16px 24px; border-radius:16px; border:1px solid #E5E5EA; }
        .legend-item { display:flex; align-items:center; gap:8px; font-size:13px; font-weight:500; color:#1C1C1E; }
        .legend-dot { width:14px; height:14px; border-radius:3px; border:1px solid rgba(0,0,0,0.1); }
        
        .c-weekend   { background: #8E44AD; } /* Violet */
        .c-sick      { background: #CC0000; } /* Red */
        .c-maternity { background: #008000; } /* Green */
        .c-ob        { background: #F1C40F; } /* Yellow */
        .c-navy      { background: #000080; } /* Navy Blue (FL/SPL/VL) */

        /* Table Design - Matching PDF */
        .cal-wrap { background:#fff; border-radius:20px; box-shadow:0 4px 24px rgba(0,0,0,0.04); border:1px solid #E5E5EA; overflow-x: auto; margin-bottom: 40px; }
        .cal-caption { text-align:center; font-family: "Times New Roman", Times, serif; font-weight:700; font-size:18px; padding:24px 20px 10px; text-transform:uppercase; color:#000; text-decoration: underline; }
        
        .cal-table { width:100%; border-collapse:collapse; table-layout:fixed; font-family: "Times New Roman", Times, serif; }
        .cal-table th, .cal-table td { border: 1px solid #000; text-align:center; padding:4px 2px; height: 32px; }
        .cal-table th { background:#f0f0f0; font-size:11px; font-weight:bold; color:#000; }
        
        .no-col { width: 40px; }
        .name-col { text-align:left !important; padding:8px 12px !important; width:220px; min-width:220px; font-size:13px; font-weight:bold; text-transform: uppercase; }
        .day-col { width:30px; }

        .day-label { font-size:10px; font-weight:bold; color:#fff; }
        .day-label-dark { font-size:10px; font-weight:bold; color:#000; }

        .btn-success { background:#22C55E; color:#fff; text-decoration:none; padding:10px 20px; border-radius:10px; font-weight:600; font-size:14px; display:inline-flex; align-items:center; gap:8px; box-shadow:0 4px 12px rgba(34,197,94,0.2); transition: all 0.2s; }
        .btn-success:hover { transform: translateY(-1px); background:#16a34a; }

        .sig-container { display: flex; justify-content: space-between; padding: 40px 30px 30px; }
        .sig-block { text-align: center; width: 300px; }
        .sig-line { border-top: 1px solid #000; margin-top: 40px; padding-top: 5px; font-weight: bold; font-size: 14px; text-transform: uppercase; font-family: "Times New Roman", serif; }
        .sig-role { font-size: 12px; color: #555; font-family: "Times New Roman", serif; margin-top: 2px; }

        .empty-state { text-align:center; padding:80px 20px; color:#8E8E93; font-size:17px; }
    </style>
</head>
<body>

@include('admin.partials.sidebar')

@php
use Carbon\Carbon;
$daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;
$monthLabel = Carbon::createFromDate($year, $month, 1)->format('F Y');
@endphp

<main class="main">
    <div class="content">
        <div class="report-header">
            <div>
                <h1 class="report-title">Monthly Summary</h1>
                <p class="report-subtitle">CENRO Olongapo City Attendance Report</p>
            </div>
            <div style="display:flex; gap:12px; align-items: center;">
                <form id="filterForm" action="{{ route('admin.monthly') }}" method="GET" style="display:flex; gap:8px;">
                    <select name="month" class="filter-select" onchange="this.form.submit()">
                        @for($m=1; $m<=12; $m++)
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ date('F', mktime(0,0,0,$m,1)) }}</option>
                        @endfor
                    </select>
                    <select name="year" class="filter-select" onchange="this.form.submit()">
                        @for($y=date('Y'); $y>=2024; $y--)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </form>
                <a href="{{ route('admin.monthly.pdf', ['month'=>$month, 'year'=>$year, 'type'=>$type]) }}" class="btn btn-success">
                    <span>📥</span> Download PDF
                </a>
            </div>
        </div>

        <div class="legend">
            <div class="legend-item"><div class="legend-dot c-weekend"></div> Sat/Sun/Holiday</div>
            <div class="legend-item"><div class="legend-dot c-sick"></div> Sick Leave (SL)</div>
            <div class="legend-item"><div class="legend-dot c-maternity"></div> Maternity (ML)</div>
            <div class="legend-item"><div class="legend-dot c-ob"></div> Official Business (OB)</div>
            <div class="legend-item"><div class="legend-dot c-navy"></div> FL / SPL / VL</div>
        </div>

        @if($approved->count() === 0)
            <div class="cal-wrap">
                <div class="empty-state">📊 No approved records found for {{ $monthLabel }}.</div>
            </div>
        @else
            @php
            $personMap = [];
            foreach($approved as $req) {
                if (!isset($personMap[$req->name])) {
                    $personMap[$req->name] = ['days' => []];
                }
                
                $details = $req->details ?? [];
                // Same logic as PDF for consistency
                $color = 'c-other';
                $label = 'OL';
                if (!empty($details['leave_type_maternity'])) { $color = 'c-maternity'; $label = 'ML'; }
                elseif (!empty($details['leave_type_sick'])) { $color = 'c-sick'; $label = 'SL'; }
                elseif ($req->type === 'travel') { $color = 'c-ob'; $label = 'OB'; }
                elseif (!empty($details['leave_type_vacation']) || !empty($details['leave_vacation_within']) || !empty($details['leave_type_mandatory']) || !empty($details['leave_type_special_priv'])) {
                    $color = 'c-navy';
                    if (!empty($details['leave_type_mandatory'])) $label = 'FL';
                    elseif (!empty($details['leave_type_special_priv'])) $label = 'SPL';
                    else $label = 'VL';
                }

                $dRange = $details['inclusive_dates'] ?? null;
                if ($dRange && str_contains($dRange, '–')) {
                    $parts = array_map('trim', explode('–', $dRange));
                    try {
                        $start = \Carbon\Carbon::parse($parts[0] . ' ' . $year);
                        $end = \Carbon\Carbon::parse($parts[1] . ' ' . $year);
                        $cur = $start->copy()->startOfDay();
                        while ($cur->lte($end->copy()->startOfDay())) {
                            if ($cur->month == $month && $cur->year == $year) {
                                $personMap[$req->name]['days'][$cur->day] = ['class' => $color, 'label' => $label];
                            }
                            $cur->addDay();
                        }
                    } catch(\Exception $e) {}
                } else {
                    $singleDate = $req->date_filling;
                    if ($singleDate && $singleDate->month == $month && $singleDate->year == $year) {
                        $personMap[$req->name]['days'][$singleDate->day] = ['class' => $color, 'label' => $label];
                    }
                }
            }
            ksort($personMap);
            @endphp

            <div class="cal-wrap">
                <div class="cal-caption">REPORT OF ATTENDANCE</div>
                <div style="text-align:center; font-family: 'Times New Roman', serif; font-size:14px; margin-bottom:20px;">
                    For the Month of {{ strtoupper($monthLabel) }} - CENRO OLONGAPO CITY
                </div>

                <table class="cal-table">
                    <thead>
                        <tr>
                            <th class="no-col">No.</th>
                            <th class="name-col">NAME OF PERSONNEL</th>
                            @for($d = 1; $d <= $daysInMonth; $d++)
                                @php $dow = \Carbon\Carbon::createFromDate($year, $month, $d)->dayOfWeek; @endphp
                                <th class="day-col" @if($dow == 0 || $dow == 6) style="background:#8E44AD; color:#fff;" @endif>{{ $d }}</th>
                            @endfor
                            <th style="width: 80px;">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count = 1; @endphp
                        @foreach($personMap as $name => $data)
                        <tr>
                            <td class="no-col">{{ $count++ }}</td>
                            <td class="name-col">{{ strtoupper($name) }}</td>
                            @for($d = 1; $d <= $daysInMonth; $d++)
                                @php
                                    $dow = \Carbon\Carbon::createFromDate($year, $month, $d)->dayOfWeek;
                                    $isWknd = ($dow === 0 || $dow === 6);
                                    $leave = $data['days'][$d] ?? null;
                                @endphp
                                @if($leave)
                                    <td class="{{ $leave['class'] }}">
                                        <span class="{{ $leave['class'] == 'c-ob' ? 'day-label-dark' : 'day-label' }}">
                                            {{ $leave['label'] }}
                                        </span>
                                    </td>
                                @elseif($isWknd)
                                    <td class="c-weekend"></td>
                                @else
                                    <td></td>
                                @endif
                            @endfor
                            <td></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="sig-container">
                    <div class="sig-block">
                        <div class="sig-role">Prepared / Reviewed by:</div>
                        <div class="sig-line">MARICA PIA R. DIMALANTA-LICO</div>
                        <div class="sig-role">FIII/Chief, CDS</div>
                    </div>
                    <div class="sig-block">
                        <div class="sig-role">Approved By:</div>
                        <div class="sig-line">EDWARD V. SERNADILLA, RPF, DPA</div>
                        <div class="sig-role">CENRO</div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</main>
</body>
</html>
