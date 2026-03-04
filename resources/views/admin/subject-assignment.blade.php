<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Subject Assignment - Admin Portal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body class="dashboard-body">

    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="../index.html" class="sidebar-brand"><i class="fas fa-graduation-cap"></i><span>EduPro
                    LMS</span></a>
        </div>
        <nav class="sidebar-menu">
            <ul class="list-unstyled">
                <li class="sidebar-menu-item"><a href="{{ route('admin.dashboard') }}" class="sidebar-link"><i
                            class="fas fa-home"></i><span>Dashboard</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/admissions.html') }}" class="sidebar-link"><i
                            class="fas fa-user-plus"></i><span>Admissions</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/timetable-input.html') }}" class="sidebar-link"><i
                            class="fas fa-calendar-plus"></i><span>Timetable Input</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/announcements.html') }}" class="sidebar-link"><i
                            class="fas fa-bullhorn"></i><span>Announcements</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/class-management.html') }}" class="sidebar-link"><i
                            class="fas fa-school"></i><span>Class Management</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/subject-assignment.html') }}" class="sidebar-link active"><i
                            class="fas fa-book"></i><span>Subject Assignment</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/student-promotion.html') }}" class="sidebar-link"><i
                            class="fas fa-level-up-alt"></i><span>Student Promotion</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/data-correction.html') }}" class="sidebar-link"><i
                            class="fas fa-user-edit"></i><span>Data Correction</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/fee-vouchers.html') }}" class="sidebar-link"><i
                            class="fas fa-receipt"></i><span>Fee Vouchers</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/fines.html') }}" class="sidebar-link"><i
                            class="fas fa-exclamation-triangle"></i><span>Fine Management</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/teacher-attendance.html') }}" class="sidebar-link"><i
                            class="fas fa-user-clock"></i><span>Teacher Attendance</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/discount-management.html') }}" class="sidebar-link"><i
                            class="fas fa-percentage"></i><span>Discount Management</span></a></li>
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
                <button class="btn btn-link text-dark d-lg-none me-3" id="sidebarToggle">
                    <i class="fas fa-bars fs-4"></i>
                </button>
                <h1 class="page-title mb-0">Subject Assignment</h1>
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

        <div class="dashboard-content">
            <div class="card-modern animate-fade-in shadow-lg border-0 mb-4">
                <div class="card-header bg-white border-0 py-4 px-4 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-plus-circle text-primary me-2"></i> Assign
                        Subject to Teacher</h5>
                    <p class="text-muted small mb-0 mt-1">Assign subjects to your teachers here.</p>
                </div>
                <div class="card-body p-4">
                    <form id="assignmentForm">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-uppercase tracking-wider">Select Teacher</label>
                                <select class="form-select bg-light border-0 py-3 px-4 shadow-none" id="teacherSelect" required>
                                    <option value="">Choose teacher...</option>
                                    <!-- Dynamic -->
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-uppercase tracking-wider">Select
                                    Subject</label>
                                <select class="form-select bg-light border-0 py-3 px-4 shadow-none" id="subjectSelect"
                                    required>
                                    <option value="">Choose subject...</option>
                                    <option value="Mathematics">Mathematics</option>
                                    <option value="Physics">Physics</option>
                                    <option value="Chemistry">Chemistry</option>
                                    <option value="Biology">Biology</option>
                                    <option value="English">English</option>
                                    <option value="Computer Science">Computer Science</option>
                                    <option value="History">History</option>
                                    <option value="Geography">Geography</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-uppercase tracking-wider">Select
                                    Class</label>
                                <select class="form-select bg-light border-0 py-3 px-4 shadow-none" id="unitSelect"
                                    required>
                                    <option value="">Choose class...</option>
                                    <!-- Dynamic -->
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label d-none d-md-block">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold lift shadow-sm">
                                    <i class="fas fa-link me-2"></i> Assign
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-modern animate-fade-in shadow-lg border-0">
                <div class="card-header bg-white border-0 py-4 px-4 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-list-ul text-success me-2"></i> Active
                        Active Assignments</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase fw-bold">
                                <tr class="border-0">
                                    <th class="ps-4">Teacher Name</th>
                                    <th>Subject</th>
                                    <th>Assigned Classes</th>
                                    <th>Workload</th>
                                    <th class="pe-4 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dinamic -->
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
    <script src="{{ asset('assets/js/subject-assignment-functions.js') }}"></script>
    <script src="{{ asset('assets/js/class-functions.js') }}"></script>
    <script>
        protectPage('admin');

        document.addEventListener('DOMContentLoaded', async function () {
            initDashboardUser();
            
            // --- DYNAMIC DROPDOWNS ---
            const classSelect = document.getElementById('unitSelect');
            const teacherSelect = document.getElementById('teacherSelect');

            const classes = await getAllClasses();
            classSelect.innerHTML = '<option value="">Choose class...</option>';
            classes.forEach(cls => {
                const opt = document.createElement('option');
                opt.value = cls.id;
                opt.textContent = cls.name + (cls.section ? ` (${cls.section})` : '');
                classSelect.appendChild(opt);
            });

            const teachers = await getAllTeachers();
            teacherSelect.innerHTML = '<option value="">Choose teacher...</option>';
            teachers.forEach(t => {
                const opt = document.createElement('option');
                opt.value = t.id;
                opt.textContent = t.name;
                teacherSelect.appendChild(opt);
            });

            loadAssignmentsTable();

            // Handle Form
            document.getElementById('assignmentForm').addEventListener('submit', async function (e) {
                e.preventDefault();

                const teacherSelect = document.getElementById('teacherSelect');
                const subjectSelect = document.getElementById('subjectSelect');
                const classSelect = document.getElementById('unitSelect');

                const teacherId = teacherSelect.value;
                const teacherName = teacherSelect.options[teacherSelect.selectedIndex].text;
                const subject = subjectSelect.value;
                const classId = classSelect.value;

                if (!teacherId || !subject || !classId) return;

                const result = await assignSubject(teacherId, teacherName, subject, classId);

                if (result.success) {
                    showToast(result.message, 'success');
                    this.reset();
                    loadAssignmentsTable();
                } else {
                    showToast(result.message, 'warning');
                }
            });
        });


        async function loadAssignmentsTable() {
            const all = await getAllAssignments();
            const tbody = document.querySelector('table tbody');
            tbody.innerHTML = '';

            if (all.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">No academic allocations found</td></tr>';
                return;
            }

            all.forEach(assign => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="ps-4"><div class="fw-bold text-dark">${assign.teacherName}</div></td>
                    <td><span class="text-muted small fw-bold text-uppercase">${assign.subject}</span></td>
                    <td><span class="badge-modern bg-primary-subtle text-primary fw-bold">${assign.class}</span></td>
                    <td><div class="small fw-bold text-dark">Assigned</div></td> 
                    <td class="pe-4 text-end">
                        <button class="btn btn-sm btn-outline-danger lift" onclick="confirmDeleteAssignment(${assign.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        async function confirmDeleteAssignment(id) {
            if (confirm('Are you sure you want to remove this assignment?')) {
                const success = await removeAssignment(id);
                if (success) {
                    showToast('Assignment removed', 'success');
                    loadAssignmentsTable();
                } else {
                    showToast('Failed to remove assignment', 'danger');
                }
            }
        }
    </script>
</body>

</html>