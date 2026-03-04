// =====================================================
// Authentication & Session Management
// =====================================================

// Global credentials object - using direct assignment to avoid redeclaration
window.LMS_CREDENTIALS = {
    student: {
        email: 'student@demo.com',
        password: 'password',
        redirectUrl: 'student/dashboard.html',
        role: 'student',
        userData: {
            id: '2024-10A-015',
            name: 'John Doe',
            email: 'student@demo.com',
            class: 'Class 10-A',
            rollNumber: '2024-10A-015',
            profileImage: null
        }
    },
    teacher: {
        email: 'teacher@demo.com',
        password: 'password',
        redirectUrl: 'teacher/dashboard.html',
        role: 'teacher',
        userData: {
            id: 1,
            name: 'Sarah Johnson',
            email: 'teacher@demo.com',
            subject: 'Mathematics',
            employeeId: 'TCH001',
            profileImage: null
        }
    },
    admin: {
        email: 'admin@demo.com',
        password: 'password',
        redirectUrl: 'admin/dashboard.html',
        role: 'admin',
        userData: {
            id: 1,
            name: 'Admin User',
            email: 'admin@demo.com',
            department: 'Administration',
            employeeId: 'ADM001',
            profileImage: null
        }
    },
    superadmin: {
        email: 'superadmin@demo.com',
        password: 'password',
        redirectUrl: 'superadmin/dashboard.html',
        role: 'superadmin',
        userData: {
            id: 1,
            name: 'Super Admin',
            email: 'superadmin@demo.com',
            department: 'System Administration',
            employeeId: 'SA001',
            profileImage: null
        }
    }
};

// Create backward compatibility alias
window.DEMO_CREDENTIALS = window.LMS_CREDENTIALS;

// Open login modal for specific portal
window.openLoginModal = function(portal) {
    const modal = new bootstrap.Modal(document.getElementById('loginModal'));
    const portalTypeInput = document.getElementById('portalType');
    const modalTitle = document.getElementById('loginModalLabel');
    const demoEmail = document.getElementById('demoEmail');

    // Set portal type
    portalTypeInput.value = portal;

    // Update modal title
    const portalNames = {
        student: 'Student',
        teacher: 'Teacher',
        admin: 'Admin',
        superadmin: 'Super Admin'
    };

    modalTitle.innerHTML = `<i class="fas fa-sign-in-alt me-2"></i> ${portalNames[portal]} Login`;

    // Update demo credentials
    if (demoEmail) {
        demoEmail.textContent = window.DEMO_CREDENTIALS[portal].email;
    }

    // Show modal
    modal.show();
};

// Handle login form submission
document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');

    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const portal = document.getElementById('portalType').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const rememberMe = document.getElementById('rememberMe').checked;

            // Validate credentials
            if (window.validateLogin(portal, email, password)) {

                // --- LOGGING INJECTION ---
                if (typeof logActivity === 'function') {
                    // We log before redirect, but since redirect is fast, we rely on localStorage being sync
                    logActivity('Login', `User logged in to ${portal} portal`, window.DEMO_CREDENTIALS[portal].userData.name, portal);
                }
                // -------------------------

                // Create session
                window.createSession(portal, rememberMe);

                // Redirect to dashboard
                window.location.href = window.DEMO_CREDENTIALS[portal].redirectUrl;
            } else {
                // Show error
                window.showAlert('error', 'Invalid email or password. Please try again.');
            }
        });
    }
});

// Validate login credentials
window.validateLogin = function(portal, email, password) {
    const credentials = window.DEMO_CREDENTIALS[portal];
    return email === credentials.email && password === credentials.password;
};

// Create user session
window.createSession = function(portal, rememberMe = false) {
    const credentials = window.DEMO_CREDENTIALS[portal];

    // FETCH REAL USER DATA IF AVAILABLE (Simulated Backend lookup)
    // currently it uses static DEMO_CREDENTIALS. 
    // We should try to find this user in 'lms_users' to get their REAL permissions.
    const users = JSON.parse(localStorage.getItem('lms_users') || '[]');
    const realUser = users.find(u => u.email === credentials.email);

    let permissions = [];
    if (realUser && realUser.permissions) {
        permissions = realUser.permissions;
    }

    const sessionData = {
        isLoggedIn: true,
        role: credentials.role,
        userData: credentials.userData,
        permissions: permissions, // STORE PERMISSIONS
        loginTime: new Date().toISOString()
    };

    // Store session data
    // ALWAYS use localStorage for file:// protocol since sessionStorage doesn't persist well
    // Otherwise, use localStorage if rememberMe is checked, sessionStorage if not
    if (window.location.protocol === 'file:' || rememberMe) {
        localStorage.setItem('lms_session', JSON.stringify(sessionData));
        // Clear sessionStorage if we're using localStorage
        sessionStorage.removeItem('lms_session');
    } else {
        sessionStorage.setItem('lms_session', JSON.stringify(sessionData));
        // Clear localStorage if we're using sessionStorage
        localStorage.removeItem('lms_session');
    }
};

// Get current session
window.getSession = function() {
    const sessionData = localStorage.getItem('lms_session') || sessionStorage.getItem('lms_session');
    return sessionData ? JSON.parse(sessionData) : null;
};

// Check if user is logged in
window.isLoggedIn = function() {
    const session = window.getSession();
    return session && session.isLoggedIn;
};

// Check if user has specific role
window.hasRole = function(role) {
    const session = window.getSession();
    return session && session.role === role;
};

// Get current user data
window.getCurrentUser = function() {
    const session = window.getSession();
    return session ? session.userData : null;
};

// Logout user
window.logout = function() {
    // --- LOGGING INJECTION ---
    const session = window.getSession();
    if (session && typeof logActivity === 'function') {
        logActivity('Logout', 'User logged out', session.userData.name, session.role);
    }
    // -------------------------

    localStorage.removeItem('lms_session');
    sessionStorage.removeItem('lms_session');
    window.location.href = '/';
};

// Protect page - redirect if not logged in
window.protectPage = function(requiredRole = null) {
    const session = window.getSession();

    if (!window.isLoggedIn()) {
        console.warn('Access Denied: Not logged in. Redirecting to home.');
        window.location.href = '/';
        return false;
    }

    if (requiredRole && !window.hasRole(requiredRole)) {
        console.warn(`Access Denied: Required role '${requiredRole}', but found '${session?.role}'.`);
        window.location.href = '/';
        return false;
    }

    return true;
};

// Change password
window.changePassword = function(currentPassword, newPassword) {
    const session = window.getSession();

    if (!session) {
        return { success: false, message: 'Not logged in' };
    }

    // In a real application, this would make an API call
    // For demo, we'll just simulate success

    // Validate current password (in demo, accept any non-empty string)
    if (!currentPassword || currentPassword.length < 1) {
        return { success: false, message: 'Current password is required' };
    }

    // Validate new password
    if (!newPassword || newPassword.length < 6) {
        return { success: false, message: 'New password must be at least 6 characters' };
    }

    // Simulate success
    return { success: true, message: 'Password changed successfully' };
};

// Show alert message
window.showAlert = function(type, message) {
    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show`;
    alertDiv.setAttribute('role', 'alert');
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    // Insert at top of form
    const form = document.getElementById('loginForm');
    if (form) {
        form.insertBefore(alertDiv, form.firstChild);

        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
};

// Initialize user info in dashboard
window.initDashboardUser = function() {
    // --- DATA SYNC START ---
    const session = window.getSession();
    if (session) {
        // Universal Sync: Match by Email across all roles
        const users = JSON.parse(localStorage.getItem('lms_users') || '[]');
        const freshUser = users.find(u => u.email === session.userData.email);

        if (freshUser) {
            let hasChanged = false;

            // 1. Sync Base Data (Name)
            if (freshUser.name && session.userData.name !== freshUser.name) {
                session.userData.name = freshUser.name;
                hasChanged = true;
            }

            // 2. Sync Permissions (Critical for dynamic access)
            const freshPerms = freshUser.permissions || [];
            if (JSON.stringify(session.permissions) !== JSON.stringify(freshPerms)) {
                session.permissions = freshPerms;
                hasChanged = true;
                console.log('Permissions updated from central storage.');
            }

            // Role specific record sync
            if (session.role === 'student') {
                const students = JSON.parse(localStorage.getItem('lms_students') || '[]');
                const freshRecord = students.find(s => s.email === session.userData.email);
                if (freshRecord) {
                    const fieldsToSync = ['class', 'rollNumber', 'section', 'profileImage'];
                    fieldsToSync.forEach(field => {
                        if (freshRecord[field] && session.userData[field] !== freshRecord[field]) {
                            session.userData[field] = freshRecord[field];
                            hasChanged = true;
                        }
                    });
                }
            }

            if (hasChanged) {
                if (localStorage.getItem('lms_session')) {
                    localStorage.setItem('lms_session', JSON.stringify(session));
                } else {
                    sessionStorage.setItem('lms_session', JSON.stringify(session));
                }
            }
        }
    }
    // --- DATA SYNC END ---

    const user = window.getCurrentUser();

    if (!user) return;

    // Update user name displays
    const userNameElements = document.querySelectorAll('.user-name');
    userNameElements.forEach(el => {
        el.textContent = user.name;
    });

    // Update user email displays
    const userEmailElements = document.querySelectorAll('.user-email');
    userEmailElements.forEach(el => {
        el.textContent = user.email;
    });

    // Update user avatar
    const userAvatarElements = document.querySelectorAll('.user-avatar');
    userAvatarElements.forEach(el => {
        if (user.profileImage) {
            el.innerHTML = `<img src="${user.profileImage}" alt="${user.name}" class="w-100 h-100 rounded-circle">`;
        } else {
            // Show initials
            const initials = user.name.split(' ').map(n => n[0]).join('').toUpperCase();
            el.textContent = initials;
        }
    });

    // Update role-specific info
    switch (session.role) {
        case 'student':
            updateElement('.student-class', user.class);
            updateElement('.student-roll', user.rollNumber);
            break;
        case 'teacher':
            updateElement('.teacher-subject', user.subject);
            updateElement('.teacher-id', user.employeeId);
            break;
        case 'admin':
        case 'superadmin':
            updateElement('.employee-id', user.employeeId);
            updateElement('.department', user.department);
            break;
    }
};

// Helper function to update element text
function updateElement(selector, value) {
    const elements = document.querySelectorAll(selector);
    elements.forEach(el => {
        el.textContent = value;
    });
}

// Export functions for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        openLoginModal: window.openLoginModal,
        validateLogin: window.validateLogin,
        createSession: window.createSession,
        getSession: window.getSession,
        isLoggedIn: window.isLoggedIn,
        hasRole: window.hasRole,
        getCurrentUser: window.getCurrentUser,
        logout: window.logout,
        protectPage: window.protectPage,
        changePassword: window.changePassword,
        initDashboardUser: window.initDashboardUser
    };
}
