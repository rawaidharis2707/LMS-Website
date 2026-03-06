<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Attendance - Super Admin Portal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body class="dashboard-body">

    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="{{ url('/') }}" class="sidebar-brand"><i class="fas fa-graduation-cap"></i><span>Lumina Academy
                    LMS</span></a>
        </div>
        <nav class="sidebar-menu">
            <ul class="list-unstyled">
                <li class="sidebar-menu-item"><a href="{{ route('superadmin.dashboard') }}" class="sidebar-link"><i
                            class="fas fa-home"></i><span>Dashboard</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('superadmin/announcements') }}" class="sidebar-link"><i
                            class="fas fa-bullhorn"></i><span>Announcements</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('superadmin/role-distribution') }}" class="sidebar-link"><i
                            class="fas fa-user-shield"></i><span>Roles & Permissions</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('superadmin/finance') }}" class="sidebar-link"><i
                            class="fas fa-money-bill-wave"></i><span>Funds Management</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('superadmin/salary') }}" class="sidebar-link"><i
                            class="fas fa-wallet"></i><span>Salary Management</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('superadmin/teacher-attendance') }}" class="sidebar-link active"><i
                            class="fas fa-clipboard-check"></i><span>Teacher Attendance</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('superadmin/reports') }}" class="sidebar-link"><i
                            class="fas fa-file-alt"></i><span>Reports</span></a></li>

                <li class="sidebar-menu-item"><a href="{{ url('superadmin/activity-logs') }}" class="sidebar-link"><i
                            class="fas fa-history"></i><span>Activity Logs</span></a></li>
            </ul>
        </nav>
        <div class="sidebar-footer p-3 mt-auto">
            <button class="btn btn-outline-light w-100" onclick="logout()"><i class="fas fa-sign-out-alt me-2"></i>
                Logout</button>
        </div>
    </aside>

    <main class="main-content">
        <nav class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="btn btn-link text-dark d-lg-none me-3" id="sidebarToggle"><i
                        class="fas fa-bars fs-4"></i></button>
                <h1 class="page-title mb-0">Teacher Attendance Overview</h1>
            </div>
            <div class="user-menu">
                <div class="user-avatar"><span>SA</span></div>
                <div class="d-none d-md-block ms-3">
                    <div class="fw-bold">Super Admin</div>
                    <div class="small text-muted">System Administrator</div>
                </div>
            </div>
        </nav>

        <div class="dashboard-content">
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <h6 class="text-muted mb-2">Total Teachers</h6>
                            <h3 class="fw-bold">85</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <h6 class="text-muted mb-2">Present Today</h6>
                            <h3 class="fw-bold text-success">82</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <h6 class="text-muted mb-2">Absent Today</h6>
                            <h3 class="fw-bold text-danger">3</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <h6 class="text-muted mb-2">Avg Attendance</h6>
                            <h3 class="fw-bold text-primary">96.5%</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-filter text-primary me-2"></i> Filter</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <select class="form-select">
                                <option value="">All Departments</option>
                                <option value="math">Mathematics</option>
                                <option value="science">Science</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" id="attendanceDate">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-list text-success me-2"></i> Teacher Attendance Records
                    </h5>
                    <button class="btn btn-sm btn-outline-success" onclick="exportAttendanceToExcel()">
                        <i class="fas fa-file-excel me-2"></i> Export to Excel
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Total Days</th>
                                    <th>Present</th>
                                    <th>Absent</th>
                                    <th>Percentage</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold">T001</td>
                                    <td>Sarah Johnson</td>
                                    <td>Mathematics</td>
                                    <td>200</td>
                                    <td class="text-success">193</td>
                                    <td class="text-danger">7</td>
                                    <td>96.5%</td>
                                    <td><span class="badge bg-success">Excellent</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">T002</td>
                                    <td>John Smith</td>
                                    <td>Physics</td>
                                    <td>200</td>
                                    <td class="text-success">188</td>
                                    <td class="text-danger">12</td>
                                    <td>94.0%</td>
                                    <td><span class="badge bg-success">Good</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">T003</td>
                                    <td>Emily Davis</td>
                                    <td>Chemistry</td>
                                    <td>200</td>
                                    <td class="text-success">178</td>
                                    <td class="text-danger">22</td>
                                    <td>89.0%</td>
                                    <td><span class="badge bg-warning">Fair</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/auth.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        protectPage('superadmin');

        document.addEventListener('DOMContentLoaded', async function () {
            initDashboardUser();
            document.getElementById('attendanceDate').valueAsDate = new Date();
            await loadAttendanceData();
        });

        async function loadAttendanceData() {
            const date = document.getElementById('attendanceDate').value;
            
            try {
                const [teachers, attendance] = await Promise.all([
                    fetch('/api/teachers').then(r => r.json()),
                    fetch(`/api/attendance?date=${date}&role=teacher`).then(r => r.json())
                ]);

                // Update Stats
                const total = teachers.length;
                const present = attendance.filter(a => a.status === 'Present').length;
                const absent = attendance.filter(a => a.status === 'Absent').length;
                const avg = total > 0 ? ((present / total) * 100).toFixed(1) : 0;

                document.querySelector('.row.g-4.mb-4').innerHTML = `
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-2">Total Teachers</h6>
                                <h3 class="fw-bold">${total}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-2">Present Today</h6>
                                <h3 class="fw-bold text-success">${present}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-2">Absent Today</h6>
                                <h3 class="fw-bold text-danger">${absent}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-2">Avg Attendance</h6>
                                <h3 class="fw-bold text-primary">${avg}%</h3>
                            </div>
                        </div>
                    </div>
                `;

                // Update Table
                const tbody = document.querySelector('tbody');
                tbody.innerHTML = '';

                teachers.forEach(t => {
                    const record = attendance.find(a => a.user_id === t.id);
                    const status = record ? record.status : 'N/A';
                    const statusBadge = getStatusBadge(status);

                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class="fw-bold">${t.id}</td>
                        <td>${t.name}</td>
                        <td>Teacher</td>
                        <td>1</td> <!-- Total Days in filtered range -->
                        <td class="text-success">${status === 'Present' ? '1' : '0'}</td>
                        <td class="text-danger">${status === 'Absent' ? '1' : '0'}</td>
                        <td>${status === 'Present' ? '100%' : '0%'}</td>
                        <td>${statusBadge}</td>
                    `;
                    tbody.appendChild(tr);
                });

            } catch (error) {
                console.error('Error loading attendance data:', error);
            }
        }

        function getStatusBadge(status) {
            if (status === 'Present') return '<span class="badge bg-success">Present</span>';
            if (status === 'Absent') return '<span class="badge bg-danger">Absent</span>';
            if (status === 'Late') return '<span class="badge bg-warning text-dark">Late</span>';
            if (status === 'Leave') return '<span class="badge bg-info">Leave</span>';
            return '<span class="badge bg-secondary">Pending</span>';
        }

        function exportAttendanceToExcel() {
            showToast('Excel export functionality coming soon', 'info');
        }
    </script>
</body>

</html>

