@extends('layouts.app')
@php $hideNav = true; @endphp


@section('title', 'Travel Order - LeaveGo')

@section('content')
<div style="min-height:100vh; background:#F2F2F7; padding:40px 20px; font-family:-apple-system,BlinkMacSystemFont,'SF Pro Text','Helvetica Neue',sans-serif;">
    <div style="max-width:640px; margin:0 auto;">
        <a href="{{ route('selection') }}" style="display:inline-flex;align-items:center;gap:6px;color:#007AFF;font-size:17px;font-weight:500;text-decoration:none;margin-bottom:28px;">
            <svg width="10" height="16" viewBox="0 0 10 16" fill="none"><path d="M8.5 1L1.5 8L8.5 15" stroke="#007AFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Back
        </a>

        <h1 style="font-size:32px;font-weight:700;color:#1C1C1E;margin-bottom:8px;letter-spacing:-0.5px;">Travel Order</h1>
        <p style="font-size:15px;color:#8E8E93;margin-bottom:32px;">DENR-CENRO Olongapo City · Official travel request</p>

        <form action="{{ route('forms.submit') }}" method="POST" id="travelForm">
            @csrf
            <input type="hidden" name="type" value="travel">
            <input type="hidden" name="date_filling" value="{{ date('Y-m-d') }}">

            {{-- Traveler Info --}}
            <div style="background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;margin-bottom:20px;">
                <div style="padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                    <span style="font-size:12px;font-weight:600;color:#8E8E93;text-transform:uppercase;letter-spacing:0.6px;">Traveler Information</span>
                </div>
                <div style="padding:6px 0;">
                    <div style="display:flex;align-items:center;padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:150px;">Last Name</label>
                        <input type="text" name="last_name" required placeholder="Doe" style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                    <div style="display:flex;align-items:center;padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:150px;">First Name</label>
                        <input type="text" name="first_name" required placeholder="John" style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                    <div style="display:flex;align-items:center;padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:150px;">Position</label>
                        <input type="text" name="position" required placeholder="e.g. Field Officer" style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                    <div style="display:flex;align-items:center;padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:150px;">Office</label>
                        <input type="text" name="office" required placeholder="CENRO Office" style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                    <div style="display:flex;align-items:center;padding:14px 18px;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:150px;">Salary</label>
                        <input type="text" name="salary" required placeholder="₱ 0.00" style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                </div>
            </div>

            {{-- Travel Details --}}
            <div style="background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;margin-bottom:20px;">
                <div style="padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                    <span style="font-size:12px;font-weight:600;color:#8E8E93;text-transform:uppercase;letter-spacing:0.6px;">Travel Details</span>
                </div>
                <div style="padding:6px 0;">
                    <div style="display:flex;align-items:center;padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:150px;">Departure Date</label>
                        <input type="date" name="departure_date" required style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                    <div style="display:flex;align-items:center;padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:150px;">Arrival Date</label>
                        <input type="date" name="arrival_date" style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                    <div style="display:flex;align-items:center;padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:150px;">Official Station</label>
                        <input type="text" name="official_station" placeholder="Home station..." style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                    <div style="display:flex;align-items:center;padding:14px 18px;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:150px;">Destination</label>
                        <input type="text" name="destination" placeholder="City, Province..." style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                </div>
            </div>

            {{-- Purpose & Expenses --}}
            <div style="background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;margin-bottom:20px;">
                <div style="padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                    <span style="font-size:12px;font-weight:600;color:#8E8E93;text-transform:uppercase;letter-spacing:0.6px;">Purpose & Expenses</span>
                </div>
                <div style="padding:6px 0;">
                    <div style="padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                        <label style="font-size:15px;color:#1C1C1E;display:block;margin-bottom:8px;">Purpose</label>
                        <textarea name="purpose" rows="3" placeholder="Official purpose of this travel..." style="width:100%;border:none;outline:none;font-size:15px;color:#1C1C1E;font-family:inherit;background:transparent;resize:none;"></textarea>
                    </div>
                    <div style="display:flex;align-items:center;padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:180px;">Per Diems / Expenses</label>
                        <input type="text" name="expenses_allowed" placeholder="e.g. ₱ 5,000" style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                    <div style="display:flex;align-items:center;padding:14px 18px;border-bottom:1px solid #F2F2F7;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:180px;">Appropriations Charged</label>
                        <input type="text" name="appropriations" placeholder="e.g. CDS" style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                    <div style="display:flex;align-items:center;padding:14px 18px;">
                        <label style="font-size:15px;color:#1C1C1E;min-width:180px;">Remarks</label>
                        <input type="text" name="remarks" placeholder="Special instructions..." style="flex:1;border:none;outline:none;font-size:15px;color:#1C1C1E;text-align:right;font-family:inherit;background:transparent;min-width:0;">
                    </div>
                </div>
            </div>

            <button type="submit" style="width:100%;background:#007AFF;color:#fff;font-size:17px;font-weight:600;padding:16px;border:none;border-radius:14px;cursor:pointer;font-family:inherit;box-shadow:0 4px 16px rgba(0,122,255,0.3);margin-bottom:40px;" onclick="mergeNames()">Submit Travel Order</button>
        </form>
    </div>
</div>
<script>
function mergeNames() {
    const form = document.getElementById('travelForm');
    const first = form.querySelector('[name="first_name"]').value;
    const last = form.querySelector('[name="last_name"]').value;
    const input = document.createElement('input');
    input.type = 'hidden'; input.name = 'name';
    input.value = last + ', ' + first;
    form.appendChild(input);
}
</script>
@endsection
