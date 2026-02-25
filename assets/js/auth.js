// =====================================================
// Authentication & Session Management
// =====================================================

// Demo credentials for each portal
const DEMO_CREDENTIALS = {
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

// Open login modal for specific portal
function openLoginModal(portal) {
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
        demoEmail.textContent = DEMO_CREDENTIALS[portal].email;
    }

    // Show modal
    modal.show();
}

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
            if (validateLogin(portal, email, password)) {

                // --- LOGGING INJECTION ---
                if (typeof logActivity === 'function') {
                    // We log before redirect, but since redirect is fast, we rely on localStorage being sync
                    logActivity('Login', `User logged in to ${portal} portal`, DEMO_CREDENTIALS[portal].userData.name, portal);
                }
                // -------------------------

                // Create session
                createSession(portal, rememberMe);

                // Redirect to dashboard
                window.location.href = DEMO_CREDENTIALS[portal].redirectUrl;
            } else {
                // Show error
                showAlert('error', 'Invalid email or password. Please try again.');
            }
        });
    }
});

// Validate login credentials
function validateLogin(portal, email, password) {
    const credentials = DEMO_CREDENTIALS[portal];
    return email === credentials.email && password === credentials.password;
}

// Create user session
function createSession(portal, rememberMe = false) {
    const credentials = DEMO_CREDENTIALS[portal];

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
}

// Get current session
function getSession() {
    const sessionData = localStorage.getItem('lms_session') || sessionStorage.getItem('lms_session');
    return sessionData ? JSON.parse(sessionData) : null;
}

// Check if user is logged in
function isLoggedIn() {
    const session = getSession();
    return session && session.isLoggedIn;
}

// Check if user has specific role
function hasRole(role) {
    const session = getSession();
    return session && session.role === role;
}

// Get current user data
function getCurrentUser() {
    const session = getSession();
    return session ? session.userData : null;
}

// Logout user
function logout() {
    // --- LOGGING INJECTION ---
    const session = getSession();
    if (session && typeof logActivity === 'function') {
        logActivity('Logout', 'User logged out', session.userData.name, session.role);
    }
    // -------------------------

    localStorage.removeItem('lms_session');
    sessionStorage.removeItem('lms_session');
    window.location.href = '../index.html';
}

// Protect page - redirect if not logged in
function protectPage(requiredRole = null) {
    const session = getSession();

    if (!isLoggedIn()) {
        console.warn('Access Denied: Not logged in. Redirecting to home.');
        window.location.href = '../index.html';
        return false;
    }

    if (requiredRole && !hasRole(requiredRole)) {
        console.warn(`Access Denied: Required role '${requiredRole}', but found '${session?.role}'.`);
        window.location.href = '../index.html';
        return false;
    }

    return true;
}

// Change password
function changePassword(currentPassword, newPassword) {
    const session = getSession();

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
}

// Show alert message
function showAlert(type, message) {
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
}

// Initialize user info in dashboard
function initDashboardUser() {
    // --- DATA SYNC START ---
    const session = getSession();
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

    const user = getCurrentUser();

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
    // const session = getSession(); // Removed as it is already defined at top of function
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
}

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
        openLoginModal,
        validateLogin,
        createSession,
        getSession,
        isLoggedIn,
        hasRole,
        getCurrentUser,
        logout,
        protectPage,
        changePassword,
        initDashboardUser
    };
}
