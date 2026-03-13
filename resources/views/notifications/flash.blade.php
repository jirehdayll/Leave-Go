@if(session()->has('success'))
    <div class="notification notification-success" id="flash-notification">
        <div class="notification-icon">✓</div>
        <div class="notification-message">{{ session('success') }}</div>
        <button class="notification-close" onclick="this.parentElement.style.display='none'">×</button>
    </div>
@endif

@if(session()->has('error'))
    <div class="notification notification-error" id="flash-notification">
        <div class="notification-icon">⚠️</div>
        <div class="notification-message">{{ session('error') }}</div>
        <button class="notification-close" onclick="this.parentElement.style.display='none'">×</button>
    </div>
@endif

@if(session()->has('warning'))
    <div class="notification notification-warning" id="flash-notification">
        <div class="notification-icon">⚠️</div>
        <div class="notification-message">{{ session('warning') }}</div>
        <button class="notification-close" onclick="this.parentElement.style.display='none'">×</button>
    </div>
@endif

@if($errors->any())
    <div class="notification notification-error" id="flash-notification">
        <div class="notification-icon">⚠️</div>
        <div class="notification-message">
            @foreach($errors->all() as $error)
                {{ $error }} @if(!$loop->last)<br>@endif
            @endforeach
        </div>
        <button class="notification-close" onclick="this.parentElement.style.display='none'">×</button>
    </div>
@endif

<style>
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 16px 20px;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    z-index: 1000;
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 300px;
    max-width: 500px;
    animation: slideInRight 0.3s ease-out;
    backdrop-filter: blur(20px);
}

.notification-success {
    background: rgba(52, 199, 89, 0.95);
    color: white;
    border: 1px solid rgba(52, 199, 89, 0.3);
}

.notification-error {
    background: rgba(255, 59, 48, 0.95);
    color: white;
    border: 1px solid rgba(255, 59, 48, 0.3);
}

.notification-warning {
    background: rgba(255, 149, 0, 0.95);
    color: white;
    border: 1px solid rgba(255, 149, 0, 0.3);
}

.notification-icon {
    font-size: 20px;
    flex-shrink: 0;
}

.notification-message {
    flex: 1;
    font-size: 15px;
    font-weight: 500;
    line-height: 1.4;
}

.notification-close {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    padding: 0;
    opacity: 0.8;
    transition: opacity 0.2s;
}

.notification-close:hover {
    opacity: 1;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOutRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}
</style>

<script>
// Auto-hide notifications after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const notifications = document.querySelectorAll('.notification');
    notifications.forEach(notification => {
        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease-out';
            setTimeout(() => {
                notification.style.display = 'none';
            }, 300);
        }, 5000);
    });
});
</script>
