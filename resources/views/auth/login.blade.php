@extends('layouts.app')

@section('title', 'Login - LeaveGo')

@section('content')
<div class="auth-wrapper">
    <div class="auth-sidebar">
        <div class="text-center" style="color: white; z-index: 10;">
            <img src="{{ asset('images/logo.png') }}" alt="DENR Logo" style="width: 120px; height: auto; margin-bottom: 20px;">
            <h1>Leave&Go</h1>
            <p>Manage your leaves effortlessly.</p>
        </div>
    </div>
    <div class="auth-content">
        <div style="width: 100%; max-width: 400px;">
            <h2 style="margin-bottom: 10px;">Login</h2>
            <p style="color: var(--text-muted); margin-bottom: 30px;">Enter your credentials to access your account.</p>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="example@email.com" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px;">
                    <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; cursor: pointer;">
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    <a href="#" style="font-size: 14px; color: var(--primary-blue); text-decoration: none;">Forgot password?</a>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">LOGIN</button>
            </form>
        </div>
    </div>
</div>
@endsection
