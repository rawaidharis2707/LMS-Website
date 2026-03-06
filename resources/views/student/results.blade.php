<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Results - Student Portal</title>

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
                <li class="sidebar-menu-item">
                    <a href="{{ route('student.dashboard') }}" class="sidebar-link">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ url('student/profile') }}" class="sidebar-link">
                        <i class="fas fa-user"></i>
                        <span>My Profile</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ url('student/subjects') }}" class="sidebar-link">
                        <i class="fas fa-book"></i>
                        <span>Subjects</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ url('student/timetable') }}" class="sidebar-link">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Time Table</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ url('student/attendance') }}" class="sidebar-link">
                        <i class="fas fa-user-check"></i>
                        <span>Attendance</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ url('student/results') }}" class="sidebar-link active">
                        <i class="fas fa-chart-bar"></i>
                        <span>Results</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ url('student/assignments') }}" class="sidebar-link">
                        <i class="fas fa-tasks"></i>
                        <span>Assignments</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ url('student/quizzes') }}" class="sidebar-link">
                        <i class="fas fa-question-circle"></i>
                        <span>Quizzes</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ url('student/notes') }}" class="sidebar-link">
                        <i class="fas fa-file-pdf"></i>
                        <span>Notes & PDFs</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ url('student/lectures') }}" class="sidebar-link">
                        <i class="fas fa-video"></i>
                        <span>Lecture Videos</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ url('student/announcements') }}" class="sidebar-link">
                        <i class="fas fa-bullhorn"></i>
                        <span>Announcements</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ url('student/fees') }}" class="sidebar-link">
                        <i class="fas fa-dollar-sign"></i>
                        <span>Fee Details</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ url('student/fines') }}" class="sidebar-link">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Fine Details</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ url('student/fee-vouchers') }}" class="sidebar-link">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Fee Vouchers</span>
                    </a>
                </li>
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
                <h1 class="page-title mb-0">Exam Results</h1>
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

                <div class="user-avatar text-white"><span>JD</span></div>
                <div class="d-none d-md-block ms-3">
                    <div class="fw-bold user-name">John Doe</div>
                    <div class="small text-muted student-class">Class 10-A</div>
                </div>
            </div>
        </nav>

        <div class="dashboard-content" id="resultsContainer"></div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('assets/js/auth.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/data.js') }}"></script>
    <script src="{{ asset('assets/js/notifications.js') }}"></script>
    <script src="{{ asset('assets/js/storage.js') }}"></script>
    <script src="{{ asset('assets/js/search.js') }}"></script>
    <script src="{{ asset('assets/js/enhancements.js') }}"></script>
    <script src="{{ asset('assets/js/charts.js') }}"></script>
    <script src="{{ asset('assets/js/marks-functions.js') }}"></script>
    <script>
        protectPage('student');

        document.addEventListener('DOMContentLoaded', function () {
            initDashboardUser();
            loadResults();
        });

        async function loadResults() {
            const container = document.getElementById('resultsContainer');
            
            try {
                const response = await fetch('/api/marks');
                const marks = await response.json();

                if (marks.length === 0) {
                    container.innerHTML = `
                        <div class="text-center py-5">
                             <i class="fas fa-poll fa-3x text-muted mb-3"></i>
                             <h5>No results declared yet</h5>
                             <p class="text-muted">Marks will appear here once uploaded by teachers.</p>
                        </div>
                    `;
                    return;
                }

                // Group marks by exam_type
                const groupedResults = marks.reduce((acc, mark) => {
                    const type = mark.exam_type;
                    if (!acc[type]) {
                        acc[type] = {
                            exam: type,
                            date: mark.created_at,
                            subjects: [],
                            totalObtained: 0,
                            totalMax: 0
                        };
                    }
                    acc[type].subjects.push({
                        name: mark.subject ? mark.subject.name : 'Unknown',
                        obtained: mark.marks_obtained,
                        max: mark.total_marks,
                        grade: mark.grade,
                        remarks: mark.teacher_remarks || 'No remarks'
                    });
                    acc[type].totalObtained += mark.marks_obtained;
                    acc[type].totalMax += mark.total_marks;
                    return acc;
                }, {});

                let html = '';
                Object.values(groupedResults).forEach((exam, index) => {
                    const cardId = `result-card-${index}`;
                    const percentage = (exam.totalObtained / exam.totalMax) * 100;
                    
                    let overallGrade = 'F';
                    if (percentage >= 80) overallGrade = 'A+';
                    else if (percentage >= 70) overallGrade = 'A';
                    else if (percentage >= 60) overallGrade = 'B';
                    else if (percentage >= 50) overallGrade = 'C';
                    else if (percentage >= 40) overallGrade = 'D';

                    html += `
                        <div class="card-modern animate-fade-in mb-4" id="${cardId}">
                            <div class="card-header bg-primary text-white py-3">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h5 class="mb-0 fw-bold text-white">${exam.exam}</h5>
                                        <small>Latest Update: ${new Date(exam.date).toLocaleDateString()}</small>
                                    </div>
                                    <div class="col-md-4 text-md-end mt-2 mt-md-0">
                                        <button class="btn btn-light btn-sm no-print" onclick="downloadResult('${cardId}', '${exam.exam}')">
                                            <i class="fas fa-download me-2"></i> Download Result Card
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-4 mb-4">
                                    <div class="col-md-3">
                                        <div class="text-center p-3 bg-light rounded">
                                            <h6 class="text-muted mb-2">Total Marks</h6>
                                            <h3 class="fw-bold mb-0">${exam.totalObtained}/${exam.totalMax}</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center p-3 bg-light rounded">
                                            <h6 class="text-muted mb-2">Percentage</h6>
                                            <h3 class="fw-bold mb-0 text-primary">${percentage.toFixed(2)}%</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center p-3 bg-light rounded">
                                            <h6 class="text-muted mb-2">Grade</h6>
                                            <h3 class="fw-bold mb-0 text-success">${overallGrade}</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center p-3 bg-light rounded">
                                            <h6 class="text-muted mb-2">Status</h6>
                                            <h3 class="fw-bold mb-0 text-info">${overallGrade === 'F' ? 'Fail' : 'Pass'}</h3>
                                        </div>
                                    </div>
                                </div>
                                
                                <h6 class="fw-bold mb-3">Subject-Wise Performance</h6>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Subject</th>
                                                <th>Marks</th>
                                                <th>Max</th>
                                                <th>Grade</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${exam.subjects.map(s => `
                                                <tr>
                                                    <td class="fw-bold">${s.name}</td>
                                                    <td>${s.obtained}</td>
                                                    <td>${s.max}</td>
                                                    <td><span class="badge ${s.grade === 'F' ? 'bg-danger' : 'bg-success'}">${s.grade}</span></td>
                                                    <td><small class="text-muted">${s.remarks}</small></td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    `;
                });
                container.innerHTML = html;
            } catch (error) {
                console.error('Error loading results:', error);
                container.innerHTML = '<div class="alert alert-danger">Error loading results. Please try again later.</div>';
            }
        }

        function downloadResult(cardId, examName) {
            const element = document.getElementById(cardId);
            const btn = element.querySelector('.no-print');

            if (btn) btn.style.display = 'none';

            setTimeout(() => {
                const opt = {
                    margin: [10, 10],
                    filename: `Result_${examName.replace(/\s+/g, '_')}.pdf`,
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: {
                        scale: 2,
                        useCORS: true,
                        logging: false,
                        scrollY: -window.scrollY,
                        scrollX: -window.scrollX,
                        windowWidth: element.scrollWidth,
                        windowHeight: element.scrollHeight
                    },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
                };

                html2pdf().set(opt).from(element).save().then(() => {
                    if (btn) btn.style.display = '';
                }).catch(err => {
                    console.error("PDF Generation Error:", err);
                    if (btn) btn.style.display = '';
                    alert("Error generating PDF. Please try again.");
                });
            }, 300);
        }
    </script>
</body>

</html>

