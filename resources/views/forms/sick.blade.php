@extends('layouts.app')

@section('title', 'Application for Leave - LeaveGo')

@section('content')
<div class="ios-form-container">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('selection') }}" style="text-decoration: none; color: #007aff; font-size: 17px; font-weight: 500;">← Back to Options</a>
    </div>

    <div class="ios-card">
        <h1 class="ios-title">Sick Leave Application</h1>
        
        <form action="{{ route('forms.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="type" value="sick">

            <div class="ios-row">
                <div class="ios-input-group">
                    <label class="ios-label">First Name</label>
                    <input type="text" name="first_name" class="ios-input" placeholder="John" required>
                </div>
                <div class="ios-input-group">
                    <label class="ios-label">Last Name</label>
                    <input type="text" name="last_name" class="ios-input" placeholder="Doe" required>
                </div>
            </div>

            <div class="ios-input-group">
                <label class="ios-label">Office / Department</label>
                <input type="text" name="office" class="ios-input" placeholder="e.g. Engineering" required>
            </div>

            <div class="ios-row">
                <div class="ios-input-group">
                    <label class="ios-label">Position</label>
                    <input type="text" name="position" class="ios-input" required>
                </div>
                <div class="ios-input-group">
                    <label class="ios-label">Salary</label>
                    <input type="text" name="salary" class="ios-input" placeholder="₱ 0.00" required>
                </div>
            </div>

            <div class="ios-row">
                <div class="ios-input-group">
                    <label class="ios-label">Date of Filing</label>
                    <input type="date" name="date_filling" class="ios-input" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="ios-input-group">
                    <label class="ios-label">Number of Working Days</label>
                    <input type="number" name="working_days_applied" class="ios-input" min="1" required>
                </div>
            </div>

            <div class="ios-input-group">
                <label class="ios-label">Inclusive Dates (e.g. Oct 1 - Oct 3)</label>
                <input type="text" name="inclusive_dates" class="ios-input" required>
            </div>

            <div class="ios-input-group" style="margin-top: 30px;">
                <label class="ios-label" style="margin-bottom: 12px;">Type of Leave</label>
                <select name="leave_type" class="ios-select" required>
                    <option value="" disabled selected>Select sick leave type...</option>
                    <option value="sick_hospital">In Hospital</option>
                    <option value="sick_outpatient">Out Patient</option>
                    <option value="other">Other Medical Leave</option>
                </select>
            </div>

            <div class="ios-input-group">
                <label class="ios-label">Specific Illness / Description</label>
                <textarea name="illness_description" class="ios-textarea" placeholder="Please specify your illness..."></textarea>
            </div>

            <div style="margin-top: 40px;">
                <button type="submit" class="ios-button">Submit Application</button>
            </div>
        </form>
    </div>
</div>

<!-- Merge first/last name to 'name' for backend validation before submit -->
<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        let first = document.querySelector('input[name="first_name"]').value;
        let last = document.querySelector('input[name="last_name"]').value;
        let hiddenName = document.createElement('input');
        hiddenName.type = 'hidden';
        hiddenName.name = 'name';
        hiddenName.value = last + ', ' + first;
        this.appendChild(hiddenName);
    });
</script>
@endsection
