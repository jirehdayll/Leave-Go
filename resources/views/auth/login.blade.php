<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Leave&Go - Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .background-decoration {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }
        
        .blue-semicircle {
            position: absolute;
            top: -100px;
            left: -100px;
            width: 300px;
            height: 300px;
            background: rgba(52, 152, 219, 0.3);
            border-radius: 50%;
        }
        
        .green-stripes {
            position: absolute;
            top: 50px;
            left: 50px;
            width: 200px;
            height: 100px;
            background: repeating-linear-gradient(
                0deg,
                rgba(46, 204, 113, 0.3),
                rgba(46, 204, 113, 0.3) 10px,
                transparent 10px,
                transparent 20px
            );
        }
        
        .white-stripes {
            position: absolute;
            top: 100px;
            left: 100px;
            width: 150px;
            height: 150px;
            background: repeating-linear-gradient(
                45deg,
                rgba(255, 255, 255, 0.5),
                rgba(255, 255, 255, 0.5) 5px,
                transparent 5px,
                transparent 10px
            );
        }
        
        .login-container {
            background: white;
            border-radius: 20px;
            padding: 60px 50px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            position: relative;
            z-index: 1;
        }
        
        .brand {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .brand h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .brand .leave {
            color: #27ae60;
        }
        
        .brand .ampersand {
            color: #3498db;
        }
        
        .brand .go {
            color: #27ae60;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
            font-size: 14px;
        }
        
        .form-input {
            width: 100%;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #3498db;
            background: white;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        
        .form-input::placeholder {
            color: #999;
        }
        
        .login-button {
            width: 100%;
            padding: 15px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .login-button:hover {
            background: #229954;
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
        }
        
        .login-button:active {
            transform: translateY(0);
        }
        
        .error-message {
            background: rgba(231, 76, 60, 0.1);
            border: 1px solid rgba(231, 76, 60, 0.3);
            color: #e74c3c;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .field-error {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
        }
        
        @media (max-width: 480px) {
            .login-container {
                margin: 20px;
                padding: 40px 30px;
            }
            
            .brand h1 {
                font-size: 36px;
            }
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-container {
            animation: fadeIn 0.6s ease-out;
        }
    </style>
</head>
<body>
    <div class="background-decoration">
        <div class="blue-semicircle"></div>
        <div class="green-stripes"></div>
        <div class="white-stripes"></div>
    </div>
    
    <div class="login-container">
        <div class="brand">
            <h1>
                <span class="leave">Leave</span><span class="ampersand">&</span><span class="go">Go</span>
            </h1>
        </div>
        
        @if ($errors->any())
            <div class="error-message">
                {{ $errors->first() }}
            </div>
        @endif
        
        <form method="POST" action="/login">
            @csrf
            
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input 
                    type="email" 
                    id="email"
                    name="email" 
                    class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                    value="{{ old('email') }}" 
                    placeholder="Enter your email"
                    required 
                    autocomplete="email" 
                    autofocus
                >
                @if ($errors->has('email'))
                    <div class="field-error">{{ $errors->first('email') }}</div>
                @endif
            </div>
            
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input 
                    type="password" 
                    id="password"
                    name="password" 
                    class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}" 
                    placeholder="Enter your password"
                    required 
                    autocomplete="current-password"
                >
                @if ($errors->has('password'))
                    <div class="field-error">{{ $errors->first('password') }}</div>
                @endif
            </div>
            
            <button type="submit" class="login-button">
                LOGIN
            </button>
        </form>
    </div>
    
    <script>
        // Add smooth animations
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-input');
            
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
