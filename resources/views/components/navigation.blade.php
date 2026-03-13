@if(auth()->check())
<nav class="ios-navigation">
    <div class="nav-brand">
        <span class="brand-icon">LG</span>
        <span class="brand-name">Leave Go</span>
    </div>
    
    <div class="nav-menu">
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <span class="nav-icon">🏠</span>
            Dashboard
        </a>
        
        @if(auth()->user()->is_admin)
            <a href="{{ route('employees.index') }}" class="nav-link {{ request()->is('employees*') ? 'active' : '' }}">
                <span class="nav-icon">👥</span>
                Employees
            </a>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin*') ? 'active' : '' }}">
                <span class="nav-icon">⚙️</span>
                Admin
            </a>
        @endif
        
        <a href="{{ route('selection') }}" class="nav-link {{ request()->is('selection') ? 'active' : '' }}">
            <span class="nav-icon">📝</span>
            Leave Request
        </a>
    </div>
    
    <div class="nav-user">
        <div class="user-menu">
            <button class="user-button" onclick="toggleUserMenu()">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="user-name">{{ auth()->user()->name }}</span>
                <span class="user-arrow">▼</span>
            </button>
            
            <div class="user-dropdown" id="userDropdown">
                <div class="dropdown-header">
                    <div class="user-info">
                        <strong>{{ auth()->user()->name }}</strong>
                        <small>{{ auth()->user()->email }}</small>
                    </div>
                </div>
                
                <div class="dropdown-divider"></div>
                
                @if(auth()->user()->is_admin)
                    <a href="{{ route('employees.index') }}" class="dropdown-item">
                        <span class="dropdown-icon">👥</span>
                        Manage Employees
                    </a>
                @endif
                
                <a href="#" class="dropdown-item">
                    <span class="dropdown-icon">👤</span>
                    Profile Settings
                </a>
                
                <div class="dropdown-divider"></div>
                
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="dropdown-item logout-item">
                        <span class="dropdown-icon">🚪</span>
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
.ios-navigation {
    background: white;
    border-radius: 16px;
    padding: 12px 20px;
    margin-bottom: 24px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
}

.nav-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 700;
    font-size: 20px;
    color: #1D1D1F;
}

.brand-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #007AFF, #0051D5);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
    font-weight: bold;
}

.nav-menu {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    border-radius: 10px;
    text-decoration: none;
    color: #8E8E93;
    font-weight: 500;
    transition: all 0.3s ease;
    font-size: 15px;
}

.nav-link:hover {
    background: #F2F2F7;
    color: #007AFF;
    text-decoration: none;
}

.nav-link.active {
    background: rgba(0, 122, 255, 0.1);
    color: #007AFF;
}

.nav-icon {
    font-size: 16px;
}

.nav-user {
    position: relative;
}

.user-button {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 12px;
    border: none;
    background: #F2F2F7;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.user-button:hover {
    background: #E5E5EA;
}

.user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #007AFF, #0051D5);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 600;
}

.user-name {
    font-weight: 500;
    color: #1D1D1F;
    font-size: 15px;
}

.user-arrow {
    font-size: 12px;
    color: #8E8E93;
    transition: transform 0.3s ease;
}

.user-dropdown {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    background: white;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    min-width: 240px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 1000;
}

.user-dropdown.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-header {
    padding: 16px;
    border-bottom: 1px solid #F2F2F7;
}

.user-info strong {
    display: block;
    color: #1D1D1F;
    font-size: 15px;
}

.user-info small {
    color: #8E8E93;
    font-size: 13px;
}

.dropdown-divider {
    height: 1px;
    background: #F2F2F7;
    margin: 4px 0;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    color: #1D1D1F;
    text-decoration: none;
    font-size: 15px;
    transition: background 0.2s ease;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
}

.dropdown-item:hover {
    background: #F2F2F7;
    text-decoration: none;
    color: #1D1D1F;
}

.logout-item:hover {
    background: rgba(255, 59, 48, 0.1);
    color: #FF3B30;
}

.dropdown-icon {
    font-size: 16px;
    width: 20px;
    text-align: center;
}

.logout-form {
    margin: 0;
    padding: 0;
}

@media (max-width: 768px) {
    .ios-navigation {
        flex-direction: column;
        align-items: stretch;
    }
    
    .nav-menu {
        justify-content: center;
    }
    
    .nav-user {
        align-self: flex-end;
    }
}
</style>

<script>
function toggleUserMenu() {
    const dropdown = document.getElementById('userDropdown');
    dropdown.classList.toggle('show');
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function closeDropdown(e) {
        if (!e.target.closest('.user-menu')) {
            dropdown.classList.remove('show');
            document.removeEventListener('click', closeDropdown);
        }
    });
}
</script>
@endif
