<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Details - Student Portal</title>

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
                <li class="sidebar-menu-item"><a href="{{ url('student/fees') }}" class="sidebar-link active"><i
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
                <h1 class="page-title mb-0">Fee Details</h1>
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
                    <div class="card-modern animate-fade-in border-start border-primary border-4 h-100">
                        <div class="card-body">
                            <p class="text-muted mb-1">Total Fee Vouchers</p>
                            <h3 class="fw-bold mb-0" id="totalVouchersCount">0</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-modern animate-fade-in border-start border-success border-4 h-100">
                        <div class="card-body">
                            <p class="text-muted mb-1">Total Paid</p>
                            <h3 class="fw-bold mb-0 text-success">$<span id="paidAmount">0</span></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-modern animate-fade-in border-start border-danger border-4 h-100">
                        <div class="card-body">
                            <p class="text-muted mb-1">Pending Dues</p>
                            <h3 class="fw-bold mb-0 text-danger">$<span id="pendingAmount">0</span></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-modern animate-fade-in border-start border-warning border-4 h-100">
                        <div class="card-body">
                            <p class="text-muted mb-1">Total Fines</p>
                            <h3 class="fw-bold mb-0 text-warning">$<span id="fineAmount">0</span></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-modern animate-fade-in">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-history text-secondary me-2"></i> Payment History</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Voucher ID</th>
                                    <th>Period</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Payment Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="vouchersTable">
                            </tbody>
                        </table>
                        <div id="noDataMessage" class="text-center py-4 text-muted" style="display: none;">
                            No fee records found.
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
    <script src="{{ asset('assets/js/storage.js') }}"></script>
    <script src="{{ asset('assets/js/notifications.js') }}"></script>
    <script src="{{ asset('assets/js/search.js') }}"></script>
    <script src="{{ asset('assets/js/enhancements.js') }}"></script>
    <script src="{{ asset('assets/js/charts.js') }}"></script>
    <script src="{{ asset('assets/js/voucher-functions.js') }}"></script>

    <script>
        protectPage('student');

        document.addEventListener('DOMContentLoaded', function () {
            initDashboardUser();
            loadFeeDetails();
        });

        async function loadFeeDetails() {
            try {
                const response = await fetch('/api/fees');
                const vouchers = await response.json();

                let totalAmount = 0;
                let paidAmount = 0;
                let pendingAmount = 0;
                let fineAmount = 0;

                vouchers.forEach(v => {
                    const amount = parseFloat(v.amount);
                    const isPaid = v.status === 'Paid';
                    const isOverdue = !isPaid && new Date(v.due_date) < new Date();
                    const fine = isOverdue ? 500 : 0; // Fixed mock fine logic for now
                    const effectiveTotal = amount + fine;

                    totalAmount += effectiveTotal;

                    if (isPaid) {
                        paidAmount += effectiveTotal;
                    } else {
                        pendingAmount += effectiveTotal;
                    }
                    fineAmount += fine;
                });

                document.getElementById('totalVouchersCount').innerText = vouchers.length;
                document.getElementById('paidAmount').innerText = paidAmount.toLocaleString();
                document.getElementById('pendingAmount').innerText = pendingAmount.toLocaleString();
                document.getElementById('fineAmount').innerText = fineAmount.toLocaleString();

                const tbody = document.getElementById('vouchersTable');
                if (!tbody) return;
                
                tbody.innerHTML = '';

                if (vouchers.length === 0) {
                    document.getElementById('noDataMessage').style.display = 'block';
                } else {
                    document.getElementById('noDataMessage').style.display = 'none';

                    vouchers.forEach(v => {
                        const isPaid = v.status === 'Paid';
                        const isOverdue = !isPaid && new Date(v.due_date) < new Date();
                        const fine = isOverdue ? 500 : 0;
                        const amount = parseFloat(v.amount);
                        const effectiveTotal = amount + fine;

                        let statusBadge;
                        if (isPaid) statusBadge = '<span class="badge bg-success">Paid</span>';
                        else if (isOverdue) statusBadge = '<span class="badge bg-danger">Overdue</span>';
                        else statusBadge = '<span class="badge bg-warning text-dark">Unpaid</span>';

                        let actionBtn;
                        if (isPaid) {
                            actionBtn = `<button class="btn btn-sm btn-outline-success" onclick="viewReceipt('${v.id}')"><i class="fas fa-receipt"></i> Receipt</button>`;
                        } else {
                            actionBtn = `<button class="btn btn-sm btn-outline-primary" onclick="downloadVoucher('${v.id}')"><i class="fas fa-download"></i> Voucher</button>`;
                        }

                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="fw-bold text-secondary">${v.voucher_id}</td>
                            <td>${v.month}</td>
                            <td class="fw-bold">$${effectiveTotal.toFixed(2)}${fine > 0 ? ' <small class="text-danger">(+Fine)</small>' : ''}</td>
                            <td>${statusBadge}</td>
                            <td>${isPaid ? new Date(v.updated_at).toLocaleDateString() : '-'}</td>
                            <td>${actionBtn}</td>
                        `;
                        tbody.appendChild(tr);
                    });
                }
            } catch (error) {
                console.error('Error loading fee details:', error);
                showToast('Error loading fee records', 'error');
            }
        }

        function downloadVoucher(voucherId) {
            showToast('Generating voucher...', 'info');
        }

        function viewReceipt(voucherId) {
            showToast('Opening receipt...', 'info');
        }

        function payNow() {
            showToast('Please visit the bank to pay your fees.', 'info');
        }
    </script>
</body>

</html>

