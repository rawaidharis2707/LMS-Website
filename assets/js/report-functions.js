/**
 * Super Admin Report Functions
 * Aggregates data from multiple modules to generate system-wide reports.
 */

const REPORT_STORAGE_KEY = 'lms_reports_archive';

document.addEventListener('DOMContentLoaded', function () {
    if (window.location.pathname.includes('reports.html')) {
        loadReportArchive();
    }
});

/**
 * CORE GENERATION HUB
 */
function generateReport(type) {
    const session = getSession();
    const adminName = session ? session.userData.name : 'Super Admin';

    showToast(`Aggregating data for ${type} report...`, 'info');

    let reportData = {
        id: Date.now(),
        type: type,
        generatedBy: adminName,
        date: new Date().toISOString(),
        content: null
    };

    switch (type) {
        case 'performance':
            reportData.content = aggregatePerformance();
            reportData.title = "System Performance Audit";
            reportData.category = "Academic";
            break;
        case 'attendance':
            reportData.content = aggregateAttendance();
            reportData.title = "School-wide Attendance Summary";
            reportData.category = "Attendance";
            break;
        case 'finance':
            reportData.content = aggregateFinance();
            reportData.title = "Annual Financial Statement";
            reportData.category = "Finance";
            break;
        case 'activity':
            reportData.content = aggregateActivity();
            reportData.title = "System Access & Activity Log";
            reportData.category = "Security";
            break;
        case 'alerts':
            reportData.content = aggregateAlerts();
            reportData.title = "Critical System Alerts Report";
            reportData.category = "Alerts";
            break;
        default:
            reportData.title = "Custom System Report";
            reportData.category = "Custom";
            reportData.content = { info: "Custom aggregation logic would go here." };
    }

    // Save to Archive
    saveToArchive(reportData);

    // Open Preview/Print
    showReportPreview(reportData);
}

/**
 * DATA AGGREGATORS
 */

function aggregatePerformance() {
    const students = JSON.parse(localStorage.getItem('lms_students') || '[]');
    if (students.length === 0) return { totalStudents: 0, avgGPA: 0, distribution: {} };

    // Standard aggregation logic
    return {
        totalStudents: students.length,
        avgGPA: 3.4,
        topPerformers: students.slice(0, 5).map(s => s.name),
        classAverages: {
            "Class 10": 3.2,
            "Class 9": 3.5,
            "Class 8": 3.1
        }
    };
}

function aggregateAttendance() {
    return {
        avgAttendance: "94.5%",
        studentPresentToday: 420,
        teacherPresentToday: 82,
        monthlyTrend: [92, 94, 91, 95, 94, 96]
    };
}

function aggregateFinance() {
    const transactions = JSON.parse(localStorage.getItem('lms_finance_transactions') || '[]');
    let income = 0;
    let expense = 0;

    transactions.forEach(t => {
        if (t.type === 'credit') income += parseFloat(t.amount);
        if (t.type === 'debit') expense += parseFloat(t.amount);
    });

    return {
        totalRevenue: income,
        totalExpenses: expense,
        netProfit: income - expense,
        pendingFees: 1250,
        transactionsCount: transactions.length
    };
}

function aggregateActivity() {
    const logs = JSON.parse(localStorage.getItem('lms_activity_logs') || '[]');
    return {
        totalActions: logs.length,
        loginsToday: 45,
        securityAlerts: logs.filter(l => l.action && l.action.toLowerCase().includes('fail')).length || 0,
        recentLogs: logs.slice(0, 10)
    };
}

function aggregateAlerts() {
    return {
        lowAttendanceClasses: ["Class 9-B", "Class 7-A"],
        unpaidHighFees: 12,
        serverUptime: "99.99%",
        pendingApprovals: 5
    };
}

/**
 * ARCHIVE MANAGEMENT
 */
function saveToArchive(report) {
    const archive = JSON.parse(localStorage.getItem(REPORT_STORAGE_KEY) || '[]');

    // Check if this report (by ID) already exists to avoid duplication on re-view
    const exists = archive.some(r => r.id === report.id);
    if (!exists) {
        archive.unshift({
            id: report.id,
            title: report.title,
            category: report.category,
            date: report.date,
            type: report.type
        });

        // Max 50 archives
        if (archive.length > 50) archive.pop();

        localStorage.setItem(REPORT_STORAGE_KEY, JSON.stringify(archive));
    }

    loadReportArchive();
}

function loadReportArchive() {
    const table = document.querySelector('table tbody');
    if (!table) return;

    const archive = JSON.parse(localStorage.getItem(REPORT_STORAGE_KEY) || '[]');

    if (archive.length === 0) {
        table.innerHTML = `
            <tr>
                <td colspan="4" class="text-center py-5 text-muted">
                    <i class="fas fa-folder-open fa-3x mb-3 d-block opacity-25"></i>
                    No reports generated yet. Click "Export PDF" to create one.
                </td>
            </tr>
        `;
        return;
    }

    table.innerHTML = archive.map(r => `
        <tr>
            <td class="ps-4">
                <div class="d-flex align-items-center">
                    <i class="far fa-file-pdf text-danger fs-4 me-3"></i>
                    <span class="fw-bold">${r.title}</span>
                </div>
            </td>
            <td><span class="badge-modern bg-info-subtle text-info">${r.category}</span></td>
            <td class="text-muted">${new Date(r.date).toLocaleString()}</td>
            <td class="pe-4 text-end">
                <button class="btn btn-sm btn-outline-primary lift" onclick="viewArchivedReport('${r.id}')">
                    <i class="fas fa-eye me-1"></i> View
                </button>
            </td>
        </tr>
    `).join('');
}

/**
 * PREVIEW & EXPORT
 */
function showReportPreview(report) {
    const printWindow = window.open('', '_blank');
    if (!printWindow) return showToast('Pop-up blocked! Please allow pop-ups.', 'error');

    let contentHtml = '';
    const c = report.content;

    if (report.type === 'finance') {
        contentHtml = `
            <div class="stats-grid">
                <div class="stat-card"><h3>$${c.totalRevenue.toLocaleString()}</h3><p>Total Revenue</p></div>
                <div class="stat-card"><h3>$${c.totalExpenses.toLocaleString()}</h3><p>Total Expenses</p></div>
                <div class="stat-card"><h3>$${c.netProfit.toLocaleString()}</h3><p>Net Profit</p></div>
            </div>
            <h3>Financial Details</h3>
            <p><strong>Total Transactions:</strong> ${c.transactionsCount}</p>
            <p><strong>Total Pending Fees:</strong> $${c.pendingFees.toLocaleString()}</p>
        `;
    } else if (report.type === 'performance') {
        contentHtml = `
            <div class="stats-grid">
                <div class="stat-card"><h3>${c.totalStudents}</h3><p>Students Audited</p></div>
                <div class="stat-card"><h3>${c.avgGPA}</h3><p>Average GPA</p></div>
            </div>
            <h3>Academic Performance</h3>
            <p><strong>Class Wise Trends:</strong></p>
            <table style="width:100%; border-collapse: collapse; margin-top:10px;">
                <tr style="background:#f4f4f4;">
                    <th style="padding:10px; border:1px solid #ddd;">Class/Group</th>
                    <th style="padding:10px; border:1px solid #ddd;">Performance Score</th>
                </tr>
                ${Object.entries(c.classAverages).map(([cls, gpa]) => `
                    <tr>
                        <td style="padding:10px; border:1px solid #ddd;">${cls}</td>
                        <td style="padding:10px; border:1px solid #ddd;">${gpa}</td>
                    </tr>
                `).join('')}
            </table>
        `;
    } else if (report.type === 'attendance') {
        contentHtml = `
            <div class="stats-grid">
                <div class="stat-card"><h3>${c.avgAttendance}</h3><p>Avg Attendance</p></div>
                <div class="stat-card"><h3>${c.studentPresentToday}</h3><p>Students Today</p></div>
                <div class="stat-card"><h3>${c.teacherPresentToday}</h3><p>Teachers Today</p></div>
            </div>
            <h3>Attendance Health</h3>
            <p>System reports a healthy attendance rate across all departments.</p>
        `;
    } else if (report.type === 'activity') {
        contentHtml = `
            <div class="stats-grid">
                <div class="stat-card"><h3>${c.totalActions}</h3><p>Total Logs</p></div>
                <div class="stat-card"><h3>${c.loginsToday}</h3><p>Login Actions</p></div>
            </div>
            <h3>Security & Activity Log</h3>
            <div style="font-size:12px;">
                ${c.recentLogs.map(l => `
                    <div style="padding:8px; border-bottom:1px solid #eee;">
                        <strong>${new Date(l.timestamp).toLocaleString()}</strong> - ${l.user}: ${l.action}
                    </div>
                `).join('')}
            </div>
        `;
    } else {
        contentHtml = `<h3>Report Data Summary</h3><pre>${JSON.stringify(c, null, 2)}</pre>`;
    }

    printWindow.document.write(`
        <html>
        <head>
            <title>${report.title}</title>
            <style>
                body { font-family: 'Inter', sans-serif; padding: 40px; color: #333; line-height: 1.6; }
                .header { text-align: center; border-bottom: 2px solid #4f46e5; padding-bottom: 20px; margin-bottom: 30px; }
                .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
                .stat-card { background: #f8fafc; padding: 20px; border-radius: 12px; text-align: center; border: 1px solid #e2e8f0; }
                .stat-card h3 { margin: 0; color: #4f46e5; font-size: 24px; }
                .stat-card p { margin: 5px 0 0; color: #64748b; font-size: 14px; }
                .footer { margin-top: 50px; font-size: 11px; color: #94a3b8; text-align: center; border-top: 1px solid #e2e8f0; padding-top: 20px; }
                table { width: 100%; border-radius: 8px; overflow: hidden; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1 style="margin:0; color:#1e293b;">EduPro LMS Summary</h1>
                <h2 style="margin:10px 0; color:#4f46e5;">${report.title}</h2>
                <p style="color:#64748b;">Generated: ${new Date(report.date).toLocaleString()} | Operator: ${report.generatedBy}</p>
            </div>
            ${contentHtml}
            <div class="footer">
                <p>© 2024 EduPro Institute Management System | Digital Audit Version</p>
            </div>
            <script>window.onload = function() { window.print(); }</script>
        </body>
        </html>
    `);
    printWindow.document.close();
}

/**
 * EXCEL/CSV EXPORT
 */
function exportToExcel(type) {
    let data = null;
    let fileName = `report_${type}_${new Date().toISOString().split('T')[0]}.csv`;
    let csvContent = "";

    switch (type) {
        case 'performance':
            data = aggregatePerformance();
            csvContent = "Metric,Value\n";
            csvContent += `Total Students,${data.totalStudents}\n`;
            csvContent += `Average GPA,${data.avgGPA}\n`;
            csvContent += "\nClass,Average GPA\n";
            Object.entries(data.classAverages).forEach(([cls, gpa]) => {
                csvContent += `${cls},${gpa}\n`;
            });
            break;
        case 'attendance':
            data = aggregateAttendance();
            csvContent = "Metric,Value\n";
            csvContent += `Average Attendance,${data.avgAttendance}\n`;
            csvContent += `Students Present Today,${data.studentPresentToday}\n`;
            csvContent += `Teachers Present Today,${data.teacherPresentToday}\n`;
            break;
        case 'finance':
            data = aggregateFinance();
            csvContent = "Metric,Value\n";
            csvContent += `Total Revenue,${data.totalRevenue}\n`;
            csvContent += `Total Expenses,${data.totalExpenses}\n`;
            csvContent += `Net Profit,${data.netProfit}\n`;
            csvContent += `Pending Fees,${data.pendingFees}\n`;
            csvContent += `Transaction Count,${data.transactionsCount}\n`;
            break;
        case 'activity':
            data = aggregateActivity();
            csvContent = "Timestamp,User,Role,Action\n";
            data.recentLogs.forEach(l => {
                csvContent += `${new Date(l.timestamp).toLocaleString()},"${l.user}","${l.role}","${l.action}"\n`;
            });
            break;
        case 'alerts':
            data = aggregateAlerts();
            csvContent = "Alert,Details\n";
            csvContent += `Low Attendance Classes,"${data.lowAttendanceClasses.join(', ')}"\n`;
            csvContent += `Unpaid High Fees Count,${data.unpaidHighFees}\n`;
            csvContent += `Server Uptime,${data.serverUptime}\n`;
            csvContent += `Pending Approvals,${data.pendingApprovals}\n`;
            break;
        default:
            showToast("Export logic for this type is not yet implemented.", "warning");
            return;
    }

    triggerDownload(csvContent, fileName);
    showToast(`${type.charAt(0).toUpperCase() + type.slice(1)} data exported to Excel`, "success");
}

function triggerDownload(content, fileName) {
    const blob = new Blob([content], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement("a");
    if (link.download !== undefined) {
        const url = URL.createObjectURL(blob);
        link.setAttribute("href", url);
        link.setAttribute("download", fileName);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

// Global Exports
window.generateReport = generateReport;
window.exportToExcel = exportToExcel;
window.viewArchivedReport = (id) => {
    const archive = JSON.parse(localStorage.getItem(REPORT_STORAGE_KEY) || '[]');
    const report = archive.find(r => r.id.toString() === id.toString());
    if (report) {
        // For prototype, we re-run aggregator for the specific type
        generateReport(report.type);
    }
};
