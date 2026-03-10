@extends('layouts.app')

@section('title', 'Success - LeaveGo')

@section('content')
<div class="container flex-center full-height">
    <div style="text-align: center; max-width: 500px;">
        <div style="font-size: 80px; color: var(--primary-green); margin-bottom: 20px;">✅</div>
        <h1 style="margin-bottom: 20px;">Form Submitted</h1>
        <p style="color: var(--text-muted); margin-bottom: 40px;">Your application has been successfully submitted and is now pending review by the administrator. You will be notified once a decision has been made.</p>
        
        <div style="display: flex; gap: 20px; justify-content: center;">
            <a href="{{ route('selection') }}" class="btn btn-blue">New Application</a>
            <a href="{{ route('login') }}" class="btn " style="border: 1px solid #ddd;">Back to Home</a>
        </div>
    </div>
</div>
@endsection
