@php
    $currentRoute = Route::currentRouteName();
@endphp

<aside class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">LeaveGo</div>
        <div class="sidebar-subtitle">Admin Panel</div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section-title">Applications</div>
        <a href="{{ route('admin.dashboard', ['tab'=>'pending']) }}" class="nav-item {{ $currentRoute == 'admin.dashboard' ? 'active' : '' }}">
            <div class="nav-icon">📥</div> Pending
        </a>
        <a href="{{ route('admin.approved') }}" class="nav-item {{ $currentRoute == 'admin.approved' ? 'active' : '' }}">
            <div class="nav-icon">✅</div> Approved Forms
        </a>
        <a href="{{ route('admin.dashboard', ['tab'=>'trash']) }}" class="nav-item">
            <div class="nav-icon">🗑</div> Trash
        </a>
        
        <div class="nav-section-title" style="margin-top:16px;">Reports</div>
        <a href="{{ route('admin.monthly') }}" class="nav-item {{ $currentRoute == 'admin.monthly' ? 'active' : '' }}">
            <div class="nav-icon">📊</div> Monthly Summary
        </a>
        
        <div class="nav-section-title" style="margin-top:16px;">Manage</div>
        <a href="{{ route('admin.employees') }}" class="nav-item {{ Str::contains($currentRoute, 'admin.employees') ? 'active' : '' }}">
            <div class="nav-icon">👥</div> Account Management
        </a>
        <a href="{{ route('admin.create-account') }}" class="nav-item {{ $currentRoute == 'admin.create-account' ? 'active' : '' }}">
            <div class="nav-icon">👤</div> Create Account
        </a>
    </nav>
    <div class="sidebar-footer">
        <strong>{{ Auth::user()->name }}</strong>
        {{ Auth::user()->email }}
        <form action="{{ route('logout') }}" method="POST" style="margin-top:10px;">
            @csrf
            <button type="submit" style="background:none;border:none;color:#FF3B30;cursor:pointer;font-size:13px;padding:0;font-family:inherit;font-weight:500;">Sign Out</button>
        </form>
    </div>
</aside>

<style>
    .sidebar { width:260px; min-height:100vh; background:#fff; border-right:1px solid #E5E5EA; display:flex; flex-direction:column; flex-shrink:0; position:fixed; top:0; left:0; bottom:0; z-index: 1000; }
    .sidebar-header { padding:28px 24px 20px; border-bottom:1px solid #F2F2F7; }
    .sidebar-logo { font-size:24px; font-weight:700; color:#007AFF; }
    .sidebar-subtitle { font-size:12px; color:#8E8E93; margin-top:2px; }
    .sidebar-nav { padding:12px 0; flex:1; overflow-y: auto; }
    .nav-section-title { font-size:11px; font-weight:600; color:#8E8E93; text-transform:uppercase; letter-spacing:0.8px; padding:16px 24px 8px; }
    .nav-item { display:flex; align-items:center; gap:12px; padding:12px 24px; text-decoration:none; color:#1C1C1E; font-size:15px; transition:all 0.15s ease; border-left: 3px solid transparent; }
    .nav-item:hover { background:#F2F2F7; }
    .nav-item.active { background:#EBF4FF; color:#007AFF; font-weight:600; border-left-color: #007AFF; }
    .nav-icon { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:16px; background:#F2F2F7; transition: all 0.15s ease; }
    .nav-item.active .nav-icon { background:#007AFF; color:#fff; }
    .sidebar-footer { padding:20px 24px; border-top:1px solid #F2F2F7; font-size:13px; color:#8E8E93; }
    .sidebar-footer strong { color:#1C1C1E; display:block; font-size:14px; margin-bottom:2px; }
</style>
