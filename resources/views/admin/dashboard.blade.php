@extends('layouts.app')

@section('title', 'Admin Dashboard - LeaveGo')

@section('inline_styles')
.dashboard-wrapper {
    display: flex;
    min-height: 100vh;
}

.sidebar {
    width: 260px;
    background: var(--white);
    border-right: 1px solid #eee;
    padding: 30px 20px;
    display: flex;
    flex-direction: column;
}

.main-content {
    flex: 1;
    background: #f8fafc;
    padding: 40px;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 12px 15px;
    border-radius: 8px;
    color: var(--text-muted);
    text-decoration: none;
    margin-bottom: 5px;
    transition: var(--transition);
}

.nav-item:hover, .nav-item.active {
    background: var(--primary-green);
    color: var(--white);
}

.metrics-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}

.metric-card {
    background: var(--white);
    padding: 25px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    text-align: center;
}

.metric-value {
    font-size: 36px;
    font-weight: 700;
    margin: 10px 0;
}

.metric-label {
    color: var(--text-muted);
    font-size: 14px;
}

.charts-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 30px;
}

.chart-container {
    background: var(--white);
    padding: 30px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
}
@endsection

@section('content')
<div class="dashboard-wrapper">
    <div class="sidebar">
        <div class="logo" style="margin-bottom: 50px;">
            <div class="logo-icon"></div>
            <div>Leave<span class="blue">Go</span></div>
        </div>
        
        <nav>
            <a href="#" class="nav-item active"><span>📊</span> Dashboard</a>
            <a href="#" class="nav-item"><span>⏳</span> Pendings</a>
            <a href="#" class="nav-item"><span>⭐</span> Favorites</a>
            <a href="#" class="nav-item"><span>🗑️</span> Trash</a>
        </nav>

        <div style="margin-top: auto;">
            <a href="{{ route('login') }}" class="nav-item"><span>🚪</span> Logout</a>
        </div>
    </div>

    <div class="main-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h1 style="font-size: 24px;">Dashboard</h1>
                <p style="color: var(--text-muted);">Monday, March 10, 2026</p>
            </div>
            <div style="display: flex; align-items: center; gap: 15px;">
                <div style="text-align: right;">
                    <div style="font-weight: 600;">Jireh Dayll Brill</div>
                    <div style="font-size: 12px; color: var(--text-muted);">Admin</div>
                </div>
                <div style="width: 45px; height: 45px; background: #ddd; border-radius: 50%;"></div>
            </div>
        </div>

        <div class="metrics-grid">
            <div class="metric-card">
                <div class="metric-label" style="color: var(--primary-green);">Current Travel Order</div>
                <div class="metric-value">6</div>
                <div class="metric-label">Total</div>
            </div>
            <div class="metric-card">
                <div class="metric-label" style="color: var(--primary-blue);">Current Sick Leave</div>
                <div class="metric-value">7</div>
                <div class="metric-label">Total</div>
            </div>
            <div class="metric-card">
                <div class="metric-label" style="color: #f39c12;">Pending Travel Order</div>
                <div class="metric-value">11</div>
                <div class="metric-label">Total</div>
            </div>
            <div class="metric-card">
                <div class="metric-label" style="color: #e74c3c;">Pending Sick Leave</div>
                <div class="metric-value">15</div>
                <div class="metric-label">Total</div>
            </div>
        </div>

        <div class="charts-grid">
            <div class="chart-container">
                <h3 style="margin-bottom: 20px;">Month/Year Status</h3>
                <div style="height: 250px; background: #f9f9f9; border-radius: 8px; display: flex; align-items: flex-end; padding: 20px; gap: 10px;">
                    <!-- Simple CSS bar chart simulation -->
                    <div style="flex: 1; height: 40%; background: var(--primary-blue); opacity: 0.6; border-radius: 4px;"></div>
                    <div style="flex: 1; height: 60%; background: var(--primary-green); opacity: 0.6; border-radius: 4px;"></div>
                    <div style="flex: 1; height: 30%; background: var(--primary-blue); opacity: 0.6; border-radius: 4px;"></div>
                    <div style="flex: 1; height: 80%; background: var(--primary-green); opacity: 0.6; border-radius: 4px;"></div>
                    <div style="flex: 1; height: 50%; background: var(--primary-blue); opacity: 0.6; border-radius: 4px;"></div>
                    <div style="flex: 1; height: 75%; background: var(--primary-green); opacity: 0.6; border-radius: 4px;"></div>
                </div>
            </div>
            <div class="chart-container">
                <h3 style="margin-bottom: 20px;">This Month's Stats</h3>
                <div style="display: flex; justify-content: center; align-items: center; height: 250px;">
                    <div style="width: 180px; height: 180px; border-radius: 50%; border: 20px solid #eee; position: relative; display: flex; align-items: center; justify-content: center;">
                        <div style="position: absolute; width: 100%; height: 100%; border-radius: 50%; border: 20px solid var(--primary-green); border-bottom-color: transparent; border-left-color: transparent; transform: rotate(45deg);"></div>
                        <div style="text-align: center;">
                            <div style="font-size: 32px; font-weight: 700;">13</div>
                            <div style="font-size: 12px; color: var(--text-muted);">Total Requests</div>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 20px; display: flex; justify-content: space-around;">
                    <div style="font-size: 14px;"><span style="color: var(--primary-blue);">●</span> Travel Order: 6</div>
                    <div style="font-size: 14px;"><span style="color: var(--primary-green);">●</span> Sick Leave: 7</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
