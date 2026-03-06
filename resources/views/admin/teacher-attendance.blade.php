<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Attendance - Admin Portal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body class="dashboard-body">

    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="/" class="sidebar-brand"><i class="fas fa-graduation-cap"></i><span>Lumina Academy
                    LMS</span></a>
        </div>
        <nav class="sidebar-menu">
            <ul class="list-unstyled">
                <li class="sidebar-menu-item"><a href="{{ route('admin.dashboard') }}" class="sidebar-link"><i
                            class="fas fa-home"></i><span>Dashboard</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/admissions') }}" class="sidebar-link"><i
                            class="fas fa-user-plus"></i><span>Admissions</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/timetable-input') }}" class="sidebar-link"><i
                            class="fas fa-calendar-plus"></i><span>Timetable Input</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/announcements') }}" class="sidebar-link"><i
                            class="fas fa-bullhorn"></i><span>Announcements</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/class-management') }}" class="sidebar-link"><i
                            class="fas fa-school"></i><span>Class Management</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/subject-assignment') }}" class="sidebar-link"><i
                            class="fas fa-book"></i><span>Subject Assignment</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/student-promotion') }}" class="sidebar-link"><i
                            class="fas fa-level-up-alt"></i><span>Student Promotion</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/data-correction') }}" class="sidebar-link"><i
                            class="fas fa-user-edit"></i><span>Data Correction</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/fee-vouchers') }}" class="sidebar-link"><i
                            class="fas fa-receipt"></i><span>Fee Vouchers</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/fines') }}" class="sidebar-link"><i
                            class="fas fa-exclamation-triangle"></i><span>Fine Management</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/teacher-attendance') }}" class="sidebar-link active"><i
                            class="fas fa-user-clock"></i><span>Teacher Attendance</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/discount-management') }}" class="sidebar-link"><i
                            class="fas fa-percentage"></i><span>Discount Management</span></a></li>
            </ul>
        </nav>
        <div class="sidebar-footer p-3 mt-auto">
            <button class="btn btn-outline-light w-100" onclick="logout()"><i class="fas fa-sign-out-alt me-2"></i>
                Logout</button>
        </div>
    </aside>

    <main class="main-content">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="btn btn-link text-dark d-lg-none me-3" id="sidebarToggle">
                    <i class="fas fa-bars fs-4"></i>
                </button>
                <h1 class="page-title mb-0">Personnel Presence</h1>
            </div>

            <div class="user-menu">
                <!-- Global Search Trigger -->
                <div class="search-trigger me-3 d-none d-md-flex align-items-center" onclick="globalSearch.openSearch()"
                    style="cursor: pointer; background: #f1f5f9; padding: 0.5rem 1rem; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <i class="fas fa-search text-muted me-2"></i>
                    <span class="text-muted small">Search (Ctrl+K)</span>
                </div>

                <!-- Notification Bell -->
                <div class="dropdown me-3">
                    <button class="btn btn-link text-dark p-2" type="button" id="notificationDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false" style="position: relative; overflow: visible;">
                        <i class="fas fa-bell fs-5"></i>
                        <span class="badge rounded-pill bg-danger" id="notificationBadge"
                            style="position: absolute; top: -5px; right: -5px; font-size: 0.65rem; min-width: 18px; height: 18px; display: none; align-items: center; justify-content: center; padding: 0.25em 0.4em;">0</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end shadow-lg" style="width: 380px; max-height: 500px;">
                        <div class="dropdown-header d-flex justify-content-between align-items-center py-3 px-3">
                            <h6 class="mb-0 fw-bold">System Alerts</h6>
                            <div>
                                <button class="btn btn-sm btn-link text-primary p-0 me-2"
                                    onclick="notificationSystem.markAllAsRead()" title="Mark all as read">
                                    <i class="fas fa-check-double"></i>
                                </button>
                                <button class="btn btn-sm btn-link text-danger p-0"
                                    onclick="notificationSystem.clearAll()" title="Clear all">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="dropdown-divider m-0"></div>
                        <div id="notificationsList" style="max-height: 400px; overflow-y: auto;">
                            <!-- Notifications will be loaded here -->
                        </div>
                    </div>
                </div>

                <div class="user-avatar shadow-sm"><span>AD</span></div>
                <div class="d-none d-md-block ms-3">
                    <div class="fw-bold user-name" id="userNameDisplay">Admin User</div>
                    <div class="small text-muted" id="userRoleDisplay">Administrator</div>
                </div>
            </div>
        </nav>

        <div class="dashboard-content px-4 py-4">
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card-modern animate-fade-in p-4 shadow-sm h-100">
                        <label class="form-label fw-bold small text-uppercase tracking-wider mb-2">Operational
                            Chronology</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i
                                    class="fas fa-calendar-alt text-muted"></i></span>
                            <input type="date" id="attendanceDate"
                                class="form-control bg-light border-0 py-2 shadow-none"
                                onchange="loadAttendanceTable()">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-end d-flex align-items-end justify-content-end">
                    <button class="btn btn-primary px-5 py-3 fw-bold lift shadow-sm" onclick="saveAllAttendance()">
                        <i class="fas fa-save me-2"></i> Commit Registry
                    </button>
                </div>
            </div>

            <div class="card-modern animate-fade-in shadow-lg border-0">
                <div
                    class="card-header bg-white border-0 py-4 px-4 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-users-viewfinder text-primary me-2"></i>
                        Instructor Registry</h5>
                    <div class="badge-modern bg-primary-subtle text-primary fw-bold" id="teacherCount">0 Active</div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase fw-bold">
                                <tr class="border-0">
                                    <th class="ps-4">Personnel</th>
                                    <th>Expertise Module</th>
                                    <th>Registry Status</th>
                                    <th>Check-in Point</th>
                                    <th class="pe-4">Check-out Point</th>
                                </tr>
                            </thead>
                            <tbody id="teacherTableBody">
                                <!-- Dynamic Content -->
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
    <script src="{{ asset('assets/js/data.js') }}"></script>
    <script src="{{ asset('assets/js/notifications.js') }}"></script>
    <script src="{{ asset('assets/js/storage.js') }}"></script>
    <script src="{{ asset('assets/js/search.js') }}"></script>
    <script src="{{ asset('assets/js/enhancements.js') }}"></script>
    <script src="{{ asset('assets/js/teacher-attendance-functions.js') }}"></script>
    <script src="{{ asset('assets/js/activity-functions.js') }}"></script>
    <script>
        protectPage('admin');

        let teachersList = [];

        document.addEventListener('DOMContentLoaded', async function () {
            initDashboardUser();
            document.getElementById('attendanceDate').valueAsDate = new Date();
            await loadTeachers();
            await loadAttendanceTable();
        });

        async function loadTeachers() {
            try {
                const response = await fetch('/api/teachers');
                teachersList = await response.json();
                document.getElementById('teacherCount').innerText = `${teachersList.length} Active Personnel`;
            } catch (error) {
                console.error('Error loading teachers:', error);
            }
        }

        async function loadAttendanceTable() {
            const date = document.getElementById('attendanceDate').value;
            const tbody = document.getElementById('teacherTableBody');
            tbody.innerHTML = '<tr><td colspan="5" class="text-center py-5"><div class="spinner-border text-primary"></div></td></tr>';

            try {
                const response = await fetch(`/api/attendance?date=${date}&role=teacher`);
                const existingRecords = await response.json();

                tbody.innerHTML = '';

                teachersList.forEach(t => {
                    const record = existingRecords.find(r => r.user_id === t.id);
                    const status = record ? record.status : 'Present';
                    const checkIn = record ? record.check_in : '08:00';
                    const checkOut = record ? record.check_out : '14:30';

                    const tr = document.createElement('tr');
                    tr.className = 'teacher-row animate-fade-in';
                    tr.setAttribute('data-id', t.id);
                    tr.setAttribute('data-name', t.name);

                    tr.innerHTML = `
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar shadow-sm me-3" style="width: 40px; height: 40px; font-size: 0.9rem; background: #e2e8f0; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                    <span>${t.name.split(' ').map(n => n[0]).join('')}</span>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">${t.name}</div>
                                    <div class="small text-muted">ID: ${t.id}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-modern bg-info-subtle text-info fw-bold">Teacher</span>
                        </td>
                        <td>
                            <select class="form-select form-select-sm status-select bg-light border-0 shadow-none fw-bold" 
                                    style="width: 140px; padding: 0.5rem;" 
                                    onchange="toggleTimes(this)">
                                <option value="Present" ${status === 'Present' ? 'selected' : ''}>Status: Present</option>
                                <option value="Absent" ${status === 'Absent' ? 'selected' : ''}>Status: Absent</option>
                                <option value="Leave" ${status === 'Leave' ? 'selected' : ''}>Status: Leave</option>
                                <option value="Late" ${status === 'Late' ? 'selected' : ''}>Status: Late</option>
                            </select>
                        </td>
                        <td>
                            <input type="time" class="form-control form-control-sm check-in bg-light border-0 shadow-none" 
                                   value="${checkIn}" style="width: 120px;"
                                   ${status === 'Absent' || status === 'Leave' ? 'disabled' : ''}>
                        </td>
                        <td class="pe-4">
                            <input type="time" class="form-control form-control-sm check-out bg-light border-0 shadow-none" 
                                   value="${checkOut}" style="width: 120px;"
                                   ${status === 'Absent' || status === 'Leave' ? 'disabled' : ''}>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            } catch (error) {
                console.error('Error loading attendance:', error);
                tbody.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Error loading data</td></tr>';
            }
        }

        function toggleTimes(select) {
            const row = select.closest('tr');
            const inputs = row.querySelectorAll('input[type="time"]');
            const status = select.value;
            const disabled = status === 'Absent' || status === 'Leave';

            inputs.forEach(input => {
                input.disabled = disabled;
                input.style.opacity = disabled ? '0.5' : '1';
            });
        }

        async function saveAllAttendance() {
            const date = document.getElementById('attendanceDate').value;
            if (!date) {
                showToast('Please select a date', 'warning');
                return;
            }

            const rows = document.querySelectorAll('.teacher-row');
            const attendance = [];

            rows.forEach(row => {
                const userId = row.dataset.id;
                const status = row.querySelector('.status-select').value;
                const checkIn = row.querySelector('.check-in').value;
                const checkOut = row.querySelector('.check-out').value;

                attendance.push({
                    user_id: userId,
                    date: date,
                    status: status,
                    check_in: checkIn,
                    check_out: checkOut
                });
            });

            try {
                const response = await fetch('/api/attendance/batch', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ attendance: attendance })
                });

                const result = await response.json();
                if (result.success) {
                    showToast('Attendance registry archived successfully!', 'success');
                    await loadAttendanceTable();
                } else {
                    showToast(result.message || 'Failed to save attendance', 'error');
                }
            } catch (error) {
                console.error('Error saving attendance:', error);
                showToast('An error occurred during save', 'error');
            }
        }
    </script>
</body>

</html>
