/**
 * WordPress-Style Admin Dashboard JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Sidebar Toggle
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('admin-sidebar');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            
            // Save state to localStorage
            if (sidebar.classList.contains('collapsed')) {
                localStorage.setItem('adminSidebarCollapsed', 'true');
            } else {
                localStorage.removeItem('adminSidebarCollapsed');
            }
        });
        
        // Restore sidebar state
        if (localStorage.getItem('adminSidebarCollapsed') === 'true') {
            sidebar.classList.add('collapsed');
        }
    }
    
    // Mobile Sidebar Toggle
    if (window.innerWidth <= 782) {
        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                sidebar.classList.toggle('mobile-open');
            });
            
            // Close sidebar when clicking outside
            document.addEventListener('click', function(e) {
                if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('mobile-open');
                }
            });
        }
    }
    
    // Submenu Toggle
    const submenuToggles = document.querySelectorAll('.submenu-toggle');
    submenuToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const menuItem = this.closest('.menu-item');
            const isOpen = menuItem.classList.contains('open');
            
            // Close all other submenus
            document.querySelectorAll('.menu-item.has-submenu').forEach(function(item) {
                if (item !== menuItem) {
                    item.classList.remove('open');
                }
            });
            
            // Toggle current submenu
            menuItem.classList.toggle('open', !isOpen);
            
            // Save state to localStorage
            const menuText = toggle.querySelector('.menu-text').textContent;
            if (!isOpen) {
                localStorage.setItem('adminSubmenu_' + menuText, 'open');
            } else {
                localStorage.removeItem('adminSubmenu_' + menuText);
            }
        });
        
        // Restore submenu state
        const menuText = toggle.querySelector('.menu-text').textContent;
        if (localStorage.getItem('adminSubmenu_' + menuText) === 'open') {
            toggle.closest('.menu-item').classList.add('open');
        }
    });
    
    // Auto-open submenu if a submenu item is active
    const activeSubmenuItem = document.querySelector('.submenu-item.active');
    if (activeSubmenuItem) {
        const parentMenu = activeSubmenuItem.closest('.menu-item.has-submenu');
        if (parentMenu) {
            parentMenu.classList.add('open');
        }
    }
    
    // User Dropdown Menu
    const userDropdownToggle = document.querySelector('.user-dropdown-toggle');
    const userDropdownMenu = document.querySelector('.user-dropdown-menu');
    
    if (userDropdownToggle && userDropdownMenu) {
        userDropdownToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdownMenu.classList.toggle('show');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userDropdownToggle.contains(e.target) && !userDropdownMenu.contains(e.target)) {
                userDropdownMenu.classList.remove('show');
            }
        });
    }
    
    // Confirm Delete Actions
    const deleteButtons = document.querySelectorAll('[data-confirm-delete]');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            const message = this.getAttribute('data-confirm-delete') || 'Are you sure you want to delete this item?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });
    
    // Auto-dismiss notifications
    const notifications = document.querySelectorAll('.admin-notification[data-auto-dismiss]');
    notifications.forEach(function(notification) {
        const delay = parseInt(notification.getAttribute('data-auto-dismiss')) || 5000;
        setTimeout(function() {
            notification.style.opacity = '0';
            setTimeout(function() {
                notification.remove();
            }, 300);
        }, delay);
    });
    
    // Dismissible notifications
    const dismissButtons = document.querySelectorAll('.notification-dismiss');
    dismissButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const notification = this.closest('.admin-notification');
            if (notification) {
                notification.style.opacity = '0';
                setTimeout(function() {
                    notification.remove();
                }, 300);
            }
        });
    });
    
});
