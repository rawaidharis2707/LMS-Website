<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fine Details - Student Portal</title>

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
                <li class="sidebar-menu-item"><a href="{{ url('student/quizzes') }}" class="sidebar-link"><i
                            class="fas fa-question-circle"></i><span>Quizzes</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('student/notes') }}" class="sidebar-link"><i
                            class="fas fa-file-pdf"></i><span>Notes & PDFs</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('student/lectures') }}" class="sidebar-link"><i
                            class="fas fa-video"></i><span>Lecture Videos</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('student/announcements') }}" class="sidebar-link"><i
                            class="fas fa-bullhorn"></i><span>Announcements</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('student/fees') }}" class="sidebar-link"><i
                            class="fas fa-dollar-sign"></i><span>Fee Details</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('student/fines') }}" class="sidebar-link active"><i
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
                <h1 class="page-title mb-0">Fine Details</h1>
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

        <div class="dashboard-content">
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card-modern animate-fade-in">
                        <div class="card-body text-center">
                            <i class="fas fa-exclamation-circle fa-2x text-warning mb-2"></i>
                            <h6 class="text-muted mb-2">Total Fines</h6>
                            <h3 class="fw-bold text-dark">$150</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-modern animate-fade-in">
                        <div class="card-body text-center">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <h6 class="text-muted mb-2">Paid</h6>
                            <h3 class="fw-bold text-success">$100</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-modern animate-fade-in">
                        <div class="card-body text-center">
                            <i class="fas fa-clock fa-2x text-danger mb-2"></i>
                            <h6 class="text-muted mb-2">Pending</h6>
                            <h3 class="fw-bold text-danger">$50</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-modern animate-fade-in">
                        <div class="card-body text-center">
                            <i class="fas fa-list fa-2x text-primary mb-2"></i>
                            <h6 class="text-muted mb-2">Total Count</h6>
                            <h3 class="fw-bold text-primary">5</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-modern animate-fade-in">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-list text-warning me-2"></i> Fine History</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Reason</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
    <script src="{{ asset('assets/js/storage.js') }}"></script>
    <script src="{{ asset('assets/js/notifications.js') }}"></script>
    <script src="{{ asset('assets/js/search.js') }}"></script>
    <script src="{{ asset('assets/js/enhancements.js') }}"></script>
    <script src="{{ asset('assets/js/charts.js') }}"></script>
    <script src="{{ asset('assets/js/fines-functions.js') }}"></script>
    <script>
        protectPage('student');

        document.addEventListener('DOMContentLoaded', function () {
            initDashboardUser();
            loadStudentFines();
        });

        async function loadStudentFines() {
            try {
                const response = await fetch('/api/fines');
                const fines = await response.json();

                let total = 0;
                let paid = 0;
                let pending = 0;
                let count = fines.length;

                fines.forEach(f => {
                    const amount = parseFloat(f.amount);
                    total += amount;
                    if (f.status === 'Paid') paid += amount;
                    else pending += amount;
                });

                const cards = document.querySelectorAll('.card-body.text-center');
                if (cards.length >= 4) {
                    cards[0].querySelector('h3').innerText = `$${total.toFixed(2)}`;
                    cards[1].querySelector('h3').innerText = `$${paid.toFixed(2)}`;
                    cards[2].querySelector('h3').innerText = `$${pending.toFixed(2)}`;
                    cards[3].querySelector('h3').innerText = count;
                }

                const tbody = document.querySelector('table tbody');
                if (!tbody) return;
                
                tbody.innerHTML = '';

                if (fines.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">No fines record found</td></tr>';
                } else {
                    fines.forEach(fine => {
                        const statusClass = fine.status === 'Paid' ? 'success' : 'danger';
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${new Date(fine.date_issued).toLocaleDateString()}</td>
                            <td>${fine.reason || 'N/A'}</td>
                            <td><span class="badge bg-secondary">${fine.category}</span></td>
                            <td class="fw-bold text-danger">$${parseFloat(fine.amount).toFixed(2)}</td>
                            <td><span class="badge bg-${statusClass}">${fine.status}</span></td>
                        `;
                        tbody.appendChild(tr);
                    });
                }
            } catch (error) {
                console.error('Error loading fines:', error);
                showToast('Error loading fine records', 'error');
            }
        }

        function viewReceipt(id) {
            showToast('Downloading receipt...', 'success');
        }
    </script>
</body>

</html>

