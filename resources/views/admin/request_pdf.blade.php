@php $details = $req->details ?? []; @endphp
@if($req->type === 'travel')
<div style="font-family:Arial,sans-serif;font-size:13px;padding:24px;">
    <div style="text-align:center;font-weight:bold;font-size:18px;">Department of Environment and Natural Resources<br>Community Environment and Natural Resources Office, Olongapo City</div>
    <div style="text-align:center;font-size:16px;margin:10px 0 20px 0;">TRAVEL ORDER</div>
    <table style="width:100%;margin-bottom:16px;">
        <tr><td>Name:</td><td>{{ $req->name }}</td><td>Salary:</td><td>{{ $req->salary }}</td></tr>
        <tr><td>Position/Designation:</td><td>{{ $req->position }}</td><td>Office:</td><td>{{ $req->office }}</td></tr>
        <tr><td>Departure Date:</td><td>{{ $details['departure_date'] ?? '' }}</td><td>Arrival Date:</td><td>{{ $details['arrival_date'] ?? '' }}</td></tr>
        <tr><td>Destination:</td><td colspan="3">{{ $details['destination'] ?? '' }}</td></tr>
        <tr><td>Official Station:</td><td colspan="3">{{ $details['official_station'] ?? '' }}</td></tr>
    </table>
    <div><b>PURPOSE:</b> {{ $details['purpose'] ?? '' }}</div>
    <div style="margin:10px 0;"><b>Per Diems/Expenses Allowed:</b> {{ $details['expenses_allowed'] ?? '' }} &nbsp; <b>Assistants/Laborers Allowed:</b> {{ $details['assistants_allowed'] ?? '' }}</div>
    <div><b>Appropriations Charged:</b> {{ $details['appropriations'] ?? '' }}</div>
    <div><b>Remarks/Special Instructions:</b> {{ $details['remarks'] ?? '' }}</div>
    <div style="margin:18px 0 8px 0;"><b>CERTIFICATION / UNDERTAKING:</b></div>
    <div style="font-size:12px;">I certify that the above travel is necessary... (see original for full text)</div>
    <div style="margin:30px 0 0 0;display:flex;justify-content:space-between;">
        <div>Approved:<br><br><br><b>EDWARD V. SERNADILLA, RPF, DPA</b><br>OIC, CENRO</div>
        <div>Prepared:<br><br><br><b>MARICA PIA R. DIMALANTA-LICO</b><br>Chief, PSU</div>
    </div>
</div>
@else
<div style="font-family:Arial,sans-serif;font-size:13px;padding:24px;">
    <div style="text-align:center;font-weight:bold;font-size:18px;">Republic of the Philippines<br>Department of Environment and Natural Resources<br>PROVINCIAL ENVIRONMENT AND NATURAL RESOURCES OFFICE<br>REGION III, Iba, Zambales</div>
    <div style="text-align:center;font-size:16px;margin:10px 0 20px 0;">APPLICATION FOR LEAVE</div>
    <table style="width:100%;margin-bottom:16px;">
        <tr><td>Office/Department:</td><td>{{ $req->office }}</td><td>Name:</td><td>{{ $req->name }}</td></tr>
        <tr><td>Date of Filing:</td><td>{{ $req->date_filling }}</td><td>Position:</td><td>{{ $req->position }}</td></tr>
        <tr><td>Salary:</td><td>{{ $req->salary }}</td><td></td><td></td></tr>
    </table>
    <div><b>6A. Type of Leave:</b> 
        @php $leaves = []; @endphp
        @foreach(['vacation'=>'Vacation Leave','mandatory'=>'Mandatory/Forced Leave','sick'=>'Sick Leave','maternity'=>'Maternity Leave','paternity'=>'Paternity Leave','special_priv'=>'Special Privilege Leave','solo_parent'=>'Solo Parent Leave','study'=>'Study Leave','vawc'=>'10-Day VAWC Leave','rehab'=>'Rehabilitation Privilege','women'=>'Special Leave Benefits for Women','calamity'=>'Special Emergency (Calamity) Leave','adoption'=>'Adoption Leave'] as $key=>$label)
            @if(!empty($details['leave_type_'.$key])) @php $leaves[] = $label; @endphp @endif
        @endforeach
        {{ implode(', ', $leaves) }}
        @if(!empty($details['leave_type_others'])) Others: {{ $details['leave_type_others'] }} @endif
    </div>
    <div><b>6B. Details of Leave:</b> 
        @if(!empty($details['leave_vacation_within'])) Within PH @endif
        @if(!empty($details['leave_vacation_abroad'])) Abroad: {{ $details['leave_vacation_abroad'] }} @endif
        @if(!empty($details['leave_sick_hospital'])) In Hospital: {{ $details['leave_sick_hospital'] }} @endif
        @if(!empty($details['leave_sick_outpatient'])) Out Patient: {{ $details['leave_sick_outpatient'] }} @endif
        @if(!empty($details['leave_women_illness'])) Women Illness: {{ $details['leave_women_illness'] }} @endif
        @if(!empty($details['leave_study_master'])) Master's Degree @endif
        @if(!empty($details['leave_study_bar'])) BAR/Board Exam @endif
        @if(!empty($details['leave_other_monetization'])) Monetization @endif
        @if(!empty($details['leave_other_terminal'])) Terminal Leave @endif
    </div>
    <div><b>6C. Number of Working Days Applied For:</b> {{ $details['working_days_applied'] ?? '' }}</div>
    <div><b>Inclusive Dates:</b> {{ $details['inclusive_dates'] ?? '' }}</div>
    <div><b>Commutation:</b> {{ $details['commutation'] ?? '' }}</div>
    <div style="margin:30px 0 0 0;display:flex;justify-content:space-between;">
        <div>Certified by:<br><br><br><b>DAISY A. FABILENA</b><br>AO IV/HRMO</div>
        <div>Approved:<br><br><br><b>EDWARD V. SERNADILLA, RPF, DPA</b><br>OIC, CENRO</div>
    </div>
</div>
@endif