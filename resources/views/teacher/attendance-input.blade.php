<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Attendance Input - Teacher Portal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body class="dashboard-body">

    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="{{ url('/') }}" class="sidebar-brand"><i class="fas fa-graduation-cap"></i><span>EduPro
                    LMS</span></a>
        </div>
        <nav class="sidebar-menu">
            <ul class="list-unstyled">
                <li class="sidebar-menu-item"><a href="{{ route('teacher.dashboard') }}" class="sidebar-link"><i
                            class="fas fa-home"></i><span>Dashboard</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/marks-input.html') }}" class="sidebar-link"><i
                            class="fas fa-edit"></i><span>Marks Input</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/remarks.html') }}" class="sidebar-link"><i
                            class="fas fa-comments"></i><span>Student Remarks</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/upload-assignments.html') }}" class="sidebar-link"><i
                            class="fas fa-upload"></i><span>Upload Assignments</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/upload-notes.html') }}" class="sidebar-link"><i
                            class="fas fa-file-upload"></i><span>Upload Notes</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/upload-lectures.html') }}" class="sidebar-link"><i
                            class="fas fa-video"></i><span>Upload Lectures</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/create-quiz.html') }}" class="sidebar-link"><i
                            class="fas fa-plus-circle"></i><span>Create Quiz</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/attendance-input.html') }}" class="sidebar-link active"><i
                            class="fas fa-check-square"></i><span>Attendance Input</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/my-attendance.html') }}" class="sidebar-link"><i
                            class="fas fa-calendar-check"></i><span>My Attendance</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/timetable.html') }}" class="sidebar-link"><i
                            class="fas fa-calendar-alt"></i><span>Timetable</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/announcements.html') }}" class="sidebar-link"><i
                            class="fas fa-bullhorn"></i><span>Announcements</span></a></li>
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
                <h1 class="page-title mb-0">Attendance Input</h1>
            </div>

            <div class="user-menu">
                <div class="search-trigger me-3 d-none d-md-flex align-items-center" onclick="globalSearch.openSearch()"
                    style="cursor: pointer; background: #f1f5f9; padding: 0.5rem 1rem; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <i class="fas fa-search text-muted me-2"></i>
                    <span class="text-muted small">Search (Ctrl+K)</span>
                </div>

                <div class="dropdown me-3">
                    <button class="btn btn-link text-dark p-2" type="button" id="notificationDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false" style="position: relative; overflow: visible;">
                        <i class="fas fa-bell fs-5"></i>
                        <span class="badge rounded-pill bg-danger" id="notificationBadge"
                            style="position: absolute; top: -5px; right: -5px; font-size: 0.65rem; min-width: 18px; height: 18px; display: none; align-items: center; justify-content: center; padding: 0.25em 0.4em;">0</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end shadow-lg" style="width: 380px; max-height: 500px;">
                        <div class="dropdown-header d-flex justify-content-between align-items-center py-3 px-3">
                            <h6 class="mb-0 fw-bold">Notifications</h6>
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
                        </div>
                    </div>
                </div>

                <div class="user-avatar"><span>SJ</span></div>
                <div class="d-none d-md-block ms-3">
                    <div class="fw-bold user-name" id="userNameDisplay">Sarah Johnson</div>
                    <div class="small text-muted" id="userRoleDisplay">Mathematics Teacher</div>
                </div>
            </div>
        </nav>

        <div class="dashboard-content px-4 py-4">
            <div class="card-modern animate-fade-in mb-4">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Select Class</label>
                            <select class="form-select border-0 bg-light" id="classSelect" required>
                                <option value="">Choose class...</option>
                                <option value="10-A">Class 10-A</option>
                                <option value="10-B">Class 10-B</option>
                                <option value="9-A">Class 9-A</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Subject</label>
                            <select class="form-select border-0 bg-light" id="subjectSelect" required>
                                <option value="">Choose subject...</option>
                                <option value="Mathematics">Mathematics</option>
                                <option value="Physics">Physics</option>
                                <option value="Chemistry">Chemistry</option>
                                <option value="English">English</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Date</label>
                            <input type="date" class="form-control border-0 bg-light" id="dateSelect" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Actions</label>
                            <div class="btn-group w-100" role="group" style="height: 38px;">
                                <button class="btn btn-primary lift fw-bold" onclick="loadStudents()"
                                    style="height: 38px;">
                                    <i class="fas fa-search me-1"></i> LOAD
                                </button>
                                <button class="btn btn-secondary lift" onclick="viewHistory()" style="height: 38px;">
                                    <i class="fas fa-history me-1"></i> HISTORY
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-modern animate-fade-in mb-4 shadow-lg" id="historyCard" style="display: none;">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-history text-secondary me-2"></i> Attendance History</h5>
                    <button class="btn btn-sm btn-outline-danger lift" onclick="closeHistory()"><i
                            class="fas fa-times me-1"></i>
                        Close</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Status Summary</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="historyTableBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card-modern animate-fade-in shadow-lg" id="studentListCard" style="display: none;">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-users me-2"></i> Student List</h5>
                        <p class="text-muted small mb-0 mt-1" id="attendanceInfo"></p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-success lift" onclick="markAll('Present')">Mark All
                            P</button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Roll No</th>
                                    <th>Student Name</th>
                                    <th class="text-center">Status</th>
                                    <th class="pe-4">Remarks / Extra Info</th>
                                </tr>
                            </thead>
                            <tbody id="attendanceTableBody"></tbody>
                        </table>
                    </div>
                    <div class="p-4 bg-light text-end">
                        <button class="btn btn-success px-5 py-2 lift fw-bold" onclick="submitAttendance()">
                            <i class="fas fa-save me-2"></i> Save All Attendance
                        </button>
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
    <script src="{{ asset('assets/js/activity-functions.js') }}"></script>
    <script src="{{ asset('assets/js/attendance-functions.js') }}"></script>
    <script>
        protectPage('teacher');

        document.addEventListener('DOMContentLoaded', async function () {
            initDashboardUser();
            
            const classSelect = document.getElementById('classSelect');
            const subjectSelect = document.getElementById('subjectSelect');
            
            const classes = await getClasses();
            classSelect.innerHTML = '<option value="">Choose class...</option>';
            classes.forEach(c => {
                const opt = document.createElement('option');
                opt.value = c.id;
                opt.textContent = `Class ${c.name}`;
                classSelect.appendChild(opt);
            });

            classSelect.addEventListener('change', async function() {
                const classId = this.value;
                if (!classId) return;
                
                const subjects = await getSubjects(classId);
                subjectSelect.innerHTML = '<option value="">Choose subject...</option>';
                subjects.forEach(s => {
                    const opt = document.createElement('option');
                    opt.value = s.id;
                    opt.textContent = s.name;
                    subjectSelect.appendChild(opt);
                });
            });

            document.getElementById('dateSelect').valueAsDate = new Date();
        });

        async function loadStudents() {
            const classId = document.getElementById('classSelect').value;
            const subjectId = document.getElementById('subjectSelect').value;
            const date = document.getElementById('dateSelect').value;

            if (!classId || !subjectId || !date) {
                showToast('Please select Class, Subject and Date', 'warning');
                return;
            }

            const tbody = document.getElementById('attendanceTableBody');
            tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4"><div class="spinner-border text-primary"></div></td></tr>';

            try {
                const response = await fetch(`/api/students?class_id=${classId}`);
                const students = await response.json();

                if (students.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4">No students found in this class.</td></tr>';
                    return;
                }

                document.getElementById('studentListCard').style.display = 'block';
                document.getElementById('historyCard').style.display = 'none';
                document.getElementById('attendanceInfo').innerText = `${document.getElementById('classSelect').options[document.getElementById('classSelect').selectedIndex].text} | ${document.getElementById('subjectSelect').options[document.getElementById('subjectSelect').selectedIndex].text} | ${date}`;

                tbody.innerHTML = '';
                students.forEach(student => {
                    const tr = document.createElement('tr');
                    tr.className = 'student-row';
                    tr.dataset.id = student.id;
                    tr.innerHTML = `
                        <td class="ps-4">${student.roll_number || 'N/A'}</td>
                        <td class="fw-bold">${student.name}</td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="status-${student.id}" id="p-${student.id}" value="Present" checked>
                                <label class="btn btn-outline-success btn-sm" for="p-${student.id}">P</label>

                                <input type="radio" class="btn-check" name="status-${student.id}" id="a-${student.id}" value="Absent">
                                <label class="btn btn-outline-danger btn-sm" for="a-${student.id}">A</label>

                                <input type="radio" class="btn-check" name="status-${student.id}" id="l-${student.id}" value="Leave">
                                <label class="btn btn-outline-warning btn-sm" for="l-${student.id}">L</label>
                            </div>
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm" placeholder="Optional remark" id="remark-${student.id}">
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            } catch (error) {
                console.error('Error loading students:', error);
                showToast('Error loading students', 'error');
            }
        }

        async function submitAttendance() {
            const classId = document.getElementById('classSelect').value;
            const subjectId = document.getElementById('subjectSelect').value;
            const date = document.getElementById('dateSelect').value;
            const rows = document.querySelectorAll('.student-row');
            
            if (rows.length === 0) return;

            const attendance = [];
            rows.forEach(row => {
                const studentId = row.dataset.id;
                const status = row.querySelector(`input[name="status-${studentId}"]:checked`).value;
                const remark = document.getElementById(`remark-${studentId}`).value;
                attendance.push({
                    user_id: studentId,
                    subject_id: subjectId,
                    school_class_id: classId,
                    date: date,
                    status: status,
                    remarks: remark
                });
            });

            try {
                const result = await saveAttendanceBatch(attendance);
                if (result.success) {
                    showToast('Attendance submitted successfully!', 'success');
                    const user = getCurrentUser();
                    if (typeof logActivity === 'function') {
                        logActivity('Attendance', `Marked attendance for ${document.getElementById('classSelect').options[document.getElementById('classSelect').selectedIndex].text}`, user.name, user.role);
                    }
                    document.getElementById('studentListCard').style.display = 'none';
                } else {
                    showToast(result.message || 'Failed to submit attendance', 'error');
                }
            } catch (error) {
                console.error('Error submitting attendance:', error);
                showToast('An error occurred during submission', 'error');
            }
        }

        function viewHistory() {
            showToast('History view is being updated to use API', 'info');
        }

        function closeHistory() {
            document.getElementById('historyCard').style.display = 'none';
        }

        function markAll(status) {
            const radios = document.querySelectorAll(`input[value="${status}"]`);
            radios.forEach(radio => radio.checked = true);
            showToast(`Marked all as ${status}`, 'info');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/auth.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
