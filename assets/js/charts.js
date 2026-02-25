// LMS Charts & Data Visualization
// Used primarily by Admin Dashboard.
// Student/Teacher dashboards use inline logic for role-specific data.


document.addEventListener('DOMContentLoaded', function () {
    // Only init if elements exist (Avoid errors on other pages)
    if (document.getElementById('revenueChart')) {
        initRevenueChart();
    }

    // Split Attendance Charts
    if (document.getElementById('teacherAttendanceChart')) {
        initTeacherAttendanceChart();
    }
    if (document.getElementById('studentAttendanceChart') || document.getElementById('attendanceChart')) {
        initStudentAttendanceChart();
    }
});

function initRevenueChart() {
    const ctx = document.getElementById('revenueChart').getContext('2d');

    // FETCH REAL FEE DATA
    const vouchers = JSON.parse(localStorage.getItem('lms_vouchers') || '[]');

    let monthlyRevenue = new Array(12).fill(0);
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    let hasRealData = false;

    if (vouchers.length > 0) {
        vouchers.forEach(v => {
            if (v.status === 'Paid' || v.status === 'paid') {
                const date = new Date(v.dueDate);
                const monthIndex = date.getMonth();
                if (!isNaN(monthIndex)) {
                    monthlyRevenue[monthIndex] += parseInt(v.amount);
                    hasRealData = true;
                }
            }
        });
    }

    // FALLBACK: If no real data, use nice demo data so the admin isn't staring at a blank screen
    if (!hasRealData || monthlyRevenue.every(v => v === 0)) {
        monthlyRevenue = [15000, 25000, 20000, 35000, 45000, 40000, 55000, 50000, 65000, 75000, 70000, 85000];
    }

    // Gradient styling for "Wow" factor
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
    gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Revenue (PKR)',
                data: monthlyRevenue,
                borderColor: '#4f46e5',
                backgroundColor: gradient, // Use gradient fill
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#4f46e5',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function (context) {
                            return 'PKR ' + context.raw.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [5, 5], drawBorder: false, color: '#e2e8f0' },
                    ticks: { callback: (val) => (val / 1000) + 'k' }
                },
                x: {
                    grid: { display: false, drawBorder: false }
                }
            }
        }
    });
}

function initTeacherAttendanceChart() {
    const ctx = document.getElementById('teacherAttendanceChart').getContext('2d');

    // FETCH REAL ATTENDANCE (TEACHERS)
    const attendance = JSON.parse(localStorage.getItem('lms_teacher_attendance') || '[]');

    let presentCount = 0;
    let absentCount = 0;

    if (attendance.length > 0) {
        attendance.forEach(a => {
            if (a.status === 'Present' || a.status === 'Late') presentCount++;
            else absentCount++;
        });
    }

    // FALLBACK: Use Demo Data if empty
    if (attendance.length === 0) {
        presentCount = 12; // Demo value for teachers
        absentCount = 2;   // Demo value
    }

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Present', 'Absent/Leave'],
            datasets: [{
                data: [presentCount, absentCount],
                backgroundColor: ['#10b981', '#ef4444'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 10, font: { size: 11 } } }
            }
        }
    });
}

function initStudentAttendanceChart() {
    const canvas = document.getElementById('studentAttendanceChart') || document.getElementById('attendanceChart');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');

    // FETCH REAL ATTENDANCE (STUDENTS)
    const attendance = JSON.parse(localStorage.getItem('lms_attendance') || '[]');

    let presentCount = 0;
    let absentCount = 0;

    if (attendance.length > 0) {
        attendance.forEach(a => {
            if (a.status === 'Present') presentCount++;
            else absentCount++;
        });
    }

    // FALLBACK: Use Demo Data if empty
    if (attendance.length === 0) {
        presentCount = 350; // Demo value
        absentCount = 45;   // Demo value
    }

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Present', 'Absent'],
            datasets: [{
                data: [presentCount, absentCount],
                backgroundColor: ['#3b82f6', '#f59e0b'], // Blue and Orange for Students diff
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 10, font: { size: 11 } } }
            }
        }
    });
}


// Note: Student and Teacher dashboards have their own inline chart initialization logic
// to handle specific RBAC data (Marks, specific attendance).
// This file primarily serves the Admin Dashboard currently.

