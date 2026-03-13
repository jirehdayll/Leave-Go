@extends('layouts.app')

@section('title', 'Application for Leave - LeaveGo')

@section('content')
<div style="min-height:100vh; background:#F2F2F7; padding: 40px 20px; font-family:-apple-system,BlinkMacSystemFont,'SF Pro Text','Helvetica Neue',sans-serif;">
    <div style="max-width:640px; margin:0 auto;">
        <a href="{{ route('selection') }}" style="display:inline-flex;align-items:center;gap:6px;color:#007AFF;font-size:17px;font-weight:500;text-decoration:none;margin-bottom:28px;">
            <svg width="10" height="16" viewBox="0 0 10 16" fill="none"><path d="M8.5 1L1.5 8L8.5 15" stroke="#007AFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Back
        </a>

        <h1 style="font-size:32px;font-weight:700;color:#1C1C1E;margin-bottom:8px;letter-spacing:-0.5px;">Application for Leave</h1>
        <p style="font-size:15px;color:#8E8E93;margin-bottom:32px;">Civil Service Form No. 6 · Fill up all required fields</p>

        <form action="{{ route('forms.submit') }}" method="POST" id="leaveForm">
            @csrf
            <input type="hidden" name="type" value="leave">

            {{-- Section: Basic Info --}}
            <div style="background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;margin-bottom:20px;">
                <div style="padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                    <span style="font-size:12px;font-weight:600;color:#8E8E93;text-transform:uppercase;letter-spacing:0.6px;">Employee Information</span>
                </div>
                <div style="padding:6px 0;">
                    <div style="display:flex;align-items:center;padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:130px;font-weight:400;">Office / Dept.</label>
                        <input type="text" name="office" required placeholder="Department name" style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                    <div style="display:flex;align-items:center;padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:130px;font-weight:400;">Last Name</label>
                        <input type="text" name="last_name" required placeholder="Doe" style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                    <div style="display:flex;align-items:center;padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:130px;font-weight:400;">First Name</label>
                        <input type="text" name="first_name" required placeholder="John" style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                    <div style="display:flex;align-items:center;padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:130px;font-weight:400;">Date of Filing</label>
                        <input type="date" name="date_filling" required value="{{ date('Y-m-d') }}" style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                    <div style="display:flex;align-items:center;padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:130px;font-weight:400;">Position</label>
                        <input type="text" name="position" required placeholder="Your position" style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                    <div style="display:flex;align-items:center;padding:14px 18px;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:130px;font-weight:400;">Salary</label>
                        <input type="text" name="salary" required placeholder="₱ 0.00" style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                </div>
            </div>

            {{-- Section 6A: Type of Leave --}}
            <div style="background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;margin-bottom:20px;">
                <div style="padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                    <span style="font-size:12px;font-weight:600;color:#8E8E93;text-transform:uppercase;letter-spacing:0.6px;">6A · Type of Leave</span>
                </div>
                <div style="padding:6px 0;">
                    @php
                    $leaveTypes = [
                        'vacation' => 'Vacation Leave',
                        'mandatory' => 'Mandatory / Forced Leave',
                        'sick' => 'Sick Leave',
                        'maternity' => 'Maternity Leave',
                        'paternity' => 'Paternity Leave',
                        'special_priv' => 'Special Privilege Leave',
                        'solo_parent' => 'Solo Parent Leave',
                        'study' => 'Study Leave',
                        'vawc' => '10-Day VAWC Leave',
                        'rehab' => 'Rehabilitation Privilege',
                        'women' => 'Special Leave Benefits for Women',
                        'calamity' => 'Special Emergency (Calamity) Leave',
                        'adoption' => 'Adoption Leave',
                    ];
                    @endphp
                    @foreach($leaveTypes as $key => $label)
                    <label style="display:flex;align-items:center;justify-content:space-between;padding:13px 18px;border-bottom:1px solid #F2F2F7;cursor:pointer;">
                        <span style="font-size:15px;color:#1C1C1E;">{{ $label }}</span>
                        <input type="checkbox" name="leave_type_{{ $key }}" value="1" style="width:20px;height:20px;accent-color:#007AFF;cursor:pointer;">
                    </label>
                    @endforeach
                    <div style="display:flex;align-items:center;padding:14px 18px;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:80px;font-weight:400;">Others</label>
                        <input type="text" name="leave_type_others" placeholder="Specify..." style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                </div>
            </div>

            {{-- Section 6B: Details of Leave --}}
            <div style="background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;margin-bottom:20px;">
                <div style="padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                    <span style="font-size:12px;font-weight:600;color:#8E8E93;text-transform:uppercase;letter-spacing:0.6px;">6B · Details of Leave</span>
                </div>
                <div style="padding:6px 0;">
                    <div style="padding:10px 18px 4px; font-size:13px;color:#8E8E93;font-style:italic;">Vacation / Special Privilege Leave</div>
                    <label style="display:flex;align-items:center;justify-content:space-between;padding:13px 18px;border-bottom:1px solid #F2F2F7;cursor:pointer;">
                        <span style="font-size:15px;color:#1C1C1E;">Within the Philippines</span>
                        <input type="checkbox" name="leave_vacation_within" value="1" style="width:20px;height:20px;accent-color:#007AFF;">
                    </label>
                    <div style="display:flex;align-items:center;padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:130px;font-weight:400;">Abroad (Specify)</label>
                        <input type="text" name="leave_vacation_abroad" placeholder="Country..." style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                    <div style="padding:10px 18px 4px; font-size:13px;color:#8E8E93;font-style:italic;">Sick Leave</div>
                    <div style="display:flex;align-items:center;padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:130px;font-weight:400;">In Hospital</label>
                        <input type="text" name="leave_sick_hospital" placeholder="Specify illness..." style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                    <div style="display:flex;align-items:center;padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:130px;font-weight:400;">Out Patient</label>
                        <input type="text" name="leave_sick_outpatient" placeholder="Specify illness..." style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                    <div style="padding:10px 18px 4px; font-size:13px;color:#8E8E93;font-style:italic;">Special Leave Benefits for Women</div>
                    <div style="display:flex;align-items:center;padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:130px;font-weight:400;">Specify Illness</label>
                        <input type="text" name="leave_women_illness" placeholder="..." style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                    <div style="padding:10px 18px 4px; font-size:13px;color:#8E8E93;font-style:italic;">Study Leave</div>
                    <label style="display:flex;align-items:center;justify-content:space-between;padding:13px 18px;border-bottom:1px solid #F2F2F7;cursor:pointer;">
                        <span style="font-size:15px;color:#1C1C1E;">Completion of Master's Degree</span>
                        <input type="checkbox" name="leave_study_master" value="1" style="width:20px;height:20px;accent-color:#007AFF;">
                    </label>
                    <label style="display:flex;align-items:center;justify-content:space-between;padding:13px 18px;border-bottom:1px solid #F2F2F7;cursor:pointer;">
                        <span style="font-size:15px;color:#1C1C1E;">BAR / Board Examination Review</span>
                        <input type="checkbox" name="leave_study_bar" value="1" style="width:20px;height:20px;accent-color:#007AFF;">
                    </label>
                    <div style="padding:10px 18px 4px; font-size:13px;color:#8E8E93;font-style:italic;">Other Purpose</div>
                    <label style="display:flex;align-items:center;justify-content:space-between;padding:13px 18px;border-bottom:1px solid #F2F2F7;cursor:pointer;">
                        <span style="font-size:15px;color:#1C1C1E;">Monetization of Leave Credits</span>
                        <input type="checkbox" name="leave_other_monetization" value="1" style="width:20px;height:20px;accent-color:#007AFF;">
                    </label>
                    <label style="display:flex;align-items:center;justify-content:space-between;padding:13px 18px;cursor:pointer;">
                        <span style="font-size:15px;color:#1C1C1E;">Terminal Leave</span>
                        <input type="checkbox" name="leave_other_terminal" value="1" style="width:20px;height:20px;accent-color:#007AFF;">
                    </label>
                </div>
            </div>

            {{-- Section 6C & 6D --}}
            <div style="background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;margin-bottom:20px;">
                <div style="padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                    <span style="font-size:12px;font-weight:600;color:#8E8E93;text-transform:uppercase;letter-spacing:0.6px;">6C · Days Applied For</span>
                </div>
                <div style="padding:6px 0;">
                    <div style="display:flex;align-items:center;padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:160px;font-weight:400;">Number of Working Days</label>
                        <input type="number" name="working_days_applied" min="1" required placeholder="e.g. 3" style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                    <div style="display:flex;align-items:center;padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:160px;font-weight:400;">Inclusive Dates</label>
                        <input type="text" name="inclusive_dates" required placeholder="e.g. Oct 1 – Oct 3, 2025" style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                    <div style="padding:14px 18px 4px;border-bottom:1px solid #F2F2F7;">
                        <span style="font-size:12px;font-weight:600;color:#8E8E93;text-transform:uppercase;letter-spacing:0.6px;">6D · Commutation</span>
                    </div>
                    <label style="display:flex;align-items:center;justify-content:space-between;padding:13px 18px;border-bottom:1px solid #F2F2F7;cursor:pointer;">
                        <span style="font-size:15px;color:#1C1C1E;">Not Requested</span>
                        <input type="radio" name="commutation" value="not_requested" style="width:20px;height:20px;accent-color:#007AFF;">
                    </label>
                    <label style="display:flex;align-items:center;justify-content:space-between;padding:13px 18px;cursor:pointer;">
                        <span style="font-size:15px;color:#1C1C1E;">Requested</span>
                        <input type="radio" name="commutation" value="requested" style="width:20px;height:20px;accent-color:#007AFF;">
                    </label>
                </div>
            </div>

            <button type="submit" style="width:100%;background:#007AFF;color:#fff;font-size:17px;font-weight:600;padding:16px;border:none;border-radius:14px;cursor:pointer;font-family:inherit;box-shadow:0 4px 16px rgba(0,122,255,0.3);transition:background 0.2s;margin-bottom:40px;" onclick="mergeNames()">Submit Application</button>
        </form>
    </div>
</div>

<script>
function mergeNames() {
    const form = document.getElementById('leaveForm');
    const first = form.querySelector('[name="first_name"]').value;
    const last = form.querySelector('[name="last_name"]').value;
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'name';
    input.value = last + ', ' + first;
    form.appendChild(input);
}
</script>
@endsection
