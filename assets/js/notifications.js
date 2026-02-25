// Notifications System for LMS
class NotificationSystem {
    constructor() {
        this.storageKey = 'lms_notifications';
        this.init();
    }

    init() {
        this.loadNotifications();
        this.updateBadge();
    }

    // Get current user role from session
    getCurrentUserRole() {
        const session = localStorage.getItem('lms_session') || sessionStorage.getItem('lms_session');
        if (session) {
            const sessionData = JSON.parse(session);
            return sessionData.role || null;
        }
        return null;
    }

    // Check if notification is visible to current user role
    isNotificationVisibleToRole(notification) {
        const userRole = this.getCurrentUserRole();

        // If no role, don't show any notifications
        if (!userRole) {
            return false;
        }

        // If no targetRoles specified, hide it (changed from showing to all)
        // This ensures old notifications without role targeting are hidden
        if (!notification.targetRoles || notification.targetRoles.length === 0) {
            return false;
        }

        // Check if user's role is in the target roles array
        return notification.targetRoles.includes(userRole);
    }

    // Migrate old notifications to add targetRoles based on type
    migrateOldNotifications() {
        let migrated = false;

        this.notifications.forEach(notification => {
            // If notification already has targetRoles, skip it
            if (notification.targetRoles && notification.targetRoles.length > 0) {
                return;
            }

            // Assign targetRoles based on notification type
            switch (notification.type) {
                case 'assignment':
                case 'quiz':
                case 'result':
                    notification.targetRoles = ['student'];
                    migrated = true;
                    break;
                case 'submission':
                case 'attendance':
                    notification.targetRoles = ['teacher'];
                    migrated = true;
                    break;
                case 'announcement':
                case 'user_request':
                    notification.targetRoles = ['admin', 'superadmin'];
                    migrated = true;
                    break;
                case 'system':
                case 'security':
                    notification.targetRoles = ['superadmin'];
                    migrated = true;
                    break;
                default:
                    // For unknown types, hide them (set empty array)
                    notification.targetRoles = [];
                    migrated = true;
                    break;
            }
        });

        // Save if any migrations occurred
        if (migrated) {
            this.saveNotifications();
            console.log('Migrated old notifications to role-based system');
        }
    }

    // Get all notifications
    getNotifications() {
        const stored = localStorage.getItem(this.storageKey);
        return stored ? JSON.parse(stored) : this.getDefaultNotifications();
    }

    // Default notifications
    getDefaultNotifications() {
        return [
            // Student notifications
            {
                id: Date.now() + 1,
                type: 'assignment',
                title: 'New Assignment Posted',
                message: 'Mathematics assignment "Calculus Problems" is due in 3 days',
                time: new Date(Date.now() - 3600000).toISOString(),
                read: false,
                icon: 'fas fa-tasks',
                color: 'primary',
                targetRoles: ['student']
            },
            {
                id: Date.now() + 2,
                type: 'quiz',
                title: 'Quiz Available',
                message: 'New quiz on Physics Chapter 5 is now available',
                time: new Date(Date.now() - 5400000).toISOString(),
                read: false,
                icon: 'fas fa-question-circle',
                color: 'info',
                targetRoles: ['student']
            },
            {
                id: Date.now() + 3,
                type: 'result',
                title: 'Result Published',
                message: 'Monthly test results are now available',
                time: new Date(Date.now() - 10800000).toISOString(),
                read: false,
                icon: 'fas fa-chart-bar',
                color: 'success',
                targetRoles: ['student']
            },
            // Teacher notifications
            {
                id: Date.now() + 4,
                type: 'submission',
                title: 'Assignment Submissions',
                message: '15 new assignment submissions require grading',
                time: new Date(Date.now() - 7200000).toISOString(),
                read: false,
                icon: 'fas fa-file-alt',
                color: 'warning',
                targetRoles: ['teacher']
            },
            {
                id: Date.now() + 5,
                type: 'attendance',
                title: 'Attendance Reminder',
                message: 'Please mark attendance for Class 10-A',
                time: new Date(Date.now() - 14400000).toISOString(),
                read: false,
                icon: 'fas fa-user-check',
                color: 'primary',
                targetRoles: ['teacher']
            },
            // Admin notifications
            {
                id: Date.now() + 6,
                type: 'announcement',
                title: 'Important Announcement',
                message: 'Parent-Teacher meeting scheduled for Friday',
                time: new Date(Date.now() - 18000000).toISOString(),
                read: false,
                icon: 'fas fa-bullhorn',
                color: 'warning',
                targetRoles: ['admin', 'superadmin']
            },
            {
                id: Date.now() + 7,
                type: 'user_request',
                title: 'New User Registration',
                message: '3 new teacher registration requests pending approval',
                time: new Date(Date.now() - 21600000).toISOString(),
                read: false,
                icon: 'fas fa-user-plus',
                color: 'info',
                targetRoles: ['admin', 'superadmin']
            },
            // Superadmin notifications
            {
                id: Date.now() + 8,
                type: 'system',
                title: 'System Update',
                message: 'Database backup completed successfully',
                time: new Date(Date.now() - 25200000).toISOString(),
                read: false,
                icon: 'fas fa-cog',
                color: 'success',
                targetRoles: ['superadmin']
            },
            {
                id: Date.now() + 9,
                type: 'security',
                title: 'Security Alert',
                message: 'Multiple failed login attempts detected',
                time: new Date(Date.now() - 28800000).toISOString(),
                read: false,
                icon: 'fas fa-shield-alt',
                color: 'danger',
                targetRoles: ['superadmin']
            }
        ];
    }

    // Load notifications
    loadNotifications() {
        this.notifications = this.getNotifications();
        // Migrate old notifications that don't have targetRoles
        this.migrateOldNotifications();
    }

    // Get filtered notifications based on current user role
    getFilteredNotifications() {
        return this.notifications.filter(n => this.isNotificationVisibleToRole(n));
    }

    // Save notifications
    saveNotifications() {
        localStorage.setItem(this.storageKey, JSON.stringify(this.notifications));
    }

    // Add notification
    addNotification(notification) {
        notification.id = Date.now();
        notification.time = new Date().toISOString();
        notification.read = false;

        // Ensure targetRoles is an array (default to empty array for backward compatibility)
        if (!notification.targetRoles) {
            notification.targetRoles = [];
        }

        this.notifications.unshift(notification);
        this.saveNotifications();
        this.updateBadge();
        this.renderNotifications();
    }

    // Mark as read
    markAsRead(id) {
        const notification = this.notifications.find(n => n.id === id);
        if (notification) {
            notification.read = true;
            this.saveNotifications();
            this.updateBadge();
            this.renderNotifications();
        }
    }

    // Mark all as read
    markAllAsRead() {
        this.notifications.forEach(n => n.read = true);
        this.saveNotifications();
        this.updateBadge();
        this.renderNotifications();
    }

    // Delete notification
    deleteNotification(id) {
        this.notifications = this.notifications.filter(n => n.id !== id);
        this.saveNotifications();
        this.updateBadge();
        this.renderNotifications();
    }

    // Clear all
    clearAll() {
        this.notifications = [];
        this.saveNotifications();
        this.updateBadge();
        this.renderNotifications();
    }

    // Reset to default notifications (useful for testing)
    resetToDefaults() {
        localStorage.removeItem(this.storageKey);
        this.loadNotifications();
        this.updateBadge();
        this.renderNotifications();
        console.log('Reset to default role-based notifications');
    }

    // Get unread count
    getUnreadCount() {
        const filtered = this.getFilteredNotifications();
        return filtered.filter(n => !n.read).length;
    }

    // Update badge
    updateBadge() {
        const badge = document.getElementById('notificationBadge');
        const count = this.getUnreadCount();
        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'inline-block' : 'none';
        }
    }

    // Render notifications
    renderNotifications() {
        const container = document.getElementById('notificationsList');
        if (!container) return;

        // Get filtered notifications based on role
        const filteredNotifications = this.getFilteredNotifications();

        if (filteredNotifications.length === 0) {
            container.innerHTML = `
                <div class="empty-state p-4 text-center">
                    <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No notifications</p>
                </div>
            `;
            return;
        }

        container.innerHTML = filteredNotifications.map(n => `
            <div class="notification-item ${n.read ? 'read' : 'unread'}" data-id="${n.id}">
                <div class="d-flex">
                    <div class="notification-icon icon-box-${n.color} me-3">
                        <i class="${n.icon}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1 ${n.read ? 'text-muted' : 'fw-bold'}">${n.title}</h6>
                        <p class="mb-1 small text-muted">${n.message}</p>
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            ${this.formatTime(n.time)}
                        </small>
                    </div>
                    <div class="notification-actions">
                        ${!n.read ? `<button class="btn btn-sm btn-link p-1" onclick="notificationSystem.markAsRead(${n.id})" title="Mark as read">
                            <i class="fas fa-check text-primary"></i>
                        </button>` : ''}
                        <button class="btn btn-sm btn-link p-1" onclick="notificationSystem.deleteNotification(${n.id})" title="Delete">
                            <i class="fas fa-times text-danger"></i>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    // Format time
    formatTime(timeString) {
        const time = new Date(timeString);
        const now = new Date();
        const diff = now - time;

        const minutes = Math.floor(diff / 60000);
        const hours = Math.floor(diff / 3600000);
        const days = Math.floor(diff / 86400000);

        if (minutes < 1) return 'Just now';
        if (minutes < 60) return `${minutes}m ago`;
        if (hours < 24) return `${hours}h ago`;
        if (days < 7) return `${days}d ago`;
        return time.toLocaleDateString();
    }
}

// Initialize notification system
let notificationSystem;
document.addEventListener('DOMContentLoaded', function () {
    notificationSystem = new NotificationSystem();
    notificationSystem.renderNotifications();
});
