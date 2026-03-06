<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Teacher Dashboard - Lumina International Academy</title>

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
                <li class="sidebar-menu-item"><a href="{{ route('teacher.dashboard') }}" class="sidebar-link active"><i
                            class="fas fa-home"></i><span>Dashboard</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('teacher/marks-input') }}" class="sidebar-link"><i
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
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="btn btn-link text-dark d-lg-none me-3" id="sidebarToggle">
                    <i class="fas fa-bars fs-4"></i>
                </button>
                <h1 class="page-title mb-0">Teacher Dashboard</h1>
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
                            <h6 class="mb-0 fw-bold">Notifications / Alerts</h6>
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

                <div class="user-avatar"><span>SJ</span></div>
                <div class="d-none d-md-block ms-3">
                    <div class="fw-bold user-name" id="userNameDisplay">Sarah Johnson</div>
                    <div class="small text-muted" id="userRoleDisplay">Mathematics Teacher</div>
                </div>
            </div>
        </nav>

        <div class="dashboard-content px-4 py-4">
            <!-- Welcome Section -->
            <div class="card-modern border-0 shadow-lg mb-4 overflow-hidden"
                style="background: linear-gradient(135deg, #6366f1, #a855f7);">
                <div class="card-body p-5 position-relative" style="z-index: 1;">
                    <div class="row align-items-center position-relative">
                        <div class="col-lg-8">
                            <h2 class="display-5 fw-bold text-white mb-3 animate-fade-in">
                                Welcome back, <span id="welcomeName">Teacher</span>!
                            </h2>
                            <p class="text-white-50 fs-5 mb-0 animate-fade-in" style="animation-delay: 0.1s;">
                                Manage your classes, track student progress, and organize your teaching day.
                            </p>
                        </div>
                        <div class="col-lg-4 d-none d-lg-block text-end animate-fade-in position-relative"
                            style="animation-delay: 0.2s; z-index: 2;">
                            <div class="text-white">
                                <h4 class="mb-0 fw-bold text-white" id="currentDateDisplay">--:--</h4>
                                <p class="mb-0 opacity-75 small text-white" id="currentTimeDisplay">--:--</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="stat-widget-modern animate-fade-in" style="animation-delay: 0.1s;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="stat-content">
                                <p class="text-muted mb-1 text-uppercase small fw-bold">My Classes</p>
                                <h3 class="fw-bold mb-0" id="statMyClasses">{{ $stats['myClasses'] }}</h3>
                            </div>
                            <div class="stat-icon-modern gradient-success shadow-success">
                                <i class="fas fa-chalkboard"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-widget-modern animate-fade-in" style="animation-delay: 0.2s;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="stat-content">
                                <p class="text-muted mb-1 text-uppercase small fw-bold">Total Students</p>
                                <h3 class="fw-bold mb-0" id="statTotalStudents">{{ $stats['totalStudents'] }}</h3>
                            </div>
                            <div class="stat-icon-modern gradient-primary shadow-primary">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-widget-modern animate-fade-in" style="animation-delay: 0.3s;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="stat-content">
                                <p class="text-muted mb-1 text-uppercase small fw-bold">Pending Marks</p>
                                <h3 class="fw-bold mb-0">{{ $stats['pendingSubmissions'] }}</h3>
                            </div>
                            <div class="stat-icon-modern gradient-warning shadow-warning">
                                <i class="fas fa-edit"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-widget-modern animate-fade-in" style="animation-delay: 0.4s;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="stat-content">
                                <p class="text-muted mb-1 text-uppercase small fw-bold">Attendance Today</p>
                                <h3 class="fw-bold mb-0">{{ is_numeric($stats['attendanceToday']) ? $stats['attendanceToday'] . '%' : $stats['attendanceToday'] }}</h3>
                            </div>
                            <div class="stat-icon-modern gradient-info shadow-info">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card-modern animate-fade-in" style="animation-delay: 0.5s;">
                        <div
                            class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-calendar-day text-primary me-2"></i> Today's
                                Schedule</h5>
                            <button class="btn btn-sm btn-outline-primary lift"
                                onclick="window.location.href='{{ url('teacher/timetable') }}'">View Full Timetable</button>
                        </div>
                        <div class="card-body">
                            <div id="todaySchedule">
                                <!-- Dynamic Content -->
                            </div>
                        </div>
                    </div>

                    <div class="card-modern animate-fade-in mt-4" style="animation-delay: 0.6s;">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-bolt text-warning me-2"></i> Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <a href="{{ url('teacher/attendance-input') }}"
                                        class="btn btn-modern btn-outline-primary w-100 lift">
                                        <i class="fas fa-check me-2"></i> Mark Attendance
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ url('teacher/marks-input') }}" class="btn btn-modern btn-outline-success w-100 lift">
                                        <i class="fas fa-edit me-2"></i> Enter Marks
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ url('teacher/upload-notes') }}" class="btn btn-modern btn-outline-info w-100 lift">
                                        <i class="fas fa-upload me-2"></i> Upload Notes
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ url('teacher/create-quiz') }}" class="btn btn-modern btn-outline-warning w-100 lift">
                                        <i class="fas fa-plus me-2"></i> Create Quiz
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card-modern animate-fade-in" style="animation-delay: 0.7s;">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-bell text-info me-2"></i> Notifications</h5>
                        </div>
                        <div class="card-body">
                            <div id="internalAlerts">
                                <!-- Dynamic Content -->
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 text-center pb-3">
                            <a href="{{ url('teacher/announcements') }}" class="btn btn-sm btn-link text-decoration-none"
                                onmouseover="this.style.backgroundColor='#e7f3ff'; this.style.borderRadius='8px'"
                                onmouseout="this.style.backgroundColor='transparent'">View All
                                Announcements</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('assets/js/auth.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/data.js') }}"></script>
    <script src="{{ asset('assets/js/notifications.js') }}"></script>
    <script src="{{ asset('assets/js/storage.js') }}"></script>
    <script src="{{ asset('assets/js/search.js') }}"></script>
    <script src="{{ asset('assets/js/enhancements.js') }}"></script>
    <script src="{{ asset('assets/js/student-functions.js') }}"></script>
    <script src="{{ asset('assets/js/timetable-functions.js') }}"></script>
    <script src="{{ asset('assets/js/announcement-functions.js') }}"></script>
    <script src="{{ asset('assets/js/charts.js') }}"></script>
    <script>
        protectPage('teacher');
        document.addEventListener('DOMContentLoaded', function() {
            initDashboardUser();

            // Initialize Datasources
            initTimetableStorage();
            initAnnouncementStorage();
            if (typeof initStudentStorage === 'function') initStudentStorage();

            updateDateTime();
            setInterval(updateDateTime, 1000);

            // Load Dynamic Data
            loadTeacherStats();
            loadTeacherSchedule();
            loadInternalAlerts();

            // Highlight active menu item
            const currentPath = window.location.pathname.split('/').pop();
            document.querySelectorAll('.sidebar-link').forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });

        });

        function loadTeacherStats() {
            const user = getSession().userData;
            if (!user) return;

            // 1. My Classes (Unique classes from timetable)
            const timetable = getAllTimetableEntries().filter(t => t.teacher === user.name || t.teacher.includes(user.name.split(' ')[0]));
            const uniqueClasses = [...new Set(timetable.map(t => t.className))];
            document.getElementById('statMyClasses').textContent = uniqueClasses.length;

            // 2. Total Students
            let totalStudents = 0;
            if (typeof getStudentsByClass === 'function') {
                uniqueClasses.forEach(cls => {
                    const students = getStudentsByClass(cls);
                    totalStudents += students.length;
                });
            } else {
                totalStudents = uniqueClasses.length * 30;
            }
            document.getElementById('statTotalStudents').textContent = totalStudents;
        }

        function loadTeacherSchedule() {
            const user = getSession().userData;
            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const today = days[new Date().getDay()];

            const allEntries = getAllTimetableEntries();
            const todaySchedule = allEntries
                .filter(t => (t.teacher === user.name || t.teacher.includes(user.name.split(' ')[0])) && t.day === today)
                .sort((a, b) => a.period - b.period);

            const container = document.getElementById('todaySchedule');
            if (todaySchedule.length === 0) {
                container.innerHTML = '<div class="text-center py-4 text-muted border rounded bg-light"><i class="fas fa-coffee mb-2 d-block fs-3"></i>No classes scheduled for today.</div>';
                return;
            }

            let html = '';
            todaySchedule.forEach(period => {
                const timeMap = {
                    1: '08:00-09:00', 2: '09:00-10:00', 3: '10:00-11:00',
                    4: '11:00-12:00', 5: '12:00-01:00', 6: '01:00-02:00'
                };
                const time = timeMap[period.period] || `Pd ${period.period}`;

                html += `
                    <div class="d-flex mb-3 pb-3 border-bottom lift">
                        <div class="stat-icon-modern gradient-success text-white rounded p-2 text-center me-3"
                            style="min-width: 90px; height: auto;"><small class="fw-bold">${time}</small></div>
                        <div>
                            <h6 class="mb-1 fw-bold">Class ${period.className}</h6>
                            <small class="text-muted"><i class="fas fa-book me-1"></i> ${period.subject} - Room ${period.room}</small>
                        </div>
                    </div>
                `;
            });
            container.innerHTML = html;
        }

        function loadInternalAlerts() {
            const user = getSession().userData;
            const announcements = getAnnouncementsForUser('teacher', user).slice(0, 3);
            const container = document.getElementById('internalAlerts');

            if (announcements.length === 0) {
                container.innerHTML = '<div class="text-center text-muted small py-3">No new alerts.</div>';
                return;
            }

            let html = '';
            announcements.forEach(a => {
                const date = new Date(a.date).toLocaleDateString();
                html += `
                    <div class="mb-3 pb-3 border-bottom lift px-3 py-2">
                        <h6 class="mb-1 fw-bold text-truncate">${a.title}</h6>
                        <small class="text-muted d-block text-truncate">${a.content}</small>
                        <small class="text-info font-xs"><i class="far fa-clock me-1"></i> ${date}</small>
                    </div>
                `;
            });
            container.innerHTML = html;
        }

        function updateDateTime() {
            const now = new Date();
            const dateDisplay = document.getElementById('currentDateDisplay');
            const timeDisplay = document.getElementById('currentTimeDisplay');

            if (dateDisplay && timeDisplay) {
                dateDisplay.innerText = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                timeDisplay.innerText = now.toLocaleDateString([], { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            }
        }
    </script>
</body>

</html>

