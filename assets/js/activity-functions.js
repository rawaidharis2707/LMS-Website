// =====================================================
// Activity Logging System
// Shared across all portals to record actions
// =====================================================

const LOGS_STORAGE_KEY = 'lms_activity_logs';

function initActivityLogs() {
    if (!localStorage.getItem(LOGS_STORAGE_KEY)) {
        // Sample Initial Data
        const sampleLogs = [
            {
                id: 1700000001,
                timestamp: new Date().toISOString(),
                user: 'Admin User',
                role: 'admin',
                action: 'System Init',
                details: 'System initialized with default data',
                ip: '127.0.0.1',
                status: 'Success'
            }
        ];
        localStorage.setItem(LOGS_STORAGE_KEY, JSON.stringify(sampleLogs));
    }
}

function logActivity(action, details, user, role) {
    const logs = getLogs();
    const newLog = {
        id: Date.now(),
        timestamp: new Date().toISOString(),
        user: user || 'Unknown',
        role: role || 'System',
        action: action, // 'Login', 'Update', 'Delete', 'Create'
        details: details,
        ip: '192.168.1.100', // Mock IP since client-side
        status: 'Success'
    };
    logs.unshift(newLog);

    // Keep max 200 logs to prevent overflow
    if (logs.length > 200) {
        logs.pop();
    }

    localStorage.setItem(LOGS_STORAGE_KEY, JSON.stringify(logs));
}

function getLogs() {
    initActivityLogs();
    return JSON.parse(localStorage.getItem(LOGS_STORAGE_KEY) || '[]');
}

function clearLogs() {
    localStorage.setItem(LOGS_STORAGE_KEY, '[]');
}

function exportLogsToExcel() {
    const logs = getLogs();
    if (logs.length === 0) return alert("No logs found to export.");

    let csv = "Timestamp,User,Role,Action,Details,IP Address\n";
    logs.forEach(log => {
        csv += `"${new Date(log.timestamp).toLocaleString()}",${log.user},${log.role},${log.action},"${log.details}",${log.ip}\n`;
    });

    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement("a");
    const url = URL.createObjectURL(blob);
    link.setAttribute("href", url);
    link.setAttribute("download", `activity_logs_${new Date().toISOString().split('T')[0]}.csv`);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Global Export
window.getLogs = getLogs;
window.logActivity = logActivity;
window.clearLogs = clearLogs;
window.exportLogsToExcel = exportLogsToExcel;
