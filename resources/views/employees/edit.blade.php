<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Employee - Leave Go</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('notifications.flash')
    <style>
        body {
            background: #F2F2F7;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 20px;
        }
        
        .ios-card {
            background: white;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            max-width: 600px;
            margin: 0 auto;
        }
        
        .ios-header {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .employee-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #007AFF, #0051D5);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 600;
            margin: 0 auto 20px;
        }
        
        .ios-title {
            font-size: 28px;
            font-weight: 700;
            color: #1D1D1F;
            margin: 0 0 8px 0;
        }
        
        .ios-subtitle {
            color: #8E8E93;
            font-size: 16px;
            margin: 0;
        }
        
        .ios-input {
            background: rgba(142, 142, 147, 0.12);
            border: 1px solid rgba(142, 142, 147, 0.2);
            border-radius: 12px;
            padding: 16px 20px;
            font-size: 17px;
            transition: all 0.3s ease;
            width: 100%;
            box-sizing: border-box;
        }
        
        .ios-input:focus {
            outline: none;
            border-color: #007AFF;
            background: rgba(0, 122, 255, 0.05);
            box-shadow: 0 0 0 4px rgba(0, 122, 255, 0.1);
        }
        
        .ios-button {
            background: #007AFF;
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
            background: #0056CC;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(0, 122, 255, 0.3);
        }
        
        .ios-button:active {
            transform: translateY(0);
        }
        
        .ios-button-secondary {
            background: #F2F2F7;
            color: #007AFF;
            border: 1px solid #E5E5EA;
            margin-right: 12px;
        }
        
        .ios-button-secondary:hover {
            background: #E5E5EA;
        }
        
        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #8E8E93;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
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
        
        .field-error {
            color: #FF3B30;
            font-size: 14px;
            margin-top: 4px;
        }
        
        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 32px;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
            margin-top: 8px;
        }
        
        .status-active {
            background: rgba(52, 199, 89, 0.1);
            color: #34C759;
        }
        
        .status-inactive {
            background: rgba(255, 59, 48, 0.1);
            color: #FF3B30;
        }
        
        .password-note {
            font-size: 13px;
            color: #8E8E93;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    @include('components.navigation')
    
    <div class="ios-card">
        <div class="ios-header">
            <div class="employee-avatar">
                {{ strtoupper(substr($employee->name, 0, 1)) }}
            </div>
            <h1 class="ios-title">Edit Employee</h1>
            <p class="ios-subtitle">Update {{ $employee->name }}'s information</p>
            <span class="status-badge {{ $employee->is_active ? 'status-active' : 'status-inactive' }}">
                {{ $employee->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>
        
        @if ($errors->any())
            <div class="error-message">
                Please correct the errors below.
            </div>
        @endif
        
        <form method="POST" action="{{ route('employees.update', $employee) }}">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input 
                    type="text" 
                    name="name" 
                    class="ios-input {{ $errors->has('name') ? 'is-invalid' : '' }}" 
                    value="{{ old('name', $employee->name) }}" 
                    placeholder="Enter employee's full name"
                    required
                >
                @if ($errors->has('name'))
                    <div class="field-error">{{ $errors->first('name') }}</div>
                @endif
            </div>
            
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input 
                    type="email" 
                    name="email" 
                    class="ios-input {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                    value="{{ old('email', $employee->email) }}" 
                    placeholder="employee@company.com"
                    required
                >
                @if ($errors->has('email'))
                    <div class="field-error">{{ $errors->first('email') }}</div>
                @endif
            </div>
            
            <div class="form-group">
                <label class="form-label">New Password (optional)</label>
                <input 
                    type="password" 
                    name="password" 
                    class="ios-input {{ $errors->has('password') ? 'is-invalid' : '' }}" 
                    placeholder="Leave blank to keep current password"
                >
                @if ($errors->has('password'))
                    <div class="field-error">{{ $errors->first('password') }}</div>
                @endif
                <p class="password-note">Only enter a new password if you want to change it</p>
            </div>
            
            <div class="form-group">
                <label class="form-label">Confirm New Password</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    class="ios-input {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" 
                    placeholder="Re-enter new password"
                >
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Position</label>
                    <input 
                        type="text" 
                        name="position" 
                        class="ios-input" 
                        value="{{ old('position', $employee->position) }}" 
                        placeholder="e.g. Software Engineer"
                    >
                </div>
                
                <div class="form-group">
                    <label class="form-label">Office</label>
                    <input 
                        type="text" 
                        name="office" 
                        class="ios-input" 
                        value="{{ old('office', $employee->office) }}" 
                        placeholder="e.g. Manila"
                    >
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Salary</label>
                <input 
                    type="text" 
                    name="salary" 
                    class="ios-input" 
                    value="{{ old('salary', $employee->salary) }}" 
                    placeholder="e.g. ₱50,000/month"
                >
            </div>
            
            <div class="button-group">
                <a href="{{ route('employees.index') }}" class="ios-button ios-button-secondary">
                    Cancel
                </a>
                <button type="submit" class="ios-button">
                    Update Employee
                </button>
            </div>
        </form>
    </div>
    
    <script>
        // Add smooth transitions
        document.querySelectorAll('.ios-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>
