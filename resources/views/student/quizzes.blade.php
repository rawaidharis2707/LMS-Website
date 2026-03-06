<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quizzes - Student Portal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body class="dashboard-body">

    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="{{ url('/') }}" class="sidebar-brand"><i class="fas fa-university"></i><span>Lumina Academy
                    LMS</span></a>
        </div>
        <nav class="sidebar-menu">
            <ul class="list-unstyled">
                <li class="sidebar-menu-item"><a href="{{ url('student/dashboard') }}" class="sidebar-link"><i
                            class="fas fa-home"></i><span>Dashboard</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('student/profile') }}" class="sidebar-link"><i
                            class="fas fa-user"></i><span>My Profile</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('student/subjects') }}" class="sidebar-link"><i
                            class="fas fa-book"></i><span>Subjects</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('student/timetable') }}" class="sidebar-link"><i
                            class="fas fa-calendar-alt"></i><span>Time Table</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('student/attendance') }}" class="sidebar-link"><i
                            class="fas fa-user-check"></i><span>Attendance</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('student/results') }}" class="sidebar-link"><i
                            class="fas fa-chart-bar"></i><span>Results</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('student/assignments') }}" class="sidebar-link"><i
                            class="fas fa-tasks"></i><span>Assignments</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('student/quizzes') }}" class="sidebar-link active"><i
                            class="fas fa-question-circle"></i><span>Quizzes</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('student/notes') }}" class="sidebar-link"><i
                            class="fas fa-file-pdf"></i><span>Notes & PDFs</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('student/lectures') }}" class="sidebar-link"><i
                            class="fas fa-video"></i><span>Lecture Videos</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('student/announcements') }}" class="sidebar-link"><i
                            class="fas fa-bullhorn"></i><span>Announcements</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('student/fees') }}" class="sidebar-link"><i
                            class="fas fa-dollar-sign"></i><span>Fee Details</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('student/fines') }}" class="sidebar-link"><i
                            class="fas fa-exclamation-triangle"></i><span>Fine Details</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('student/fee-vouchers') }}" class="sidebar-link"><i
                            class="fas fa-receipt"></i><span>Fee Vouchers</span></a></li>
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
                <button class="btn btn-link text-dark d-lg-none me-3" id="sidebarToggle"><i
                        class="fas fa-bars fs-4"></i></button>
                <h1 class="page-title mb-0">Quizzes & Tests</h1>
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
                <div class="col-md-4">
                    <div class="card-modern animate-fade-in border-start border-success border-4">
                        <div class="card-body">
                            <p class="text-muted mb-1">Completed</p>
                            <h3 class="fw-bold mb-0" id="statCompleted">0</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-modern animate-fade-in border-start border-warning border-4">
                        <div class="card-body">
                            <p class="text-muted mb-1">Available</p>
                            <h3 class="fw-bold mb-0" id="statAvailable">0</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-modern animate-fade-in border-start border-primary border-4">
                        <div class="card-body">
                            <p class="text-muted mb-1">Avg. Score</p>
                            <h3 class="fw-bold mb-0" id="statAvgScore">0%</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div id="quizzesContainer"></div>
        </div>
    </main>

    <div class="modal fade" id="quizModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quizModalTitle">Taking Quiz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="quizQuestionsBody"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="submitQuizAnswers()">Submit Quiz</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="resultModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Quiz Result</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center" id="resultModalBody"></div>
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
    <script src="{{ asset('assets/js/quiz-functions.js') }}"></script>
    <script>
        protectPage('student');

        let currentQuizId = null;
        let quizzesData = [];
        let resultsData = [];

        document.addEventListener('DOMContentLoaded', function () {
            initDashboardUser();
            loadQuizzes();
        });

        async function loadQuizzes() {
            const container = document.getElementById('quizzesContainer');
            container.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>';
            
            try {
                const [quizzesRes, resultsRes] = await Promise.all([
                    fetch('/api/quizzes'),
                    fetch('/api/quizzes/results')
                ]);

                quizzesData = await quizzesRes.json();
                resultsData = await resultsRes.json();

                container.innerHTML = '';

                if (quizzesData.length === 0) {
                    container.innerHTML = '<p class="text-center text-muted py-5">No quizzes available for your class yet.</p>';
                    return;
                }

                quizzesData.forEach(quiz => {
                    const result = resultsData.find(r => r.quiz_id === quiz.id);
                    const isOverdue = new Date(quiz.due_date) < new Date() && !result;

                    let status = result ? 'completed' : (isOverdue ? 'overdue' : 'available');
                    let statusClass = result ? 'success' : (isOverdue ? 'danger' : 'primary');
                    let statusText = result ? 'Completed' : (isOverdue ? 'Overdue' : 'Available');

                    const div = document.createElement('div');
                    div.className = 'col-md-6 col-lg-4 mb-4';
                    div.innerHTML = `
                        <div class="card-modern h-100 lift animate-fade-in">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="stat-icon-sm bg-${statusClass}-subtle text-${statusClass}">
                                        <i class="fas fa-question-circle"></i>
                                    </div>
                                    <span class="badge bg-${statusClass}">${statusText}</span>
                                </div>
                                <h5 class="fw-bold mb-2">${quiz.title}</h5>
                                <p class="text-muted small mb-3">${quiz.description || 'No description'}</p>
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="fas fa-book text-muted me-2 font-xs"></i>
                                        <span class="small fw-bold">${quiz.subject ? quiz.subject.name : 'Unknown'}</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="fas fa-clock text-muted me-2 font-xs"></i>
                                        <span class="small">${quiz.duration_minutes} Minutes</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar-alt text-muted me-2 font-xs"></i>
                                        <span class="small text-${isOverdue ? 'danger' : 'muted'}">Due: ${new Date(quiz.due_date).toLocaleDateString()}</span>
                                    </div>
                                </div>
                                ${status === 'available' ? `
                                    <button class="btn btn-primary w-100" onclick="openQuizModal(${quiz.id})">
                                        Start Quiz <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                ` : `
                                    <button class="btn btn-outline-primary w-100" onclick="showResultSummary(${quiz.id})">
                                        View Result <i class="fas fa-chart-line ms-2"></i>
                                    </button>
                                `}
                            </div>
                        </div>
                    `;
                    container.appendChild(div);
                });

                updateStats();
            } catch (error) {
                console.error('Error loading quizzes:', error);
                container.innerHTML = '<div class="alert alert-danger">Error loading quizzes.</div>';
            }
        }

        function updateStats() {
            const completedCount = resultsData.length;
            const availableCount = quizzesData.length - completedCount;
            
            let avgScore = 0;
            if (completedCount > 0) {
                const totalPercent = resultsData.reduce((acc, r) => acc + (r.score / r.total_marks), 0);
                avgScore = Math.round((totalPercent / completedCount) * 100);
            }

            document.getElementById('statCompleted').innerText = completedCount;
            document.getElementById('statAvailable').innerText = availableCount;
            document.getElementById('statAvgScore').innerText = avgScore + '%';
        }

        function openQuizModal(id) {
            currentQuizId = id;
            const quiz = quizzesData.find(q => q.id == id);
            document.getElementById('quizModalTitle').innerText = quiz.title;
            const body = document.getElementById('quizQuestionsBody');

            let html = '';
            quiz.questions.forEach((q, idx) => {
                const options = typeof q.options === 'string' ? JSON.parse(q.options) : q.options;
                html += `
                    <div class="mb-4">
                        <h6 class="fw-bold">${idx + 1}. ${q.text}</h6>
                        <div class="ms-3">
                            ${Object.keys(options).map(key => `
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="q${idx}" value="${key}" id="q${idx}${key}">
                                    <label class="form-check-label" for="q${idx}${key}">${key}) ${options[key]}</label>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            });
            body.innerHTML = html;
            new bootstrap.Modal(document.getElementById('quizModal')).show();
        }

        async function submitQuizAnswers() {
            if (!confirm("Are you sure you want to submit?")) return;

            const quiz = quizzesData.find(q => q.id == currentQuizId);
            const answers = {};

            quiz.questions.forEach((q, idx) => {
                const selected = document.querySelector(`input[name="q${idx}"]:checked`);
                if (selected) {
                    answers[idx] = selected.value;
                }
            });

            try {
                const response = await fetch(`/api/quizzes/${currentQuizId}/submit`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ answers })
                });

                const result = await response.json();

                if (result.success) {
                    bootstrap.Modal.getInstance(document.getElementById('quizModal')).hide();
                    showToast(`Quiz submitted! You scored ${result.score}/${result.total}`, 'success');
                    loadQuizzes();
                } else {
                    showToast(result.message || 'Failed to submit quiz', 'error');
                }
            } catch (error) {
                console.error('Error submitting quiz:', error);
                showToast('An error occurred during submission', 'error');
            }
        }

        function showResultSummary(quizId) {
            const result = resultsData.find(r => r.quiz_id == quizId);
            if (!result) return;

            document.getElementById('resultModalBody').innerHTML = `
                <div class="text-center p-4">
                    <h1 class="display-1 text-primary fw-bold mb-0">${result.score}</h1>
                    <p class="text-muted h4 mb-4">out of ${result.total_marks}</p>
                    <div class="badge bg-success-subtle text-success px-4 py-2 rounded-pill">
                        <i class="fas fa-check-circle me-2"></i> ${Math.round((result.score / result.total_marks) * 100)}% Correct
                    </div>
                    <p class="text-muted small mt-4">Submitted on ${new Date(result.created_at).toLocaleString()}</p>
                </div>
            `;
            new bootstrap.Modal(document.getElementById('resultModal')).show();
        }
    </script>
</body>

</html>

