<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Marks Input - Teacher Portal</title>

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
                <li class="sidebar-menu-item"><a href="{{ url('teacher/dashboard') }}" class="sidebar-link"><i
                            class="fas fa-home"></i><span>Dashboard</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/marks-input') }}" class="sidebar-link active"><i
                            class="fas fa-edit"></i><span>Marks Input</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/remarks') }}" class="sidebar-link"><i
                            class="fas fa-comments"></i><span>Student Remarks</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/upload-assignments') }}" class="sidebar-link"><i
                            class="fas fa-upload"></i><span>Upload Assignments</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/upload-notes') }}" class="sidebar-link"><i
                            class="fas fa-file-upload"></i><span>Upload Notes</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/upload-lectures') }}" class="sidebar-link"><i
                            class="fas fa-video"></i><span>Upload Lectures</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/create-quiz') }}" class="sidebar-link"><i
                            class="fas fa-plus-circle"></i><span>Create Quiz</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/attendance-input') }}" class="sidebar-link"><i
                            class="fas fa-check-square"></i><span>Attendance Input</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/my-attendance') }}" class="sidebar-link"><i
                            class="fas fa-calendar-check"></i><span>My Attendance</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/timetable') }}" class="sidebar-link"><i
                            class="fas fa-calendar-alt"></i><span>Timetable</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/announcements') }}" class="sidebar-link"><i
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
                <h1 class="page-title mb-0">Marks Input</h1>
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
                            <select class="form-select bg-light border-0" id="classSelect">
                                <option value="">Choose class...</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Select Subject</label>
                            <select class="form-select bg-light border-0" id="subjectSelect">
                                <option value="">Choose subject...</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Exam Type</label>
                            <select class="form-select bg-light border-0" id="examSelect">
                                <option value="">Choose exam...</option>
                                <option value="Mid-Term">Mid-Term Exam</option>
                                <option value="Final">Final Exam</option>
                                <option value="Quiz">Quiz</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Action</label>
                            <button class="btn btn-primary w-100 lift fw-bold" onclick="loadClassStudents()"
                                style="height: 38px; padding: 0.375rem 0.75rem;">
                                <i class="fas fa-search me-2"></i> Fetch Roll List
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="studentsListContainer" class="mt-4">
                <div class="text-center text-muted py-5">
                    <i class="fas fa-edit fa-3x mb-3"></i>
                    <p>Select Class, Subject and Exam Type to input marks</p>
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
    <script src="{{ asset('assets/js/attendance-functions.js') }}"></script>
    <script src="{{ asset('assets/js/marks-functions.js') }}"></script>
    <script src="{{ asset('assets/js/subject-assignment-functions.js') }}"></script>
    <script src="{{ asset('assets/js/class-functions.js') }}"></script>
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
        });

        async function loadClassStudents() {
            const classId = document.getElementById('classSelect').value;
            const subjectId = document.getElementById('subjectSelect').value;
            const examVal = document.getElementById('examSelect').value;

            if (!classId || !subjectId || !examVal) {
                showToast('Please select Class, Subject and Exam Type', 'warning');
                return;
            }

            const container = document.getElementById('studentsListContainer');
            container.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary"></div></div>';

            try {
                const [studentsRes, marks] = await Promise.all([
                    fetch(`/api/students?class_id=${classId}`).then(r => r.json()),
                    getAllMarks()
                ]);

                if (studentsRes.length === 0) {
                    container.innerHTML = '<div class="alert alert-info">No students found in this class.</div>';
                    return;
                }

                let html = `
                    <div class="card-modern shadow-lg animate-fade-in">
                        <div class="card-header bg-white py-3 border-0">
                            <h5 class="mb-0 fw-bold text-primary">
                                <i class="fas fa-users me-2"></i> Student List
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4">Roll #</th>
                                            <th>Student Name</th>
                                            <th class="text-center">Max Marks</th>
                                            <th class="text-center">Marks Obtained</th>
                                            <th class="pe-4 text-center">Percentage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                `;

                studentsRes.forEach(student => {
                    const existing = marks.find(m =>
                        m.user_id === student.id &&
                        m.exam_type === examVal &&
                        m.subject_id == subjectId
                    );

                    const existingMark = existing ? existing.marks_obtained : '';
                    const totalMarks = existing ? existing.total_marks : 100;

                    html += `
                        <tr class="student-mark-row animate-fade-in" data-id="${student.id}" data-name="${student.name}">
                            <td class="ps-4"><span class="badge-modern bg-light text-dark">${student.roll_number || 'N/A'}</span></td>
                            <td class="fw-bold text-dark">${student.name}</td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm max-marks mx-auto shadow-sm" 
                                    value="${totalMarks}" style="width: 80px; text-align: center;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm obtained-marks mx-auto shadow-sm" 
                                    value="${existingMark}" 
                                    placeholder="0" min="0" max="${totalMarks}" style="width: 80px; text-align: center;"
                                    oninput="updatePercentage(this)">
                            </td>
                            <td class="text-center pe-4">
                                <span class="percentage-badge badge-modern bg-info-subtle text-info fw-bold" style="min-width: 60px;">
                                    ${existingMark ? Math.round((existingMark / totalMarks) * 100) + '%' : '0%'}
                                </span>
                            </td>
                        </tr>
                    `;
                });

                html += `
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-light py-4 text-center">
                            <button class="btn btn-success btn-lg px-5 lift" onclick="saveClassMarks()">
                                <i class="fas fa-check-circle me-2"></i> Save & Post All Marks
                            </button>
                        </div>
                    </div>
                `;

                container.innerHTML = html;
            } catch (error) {
                console.error('Error loading data:', error);
                showToast('Error loading students or marks', 'error');
            }
        }

        function updatePercentage(input) {
            const row = input.closest('tr');
            const max = parseFloat(row.querySelector('.max-marks').value) || 1;
            const obtained = parseFloat(input.value) || 0;
            const percentage = Math.round((obtained / max) * 100);
            const badge = row.querySelector('.percentage-badge');
            badge.innerText = percentage + '%';

            if (percentage < 40) badge.className = 'percentage-badge badge-modern bg-danger-subtle text-danger fw-bold';
            else if (percentage < 70) badge.className = 'percentage-badge badge-modern bg-warning-subtle text-warning fw-bold';
            else badge.className = 'percentage-badge badge-modern bg-success-subtle text-success fw-bold';
        }

        async function saveClassMarks() {
            const subjectId = document.getElementById('subjectSelect').value;
            const examVal = document.getElementById('examSelect').value;

            const rows = document.querySelectorAll('.student-mark-row');
            const batchData = [];
            let isValid = true;

            rows.forEach(row => {
                const studentId = row.dataset.id;
                const studentName = row.dataset.name;
                const totalMarks = parseFloat(row.querySelector('.max-marks').value) || 0;
                const obtainedInput = row.querySelector('.obtained-marks');
                const marksObtained = parseFloat(obtainedInput.value);

                if (isNaN(marksObtained)) return;

                if (marksObtained > totalMarks) {
                    isValid = false;
                    obtainedInput.classList.add('is-invalid');
                    showToast(`Marks cannot exceed total for ${studentName}`, 'error');
                } else {
                    obtainedInput.classList.remove('is-invalid');
                    batchData.push({
                        user_id: studentId,
                        subject_id: subjectId,
                        exam_type: examVal,
                        marks_obtained: marksObtained,
                        total_marks: totalMarks
                    });
                }
            });

            if (!isValid || batchData.length === 0) {
                if (batchData.length === 0) showToast('No marks entered to save', 'warning');
                return;
            }

            try {
                const result = await saveBulkMarks(batchData);
                if (result.success) {
                    showToast(`Successfully saved marks for ${batchData.length} students`, 'success');
                    loadClassStudents();
                } else {
                    showToast(result.message || 'Failed to save marks', 'error');
                }
            } catch (error) {
                console.error('Error saving marks:', error);
                showToast('An error occurred while saving marks', 'error');
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/auth.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
