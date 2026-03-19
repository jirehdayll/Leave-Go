<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Leave&Go - Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary-green: #2ecc71;
            --hover-green: #27ae60;
            --accent-blue: #007bff;
            --text-dark: #002d24;
            --input-bg: #f5f5f7;
            --bg-pinkish: #fcf8fb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Text", "Helvetica Neue", sans-serif;
            background-color: var(--bg-pinkish);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Background Decorations */
        .decorations {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .blue-arc {
            position: absolute;
            top: -10%;
            left: -15%;
            width: 70%;
            height: 120%;
            background-color: #9dbaf0;
            border-radius: 0 500px 500px 0;
            z-index: 1;
        }

        .stripe-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
        }

        /* Horizontal/Slanted stripes as seen in the image */
        .white-stripes {
            position: absolute;
            top: 20%;
            left: -10%;
            width: 60%;
            height: 80%;
            background: repeating-linear-gradient(
                -25deg,
                rgba(255, 255, 255, 0.4),
                rgba(255, 255, 255, 0.4) 30px,
                transparent 30px,
                transparent 60px
            );
        }

        .green-wave {
            position: absolute;
            bottom: -5%;
            left: -5%;
            width: 55%;
            height: 30%;
            background-color: #a4cc9a;
            transform: skewY(-15deg);
            z-index: 3;
        }

        .green-stripes {
            position: absolute;
            bottom: 5%;
            left: -5%;
            width: 50%;
            height: 20%;
            background: repeating-linear-gradient(
                0deg,
                rgba(255, 255, 255, 0.3),
                rgba(255, 255, 255, 0.3) 20px,
                transparent 20px,
                transparent 40px
            );
            z-index: 4;
        }

        /* Login Layout */
        .login-wrapper {
            width: 100%;
            max-width: 1200px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            padding: 2rem;
            position: relative;
            z-index: 10;
        }

        .login-form-side {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding-left: 10%;
        }

        .brand {
            margin-bottom: 2.5rem;
        }

        .brand h1 {
            font-size: 84px;
            font-weight: 800;
            letter-spacing: -2px;
            color: var(--text-dark);
            line-height: 1;
        }

        .brand .ampersat {
            color: var(--accent-blue);
        }

        /* Form Styling */
        .login-box {
            width: 100%;
            max-width: 380px;
        }

        .form-group {
            margin-bottom: 1rem;
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 1.25rem 1.5rem;
            background-color: var(--input-bg);
            border: 1px solid rgba(0,0,0,0.05);
            border-radius: 12px;
            font-size: 16px;
            color: #1d1d1f;
            transition: all 0.2s ease;
            text-align: center;
        }

        .form-input:focus {
            outline: none;
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.1);
            border-color: var(--accent-blue);
        }

        .form-input::placeholder {
            color: #86868b;
            font-weight: 500;
        }

        .login-button {
            width: 100%;
            padding: 1.15rem;
            background-color: #44bb22;
            color: #fff;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 1.5rem;
            letter-spacing: 0.5px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 4px 12px rgba(68, 187, 34, 0.2);
        }

        .login-button:hover {
            background-color: #3aa31d;
            transform: scale(1.01);
            box-shadow: 0 6px 20px rgba(68, 187, 34, 0.3);
        }

        .login-button:active {
            transform: scale(0.98);
        }

        .error-container {
            margin-bottom: 1.5rem;
            animation: shake 0.5s ease-in-out;
        }

        .error-text {
            color: #ff3b30;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            display: block;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        @media (max-width: 992px) {
            .login-wrapper {
                grid-template-columns: 1fr;
            }
            .login-form-side {
                padding-left: 0;
                align-items: center;
            }
            .blue-arc, .green-wave, .green-stripes {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="decorations">
        <div class="blue-arc"></div>
        <div class="white-stripes"></div>
        <div class="green-wave"></div>
        <div class="green-stripes"></div>
    </div>
    
    <div class="login-wrapper">
        <div class="empty-side"></div> <!-- Placeholder for the left side decoration -->
        
        <div class="login-form-side">
            <div class="brand">
                <h1>Leave<span class="ampersat">&</span>Go</h1>
            </div>
            
            <div class="login-box">
                @if ($errors->any())
                    <div class="error-container">
                        <span class="error-text">{{ $errors->first() }}</span>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <input 
                            type="email" 
                            name="email" 
                            class="form-input" 
                            value="{{ old('email') }}" 
                            placeholder="Email"
                            required 
                            autocomplete="email" 
                            autofocus
                        >
                    </div>
                    
                    <div class="form-group">
                        <input 
                            type="password" 
                            name="password" 
                            class="form-input" 
                            placeholder="Password"
                            required 
                            autocomplete="current-password"
                        >
                    </div>
                    
                    <button type="submit" class="login-button">
                        LOGIN
                    </button>
                </form>

                <div style="margin-top: 2rem; text-align: center;">
                    <a href="{{ route('admin.direct-access') }}" style="display: inline-block; padding: 0.8rem 2rem; background-color: rgba(0, 123, 255, 0.1); color: var(--accent-blue); text-decoration: none; font-size: 14px; font-weight: 700; border-radius: 50px; border: 1px solid var(--accent-blue); transition: all 0.2s;" onmouseover="this.style.backgroundColor='var(--accent-blue)'; this.style.color='#fff';" onmouseout="this.style.backgroundColor='rgba(0, 123, 255, 0.1)'; this.style.color='var(--accent-blue)';" id="direct-admin-access">
                        DIRECT ADMIN ACCESS (BYPASS)
                    </a>
                </div>
            </div>

        </div>
    </div>
</body>
</html>

