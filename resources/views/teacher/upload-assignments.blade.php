<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Upload Assignments - Teacher Portal</title>

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
                <li class="sidebar-menu-item"><a href="{{ route('teacher.dashboard') }}" class="sidebar-link"><i
                            class="fas fa-home"></i><span>Dashboard</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/marks-input') }}" class="sidebar-link"><i
                            class="fas fa-edit"></i><span>Marks Input</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/remarks') }}" class="sidebar-link"><i
                            class="fas fa-comments"></i><span>Student Remarks</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/upload-assignments') }}" class="sidebar-link active"><i
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
                <h1 class="page-title mb-0">Upload Assignments</h1>
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
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card-modern animate-fade-in shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-plus-circle me-2"></i> Create New
                                Assignment</h5>
                        </div>
                        <div class="card-body p-4">
                            <form id="uploadAssignmentForm" onsubmit="handleAssignmentUpload(event)">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Assignment Title</label>
                                    <input type="text" class="form-control bg-light border-0" id="assignmentTitle" required
                                        placeholder="e.g., Chapter 5 Practice Problems">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Detailed Instructions</label>
                                    <textarea class="form-control bg-light border-0" id="assignmentDescription" rows="4" required
                                        placeholder="Specify what students need to do..."></textarea>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Target Class</label>
                                        <select class="form-select bg-light border-0" id="classSelect" required>
                                            <option value="">Choose...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Subject</label>
                                        <select class="form-select bg-light border-0" id="subjectSelect" required>
                                            <option value="">Choose...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Submission Deadline</label>
                                        <input type="date" class="form-control bg-light border-0" id="dueDate" required>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Resource Materials (Max 10MB)</label>
                                    <input type="file" class="form-control bg-light border-0" id="assignmentFile" accept=".pdf,.doc,.docx">
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-2 lift fw-bold">
                                    <i class="fas fa-paper-plane me-2"></i> Publish Assignment
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card-modern animate-fade-in shadow-lg">
                        <div
                            class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-list me-2 text-success"></i> Posted
                                Assignments</h5>
                            <div class="d-flex align-items-center gap-2">
                                <input type="text" class="form-control form-control-sm" id="assignmentSearch"
                                    placeholder="Search assignments..." style="max-width: 200px;"
                                    oninput="filterAssignments()">
                                <span class="badge rounded-pill bg-light text-dark px-3"
                                    id="assignmentCountDisplay">0
                                    Total</span>
                            </div>
                        </div>
                        <div class="card-body p-4" style="max-height: 600px; overflow-y: auto;"
                            id="teacherAssignmentList">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="submissionsModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white py-3">
                    <h5 class="modal-title fw-bold text-white" id="subModalTitle">Submissions</h5>
                    <div class="d-flex align-items-center gap-2">
                        <input type="text" class="form-control form-control-sm" id="submissionSearch"
                            placeholder="Search student..." style="max-width: 200px;" oninput="filterSubmissions()">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                </div>
                <div class="modal-body p-0" id="subModalBody"></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/auth.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/data.js') }}"></script>
    <script src="{{ asset('assets/js/notifications.js') }}"></script>
    <script src="{{ asset('assets/js/storage.js') }}"></script>
    <script src="{{ asset('assets/js/search.js') }}"></script>
    <script src="{{ asset('assets/js/enhancements.js') }}"></script>
    <script src="{{ asset('assets/js/activity-functions.js') }}"></script>
    <script src="{{ asset('assets/js/class-functions.js') }}"></script>
    <script src="{{ asset('assets/js/assignment-functions.js') }}"></script>
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

            loadTeacherAssignments();
        });

        async function handleAssignmentUpload(event) {
            event.preventDefault();
            
            const title = document.getElementById('assignmentTitle').value;
            const description = document.getElementById('assignmentDescription').value;
            const classId = document.getElementById('classSelect').value;
            const subjectId = document.getElementById('subjectSelect').value;
            const dueDate = document.getElementById('dueDate').value;
            const file = document.getElementById('assignmentFile').files[0];

            if (!title || !classId || !subjectId || !dueDate) {
                showToast('Please fill all required fields', 'warning');
                return;
            }

            const formData = new FormData();
            formData.append('title', title);
            formData.append('description', description);
            formData.append('type', 'assignment');
            formData.append('school_class_id', classId);
            formData.append('subject_id', subjectId);
            formData.append('due_date', dueDate);
            if (file) formData.append('file', file);

            try {
                const response = await fetch('/api/content', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    showToast('Assignment uploaded successfully!', 'success');
                    document.getElementById('uploadAssignmentForm').reset();
                    loadTeacherAssignments();
                } else {
                    showToast(result.message || 'Upload failed', 'error');
                }
            } catch (error) {
                console.error('Error uploading assignment:', error);
                showToast('An error occurred during upload', 'error');
            }
        }

        async function loadTeacherAssignments() {
            const container = document.getElementById('teacherAssignmentList');
            const countDisplay = document.getElementById('assignmentCountDisplay');
            container.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary"></div></div>';

            try {
                const [contentRes, submissionsRes] = await Promise.all([
                    fetch('/api/content?type=assignment').then(r => r.json()),
                    fetch('/api/submissions').then(r => r.json())
                ]);

                container.innerHTML = '';
                countDisplay.innerText = `${contentRes.length} Total`;

                if (contentRes.length === 0) {
                    container.innerHTML = '<div class="text-center py-5"><i class="fas fa-folder-open fa-3x text-light mb-3"></i><p class="text-muted">No assignments created yet.</p></div>';
                    return;
                }

                contentRes.forEach(a => {
                    const subCount = submissionsRes.filter(s => s.school_content_id === a.id).length;
                    const isLate = new Date(a.due_date) < new Date();

                    const div = document.createElement('div');
                    div.className = 'card-modern mb-3 p-3 animate-fade-in lift';
                    div.innerHTML = `
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">${a.title}</h6>
                                <p class="text-muted small mb-0"><i class="fas fa-users me-1"></i> ${a.school_class ? a.school_class.name : 'Unknown'} � <i class="fas fa-book me-1"></i> ${a.subject ? a.subject.name : 'Unknown'}</p>
                            </div>
                            <span class="badge-modern bg-${isLate ? 'danger' : 'warning'}-subtle text-${isLate ? 'danger' : 'warning'} fw-bold">
                                ${isLate ? 'Deadline Passed' : 'Due: ' + new Date(a.due_date).toLocaleDateString()}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <div class="d-flex align-items-center">
                                <span class="badge rounded-pill bg-info-subtle text-info fw-bold py-2 px-3">
                                    <i class="fas fa-file-alt me-1"></i> ${subCount} Submissions
                                </span>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-success lift me-2" onclick="viewSubmissions(${a.id})" title="View Submissions">
                                    <i class="fas fa-users"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger lift" onclick="deleteAssignmentClick(${a.id})" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    `;
                    container.appendChild(div);
                });
            } catch (error) {
                console.error('Error loading assignments:', error);
                container.innerHTML = '<div class="alert alert-danger">Error loading assignments.</div>';
            }
        }

        async function deleteAssignmentClick(id) {
            if (!confirm('Delete this assignment?')) return;

            try {
                const response = await fetch(`/api/content/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    showToast('Assignment deleted', 'success');
                    loadTeacherAssignments();
                } else {
                    showToast(result.message || 'Delete failed', 'error');
                }
            } catch (error) {
                console.error('Error deleting assignment:', error);
                showToast('An error occurred during deletion', 'error');
            }
        }

        function viewSubmissions(id) {
            showToast('Submission management is coming soon', 'info');
        }
    </script>
</body>

</html>

