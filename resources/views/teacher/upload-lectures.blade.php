<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Upload Lectures - Teacher Portal</title>

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
                <li class="sidebar-menu-item"><a href="{{ url('teacher/upload-assignments') }}" class="sidebar-link"><i
                            class="fas fa-upload"></i><span>Upload Assignments</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/upload-notes') }}" class="sidebar-link"><i
                            class="fas fa-file-upload"></i><span>Upload Notes</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/upload-lectures') }}" class="sidebar-link active"><i
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
                <h1 class="page-title mb-0">Video Lectures</h1>
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
            <div class="card-modern animate-fade-in mb-4 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-video-camera me-2"></i> Publish New Lecture
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form id="uploadLecturesForm" onsubmit="handleLectureUpload(event)">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold font-sm">Lecture Title</label>
                                <input type="text" class="form-control bg-light border-0 py-2" id="lectureTitle" required
                                    placeholder="e.g., Intro to Algebra">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold font-sm">Assign to Class</label>
                                <select class="form-select bg-light border-0 py-2" id="classSelect" required>
                                    <option value="">Choose...</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold font-sm">Subject</label>
                                <select class="form-select bg-light border-0 py-2" id="subjectSelect" required>
                                    <option value="">Choose...</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-bold font-sm">Video URL (YouTube Embed Link)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i
                                            class="fab fa-youtube text-danger"></i></span>
                                    <input type="url" class="form-control bg-light border-0 py-2" id="lectureUrl" required
                                        placeholder="https://www.youtube.com/embed/...">
                                </div>
                                <small class="text-muted">Tip: Copy the 'Embed' URL from YouTube's Share menu.</small>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold font-sm">Lecture Duration (Optional)</label>
                                <input type="text" class="form-control bg-light border-0 py-2" id="lectureDescription"
                                    placeholder="e.g. 45 mins or description">
                            </div>
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary px-5 py-2 lift fw-bold">
                                    <i class="fas fa-plus-circle me-2"></i> Add to Lecture List
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-modern animate-fade-in shadow-lg">
                <div
                    class="card-header bg-white border-0 py-4 px-4 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-play-circle me-2 text-success"></i> Broadcasted
                        Lectures</h5>
                    <div class="badge-modern bg-light text-dark px-3 py-2" id="lectureCountDisplay">0 Lectures</div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase fw-bold">
                                <tr>
                                    <th class="ps-4">Lecture Info</th>
                                    <th class="text-center">Target Class</th>
                                    <th class="text-center">Subject</th>
                                    <th class="text-center">Runtime</th>
                                    <th class="text-center">Date Added</th>
                                    <th class="pe-4 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="lectureTableBody"></tbody>
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
    <script src="{{ asset('assets/js/activity-functions.js') }}"></script>
    <script src="{{ asset('assets/js/lectures-functions.js') }}"></script>
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

            loadTeacherLectures();
        });

        async function handleLectureUpload(event) {
            event.preventDefault();
            
            const title = document.getElementById('lectureTitle').value;
            const classId = document.getElementById('classSelect').value;
            const subjectId = document.getElementById('subjectSelect').value;
            const url = document.getElementById('lectureUrl').value;
            const description = document.getElementById('lectureDescription').value;

            if (!title || !classId || !subjectId || !url) {
                showToast('Please fill all required fields', 'warning');
                return;
            }

            try {
                const response = await fetch('/api/content', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        title,
                        description,
                        type: 'lecture',
                        school_class_id: classId,
                        subject_id: subjectId,
                        video_url: url
                    })
                });

                const result = await response.json();

                if (result.success) {
                    showToast('Lecture published successfully!', 'success');
                    document.getElementById('uploadLecturesForm').reset();
                    loadTeacherLectures();
                } else {
                    showToast(result.message || 'Publish failed', 'error');
                }
            } catch (error) {
                console.error('Error publishing lecture:', error);
                showToast('An error occurred during publishing', 'error');
            }
        }

        async function loadTeacherLectures() {
            const tbody = document.getElementById('lectureTableBody');
            const countDisplay = document.getElementById('lectureCountDisplay');
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-5"><div class="spinner-border text-primary"></div></td></tr>';

            try {
                const contentRes = await fetch('/api/content?type=lecture').then(r => r.json());

                tbody.innerHTML = '';
                countDisplay.innerText = `${contentRes.length} Lectures`;

                if (contentRes.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" class="text-center py-5 text-muted">No lectures added yet. Publish your first video lecture above!</td></tr>';
                    return;
                }

                contentRes.forEach(l => {
                    const tr = document.createElement('tr');
                    tr.className = 'animate-fade-in';
                    tr.innerHTML = `
                        <td class="ps-4">
                            <div class="fw-bold text-dark">${l.title}</div>
                            <small class="text-muted truncate-text" style="max-width: 200px; display: block;">${l.video_url}</small>
                        </td>
                        <td class="text-center"><span class="badge bg-light text-dark">${l.school_class ? l.school_class.name : 'Unknown'}</span></td>
                        <td class="text-center text-muted">${l.subject ? l.subject.name : 'Unknown'}</td>
                        <td class="text-center small">${l.description || 'N/A'}</td>
                        <td class="text-center text-muted small">${new Date(l.created_at).toLocaleDateString()}</td>
                        <td class="pe-4 text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-primary me-1" onclick="previewLecture('${l.video_url}')">
                                    <i class="fas fa-play"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteLectureClick(${l.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            } catch (error) {
                console.error('Error loading lectures:', error);
                tbody.innerHTML = '<tr><td colspan="6" class="text-center py-5 text-danger">Error loading lectures.</td></tr>';
            }
        }

        async function deleteLectureClick(id) {
            if (!confirm('Delete this lecture?')) return;

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
                    showToast('Lecture deleted', 'success');
                    loadTeacherLectures();
                } else {
                    showToast(result.message || 'Delete failed', 'error');
                }
            } catch (error) {
                console.error('Error deleting lecture:', error);
                showToast('An error occurred during deletion', 'error');
            }
        }

        function previewLecture(url) {
            if (url) window.open(url, '_blank');
            else showToast('Video URL not found', 'warning');
        }
    </script>
</body>

</html>

