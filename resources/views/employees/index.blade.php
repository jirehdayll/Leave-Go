<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employees - Leave Go</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('notifications.flash')
    <style>
        body {
            background: #F2F2F7;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 20px;
        }
        
        .ios-header {
            background: white;
            border-radius: 20px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .ios-title {
            font-size: 28px;
            font-weight: 700;
            color: #1D1D1F;
            margin: 0;
        }
        
        .ios-subtitle {
            color: #8E8E93;
            font-size: 16px;
            margin: 4px 0 0 0;
        }
        
        .ios-button {
            background: #007AFF;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .ios-button:hover {
            background: #0056CC;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(0, 122, 255, 0.3);
            text-decoration: none;
            color: white;
        }
        
        .ios-button-secondary {
            background: #F2F2F7;
            color: #007AFF;
            border: 1px solid #E5E5EA;
        }
        
        .ios-button-secondary:hover {
            background: #E5E5EA;
            text-decoration: none;
            color: #007AFF;
        }
        
        .ios-button-danger {
            background: #FF3B30;
        }
        
        .ios-button-danger:hover {
            background: #D70015;
        }
        
        .employee-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .employee-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .employee-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #007AFF, #0051D5);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 600;
            margin-right: 16px;
        }
        
        .employee-info {
            flex: 1;
        }
        
        .employee-name {
            font-size: 18px;
            font-weight: 600;
            color: #1D1D1F;
            margin: 0 0 4px 0;
        }
        
        .employee-email {
            color: #8E8E93;
            font-size: 14px;
            margin: 0 0 8px 0;
        }
        
        .employee-details {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }
        
        .employee-detail {
            font-size: 13px;
            color: #8E8E93;
            background: #F2F2F7;
            padding: 4px 12px;
            border-radius: 8px;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-active {
            background: rgba(52, 199, 89, 0.1);
            color: #34C759;
        }
        
        .status-inactive {
            background: rgba(255, 59, 48, 0.1);
            color: #FF3B30;
        }
        
        .employee-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        
        .action-button {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background: #F2F2F7;
            color: #8E8E93;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .action-button:hover {
            background: #E5E5EA;
            color: #007AFF;
        }
        
        .success-message {
            background: rgba(52, 199, 89, 0.1);
            border: 1px solid rgba(52, 199, 89, 0.3);
            color: #34C759;
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-weight: 500;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #8E8E93;
        }
        
        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }
        
        .search-bar {
            background: white;
            border: 1px solid #E5E5EA;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 16px;
            width: 300px;
            margin-bottom: 24px;
        }
        
        .search-bar:focus {
            outline: none;
            border-color: #007AFF;
            box-shadow: 0 0 0 4px rgba(0, 122, 255, 0.1);
        }
    </style>
</head>
<body>
    @include('components.navigation')
    
    <div class="container">
        <div class="ios-header">
            <div>
                <h1 class="ios-title">Employees</h1>
                <p class="ios-subtitle">{{ $employees->count() }} total employees</p>
            </div>
            @if(auth()->user()->is_admin)
                <a href="{{ route('employees.create') }}" class="ios-button">
                    <span>+</span> Add Employee
                </a>
            @endif
        </div>
        
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
        
        @if($employees->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">👥</div>
                <h3>No employees found</h3>
                <p>Start by adding your first employee to the system.</p>
                @if(auth()->user()->is_admin)
                    <br>
                    <a href="{{ route('employees.create') }}" class="ios-button">
                        <span>+</span> Add First Employee
                    </a>
                @endif
            </div>
        @else
            @foreach($employees as $employee)
                <div class="employee-card">
                    <div style="display: flex; align-items: center;">
                        <div class="employee-avatar">
                            {{ strtoupper(substr($employee->name, 0, 1)) }}
                        </div>
                        <div class="employee-info">
                            <h3 class="employee-name">{{ $employee->name }}</h3>
                            <p class="employee-email">{{ $employee->email }}</p>
                            <div class="employee-details">
                                @if($employee->position)
                                    <span class="employee-detail">{{ $employee->position }}</span>
                                @endif
                                @if($employee->office)
                                    <span class="employee-detail">{{ $employee->office }}</span>
                                @endif
                                @if($employee->salary)
                                    <span class="employee-detail">{{ $employee->salary }}</span>
                                @endif
                            </div>
                        </div>
                        <div style="margin-left: auto; display: flex; align-items: center; gap: 16px;">
                            <span class="status-badge {{ $employee->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $employee->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            @if(auth()->user()->is_admin)
                                <div class="employee-actions">
                                    <a href="{{ route('employees.edit', $employee) }}" class="action-button" title="Edit">
                                        ✏️
                                    </a>
                                    @if($employee->id !== auth()->id())
                                        <form method="POST" action="{{ route('employees.toggle-status', $employee) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="action-button" title="{{ $employee->is_active ? 'Deactivate' : 'Activate' }}">
                                                {{ $employee->is_active ? '⏸️' : '▶️' }}
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('employees.destroy', $employee) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this employee?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-button" title="Delete" style="color: #FF3B30;">
                                                🗑️
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</body>
</html>
