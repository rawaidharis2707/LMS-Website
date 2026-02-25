// =====================================================
// Main Utilities & Helper Functions
// =====================================================

// Initialize app on DOM load
document.addEventListener('DOMContentLoaded', function () {
    // Initialize tooltips
    initTooltips();

    // Initialize popovers
    initPopovers();

    // Add active class to current page in sidebar
    highlightActivePage();

    // Initialize sidebar toggle
    initSidebarToggle();

    // Smooth scroll for anchor links
    initSmoothScroll();

    // Teacher Dynamic Access (Admin roles delegated to teachers)
    if (typeof getSession === 'function' && typeof isLoggedIn === 'function' && isLoggedIn()) {
        const session = getSession();
        if (session.role === 'teacher') {
            loadDynamicTeacherSidebar();
        }
    }
});

// Initialize Bootstrap tooltips
function initTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Initialize Bootstrap popovers
function initPopovers() {
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
}

// Highlight active page in sidebar
function highlightActivePage() {
    const currentPage = window.location.pathname.split('/').pop();
    const sidebarLinks = document.querySelectorAll('.sidebar-link');

    sidebarLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href && href.includes(currentPage)) {
            link.classList.add('active');
        }
    });
}

// Initialize sidebar toggle for mobile
function initSidebarToggle() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('active');
        });
    }
}

// Teacher Dynamic Access Sidebar Generation
function loadDynamicTeacherSidebar() {
    const session = getSession();
    if (session && session.permissions && session.permissions.length > 0) {
        const ul = document.querySelector('.sidebar-menu .list-unstyled');
        if (!ul) return;

        // Check if items already exist to avoid duplication
        const existingLinks = Array.from(ul.querySelectorAll('.sidebar-link')).map(a => a.getAttribute('href'));

        // Academics -> Timetable Input
        if (session.permissions.includes('academics') && !existingLinks.some(l => l.includes('timetable-input.html'))) {
            const li = document.createElement('li');
            li.className = 'sidebar-menu-item';
            li.innerHTML = `<a href="../admin/timetable-input.html" class="sidebar-link text-warning fw-bold"><i class="fas fa-calendar-plus"></i><span>Timetable Input (Admin)</span></a>`;
            ul.insertBefore(li, ul.lastElementChild);
        }

        // Finance -> Fee Vouchers
        if (session.permissions.includes('finance') && !existingLinks.some(l => l.includes('fee-vouchers.html'))) {
            const li = document.createElement('li');
            li.className = 'sidebar-menu-item';
            li.innerHTML = `<a href="../admin/fee-vouchers.html" class="sidebar-link text-warning fw-bold"><i class="fas fa-file-invoice-dollar"></i><span>Fee Vouchers (Admin)</span></a>`;
            ul.insertBefore(li, ul.lastElementChild);
        }

        // Admissions -> Admissions Management
        if (session.permissions.includes('admissions') && !existingLinks.some(l => l.includes('admissions.html'))) {
            const li = document.createElement('li');
            li.className = 'sidebar-menu-item';
            li.innerHTML = `<a href="../admin/admissions.html" class="sidebar-link text-warning fw-bold"><i class="fas fa-user-plus"></i><span>Admissions (Admin)</span></a>`;
            ul.insertBefore(li, ul.lastElementChild);
        }

        // Students -> Class Management
        if (session.permissions.includes('students') && !existingLinks.some(l => l.includes('class-management.html'))) {
            const li = document.createElement('li');
            li.className = 'sidebar-menu-item';
            li.innerHTML = `<a href="../admin/class-management.html" class="sidebar-link text-warning fw-bold"><i class="fas fa-tasks"></i><span>Class Management (Admin)</span></a>`;
            ul.insertBefore(li, ul.lastElementChild);
        }

        // Attendance -> Teacher Attendance
        if (session.permissions.includes('attendance') && !existingLinks.some(l => l.includes('teacher-attendance.html'))) {
            const li = document.createElement('li');
            li.className = 'sidebar-menu-item';
            li.innerHTML = `<a href="../admin/teacher-attendance.html" class="sidebar-link text-warning fw-bold"><i class="fas fa-clipboard-check"></i><span>Teacher Attendance (Admin)</span></a>`;
            ul.insertBefore(li, ul.lastElementChild);
        }
    }
}

// Smooth scroll for anchor links
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href !== '') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
}

// =====================================================
// Date & Time Utilities
// =====================================================

// Format date to readable string
function formatDate(date, format = 'long') {
    const d = new Date(date);

    if (format === 'long') {
        return d.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    } else if (format === 'short') {
        return d.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    } else if (format === 'numeric') {
        return d.toLocaleDateString('en-US');
    }

    return d.toLocaleDateString();
}

// Format time to readable string
function formatTime(date) {
    const d = new Date(date);
    return d.toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Get relative time (e.g., "2 hours ago")
function getRelativeTime(date) {
    const now = new Date();
    const diff = now - new Date(date);
    const seconds = Math.floor(diff / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);

    if (days > 0) return `${days} day${days > 1 ? 's' : ''} ago`;
    if (hours > 0) return `${hours} hour${hours > 1 ? 's' : ''} ago`;
    if (minutes > 0) return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
    return 'Just now';
}

// =====================================================
// Form Validation Utilities
// =====================================================

// Validate email format
function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Validate phone number
function isValidPhone(phone) {
    const re = /^[\d\s\-\+\(\)]+$/;
    return re.test(phone) && phone.replace(/\D/g, '').length >= 10;
}

// Validate password strength
function checkPasswordStrength(password) {
    let strength = 0;

    if (password.length >= 8) strength++;
    if (password.length >= 12) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^a-zA-Z0-9]/.test(password)) strength++;

    if (strength <= 2) return { level: 'weak', score: strength };
    if (strength <= 4) return { level: 'medium', score: strength };
    return { level: 'strong', score: strength };
}

// =====================================================
// Notification System
// =====================================================

// Show toast notification
function showToast(message, type = 'info', duration = 3000) {
    const toastContainer = getOrCreateToastContainer();

    const toastId = 'toast-' + Date.now();
    const toastHTML = `
        <div id="${toastId}" class="toast align-items-center text-white bg-${type === 'error' ? 'danger' : type} border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-${getToastIcon(type)} me-2"></i> ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;

    toastContainer.insertAdjacentHTML('beforeend', toastHTML);

    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, { delay: duration });
    toast.show();

    // Remove from DOM after hiding
    toastElement.addEventListener('hidden.bs.toast', function () {
        toastElement.remove();
    });
}

// Get or create toast container
function getOrCreateToastContainer() {
    let container = document.getElementById('toast-container');

    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
    }

    return container;
}

// Get icon for toast type
function getToastIcon(type) {
    const icons = {
        success: 'check-circle',
        error: 'exclamation-circle',
        warning: 'exclamation-triangle',
        info: 'info-circle'
    };
    return icons[type] || 'info-circle';
}

// =====================================================
// Loading States
// =====================================================

// Show loading spinner
function showLoading(element) {
    if (typeof element === 'string') {
        element = document.querySelector(element);
    }

    if (element) {
        element.disabled = true;
        const originalText = element.innerHTML;
        element.setAttribute('data-original-text', originalText);
        element.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Loading...';
    }
}

// Hide loading spinner
function hideLoading(element) {
    if (typeof element === 'string') {
        element = document.querySelector(element);
    }

    if (element) {
        element.disabled = false;
        const originalText = element.getAttribute('data-original-text');
        if (originalText) {
            element.innerHTML = originalText;
            element.removeAttribute('data-original-text');
        }
    }
}

// =====================================================
// Data Table Utilities
// =====================================================

// Basic table search functionality
function searchTable(searchInput, tableId) {
    const input = document.getElementById(searchInput);
    const table = document.getElementById(tableId);

    if (!input || !table) return;

    input.addEventListener('keyup', function () {
        const filter = this.value.toLowerCase();
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName('td');
            let found = false;

            for (let j = 0; j < cells.length; j++) {
                const cell = cells[j];
                if (cell.textContent.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }

            row.style.display = found ? '' : 'none';
        }
    });
}

// Sort table by column
function sortTable(tableId, columnIndex, type = 'string') {
    const table = document.getElementById(tableId);
    if (!table) return;

    const rows = Array.from(table.rows).slice(1);
    const isAscending = table.getAttribute('data-sort-order') !== 'asc';

    rows.sort((a, b) => {
        const aValue = a.cells[columnIndex].textContent.trim();
        const bValue = b.cells[columnIndex].textContent.trim();

        if (type === 'number') {
            return isAscending ?
                parseFloat(aValue) - parseFloat(bValue) :
                parseFloat(bValue) - parseFloat(aValue);
        } else {
            return isAscending ?
                aValue.localeCompare(bValue) :
                bValue.localeCompare(aValue);
        }
    });

    rows.forEach(row => table.appendChild(row));
    table.setAttribute('data-sort-order', isAscending ? 'asc' : 'desc');
}

// =====================================================
// LocalStorage Utilities
// =====================================================

// Save data to localStorage
function saveToLocalStorage(key, data) {
    try {
        localStorage.setItem(key, JSON.stringify(data));
        return true;
    } catch (e) {
        console.error('Error saving to localStorage:', e);
        return false;
    }
}

// Get data from localStorage
function getFromLocalStorage(key) {
    try {
        const data = localStorage.getItem(key);
        return data ? JSON.parse(data) : null;
    } catch (e) {
        console.error('Error reading from localStorage:', e);
        return null;
    }
}

// Remove data from localStorage
function removeFromLocalStorage(key) {
    try {
        localStorage.removeItem(key);
        return true;
    } catch (e) {
        console.error('Error removing from localStorage:', e);
        return false;
    }
}

// =====================================================
// File Upload Utilities
// =====================================================

// Validate file size
function validateFileSize(file, maxSizeMB = 5) {
    const maxSize = maxSizeMB * 1024 * 1024; // Convert to bytes
    return file.size <= maxSize;
}

// Validate file type
function validateFileType(file, allowedTypes = []) {
    if (allowedTypes.length === 0) return true;
    return allowedTypes.some(type => file.type.includes(type) || file.name.endsWith(type));
}

// Format file size for display
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
}

// =====================================================
// Confirmation Dialog
// =====================================================

// Show confirmation dialog
function confirmAction(message, onConfirm, onCancel = null) {
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.innerHTML = `
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-question-circle me-2"></i> Confirm Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>${message}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmBtn">Confirm</button>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(modal);
    const bsModal = new bootstrap.Modal(modal);

    modal.querySelector('#confirmBtn').addEventListener('click', function () {
        if (onConfirm) onConfirm();
        bsModal.hide();
    });

    modal.addEventListener('hidden.bs.modal', function () {
        modal.remove();
        if (onCancel) onCancel();
    });

    bsModal.show();
}

// =====================================================
// Print Utilities
// =====================================================

// Print specific element
function printElement(elementId) {
    const element = document.getElementById(elementId);
    if (!element) return;

    const printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write('<html><head><title>Print</title>');
    printWindow.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">');
    printWindow.document.write('<link rel="stylesheet" href="../assets/css/style.css">');
    printWindow.document.write('</head><body>');
    printWindow.document.write(element.innerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();

    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 250);
}

// =====================================================
// Export Utilities
// =====================================================

// Export table to CSV
function exportTableToCSV(tableId, filename = 'export.csv') {
    const table = document.getElementById(tableId);
    if (!table) return;

    let csv = [];
    const rows = table.rows;

    for (let i = 0; i < rows.length; i++) {
        const row = [], cols = rows[i].cells;

        for (let j = 0; j < cols.length; j++) {
            row.push('"' + cols[j].textContent.replace(/"/g, '""') + '"');
        }

        csv.push(row.join(','));
    }

    downloadCSV(csv.join('\n'), filename);
}

// Download CSV file
function downloadCSV(csv, filename) {
    const blob = new Blob([csv], { type: 'text/csv' });
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = filename;
    a.click();
}

// Export functions for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        formatDate,
        formatTime,
        getRelativeTime,
        isValidEmail,
        isValidPhone,
        checkPasswordStrength,
        showToast,
        showLoading,
        hideLoading,
        searchTable,
        sortTable,
        saveToLocalStorage,
        getFromLocalStorage,
        removeFromLocalStorage,
        validateFileSize,
        validateFileType,
        formatFileSize,
        confirmAction,
        printElement,
        exportTableToCSV
    };
}
