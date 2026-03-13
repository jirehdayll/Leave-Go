<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gordon College - Leave Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('notifications.flash')
    <style>
        body {
            background: linear-gradient(135deg, #1a5f3f 0%, #2d8659 50%, #1a5f3f 100%);
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        .ios-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .ios-input {
            background: rgba(142, 142, 147, 0.12);
            border: 1px solid rgba(142, 142, 147, 0.2);
            border-radius: 12px;
            padding: 16px 20px;
            font-size: 17px;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .ios-input:focus {
            outline: none;
            border-color: #1a5f3f;
            background: rgba(26, 95, 63, 0.05);
            box-shadow: 0 0 0 4px rgba(26, 95, 63, 0.1);
        }
        
        .ios-button {
            background: #1a5f3f;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 16px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .ios-button:hover {
            background: #2d8659;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(26, 95, 63, 0.3);
        }
        
        .ios-button:active {
            transform: translateY(0);
        }
        
        .ios-button:disabled {
            background: #C7C7CC;
            cursor: not-allowed;
            transform: none;
        }
        
        .error-message {
            background: rgba(255, 59, 48, 0.1);
            border: 1px solid rgba(255, 59, 48, 0.3);
            color: #FF3B30;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 15px;
            margin-bottom: 20px;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #1a5f3f, #2d8659);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
            margin: 0 auto 30px;
            box-shadow: 0 10px 30px rgba(26, 95, 63, 0.3);
            position: relative;
        }
        
        .logo::before {
            content: '';
            position: absolute;
            width: 90px;
            height: 90px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            top: -5px;
            left: -5px;
        }
        
        .logo-text {
            font-size: 14px;
            font-weight: 600;
            color: #1a5f3f;
            text-align: center;
            margin-top: 10px;
            letter-spacing: 1px;
        }
        
        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #8E8E93;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .input-group {
            margin-bottom: 24px;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="ios-card p-8 w-full max-w-md animate-slide-up">
            <div class="logo">
                GC
            </div>
            <div class="logo-text">GORDON COLLEGE</div>
            <div class="logo-text" style="font-size: 12px; margin-top: -5px;">OLONGAPO CITY</div>
            
            <h1 class="text-3xl font-bold text-center mb-2" style="color: #1D1D1F;">Welcome to Gordon College</h1>
            <p class="text-center mb-8" style="color: #8E8E93;">Sign in to your Leave Management account</p>
            
            @if ($errors->any())
                <div class="error-message">
                    {{ $errors->first() }}
                </div>
            @endif
            
            <form method="POST" action="/login">
                @csrf
                
                <div class="input-group">
                    <label class="form-label">Email Address</label>
                    <input 
                        type="email" 
                        name="email" 
                        class="ios-input" 
                        value="{{ old('email') }}" 
                        placeholder="Enter your email"
                        required 
                        autocomplete="email" 
                        autofocus
                    >
                </div>
                
                <div class="input-group">
                    <label class="form-label">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        class="ios-input" 
                        placeholder="Enter your password"
                        required 
                        autocomplete="current-password"
                    >
                </div>
                
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="mr-2" {{ old('remember') ? 'checked' : '' }}>
                        <span style="color: #8E8E93; font-size: 15px;">Remember me</span>
                    </label>
                </div>
                
                <button type="submit" class="ios-button mb-4">
                    Sign In to Gordon College
                </button>
                
                @if (Route::has('password.request'))
                    <div class="text-center">
                        <a href="{{ route('password.request') }}" style="color: #007AFF; text-decoration: none; font-size: 15px;">
                            Forgot your password?
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>
    
    <script>
        // Add smooth transitions and animations
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.ios-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
        });
    </script>
</body>
</html>
