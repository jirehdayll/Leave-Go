<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Summary - {{ $month }}/{{ $year }}</title>
    <style>
        @page { size: A4 landscape; margin: 8mm; }
        body { font-family: "Times New Roman", Times, serif; font-size: 8.5pt; color: #000; margin: 0; padding: 0; }
        
        .header { text-align: center; margin-bottom: 15px; }
        .header h1 { font-size: 14pt; margin: 0; font-weight: bold; text-decoration: underline; }
        .header p { font-size: 10pt; margin: 3px 0 0; }

        /* Legend */
        .legend { display: table; width: 100%; margin-bottom: 10px; border-collapse: separate; border-spacing: 5px 0; }
        .legend-item { display: table-cell; vertical-align: middle; white-space: nowrap; font-size: 8pt; }
        .legend-dot { display: inline-block; width: 10px; height: 10px; border: 0.5px solid #000; margin-right: 3px; vertical-align: middle; }
        
        .c-weekend   { background: #8E44AD; color: #fff; } /* Violet */
        .c-sick      { background: #CC0000; color: #fff; } /* Red */
        .c-maternity { background: #008000; color: #fff; } /* Green */
        .c-ob        { background: #F1C40F; color: #000; } /* Yellow */
        .c-navy      { background: #000080; color: #fff; } /* Navy Blue (FL/SPL/VL) */
        .c-other     { background: #E8E8E8; color: #000; }

        /* Table */
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { border: 0.5pt solid #000; text-align: center; height: 22px; padding: 1px; }
        th { background: #f0f0f0; font-weight: bold; font-size: 8pt; }
        
        .no-col { width: 25px; }
        .name-col { text-align: left; padding: 0 5px; width: 180px; font-weight: bold; font-size: 9pt; white-space: nowrap; overflow: hidden; }
        .day-col { width: 22px; }
        .remarks-col { width: 60px; }
        
        /* Colored Cells */
        .day-label { font-size: 7pt; font-weight: bold; }

        .footer { margin-top: 25px; width: 100%; }
        .sig-block { width: 45%; display: inline-block; text-align: center; vertical-align: top; }
        .sig-line { border-top: 1px solid #000; margin-top: 35px; padding-top: 3px; font-weight: bold; font-size: 10pt; text-transform: uppercase; }
        .sig-role { font-size: 9pt; margin-top: 2px; }
    </style>
</head>
<body>
    @php
        use Carbon\Carbon;
        $firstDay = Carbon::createFromDate($year, $month, 1);
        $daysInMonth = $firstDay->daysInMonth;
        $monthLabel = $firstDay->format('F Y');

        function leaveColorClass($type, $leaveDetails) {
            $details = $leaveDetails ?? [];
            if (!empty($details['leave_type_maternity'])) return 'c-maternity';
            if (!empty($details['leave_type_sick'])) return 'c-sick';
            if ($type === 'travel') return 'c-ob';
            
            // FL / SPL / VL -> Navy Blue
            if (!empty($details['leave_type_vacation']) || 
                !empty($details['leave_vacation_within']) || 
                !empty($details['leave_type_mandatory']) ||
                !empty($details['leave_type_special_priv'])) {
                return 'c-navy';
            }
            return 'c-other';
        }

        function leaveLabelShort($type, $details) {
            $d = $details ?? [];
            if (!empty($d['leave_type_maternity'])) return 'ML';
            if (!empty($d['leave_type_sick'])) return 'SL';
            if ($type === 'travel') return 'OB';
            if (!empty($d['leave_type_mandatory'])) return 'FL';
            if (!empty($d['leave_type_special_priv'])) return 'SPL';
            if (!empty($d['leave_type_vacation']) || !empty($d['leave_vacation_within'])) return 'VL';
            return 'OL';
        }

        // Build person map
        $personMap = [];
        foreach($approved as $req) {
            if (!isset($personMap[$req->name])) {
                $personMap[$req->name] = ['office' => $req->office, 'days' => []];
            }
            $color = leaveColorClass($req->type, $req->details);
            $label = leaveLabelShort($req->type, $req->details);
            
            $dRange = $req->details['inclusive_dates'] ?? null;
            if ($dRange && str_contains($dRange, '–')) {
                $parts = array_map('trim', explode('–', $dRange));
                try {
                    $start = Carbon::parse($parts[0] . ' ' . $year);
                    $end = Carbon::parse($parts[1] . ' ' . $year);
                    
                    $cur = $start->copy()->startOfDay();
                    while ($cur->lte($end->copy()->startOfDay())) {
                        if ($cur->month == $month && $cur->year == $year) {
                            $personMap[$req->name]['days'][$cur->day] = ['class' => $color, 'label' => $label];
                        }
                        $cur->addDay();
                    }
                } catch(Exception $e) {}
            } else {
                // Fallback to filing date if range missing
                $singleDate = $req->date_filling;
                if ($singleDate && $singleDate->month == $month && $singleDate->year == $year) {
                    $personMap[$req->name]['days'][$singleDate->day] = ['class' => $color, 'label' => $label];
                }
            }
        }
        ksort($personMap);
    @endphp

    <div class="header">
        <h1>REPORT OF ATTENDANCE</h1>
        <p>For the Month of {{ strtoupper($monthLabel) }} - CENRO OLONGAPO CITY</p>
    </div>

    <!-- Legend -->
    <div class="legend">
        <div class="legend-item"><span class="legend-dot c-weekend"></span> Sat/Sun/Holiday</div>
        <div class="legend-item"><span class="legend-dot c-sick"></span> Sick Leave (SL)</div>
        <div class="legend-item"><span class="legend-dot c-maternity"></span> Maternity (ML)</div>
        <div class="legend-item"><span class="legend-dot c-ob"></span> Official Business (OB)</div>
        <div class="legend-item"><span class="legend-dot c-navy"></span> FL / SPL / VL</div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="no-col">No.</th>
                <th class="name-col">NAME OF PERSONNEL</th>
                @for($d = 1; $d <= $daysInMonth; $d++)
                    @php $dow = Carbon::createFromDate($year, $month, $d)->dayOfWeek; @endphp
                    <th class="day-col" @if($dow == 0 || $dow == 6) style="background:#8E44AD; color:#fff;" @endif>{{ $d }}</th>
                @endfor
                <th class="remarks-col">Remarks</th>
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
                        $dow = Carbon::createFromDate($year, $month, $d)->dayOfWeek;
                        $isWknd = ($dow === 0 || $dow === 6);
                        $leave = $data['days'][$d] ?? null;
                    @endphp
                    @if($leave)
                        <td class="{{ $leave['class'] }}"><span class="day-label">{{ $leave['label'] }}</span></td>
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

    <div class="footer">
        <div class="sig-block">
            <div class="sig-role">Prepared / Reviewed by:</div>
            <div class="sig-line">MARICA PIA R. DIMALANTA-LICO</div>
            <div class="sig-role">FIII/Chief, CDS</div>
        </div>
        <div class="sig-block" style="float: right;">
            <div class="sig-role">Approved By:</div>
            <div class="sig-line">EDWARD V. SERNADILLA, RPF, DPA</div>
            <div class="sig-role">CENRO</div>
        </div>
    </div>
</body>
</html>
