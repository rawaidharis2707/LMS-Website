<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Vouchers - Student Portal</title>

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
                <li class="sidebar-menu-item"><a href="{{ url('student/fines') }}" class="sidebar-link"><i
                            class="fas fa-exclamation-triangle"></i><span>Fine Details</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('student/fee-vouchers') }}" class="sidebar-link active"><i
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
                <h1 class="page-title mb-0">Fee Vouchers</h1>
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
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="card-modern animate-fade-in bg-primary text-white">
                        <div class="card-body p-4">
                            <h4 class="fw-bold text-light mb-1">Fee Voucher History</h4>
                            <p class="mb-0 opacity-75">View and download your monthly fee vouchers</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-modern animate-fade-in h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted mb-1">Total Due</h6>
                                <h3 class="fw-bold text-danger mb-0" id="totalDueAmount">$0</h3>
                            </div>
                            <div class="icon-box bg-light text-danger rounded-circle p-3">
                                <i class="fas fa-exclamation-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-modern animate-fade-in">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-file-invoice text-primary me-2"></i> All Vouchers</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4" id="vouchersContainer">
                        <div class="col-12 text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="paymentModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white"><i class="fas text-light fa-credit-card me-2"></i> Online Payment
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="paymentVoucherId">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Select your preferred payment method
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Payment Amount</h6>
                        <h3 class="text-primary fw-bold" id="paymentAmount">$0.00</h3>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Payment Method</label>
                        <select class="form-select" id="paymentMethod">
                            <option value="">Select payment method...</option>
                            <option value="card">Credit/Debit Card</option>
                            <option value="bank">Bank Transfer</option>
                            <option value="wallet">Digital Wallet (PayPal, Stripe)</option>
                        </select>
                    </div>

                    <div id="cardDetails" class="payment-details" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Card Number</label>
                            <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456"
                                maxlength="19">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Expiry Date</label>
                                <input type="text" class="form-control" id="expiryDate" placeholder="MM/YYYY"
                                    maxlength="7">
                            </div>
                            <div class="col-6">
                                <label class="form-label">CVV</label>
                                <input type="text" class="form-control" id="cvvNumber" placeholder="123" maxlength="3">
                            </div>
                        </div>
                    </div>

                    <div id="bankDetails" class="payment-details" style="display: none;">
                        <div class="alert alert-warning">
                            <strong>Bank Details:</strong><br>
                            Account Name: Lumina Academy<br>
                            Account Number: 1234567890<br>
                            Routing Number: 987654321
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Transaction Reference</label>
                            <input type="text" class="form-control" id="transactionRef"
                                placeholder="Enter transaction reference">
                        </div>
                    </div>

                    <div id="walletDetails" class="payment-details" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" placeholder="your@email.com">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="processPayment()">
                        <i class="fas fa-check me-2"></i> Confirm Payment
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
    <script src="{{ asset('assets/js/voucher-functions.js') }}"></script>

    <script>
        protectPage('student');

        document.addEventListener('DOMContentLoaded', function () {
            initDashboardUser();

            const VOUCHER_KEY = 'lms_vouchers';
            if (!localStorage.getItem(VOUCHER_KEY)) {
                localStorage.setItem(VOUCHER_KEY, JSON.stringify([]));
            }

            loadStudentVouchers();
        });

        function loadStudentVouchers() {
            try {
                const session = getSession();
                const user = session ? session.userData : null;

                const container = document.getElementById('vouchersContainer');

                if (!user) {
                    container.innerHTML = `
                        <div class="col-12 text-center py-5">
                            <div class="text-danger mb-3"><i class="fas fa-exclamation-circle fa-2x"></i></div>
                            <h5>Session Issue</h5>
                            <p class="text-muted">Please try logging out and logging in again.</p>
                        </div>`;
                    return;
                }

                const VOUCHER_KEY = 'lms_vouchers';
                const allVouchers = JSON.parse(localStorage.getItem(VOUCHER_KEY) || '[]');
                const studentVouchers = allVouchers.filter(v =>
                    v.studentName === user.name ||
                    v.studentId === (user.rollNumber || user.id) ||
                    (user.name && v.studentName.toLowerCase().includes(user.name.toLowerCase()))
                );

                studentVouchers.sort((a, b) => new Date(b.issueDate) - new Date(a.issueDate));
                container.innerHTML = '';

                let totalDue = 0;

                if (studentVouchers.length === 0) {
                    container.innerHTML = `
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-check-circle text-muted fa-3x mb-3"></i>
                            <h5 class="text-muted">No vouchers found</h5>
                            <p class="text-muted">You have no issued fee vouchers at this time.</p>
                        </div>
                    `;
                } else {
                    studentVouchers.forEach(v => {
                        const isOverdue = v.status === 'unpaid' && new Date(v.dueDate) < new Date();
                        const fine = isOverdue ? (v.lateFine || 0) : 0;
                        const effectiveTotal = v.totalAmount + fine;

                        if (v.status === 'unpaid') totalDue += effectiveTotal;

                        const isPaid = v.status === 'paid';
                        const statusClass = isPaid ? 'success' : (isOverdue ? 'danger' : 'warning');
                        const statusText = isPaid ? 'Paid' : (isOverdue ? 'Overdue' : 'Unpaid');

                        const card = document.createElement('div');
                        card.className = 'col-md-6';
                        card.innerHTML = `
                            <div class="card border-start border-${statusClass} border-4 h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="fw-bold mb-1">${v.period} Fee</h6>
                                            <small class="text-muted">Voucher #: ${v.id}</small>
                                        </div>
                                        <span class="badge bg-${statusClass}">${statusText}</span>
                                    </div>
                                    <hr>
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <small class="text-muted d-block">${isPaid ? 'Payment Date' : 'Due Date'}</small>
                                            <span class="fw-bold">${isPaid ? formatDate(v.paymentDate) : formatDate(v.dueDate)}</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Total Amount</small>
                                            <h5 class="fw-bold text-${statusClass} mb-0">$${effectiveTotal.toFixed(2)}
                                                ${v.discount > 0 ? `<br><small class="fs-6 text-success">(Disc. -$${v.discount})</small>` : ''}
                                                ${fine > 0 ? '<br><small class="fs-6 text-danger">(Inc. Fine)</small>' : ''}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2">
                                        ${isPaid ?
                                `<button class="btn btn-outline-success" onclick="viewReceipt('${v.id}')">
                                                <i class="fas fa-receipt me-2"></i> View Receipt
                                            </button>` :
                                `<button class="btn btn-primary" onclick="openPaymentModal('${v.id}', ${effectiveTotal.toFixed(2)})">
                                                <i class="fas fa-credit-card me-2"></i> Pay Now
                                            </button>
                                            <button class="btn btn-outline-secondary" onclick="downloadVoucher('${v.id}')">
                                                <i class="fas fa-download me-2"></i> Download Voucher
                                            </button>`
                            }
                                    </div>
                                </div>
                            </div>
                        `;
                        container.appendChild(card);
                    });
                }

                document.getElementById('totalDueAmount').innerText = '$' + totalDue.toLocaleString();
            } catch (e) {
                console.error("Error loading vouchers:", e);
                document.getElementById('vouchersContainer').innerHTML = `
                    <div class="col-12 text-center py-5">
                         <p class="text-danger">Error loading vouchers. Please refresh the page.</p>
                    </div>`;
            }
        }

        function formatDate(dateString) {
            if (!dateString) return '-';
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('en-US', options);
        }

        function downloadVoucher(voucherId) {
            const voucher = getVoucherById(voucherId);
            if (!voucher) return;

            const params = new URLSearchParams({
                id: voucher.id,
                name: voucher.studentName,
                father: voucher.fatherName || '',
                class: voucher.class,
                roll: voucher.rollNo || voucher.studentId,
                period: voucher.period,
                issue: formatDate(voucher.issueDate),
                due: formatDate(voucher.dueDate),
                amount: voucher.totalAmount,
                discount: voucher.discount || 0,
                copyType: 'all'
            });

            window.open('print-voucher?' + params.toString(), '_blank', 'width=900,height=1000');
        }

        function viewReceipt(voucherId) {
            const voucher = getVoucherById(voucherId);
            if (!voucher) return;

            const params = new URLSearchParams({
                id: voucher.id,
                name: voucher.studentName,
                father: voucher.fatherName || '',
                class: voucher.class,
                roll: voucher.rollNo || voucher.studentId,
                period: voucher.period,
                issue: formatDate(voucher.issueDate),
                due: formatDate(voucher.dueDate),
                amount: voucher.totalAmount,
                paid: 'true',
                copyType: 'student'
            });

            window.open('print-voucher?' + params.toString(), '_blank', 'width=900,height=1000');
        }

        function openPaymentModal(voucherId, amount) {
            document.getElementById('paymentVoucherId').value = voucherId;
            const numAmount = parseFloat(amount);
            document.getElementById('paymentAmount').textContent = '$' + numAmount.toFixed(2);
            const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
            modal.show();
        }

        document.addEventListener('DOMContentLoaded', function () {
            const paymentMethod = document.getElementById('paymentMethod');
            if (paymentMethod) {
                paymentMethod.addEventListener('change', function () {
                    document.querySelectorAll('.payment-details').forEach(el => el.style.display = 'none');

                    const method = this.value;
                    if (method === 'card') {
                        document.getElementById('cardDetails').style.display = 'block';
                    } else if (method === 'bank') {
                        document.getElementById('bankDetails').style.display = 'block';
                    } else if (method === 'wallet') {
                        document.getElementById('walletDetails').style.display = 'block';
                    }
                });
            }

            const cardNumber = document.getElementById('cardNumber');
            if (cardNumber) {
                cardNumber.addEventListener('input', function (e) {
                    let value = e.target.value.replace(/\D/g, '');
                    let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
                    e.target.value = formattedValue;
                });
            }

            const expiryDate = document.getElementById('expiryDate');
            if (expiryDate) {
                expiryDate.addEventListener('input', function (e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length >= 2) {
                        value = value.substring(0, 2) + '/' + value.substring(2, 6);
                    }
                    e.target.value = value;
                });
            }

            const cvvNumber = document.getElementById('cvvNumber');
            if (cvvNumber) {
                cvvNumber.addEventListener('input', function (e) {
                    e.target.value = e.target.value.replace(/\D/g, '');
                });
            }
        });

        function processPayment() {
            const voucherId = document.getElementById('paymentVoucherId').value;
            const method = document.getElementById('paymentMethod').value;

            if (!method) {
                showToast('Please select a payment method', 'error');
                return;
            }

            if (method === 'card') {
                showToast('Processing card payment...', 'info');
            } else if (method === 'bank' && !document.getElementById('transactionRef').value) {
                showToast('Please enter transaction reference', 'error');
                return;
            }

            setTimeout(() => {
                markVoucherAsPaid(voucherId, method);

                showToast('Payment successful! Voucher marked as paid.', 'success');

                bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();

                setTimeout(() => {
                    loadStudentVouchers();
                }, 500);
            }, 1500);
        }

        function markVoucherAsPaid(voucherId, paymentMethod) {
            const VOUCHER_KEY = 'lms_vouchers';
            const vouchersStr = localStorage.getItem(VOUCHER_KEY);
            const vouchers = vouchersStr ? JSON.parse(vouchersStr) : [];

            const voucherIndex = vouchers.findIndex(v => v.id == voucherId);

            if (voucherIndex !== -1) {
                vouchers[voucherIndex].status = 'paid';
                vouchers[voucherIndex].paymentDate = new Date().toISOString();
                vouchers[voucherIndex].paymentMethod = paymentMethod;

                localStorage.setItem(VOUCHER_KEY, JSON.stringify(vouchers));

                const currentUser = getCurrentUser();
                if (typeof logActivity === 'function' && currentUser) {
                    logActivity('Update', `Paid fee voucher #${voucherId} via ${paymentMethod}`, currentUser.name, currentUser.role);
                }

                return true;
            } else {
                console.error('Voucher not found with ID:', voucherId);
            }
            return false;
        }
    </script>
</body>

</html>

