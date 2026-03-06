<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fee Vouchers - Admin Portal</title>

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
                <li class="sidebar-menu-item"><a href="{{ route('admin.dashboard') }}" class="sidebar-link"><i
                            class="fas fa-home"></i><span>Dashboard</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/admissions') }}" class="sidebar-link"><i
                            class="fas fa-user-plus"></i><span>Admissions</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/timetable-input') }}" class="sidebar-link"><i
                            class="fas fa-calendar-plus"></i><span>Timetable Input</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/announcements') }}" class="sidebar-link"><i
                            class="fas fa-bullhorn"></i><span>Announcements</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/class-management') }}" class="sidebar-link"><i
                            class="fas fa-school"></i><span>Class Management</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/subject-assignment') }}" class="sidebar-link"><i
                            class="fas fa-book"></i><span>Subject Assignment</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/student-promotion') }}" class="sidebar-link"><i
                            class="fas fa-level-up-alt"></i><span>Student Promotion</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/data-correction') }}" class="sidebar-link"><i
                            class="fas fa-user-edit"></i><span>Data Correction</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/fee-vouchers') }}" class="sidebar-link active"><i
                            class="fas fa-receipt"></i><span>Fee Vouchers</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/fines') }}" class="sidebar-link"><i
                            class="fas fa-exclamation-triangle"></i><span>Fine Management</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/teacher-attendance') }}" class="sidebar-link"><i
                            class="fas fa-user-clock"></i><span>Teacher Attendance</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/discount-management') }}" class="sidebar-link"><i
                            class="fas fa-percentage"></i><span>Discount Management</span></a></li>
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
                <h1 class="page-title mb-0">Fee Section</h1>
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
                            <h6 class="mb-0 fw-bold">System Alerts</h6>
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

                <div class="user-avatar shadow-sm"><span>AD</span></div>
                <div class="d-none d-md-block ms-3">
                    <div class="fw-bold user-name" id="userNameDisplay">Admin User</div>
                    <div class="small text-muted" id="userRoleDisplay">Administrator</div>
                </div>
            </div>
        </nav>

        <div class="dashboard-content">
            <!-- Statistics Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card-modern animate-fade-in p-4 shadow-sm lift h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary-subtle text-primary rounded-circle p-3 me-3">
                                <i class="fas fa-file-invoice-dollar fs-4"></i>
                            </div>
                            <h6 class="text-muted small text-uppercase fw-bold mb-0">Total Vouchers</h6>
                        </div>
                        <h2 class="fw-bold mb-1 text-dark" id="statTotal">0</h2>
                        <div class="text-muted small fw-bold">Vouchers Generated</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-modern animate-fade-in p-4 shadow-sm lift h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success-subtle text-success rounded-circle p-3 me-3">
                                <i class="fas fa-check-circle fs-4"></i>
                            </div>
                            <h6 class="text-muted small text-uppercase fw-bold mb-0">Cleared</h6>
                        </div>
                        <h2 class="fw-bold mb-1 text-success" id="statPaid">0</h2>
                        <div class="text-muted small fw-bold">Fee Vouchers Paid</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-modern animate-fade-in p-4 shadow-sm lift h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning-subtle text-warning rounded-circle p-3 me-3">
                                <i class="fas fa-clock fs-4"></i>
                            </div>
                            <h6 class="text-muted small text-uppercase fw-bold mb-0">Pending</h6>
                        </div>
                        <h2 class="fw-bold mb-1 text-warning" id="statUnpaid">0</h2>
                        <div class="text-muted small fw-bold">Pending Fee Vouchers</div>
                    </div>  
                </div>
                <div class="col-md-3">
                    <div class="card-modern animate-fade-in p-4 shadow-sm lift h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-info-subtle text-info rounded-circle p-3 me-3">
                                <i class="fas fa-vault fs-4"></i>
                            </div>
                            <h6 class="text-muted small text-uppercase fw-bold mb-0">Total Fee Collected</h6>
                        </div>
                        <h2 class="fw-bold mb-1 text-dark" id="statAmount">$0</h2>
                        <div class="text-muted small fw-bold">Total Fee Collected</div>
                    </div>
                </div>
            </div>

            <!-- Actions Bar -->
            <div class="card-modern animate-fade-in shadow-sm mb-4">
                <div class="card-body p-3">
                    <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center">
                        <div class="d-flex gap-3">
                            <button class="btn btn-primary px-4 fw-bold lift shadow-sm" onclick="openCreateModal()">
                                <i class="fas fa-plus-circle me-2"></i>Create Fee Voucher
                            </button>
                            <button class="btn btn-outline-secondary px-4 fw-bold lift" onclick="openCategoriesModal()">
                                <i class="fas fa-tags me-2"></i> Default Fee Charges
                            </button>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="input-group" style="width: 300px;">
                                <span class="input-group-text bg-light border-0"><i
                                        class="fas fa-search text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-0 shadow-none" id="searchVoucher"
                                    placeholder="Search by identity or name...">
                            </div>
                            <select class="form-select bg-light border-0 shadow-none" id="filterStatus"
                                style="width: 150px;">
                                <option value="all">Filter</option>
                                <option value="paid">Cleared</option>
                                <option value="unpaid">Pending</option>
                                <option value="overdue">Late</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vouchers Table -->
            <div class="card-modern animate-fade-in shadow-lg border-0">
                <div class="card-header bg-white border-0 py-4 px-4 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-file-invoice text-success me-2"></i> Fee Vouchers</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase fw-bold">
                                <tr class="border-0">
                                    <th class="ps-4">Voucher ID</th>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <th>Cycle</th>
                                    <th>Issuance/Due Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th class="pe-4 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody id="vouchersTableBody">
                                <!-- Populated dynamically -->
                            </tbody>
                        </table>
                    </div>
                    <div class="p-5 text-center text-muted" id="noVouchersMsg" style="display: none;">
                        <i class="fas fa-folder-open fs-1 mb-3 d-block opacity-25"></i>
                        No transaction records identified. Initialize by issuing a new instrument.
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Create/Edit Voucher Modal -->
    <div class="modal fade" id="voucherModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-light border-0 py-4 px-4">
                    <h5 class="modal-title fw-bold text-dark" id="voucherModalTitle">Generate Financial Instrument</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="voucherForm">
                        <input type="hidden" id="editVoucherId">

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase tracking-wider">Search Student *</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control bg-light border-0 py-3 px-4 shadow-none"
                                        id="vStudentSearch" placeholder="Type name or roll number..." autocomplete="off">
                                    <div id="vStudentResults" class="dropdown-menu shadow-lg w-100 mt-1" style="display: none; max-height: 200px; overflow-y: auto;"></div>
                                    <input type="hidden" id="vStudentId" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase tracking-wider">Student Details</label>
                                <input type="text" class="form-control bg-light border-0 py-3 px-4 shadow-none"
                                    id="vStudentName" readonly placeholder="Selected student will appear here">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase tracking-wider">Gaurdian Name</label>
                                <input type="text" class="form-control bg-light border-0 py-3 px-4 shadow-none"
                                    id="vFatherName">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase tracking-wider">Select
                                    Class</label>
                                <select class="form-select bg-light border-0 py-3 px-4 shadow-none" id="vClass"
                                    required>
                                    <option value="">All Classes</option>
                                    <option value="Class 9">Class 9</option>
                                    <option value="Class 10">Class 10</option>
                                    <option value="Class 11">Class 11</option>
                                    <option value="Class 12">Class 12</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-uppercase tracking-wider">Month and Year
                                    *</label>
                                <input type="text" class="form-control bg-light border-0 py-3 px-4 shadow-none"
                                    id="vPeriod" placeholder="e.g. December 2024" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-uppercase tracking-wider">Issuance Date
                                    *</label>
                                <input type="date" class="form-control bg-light border-0 py-3 px-4 shadow-none"
                                    id="vIssueDate" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-uppercase tracking-wider">Due Date
                                    *</label>
                                <input type="date" class="form-control bg-light border-0 py-3 px-4 shadow-none"
                                    id="vDueDate" required>
                            </div>
                        </div>

                        <h6 class="fw-bold small text-uppercase tracking-widest text-primary border-bottom pb-2 mb-4">
                            Fee Charges</h6>
                        <div id="feeItemsContainer">
                            <!-- Dynamic fee items -->
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary fw-bold mt-2 lift"
                            onclick="addFeeItemRow()">
                            <i class="fas fa-plus me-1"></i> Add Fee Charges
                        </button>

                        <div class="row g-4 mt-4">
                            <div class="col-md-5 ms-auto">
                                <div class="card bg-light border-0 shadow-sm">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted small fw-bold text-uppercase">Sub Total:</span>
                                            <span class="fw-bold" id="vSubtotal">$0.00</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3 align-items-center">
                                            <span class="text-danger small fw-bold text-uppercase">Late Fee Fine:</span>
                                            <input type="number"
                                                class="form-control form-control-sm text-end bg-white border-0 shadow-none fw-bold"
                                                id="vLateFine" value="0" style="width: 100px;"
                                                onchange="calculateTotal()">
                                        </div>
                                        <div class="d-flex justify-content-between pt-3 border-top">
                                            <span class="text-dark fw-bold">Net Total:</span>
                                            <span class="fw-bold text-primary fs-5" id="vTotal">$0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-outline-secondary px-4 fw-bold lift"
                        data-bs-dismiss="modal">Discard</button>
                    <button type="button" class="btn btn-primary px-5 fw-bold lift shadow-sm"
                        onclick="saveVoucher()">Generate Fee Voucher</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Manage Categories Modal -->
    <div class="modal fade" id="categoriesModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-light border-0 py-4 px-4">
                    <h5 class="modal-title fw-bold">Classification Matrix</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="input-group mb-4 shadow-sm rounded-3">
                        <input type="text" class="form-control border-0 py-3 px-4 shadow-none" id="newCatName"
                            placeholder="Entry Type">
                        <input type="number" class="form-control border-0 py-3 px-4 shadow-none" id="newCatAmount"
                            placeholder="Rate" style="max-width: 120px;">
                        <button class="btn btn-primary px-4 fw-bold" onclick="addNewCategory()">Register</button>
                    </div>
                    <ul class="list-group list-group-flush" id="categoriesList">
                        <!-- Populated dynamically -->
                    </ul>
                </div>
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
    <script src="{{ asset('assets/js/voucher-functions.js') }}"></script>
    <script src="{{ asset('assets/js/fines-functions.js') }}"></script>
    <script src="{{ asset('assets/js/activity-functions.js') }}"></script>

    <script>
        protectPage('admin');

        // Global state
        let voucherModal;
        let categoriesModal;

        document.addEventListener('DOMContentLoaded', async function () {
            initDashboardUser();
            
            // Initialize modals
            voucherModal = new bootstrap.Modal(document.getElementById('voucherModal'));
            categoriesModal = new bootstrap.Modal(document.getElementById('categoriesModal'));

            // Student Search functionality
            const studentSearch = document.getElementById('vStudentSearch');
            const studentResults = document.getElementById('vStudentResults');

            studentSearch.addEventListener('input', async function() {
                const query = this.value.trim();
                if (query.length < 2) {
                    studentResults.style.display = 'none';
                    return;
                }

                try {
                    const response = await fetch(`/api/students?search=${encodeURIComponent(query)}`);
                    const students = await response.json();
                    
                    studentResults.innerHTML = '';
                    if (students.length > 0) {
                        students.forEach(s => {
                            const div = document.createElement('div');
                            div.className = 'dropdown-item cursor-pointer py-2 border-bottom';
                            div.style.cursor = 'pointer';
                            div.innerHTML = `
                                <div class="fw-bold text-dark">${s.name}</div>
                                <div class="small text-muted">Roll: ${s.roll_number || 'N/A'} | Class: ${s.enrolled_class || 'N/A'}</div>
                            `;
                            div.onclick = () => {
                                document.getElementById('vStudentId').value = s.id;
                                document.getElementById('vStudentName').value = `${s.name} (${s.roll_number || 'N/A'})`;
                                document.getElementById('vClass').value = s.enrolled_class || '';
                                studentSearch.value = s.name;
                                studentResults.style.display = 'none';
                            };
                            studentResults.appendChild(div);
                        });
                        studentResults.style.display = 'block';
                    } else {
                        studentResults.innerHTML = '<div class="dropdown-item text-muted">No students found</div>';
                        studentResults.style.display = 'block';
                    }
                } catch (error) {
                    console.error('Error searching students:', error);
                }
            });

            // Close search results when clicking outside
            document.addEventListener('click', function(e) {
                if (!studentSearch.contains(e.target) && !studentResults.contains(e.target)) {
                    studentResults.style.display = 'none';
                }
            });

            // Initial load
            loadVouchers();
            updateStatistics();

            // Search filters
            document.getElementById('searchVoucher').addEventListener('input', loadVouchers);
            document.getElementById('filterStatus').addEventListener('change', loadVouchers);
        });

        async function loadVouchers() {
            const searchTerm = document.getElementById('searchVoucher').value.toLowerCase();
            const statusFilter = document.getElementById('filterStatus').value;
            const tbody = document.getElementById('vouchersTableBody');
            const noVouchersMsg = document.getElementById('noVouchersMsg');
            
            tbody.innerHTML = '<tr><td colspan="8" class="text-center py-5"><div class="spinner-border text-primary"></div></td></tr>';

            try {
                const response = await fetch(`/api/fees?search=${encodeURIComponent(searchTerm)}&status=${statusFilter}`);
                const data = await response.json();
                
                tbody.innerHTML = '';
                if (data.length === 0) {
                    noVouchersMsg.style.display = 'block';
                    return;
                }

                noVouchersMsg.style.display = 'none';
                data.forEach(v => {
                    const tr = document.createElement('tr');
                    tr.className = 'animate-fade-in';
                    const statusClass = v.status === 'Paid' ? 'success' : 'warning';
                    
                    tr.innerHTML = `
                        <td class="ps-4"><span class="fw-bold small text-muted">${v.voucher_id}</span></td>
                        <td>
                            <div class="fw-bold text-dark">${v.user ? v.user.name : 'N/A'}</div>
                            <div class="small text-muted fw-bold">${v.user ? (v.user.roll_number || 'N/A') : 'N/A'}</div>
                        </td>
                        <td>${v.month}</td>
                        <td class="text-end">PKR ${v.amount.toLocaleString()}</td>
                        <td>${v.due_date ? new Date(v.due_date).toLocaleDateString() : 'N/A'}</td>
                        <td><span class="badge-modern bg-${statusClass}-subtle text-${statusClass === 'success' ? 'success' : 'warning'} fw-bold">${v.status}</span></td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-primary" onclick="viewVoucher('${v.id}')">
                                <i class="fas fa-eye"></i> View
                            </button>
                            <button class="btn btn-sm btn-outline-danger ms-1" onclick="deleteVoucherClick('${v.id}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            } catch (error) {
                console.error('Error loading vouchers:', error);
                tbody.innerHTML = '<tr><td colspan="8" class="text-center py-5 text-danger">Error loading data</td></tr>';
            }
        }

        async function saveVoucher() {
            const studentId = document.getElementById('vStudentId').value;
            const amountStr = document.getElementById('vTotal').innerText.replace('$', '');
            const amount = parseFloat(amountStr);
            const dueDate = document.getElementById('vDueDate').value;
            const month = document.getElementById('vPeriod').value;

            if (!studentId || isNaN(amount) || !dueDate || !month) {
                showToast('Please fill all required fields and add at least one fee charge', 'warning');
                return;
            }

            try {
                const response = await fetch('/api/fees', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        user_id: studentId,
                        amount: amount,
                        due_date: dueDate,
                        month: month
                    })
                });

                const result = await response.json();
                if (result.success) {
                    showToast('Voucher generated successfully!', 'success');
                    voucherModal.hide();
                    loadVouchers();
                    updateStatistics();
                } else {
                    showToast(result.message || 'Failed to generate voucher', 'error');
                }
            } catch (error) {
                console.error('Error saving voucher:', error);
                showToast('An error occurred during save', 'error');
            }
        }

        async function togglePay(id) {
            try {
                const response = await fetch(`/api/fees/${id}/toggle-status`, {
                    method: 'PATCH',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const result = await response.json();
                if (result.success) {
                    showToast(`Voucher marked as ${result.status}`, 'success');
                    loadVouchers();
                    updateStatistics();
                }
            } catch (error) {
                console.error('Error toggling status:', error);
            }
        }

        async function deleteVoucherClick(id) {
            if (!confirm('Are you sure you want to delete this voucher?')) return;

            try {
                const response = await fetch(`/api/fees/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const result = await response.json();
                if (result.success) {
                    showToast('Voucher deleted', 'success');
                    loadVouchers();
                    updateStatistics();
                }
            } catch (error) {
                console.error('Error deleting voucher:', error);
            }
        }

        async function updateStatistics() {
            try {
                const response = await fetch('/api/fees');
                const vouchers = await response.json();

                if (!Array.isArray(vouchers)) {
                    console.error('Expected array for vouchers, got:', vouchers);
                    return;
                }

                document.getElementById('statTotal').innerText = vouchers.length;
                document.getElementById('statPaid').innerText = vouchers.filter(v => v.status === 'Paid').length;
                document.getElementById('statUnpaid').innerText = vouchers.filter(v => v.status === 'Unpaid').length;
                
                const totalPaid = vouchers.filter(v => v.status === 'Paid').reduce((sum, v) => sum + parseFloat(v.amount), 0);
                document.getElementById('statAmount').innerText = `PKR ${totalPaid.toLocaleString()}`;
            } catch (error) {
                console.error('Error updating statistics:', error);
            }
        }

        // --- Categories Management ---
        function openCategoriesModal() {
            renderCategoriesList();
            categoriesModal.show();
        }

        function renderCategoriesList() {
            const categories = getAllFeeCategories();
            const list = document.getElementById('categoriesList');
            list.innerHTML = '';

            if (categories.length === 0) {
                list.innerHTML = '<li class="list-group-item text-center text-muted">No categories defined</li>';
                return;
            }

            categories.forEach(cat => {
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3 border-bottom';
                li.innerHTML = `
                    <span>
                        <span class="fw-bold text-dark">${cat.name}</span>
                        <span class="badge-modern bg-primary-subtle text-primary ms-2 fw-bold">PKR ${cat.defaultAmount}</span>
                    </span>
                    <button class="btn btn-sm btn-link text-danger p-0 lift" onclick="deleteCategory(${cat.id})"><i class="fas fa-trash-alt"></i></button>
                `;
                list.appendChild(li);
            });
        }

        function addNewCategory() {
            const name = document.getElementById('newCatName').value.trim();
            const amount = parseFloat(document.getElementById('newCatAmount').value) || 0;

            if (name) {
                addFeeCategory(name, amount);
                document.getElementById('newCatName').value = '';
                document.getElementById('newCatAmount').value = '';
                renderCategoriesList();
            }
        }

        function deleteCategory(id) {
            if (confirm('Delete this category?')) {
                removeFeeCategory(id);
                renderCategoriesList();
            }
        }

        // --- Create Modal Helper ---
        function openCreateModal() {
            document.getElementById('voucherForm').reset();
            document.getElementById('vStudentId').value = '';
            document.getElementById('vStudentName').value = '';
            document.getElementById('vStudentSearch').value = '';
            document.getElementById('voucherModalTitle').innerText = 'Generate Financial Instrument';

            const today = new Date().toISOString().split('T')[0];
            document.getElementById('vIssueDate').value = today;

            const container = document.getElementById('feeItemsContainer');
            container.innerHTML = '';

            const categories = getAllFeeCategories();
            categories.forEach(cat => {
                addFeeItemRow(cat.name, cat.defaultAmount);
            });

            calculateTotal();
            voucherModal.show();
        }

        function addFeeItemRow(name = '', amount = 0, fineId = '') {
            const container = document.getElementById('feeItemsContainer');
            const div = document.createElement('div');
            div.className = 'row g-2 mb-2 fee-item-row';
            div.innerHTML = `
                <div class="col-7">
                    <input type="text" class="form-control form-control-sm fee-name" placeholder="Fee Description" value="${name}"
                        oninput="calculateTotal()">
                    <input type="hidden" class="fee-fine-id" value="${fineId}">
                </div>
                <div class="col-3">
                    <input type="number" class="form-control form-control-sm fee-amount" placeholder="Amount" value="${amount}"
                        oninput="calculateTotal()">
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-sm btn-outline-danger w-100"
                        onclick="this.closest('.fee-item-row').remove(); calculateTotal()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            container.appendChild(div);
            calculateTotal();
        }

        function calculateTotal() {
            let subtotal = 0;
            document.querySelectorAll('.fee-item-row').forEach(row => {
                const amt = parseFloat(row.querySelector('.fee-amount').value) || 0;
                subtotal += amt;
            });

            const lateFine = parseFloat(document.getElementById('vLateFine').value) || 0;
            const total = subtotal + lateFine;

            document.getElementById('vSubtotal').innerText = 'PKR ' + subtotal.toFixed(2);
            document.getElementById('vTotal').innerText = 'PKR ' + total.toFixed(2);

            return { subtotal, total, lateFine };
        }

        function importFines() {
            const studentId = document.getElementById('vStudentId').value;
            if (!studentId) {
                showToast('Please select a student first', 'warning');
                return;
            }
            showToast('Fine importing will be linked to backend fine records', 'info');
        }
    </script>
</body>

</html>