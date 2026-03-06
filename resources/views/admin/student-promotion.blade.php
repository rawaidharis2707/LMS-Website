<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Promotion - Admin Portal</title>

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
                <li class="sidebar-menu-item"><a href="{{ url('admin/student-promotion') }}" class="sidebar-link active"><i
                            class="fas fa-level-up-alt"></i><span>Student Promotion</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/data-correction') }}" class="sidebar-link"><i
                            class="fas fa-user-edit"></i><span>Data Correction</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/fee-vouchers') }}" class="sidebar-link"><i
                            class="fas fa-receipt"></i><span>Fee Vouchers</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/fines') }}" class="sidebar-link"><i
                            class="fas fa-exclamation-triangle"></i><span>Fine Management</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/teacher-attendance') }}" class="sidebar-link"><i
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
        <nav class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="btn btn-link text-dark d-lg-none me-3" id="sidebarToggle">
                    <i class="fas fa-bars fs-4"></i>
                </button>
                <h1 class="page-title mb-0">Student Promotion</h1>
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
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-cog text-primary me-2"></i> Promotion
                    </h5>
                    <p class="text-muted small mb-0 mt-1">Configure merit-based advancement for the upcoming academic
                        cycle.</p>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-uppercase tracking-wider">Current Class</label>
                            <select class="form-select bg-light border-0 py-3 px-4 shadow-none" id="fromClass">
                                <option value="">Choose grade...</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-uppercase tracking-wider">Next Class</label>
                            <select class="form-select bg-light border-0 py-3 px-4 shadow-none" id="toClass">
                                <option value="">Choose grade...</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button class="btn btn-primary w-100 py-3 fw-bold lift shadow-sm" onclick="loadStudents()">
                                <i class="fas fa-sync me-2"></i> Load Students List
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-modern animate-fade-in shadow-lg border-0" id="studentsCard" style="display: none;">
                <div class="card-header bg-white border-0 py-4 px-4 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-users text-success me-2"></i>
                                Students List</h5>
                            <p class="text-muted small mb-0 mt-1">Review and approve students for grade progression.</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm px-3 fw-bold lift" onclick="selectAll(true)">
                                <i class="fas fa-check-double me-2"></i> Select All
                            </button>
                            <button class="btn btn-primary px-4 fw-bold lift shadow-sm" onclick="promoteSelected()">
                                <i class="fas fa-arrow-up me-2"></i> Promote Students
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase fw-bold">
                                <tr class="border-0">
                                    <th class="ps-4" style="width: 50px;">
                                        <input type="checkbox" class="form-check-input shadow-none"
                                            id="selectAllCheckbox" onclick="selectAll()">
                                    </th>
                                    <th>Roll No</th>
                                    <th>Full Name</th>
                                    <th>Current Class</th>
                                    <th>Marks Percentage</th>
                                    <th>Status</th>
                                    <th class="pe-4 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody id="studentsTable">
                                <!-- Will be populated by JavaScript -->
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
    <script src="{{ asset('assets/js/class-functions.js') }}"></script>
    <script src="{{ asset('assets/js/student-functions.js') }}"></script>
    <script>
        protectPage('admin');

        document.addEventListener('DOMContentLoaded', async function () {
            initDashboardUser();
            
            // Populate Dropdowns from API
            const fromSelect = document.getElementById('fromClass');
            const toSelect = document.getElementById('toClass');

            try {
                const response = await fetch('/api/classes');
                const classes = await response.json();
                
                fromSelect.innerHTML = '<option value="">Choose grade...</option>';
                toSelect.innerHTML = '<option value="">Choose grade...</option>';
                
                classes.forEach(c => {
                    const opt1 = document.createElement('option');
                    opt1.value = c.id;
                    opt1.textContent = `Class ${c.name}`;
                    fromSelect.appendChild(opt1);

                    const opt2 = document.createElement('option');
                    opt2.value = c.id;
                    opt2.textContent = `Class ${c.name}`;
                    toSelect.appendChild(opt2);
                });
            } catch (error) {
                console.error('Error loading classes:', error);
            }
        });

        async function loadStudents() {
            const fromClassId = document.getElementById('fromClass').value;
            const toClassId = document.getElementById('toClass').value;

            if (!fromClassId || !toClassId) {
                showToast('Please select both Current and Next Class', 'error');
                return;
            }

            const tbody = document.getElementById('studentsTable');
            tbody.innerHTML = '<tr><td colspan="7" class="text-center py-5"><div class="spinner-border text-primary"></div></td></tr>';
            document.getElementById('studentsCard').style.display = 'block';

            try {
                const response = await fetch(`/api/students?class_id=${fromClassId}`);
                const students = await response.json();

                if (students.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted">No students found in this class</td></tr>';
                    return;
                }

                // In a real system, we'd fetch their results/percentage from the backend
                // For this UI, we'll simulate the "Eligible" status
                let html = '';
                students.forEach(student => {
                    html += `
                        <tr>
                            <td class="ps-4"><input type="checkbox" class="form-check-input student-checkbox shadow-none" value="${student.id}"></td>
                            <td><div class="fw-bold text-dark">${student.roll_number || 'N/A'}</div></td>
                            <td><div class="fw-bold text-dark">${student.name}</div></td>
                            <td><span class="badge-modern bg-light text-muted fw-bold">${document.getElementById('fromClass').options[document.getElementById('fromClass').selectedIndex].text}</span></td>
                            <td>
                                <div class="fw-bold text-dark">N/A</div>
                            </td>
                            <td><span class="badge-modern bg-success text-white fw-bold">ELIGIBLE</span></td>
                            <td class="pe-4 text-end"><span class="text-success fw-bold small">Ready for Promotion</span></td>
                        </tr>
                    `;
                });
                tbody.innerHTML = html;
            } catch (error) {
                console.error('Error loading students:', error);
                tbody.innerHTML = '<tr><td colspan="7" class="text-center text-danger">Error loading data</td></tr>';
            }
        }

        function selectAll(force) {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            if (typeof force === 'boolean') selectAllCheckbox.checked = force;
            const checkboxes = document.querySelectorAll('.student-checkbox:not(:disabled)');
            checkboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
        }

        async function promoteSelected() {
            const checkboxes = document.querySelectorAll('.student-checkbox:checked');
            if (checkboxes.length === 0) {
                showToast('Please select at least one student', 'error');
                return;
            }

            const targetClassId = document.getElementById('toClass').value;
            const studentIds = Array.from(checkboxes).map(cb => cb.value);

            try {
                const response = await fetch('/api/promote', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        student_ids: studentIds,
                        target_class_id: targetClassId
                    })
                });

                const result = await response.json();
                if (result.success) {
                    showToast(result.message, 'success');
                    loadStudents(); // Refresh
                } else {
                    showToast(result.message || 'Promotion failed', 'error');
                }
            } catch (error) {
                console.error('Error promoting students:', error);
                showToast('An error occurred during promotion', 'error');
            }
        }
    </script>
    </script>
</body>

</html>