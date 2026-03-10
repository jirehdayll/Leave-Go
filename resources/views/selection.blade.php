@extends('layouts.app')

@section('title', 'Select Application - LeaveGo')

@section('content')
<div class="container flex-center full-height">
    <div style="text-align: center; width: 100%;">
        <h1 style="margin-bottom: 10px;">What would you like to apply for?</h1>
        <p style="color: var(--text-muted); margin-bottom: 50px;">Please choose an application type to get started.</p>

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px; max-width: 800px; margin: 0 auto;">
            <!-- Travel Order Card -->
            <div class="card" style="border-top: 5px solid var(--primary-blue);">
                <div style="font-size: 40px; margin-bottom: 20px;">✈️</div>
                <h2 style="color: var(--primary-blue); margin-bottom: 15px;">Travel Order</h2>
                <p style="color: var(--text-muted); margin-bottom: 25px; font-size: 14px;">Apply for a travel order for official business or personal travel.</p>
                <a href="{{ route('forms.travel') }}" class="btn btn-blue" style="width: 100%;">Get Started</a>
            </div>

            <!-- Sick Leave Card -->
            <div class="card" style="border-top: 5px solid var(--primary-green);">
                <div style="font-size: 40px; margin-bottom: 20px;">🤒</div>
                <h2 style="color: var(--primary-green); margin-bottom: 15px;">Sick Leave</h2>
                <p style="color: var(--text-muted); margin-bottom: 25px; font-size: 14px;">Submit a sick leave application for health-related absences.</p>
                <a href="{{ route('forms.sick') }}" class="btn btn-primary" style="width: 100%;">Get Started</a>
            </div>
        </div>
    </div>
</div>
@endsection
