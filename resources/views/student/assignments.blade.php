<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Assignments - Student Portal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body class="dashboard-body">

    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="{{ url('/') }}" class="sidebar-brand">
                <i class="fas fa-university"></i>
                <span>Lumina Academy</span>
            </a>
        </div>

        <nav class="sidebar-menu">
            <ul class="list-unstyled">
                <li class="sidebar-menu-item"><a href="dashboard.html" class="sidebar-link"><i
                            class="fas fa-home"></i><span>Dashboard</span></a></li>
                <li class="sidebar-menu-item"><a href="profile.html" class="sidebar-link"><i
                            class="fas fa-user"></i><span>My Profile</span></a></li>
                <li class="sidebar-menu-item"><a href="subjects.html" class="sidebar-link"><i
                            class="fas fa-book"></i><span>Subjects</span></a></li>
                <li class="sidebar-menu-item"><a href="timetable.html" class="sidebar-link"><i
                            class="fas fa-calendar-alt"></i><span>Time Table</span></a></li>
                <li class="sidebar-menu-item"><a href="attendance.html" class="sidebar-link"><i
                            class="fas fa-user-check"></i><span>Attendance</span></a></li>
                <li class="sidebar-menu-item"><a href="results.html" class="sidebar-link"><i
                            class="fas fa-chart-bar"></i><span>Results</span></a></li>
                <li class="sidebar-menu-item"><a href="assignments.html" class="sidebar-link active"><i
                            class="fas fa-tasks"></i><span>Assignments</span></a></li>
                <li class="sidebar-menu-item"><a href="quizzes.html" class="sidebar-link"><i
                            class="fas fa-question-circle"></i><span>Quizzes</span></a></li>
                <li class="sidebar-menu-item"><a href="notes.html" class="sidebar-link"><i
                            class="fas fa-file-pdf"></i><span>Notes & PDFs</span></a></li>
                <li class="sidebar-menu-item"><a href="lectures.html" class="sidebar-link"><i
                            class="fas fa-video"></i><span>Lecture Videos</span></a></li>
                <li class="sidebar-menu-item"><a href="announcements.html" class="sidebar-link"><i
                            class="fas fa-bullhorn"></i><span>Announcements</span></a></li>
                <li class="sidebar-menu-item"><a href="fees.html" class="sidebar-link"><i
                            class="fas fa-dollar-sign"></i><span>Fee Details</span></a></li>
                <li class="sidebar-menu-item"><a href="fines.html" class="sidebar-link"><i
                            class="fas fa-exclamation-triangle"></i><span>Fine Details</span></a></li>
                <li class="sidebar-menu-item"><a href="fee-vouchers.html" class="sidebar-link"><i
                            class="fas fa-receipt"></i><span>Fee Vouchers</span></a></li>
            </ul>
        </nav>

        <div class="sidebar-footer p-3 mt-auto">
            <button class="btn btn-outline-light w-100" onclick="logout()">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </button>
        </div>
    </aside>

    <main class="main-content">
        <nav class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="btn btn-link text-dark d-lg-none me-3" id="sidebarToggle">
                    <i class="fas fa-bars fs-4"></i>
                </button>
                <h1 class="page-title mb-0">Assignments</h1>
            </div>

            <div class="user-menu">
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

                <div class="user-avatar"><span class="user-name">JD</span></div>
                <div class="d-none d-md-block ms-3">
                    <div class="fw-bold user-name">John Doe</div>
                    <div class="small text-muted student-class">Class 10-A</div>
                </div>
            </div>
        </nav>

        <div class="dashboard-content">
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card-modern animate-fade-in border-start border-warning border-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-muted mb-1">Pending</p>
                                    <h3 class="fw-bold mb-0">1</h3>
                                </div>
                                <i class="fas fa-clock fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-modern animate-fade-in border-start border-info border-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-muted mb-1">Submitted</p>
                                    <h3 class="fw-bold mb-0">1</h3>
                                </div>
                                <i class="fas fa-upload fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-modern animate-fade-in border-start border-success border-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-muted mb-1">Graded</p>
                                    <h3 class="fw-bold mb-0">1</h3>
                                </div>
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-modern animate-fade-in border-start border-primary border-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-muted mb-1">Avg. Score</p>
                                    <h3 class="fw-bold mb-0">80%</h3>
                                </div>
                                <i class="fas fa-chart-line fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-modern animate-fade-in mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" id="searchAssignments"
                                    placeholder="Search assignments...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterSubject">
                                <option value="">All Subjects</option>
                                <option value="Mathematics">Mathematics</option>
                                <option value="Physics">Physics</option>
                                <option value="Chemistry">Chemistry</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterStatus">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="submitted">Submitted</option>
                                <option value="graded">Graded</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" onclick="filterAssignments()">
                                <i class="fas fa-filter me-2"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="assignmentsList">
            </div>
        </div>
    </main>

    <div class="modal fade" id="submitModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-upload me-2"></i> Submit Assignment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="submitForm">
                        <input type="hidden" id="assignmentId">
                        <div class="mb-3">
                            <label class="form-label">Assignment Title</label>
                            <input type="text" class="form-control" id="assignmentTitle" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload File</label>
                            <input type="file" class="form-control" id="assignmentFile" accept=".pdf,.doc,.docx">
                            <small class="text-muted">Accepted formats: PDF, DOC, DOCX (Max: 5MB)</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Comments (Optional)</label>
                            <textarea class="form-control" rows="3" id="assignmentComments"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="handleAssignmentSubmission()">
                        <i class="fas fa-check me-2"></i> Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('assets/js/auth.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/data.js') }}"></script>
    <script src="{{ asset('assets/js/storage.js') }}"></script>
    <script src="{{ asset('assets/js/notifications.js') }}"></script>
    <script src="{{ asset('assets/js/search.js') }}"></script>
    <script src="{{ asset('assets/js/enhancements.js') }}"></script>
    <script src="{{ asset('assets/js/charts.js') }}"></script>
    <script src="{{ asset('assets/js/activity-functions.js') }}"></script>
    <script src="{{ asset('assets/js/assignment-functions.js') }}"></script>

    <script>
        protectPage('student');

        document.addEventListener('DOMContentLoaded', function () {
            initDashboardUser();
            loadAssignments();
        });

        async function loadAssignments() {
            const container = document.getElementById('assignmentsList');
            container.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>';
            
            try {
                const [assignmentsRes, submissionsRes] = await Promise.all([
                    fetch('/api/content?type=assignment'),
                    fetch('/api/submissions')
                ]);

                const assignments = await assignmentsRes.json();
                const submissions = await submissionsRes.json();

                container.innerHTML = '';

                if (assignments.length === 0) {
                    container.innerHTML = '<p class="text-center text-muted py-5">No assignments assigned to your class yet.</p>';
                    return;
                }

                assignments.forEach(assignment => {
                    const submission = submissions.find(s => s.school_content_id === assignment.id);
                    const isOverdue = new Date(assignment.due_date) < new Date() && !submission;
                    
                    let status = 'pending';
                    let statusClass = 'warning';
                    let statusText = '<i class="fas fa-clock me-2"></i> Pending';
                    let marks = null;

                    if (submission) {
                        status = submission.status;
                        if (status === 'submitted') {
                            statusClass = 'info';
                            statusText = '<i class="fas fa-upload me-2"></i> Submitted';
                        } else if (status === 'graded') {
                            statusClass = 'success';
                            statusText = '<i class="fas fa-check-circle me-2"></i> Graded';
                            marks = submission.marks_obtained;
                        }
                    } else if (isOverdue) {
                        statusClass = 'danger';
                        statusText = '<i class="fas fa-exclamation-triangle me-2"></i> Overdue';
                    }

                    const div = document.createElement('div');
                    div.className = 'card border-0 shadow-sm mb-3';
                    div.innerHTML = `
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-lg-7">
                                        <h5 class="fw-bold mb-2">${assignment.title}</h5>
                                        <p class="text-muted mb-2">${assignment.description || 'No description'}</p>
                                        <div class="d-flex flex-wrap gap-3">
                                            <small><i class="fas fa-book text-primary me-1"></i> ${assignment.subject ? assignment.subject.name : 'Unknown'}</small>
                                            <small><i class="fas fa-user text-success me-1"></i> ${assignment.author ? assignment.author.name : 'Teacher'}</small>
                                            <small><i class="fas fa-calendar text-info me-1"></i> Due: ${new Date(assignment.due_date).toLocaleDateString()}</small>
                                            ${isOverdue ? '<small class="text-danger"><i class="fas fa-exclamation-triangle me-1"></i> Overdue</small>' : ''}
                                        </div>
                                    </div>
                                    <div class="col-lg-3 mt-3 mt-lg-0">
                                        <span class="badge bg-${statusClass} px-3 py-2 w-100">${statusText}</span>
                                        ${marks !== null ? `
                                            <div class="mt-2 text-center">
                                                <strong class="text-success">${marks}/100</strong>
                                                <small class="text-muted d-block">Marks Obtained</small>
                                            </div>
                                        ` : ''}
                                    </div>
                                    <div class="col-lg-2 mt-3 mt-lg-0 text-end">
                                        ${status === 'pending' || (status === 'overdue' && !submission) ? `
                                            <button class="btn btn-primary btn-sm w-100" onclick="openSubmitModal(${assignment.id}, '${assignment.title}')">
                                                <i class="fas fa-upload me-2"></i> Submit
                                            </button>
                                        ` : `
                                            <button class="btn btn-outline-primary btn-sm w-100" onclick="viewSubmission(${assignment.id})">
                                                <i class="fas fa-eye me-2"></i> View
                                            </button>
                                        `}
                                    </div>
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

        function openSubmitModal(id, title) {
            document.getElementById('assignmentId').value = id;
            document.getElementById('assignmentTitle').value = title;
            new bootstrap.Modal(document.getElementById('submitModal')).show();
        }

        async function handleAssignmentSubmission() {
            const fileInput = document.getElementById('assignmentFile');
            const file = fileInput.files[0];
            const comments = document.getElementById('assignmentComments').value;
            const assignmentId = document.getElementById('assignmentId').value;

            if (!file) {
                showToast('Please select a file to upload', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('file', file);
            formData.append('comments', comments);
            formData.append('assignment_id', assignmentId);

            try {
                const response = await fetch('/api/submissions', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    showToast('Assignment submitted successfully!', 'success');
                    bootstrap.Modal.getInstance(document.getElementById('submitModal')).hide();
                    loadAssignments();
                } else {
                    showToast(result.message || 'Failed to submit assignment', 'error');
                }
            } catch (error) {
                console.error('Error submitting assignment:', error);
                showToast('An error occurred during submission', 'error');
            }
        }

        function viewSubmission(assignmentId) {
            showToast('Viewing submission details...', 'info');
        }

        function filterAssignments() {
            loadAssignments();
        }
    </script>
</body>

</html>

