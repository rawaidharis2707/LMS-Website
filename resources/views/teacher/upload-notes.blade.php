<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Notes - Teacher Portal</title>

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
                <li class="sidebar-menu-item"><a href="{{ url('teacher/upload-notes.html') }}" class="sidebar-link active"><i
                            class="fas fa-file-upload"></i><span>Upload Notes</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/upload-lectures.html') }}" class="sidebar-link"><i
                            class="fas fa-video"></i><span>Upload Lectures</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/create-quiz.html') }}" class="sidebar-link"><i
                            class="fas fa-plus-circle"></i><span>Create Quiz</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/attendance-input.html') }}" class="sidebar-link"><i
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
                <h1 class="page-title mb-0">Notes & Study Material</h1>
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
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-cloud-upload-alt me-2"></i> Upload Study
                        Material</h5>
                </div>
                <div class="card-body p-4">
                    <form id="uploadNotesForm" onsubmit="handleNotesUpload(event)">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Title</label>
                                <input type="text" class="form-control bg-light border-0" id="noteTitle" required
                                    placeholder="e.g., Chapter 5 Notes">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Target Class</label>
                                <select class="form-select bg-light border-0" id="classSelect" required>
                                    <option value="">Choose...</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Subject</label>
                                <select class="form-select bg-light border-0" id="subjectSelect" required>
                                    <option value="">Choose...</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Choose File (PDF, PPT, DOC)</label>
                                <div
                                    class="upload-zone p-4 bg-light rounded text-center border-dashed position-relative">
                                    <input type="file" id="noteFile"
                                        class="form-control position-absolute opacity-0 w-100 h-100 top-0 start-0"
                                        accept=".pdf,.doc,.docx,.ppt,.pptx" required style="cursor: pointer;">
                                    <div class="upload-preview">
                                        <i class="fas fa-file-upload fa-3x text-primary mb-2"></i>
                                        <p class="mb-0 text-muted">Click or drag file here to upload</p>
                                        <small class="text-light">Max file size: 20MB</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-4 text-end">
                                <button type="submit" class="btn btn-primary px-5 lift fw-bold">
                                    <i class="fas fa-check-circle me-2"></i> Securely Upload Material
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-modern animate-fade-in shadow-lg">
                <div
                    class="card-header bg-white border-0 py-4 px-4 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-folder-open me-2 text-success"></i> Distributed
                        Resources
                    </h5>
                    <div class="input-group" style="max-width: 250px;">
                        <span class="input-group-text bg-light border-0"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control bg-light border-0" placeholder="Filter materials..."
                            id="tableFilter">
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Detail</th>
                                    <th class="text-center">Class</th>
                                    <th class="text-center">Subject</th>
                                    <th class="text-center">File link</th>
                                    <th class="text-center">Date</th>
                                    <th class="pe-4 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="notesTableBody"></tbody>
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
    <script src="{{ asset('assets/js/activity-functions.js') }}"></script>
    <script src="{{ asset('assets/js/notes-functions.js') }}"></script>
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

            loadTeacherNotes();
        });

        async function handleNotesUpload(event) {
            event.preventDefault();
            
            const title = document.getElementById('noteTitle').value;
            const classId = document.getElementById('classSelect').value;
            const subjectId = document.getElementById('subjectSelect').value;
            const file = document.getElementById('noteFile').files[0];

            if (!title || !classId || !subjectId || !file) {
                showToast('Please fill all required fields', 'warning');
                return;
            }

            const formData = new FormData();
            formData.append('title', title);
            formData.append('type', 'note');
            formData.append('school_class_id', classId);
            formData.append('subject_id', subjectId);
            formData.append('file', file);

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
                    showToast('Study material uploaded successfully!', 'success');
                    document.getElementById('uploadNotesForm').reset();
                    loadTeacherNotes();
                } else {
                    showToast(result.message || 'Upload failed', 'error');
                }
            } catch (error) {
                console.error('Error uploading note:', error);
                showToast('An error occurred during upload', 'error');
            }
        }

        async function loadTeacherNotes() {
            const tbody = document.getElementById('notesTableBody');
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-5"><div class="spinner-border text-primary"></div></td></tr>';

            try {
                const contentRes = await fetch('/api/content?type=note').then(r => r.json());

                tbody.innerHTML = '';

                if (contentRes.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" class="text-center py-5 text-muted">No materials found. Upload your first study guide above!</td></tr>';
                    return;
                }

                contentRes.forEach(note => {
                    const tr = document.createElement('tr');
                    tr.className = 'animate-fade-in';
                    const fileName = note.file_path ? note.file_path.split('/').pop() : 'N/A';
                    const fileType = fileName.split('.').pop().toUpperCase();
                    const fileColor = getFileColor(fileType);
                    const fileIcon = getFileIcon(fileType);

                    tr.innerHTML = `
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-${fileColor}-subtle text-${fileColor} rounded p-2 me-3">
                                    <i class="fas fa-file-${fileIcon} fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">${note.title}</h6>
                                    <p class="text-muted small mb-0">${fileName}</p>
                                </div>
                            </div>
                        </td>
                        <td class="text-center"><span class="badge-modern bg-light text-dark">${note.school_class ? note.school_class.name : 'Unknown'}</span></td>
                        <td class="text-center text-muted">${note.subject ? note.subject.name : 'Unknown'}</td>
                        <td class="text-center">
                            <span class="badge-modern bg-${fileColor}-subtle text-${fileColor} fw-bold">
                                ${fileType}
                            </span>
                        </td>
                        <td class="text-center text-muted small">${formatDate(note.created_at)}</td>
                        <td class="pe-4 text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-primary lift me-2" onclick="viewFile('${note.file_path}')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger lift" onclick="deleteNoteClick(${note.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            } catch (error) {
                console.error('Error loading notes:', error);
                tbody.innerHTML = '<tr><td colspan="6" class="text-center py-5 text-danger">Error loading notes.</td></tr>';
            }
        }

        async function deleteNoteClick(id) {
            if (!confirm('Delete this material?')) return;

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
                    showToast('Material deleted', 'success');
                    loadTeacherNotes();
                } else {
                    showToast(result.message || 'Delete failed', 'error');
                }
            } catch (error) {
                console.error('Error deleting note:', error);
                showToast('An error occurred during deletion', 'error');
            }
        }

        function viewFile(path) {
            if (path) window.open('/storage/' + path, '_blank');
            else showToast('File path not found', 'warning');
        }

        function getFileColor(type) {
            if (type.includes('PDF')) return 'danger';
            if (type.includes('DOC')) return 'primary';
            if (type.includes('PPT')) return 'warning';
            return 'secondary';
        }

        function getFileIcon(type) {
            if (type.includes('PDF')) return 'pdf';
            if (type.includes('DOC')) return 'word';
            if (type.includes('PPT')) return 'powerpoint';
            return 'alt';
        }

        function formatDate(dateStr) {
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return new Date(dateStr).toLocaleDateString('en-US', options);
        }
    </script>
</body>

</html>

