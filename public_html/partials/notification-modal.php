<!-- Notification Modal -->
<div id="notificationModal" class="notification-modal" style="display: none;">
    <div class="notification-modal-overlay" onclick="closeNotificationModal()"></div>
    <div class="notification-modal-content">
        <button class="notification-modal-close" onclick="closeNotificationModal()">&times;</button>
        <div class="notification-modal-icon" id="notificationIcon">
            <!-- Icon will be inserted here -->
        </div>
        <h3 class="notification-modal-title" id="notificationTitle">Notification</h3>
        <p class="notification-modal-message" id="notificationMessage"></p>
        <button class="btn-primary notification-modal-btn" onclick="closeNotificationModal()">OK</button>
    </div>
</div>

<style>
.notification-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
}

.notification-modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
}

.notification-modal-content {
    position: relative;
    background: white;
    border-radius: 12px;
    padding: 40px 30px;
    max-width: 500px;
    width: 90%;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    text-align: center;
    animation: modalSlideIn 0.3s ease-out;
    z-index: 1;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.notification-modal-close {
    position: absolute;
    top: 15px;
    right: 15px;
    background: none;
    border: none;
    font-size: 32px;
    color: #999;
    cursor: pointer;
    line-height: 1;
    padding: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.2s;
}

.notification-modal-close:hover {
    color: #333;
}

.notification-modal-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 40px;
}

.notification-modal-icon.success {
    background: #d4edda;
    color: #28a745;
}

.notification-modal-icon.error {
    background: #f8d7da;
    color: #dc3545;
}

.notification-modal-icon.info {
    background: #d1ecf1;
    color: #0c5460;
}

.notification-modal-icon.warning {
    background: #fff3cd;
    color: #856404;
}

.notification-modal-title {
    font-size: 24px;
    font-weight: 600;
    margin: 0 0 15px 0;
    color: #333;
}

.notification-modal-message {
    font-size: 16px;
    line-height: 1.6;
    color: #666;
    margin: 0 0 25px 0;
}

.notification-modal-btn {
    min-width: 120px;
    padding: 12px 30px;
}

@media (max-width: 768px) {
    .notification-modal-content {
        padding: 30px 20px;
        max-width: 90%;
    }

    .notification-modal-title {
        font-size: 20px;
    }

    .notification-modal-message {
        font-size: 14px;
    }

    .notification-modal-icon {
        width: 60px;
        height: 60px;
        font-size: 30px;
    }
}
</style>

<script>
function showNotificationModal(type, title, message) {
    const modal = document.getElementById('notificationModal');
    const icon = document.getElementById('notificationIcon');
    const titleEl = document.getElementById('notificationTitle');
    const messageEl = document.getElementById('notificationMessage');

    // Set icon based on type
    const icons = {
        success: '✓',
        error: '✕',
        warning: '⚠',
        info: 'ℹ'
    };

    icon.innerHTML = icons[type] || icons.info;
    icon.className = 'notification-modal-icon ' + type;

    // Set title and message
    titleEl.textContent = title;
    messageEl.textContent = message;

    // Show modal
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeNotificationModal() {
    const modal = document.getElementById('notificationModal');
    modal.style.display = 'none';
    document.body.style.overflow = '';
    
    // Clear URL parameters after closing modal
    if (window.history.replaceState) {
        const url = new URL(window.location);
        url.searchParams.delete('notification');
        url.searchParams.delete('type');
        url.searchParams.delete('message');
        window.history.replaceState({}, '', url);
    }
}

// Close modal when pressing Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeNotificationModal();
    }
});

// Check for URL parameters on page load
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const notification = urlParams.get('notification');
    const type = urlParams.get('type') || 'info';
    const message = urlParams.get('message');

    if (notification === 'true' && message) {
        const titles = {
            success: 'Success!',
            error: 'Error',
            warning: 'Warning',
            info: 'Notice'
        };
        showNotificationModal(type, titles[type] || 'Notification', decodeURIComponent(message));
    }
});
</script>
