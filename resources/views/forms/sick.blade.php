@extends('layouts.app')

@section('title', 'Sick Leave Application - LeaveGo')

@section('content')
<div class="container" style="padding-top: 50px; padding-bottom: 50px;">
    <div style="max-width: 900px; margin: 0 auto;">
        <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px;">
            <a href="{{ route('selection') }}" style="text-decoration: none; color: var(--text-dark); font-size: 24px;">←</a>
            <h1>Sick Leave</h1>
        </div>

        <div class="card">
            <form action="{{ route('forms.submit') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="sick">
                
                <div class="form-grid">
                    <div class="form-group" style="grid-column: span 2;">
                        <label for="office">1. Office/ Department</label>
                        <input type="text" id="office" name="office" class="form-control" placeholder="Enter department" required>
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label for="name">2. NAME (Last, First, Middle)</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Doe, John Smith" required>
                    </div>

                    <div class="form-group">
                        <label for="date_filling">3. Date of Filling</label>
                        <input type="date" id="date_filling" name="date_filling" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="position">4. Position</label>
                        <input type="text" id="position" name="position" class="form-control" placeholder="Software Engineer" required>
                    </div>

                    <div class="form-group">
                        <label for="salary">5. Salary</label>
                        <input type="text" id="salary" name="salary" class="form-control" placeholder="₱ 0.00" required>
                    </div>
                </div>

                <div style="margin-top: 40px; text-align: right;">
                    <button type="submit" class="btn btn-primary" style="padding: 15px 40px;">Submit Form</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
