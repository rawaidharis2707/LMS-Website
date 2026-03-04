<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Management - Super Admin Portal</title>

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
                <li class="sidebar-menu-item"><a href="{{ route('superadmin.dashboard') }}" class="sidebar-link"><i
                            class="fas fa-home"></i><span>Dashboard</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('superadmin/announcements.html') }}" class="sidebar-link"><i
                            class="fas fa-bullhorn"></i><span>Announcements</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('superadmin/role-distribution.html') }}" class="sidebar-link"><i
                            class="fas fa-user-shield"></i><span>Roles & Permissions</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('superadmin/finance.html') }}" class="sidebar-link"><i
                            class="fas fa-money-bill-wave"></i><span>Funds Management</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('superadmin/salary.html') }}" class="sidebar-link active"><i
                            class="fas fa-wallet"></i><span>Salary Management</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('superadmin/teacher-attendance.html') }}" class="sidebar-link"><i
                            class="fas fa-clipboard-check"></i><span>Teacher Attendance</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('superadmin/reports.html') }}" class="sidebar-link"><i
                            class="fas fa-file-alt"></i><span>Reports</span></a></li>

                <li class="sidebar-menu-item"><a href="{{ url('superadmin/activity-logs.html') }}" class="sidebar-link"><i
                            class="fas fa-history"></i><span>Activity Logs</span></a></li>
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
                <h1 class="page-title mb-0">Salary & Payroll Management</h1>
            </div>
            <div class="user-menu">
                <div class="user-avatar"><span>SA</span></div>
                <div class="d-none d-md-block ms-3">
                    <div class="fw-bold">Super Admin</div>
                    <div class="small text-muted">System Administrator</div>
                </div>
            </div>
        </nav>

        <div class="dashboard-content">
            <!-- Stats Row -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="stat-widget widget-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="opacity-75 mb-1">Total Staff</h6>
                                <h3 class="fw-bold mb-0" id="statTotalStaff">--</h3>
                            </div>
                            <div class="stat-widget-icon bg-white bg-opacity-25"><i class="fas fa-users"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-widget widget-success text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="opacity-75 mb-1">Total Paid (Lifetime)</h6>
                                <h3 class="fw-bold mb-0" id="statTotalPaid">--</h3>
                            </div>
                            <div class="stat-widget-icon bg-white bg-opacity-25"><i class="fas fa-money-check-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-widget widget-warning text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="opacity-75 mb-1">Pending Approval</h6>
                                <h3 class="fw-bold mb-0">3</h3>
                            </div>
                            <div class="stat-widget-icon bg-white bg-opacity-25"><i
                                    class="fas fa-exclamation-circle"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs mb-4" id="salaryTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="staff-tab" data-bs-toggle="tab" data-bs-target="#staff"
                        type="button"><i class="fas fa-id-card me-2"></i>Staff Structure</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="payroll-tab" data-bs-toggle="tab" data-bs-target="#payroll"
                        type="button"><i class="fas fa-file-invoice-dollar me-2"></i>Generate Payroll</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history"
                        type="button"><i class="fas fa-history me-2"></i>Payment History</button>
                </li>
            </ul>

            <div class="tab-content">
                <!-- 1. Staff Structure -->
                <div class="tab-pane fade show active" id="staff" role="tabpanel">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Staff Salary Details</h5>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-success btn-sm" onclick="exportStaffStructure()">
                                    <i class="fas fa-file-excel me-2"></i> Export Staff List
                                </button>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#addStaffModal"><i class="fas fa-user-plus me-2"></i> Add
                                    Staff</button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Base Salary</th>
                                            <th>Allowances</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="staffTableBody">
                                        <!-- JS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Payroll Generation -->
                <div class="tab-pane fade" id="payroll" role="tabpanel">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Monthly Payroll Processing</h5>
                            <div class="d-flex align-items-center gap-2">
                                <select class="form-select form-select-sm" id="payrollMonth">
                                    <option value="December 2024">December 2024</option>
                                    <option value="November 2024">November 2024</option>
                                </select>
                                <button class="btn btn-success btn-sm" onclick="loadPayrollTable()">
                                    <i class="fas fa-sync-alt me-1"></i> Refresh
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Employee</th>
                                            <th>Gross Salary</th>
                                            <th>Deductions (Fine/Tax)</th>
                                            <th>Net Salary</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="payrollTableBody">
                                        <!-- JS -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-3 bg-light">
                                <small class="text-muted"><i class="fas fa-info-circle"></i> Deductions include fines
                                    for Absenteeism ($500/day) and Late Arrivals ($200/day).</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. History -->
                <div class="tab-pane fade" id="history" role="tabpanel">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Payment Log</h5>
                            <button class="btn btn-sm btn-outline-success" onclick="exportSalaryHistory()">
                                <i class="fas fa-file-excel me-2"></i> Export Excel
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Employee ID</th>
                                            <th>For Month</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Slip</th>
                                        </tr>
                                    </thead>
                                    <tbody id="historyTableBody">
                                        <!-- JS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Add Staff Modal -->
    <div class="modal fade" id="addStaffModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addStaffForm" onsubmit="handleStaffSubmit(event)">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="name" id="addName" list="staffSuggestions"
                                placeholder="Start typing to search..." oninput="checkAutoFill(this.value)" required>
                            <datalist id="staffSuggestions">
                                <!-- Populated by JS -->
                            </datalist>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Employee ID</label>
                                <input type="text" class="form-control" name="id" id="addEmpId" placeholder="EMP..."
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Role</label>
                                <select class="form-select" name="role" id="addRole">
                                    <option>Teacher</option>
                                    <option>Admin</option>
                                    <option>Support Staff</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <input type="text" class="form-control" name="department" id="addDepartment" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Base Salary</label>
                                <input type="number" class="form-control" name="baseSalary" id="addBaseSalary" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Allowances</label>
                                <input type="number" class="form-control" name="allowances" id="addAllowances"
                                    value="0">
                            </div>
                        </div>

                        <h6 class="border-bottom pb-2 mb-3 mt-2 text-primary">Banking Details</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Bank Name</label>
                                <input type="text" class="form-control" name="bankName" id="addBankName"
                                    placeholder="e.g. Chase Bank">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Account Number</label>
                                <input type="text" class="form-control" name="accountNumber" id="addAccountNumber"
                                    placeholder="e.g. 1234567890">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Account Title</label>
                            <input type="text" class="form-control" name="accountTitle" id="addAccountTitle"
                                placeholder="Name on Card">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Save Staff Member</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Staff Modal -->
    <div class="modal fade" id="editStaffModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Staff Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editStaffForm" onsubmit="handleEditStaffSubmit(event)">
                        <input type="hidden" name="id" id="editEmpId">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="name" id="editName" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Employee ID</label>
                                <input type="text" class="form-control" id="editEmpIdDisplay" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Role</label>
                                <select class="form-select" name="role" id="editRole">
                                    <option>Teacher</option>
                                    <option>Admin</option>
                                    <option>Support Staff</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <input type="text" class="form-control" name="department" id="editDepartment" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Base Salary</label>
                                <input type="number" class="form-control" name="baseSalary" id="editBaseSalary"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Allowances</label>
                                <input type="number" class="form-control" name="allowances" id="editAllowances"
                                    value="0">
                            </div>
                        </div>

                        <h6 class="border-bottom pb-2 mb-3 mt-2 text-primary">Banking Details</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Bank Name</label>
                                <input type="text" class="form-control" name="bankName" id="editBankName">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Account Number</label>
                                <input type="text" class="form-control" name="accountNumber" id="editAccountNumber">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Account Title</label>
                            <input type="text" class="form-control" name="accountTitle" id="editAccountTitle">
                        </div>

                        <button type="submit" class="btn btn-warning w-100">Update Staff Member</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Confirmation Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Confirm Salary Payment</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Processing payment for: <strong id="payEmpName"></strong></p>

                    <!-- Bank Details Display Block -->
                    <div id="bankDetailsDisplay" class="alert alert-info border d-none">
                        <small class="d-block text-muted mb-1">Beneficiary Details:</small>
                        <div class="fw-bold" id="bdName">-</div>
                        <div id="bdNumber">-</div>
                    </div>

                    <div class="alert alert-light border">
                        <div class="d-flex justify-content-between">
                            <span>Net Payable:</span>
                            <strong class="text-success" id="payAmountDisplay">$0.00</strong>
                        </div>
                    </div>
                    <form id="paymentForm">
                        <input type="hidden" id="payEmpId">
                        <input type="hidden" id="payMonth">
                        <input type="hidden" id="payAmount">

                        <div class="mb-3">
                            <label class="form-label">Payment Method</label>
                            <select class="form-select" id="payMethod" required>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Cash">Cash</option>
                                <option value="Cheque">Cheque</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Transaction/Cheque Ref (Optional)</label>
                            <input type="text" class="form-control" id="payRef" placeholder="e.g. TXN-123456">
                        </div>
                        <button type="button" onclick="processSalaryPayment()" class="btn btn-success w-100">Confirm
                            Transfer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        protectPage('superadmin');

        let staffList = [];
        let salaries = [];

        document.addEventListener('DOMContentLoaded', async function () {
            initDashboardUser();
            await loadStaff();
            await loadSalaries();
            updateStats();
        });

        async function loadStaff() {
            try {
                // Fetch teachers and admins
                const [teachers, admins] = await Promise.all([
                    fetch('/api/teachers').then(r => r.json()),
                    fetch('/api/users?role=admin').then(r => r.json())
                ]);
                
                staffList = [...teachers, ...admins];
                renderStaffTable();
                populateStaffSuggestions();
            } catch (error) {
                console.error('Error loading staff:', error);
            }
        }

        function renderStaffTable() {
            const tbody = document.getElementById('staffTableBody');
            tbody.innerHTML = '';

            staffList.forEach(staff => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${staff.id}</td>
                    <td><div class="fw-bold text-dark">${staff.name}</div></td>
                    <td><span class="badge bg-light text-dark">${staff.role}</span></td>
                    <td>$50,000</td> <!-- Simulated base salary if not in DB -->
                    <td>$2,000</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" onclick="editStaff(${staff.id})"><i class="fas fa-edit"></i></button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        async function loadSalaries() {
            const month = document.getElementById('payrollMonth').value;
            try {
                const response = await fetch(`/api/salaries?month=${encodeURIComponent(month)}`);
                salaries = await response.json();
                renderPayrollTable();
                renderHistoryTable();
            } catch (error) {
                console.error('Error loading salaries:', error);
            }
        }

        function renderPayrollTable() {
            const tbody = document.getElementById('payrollTableBody');
            tbody.innerHTML = '';

            // Combine staffList and existing salaries for the month
            staffList.forEach(staff => {
                const salary = salaries.find(s => s.user_id === staff.id);
                const status = salary ? salary.status : 'Pending';
                const statusClass = status === 'Paid' ? 'success' : (status === 'Unpaid' ? 'warning' : 'secondary');
                
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>
                        <div class="fw-bold text-dark">${staff.name}</div>
                        <div class="small text-muted">ID: ${staff.id}</div>
                    </td>
                    <td>$${salary ? parseFloat(salary.base_salary).toLocaleString() : '50,000'}</td>
                    <td>$${salary ? parseFloat(salary.deductions).toLocaleString() : '0'}</td>
                    <td><div class="fw-bold text-dark">$${salary ? parseFloat(salary.net_salary).toLocaleString() : '50,000'}</div></td>
                    <td><span class="badge bg-${statusClass}">${status}</span></td>
                    <td>
                        ${status === 'Pending' || status === 'Unpaid' ? 
                            `<button class="btn btn-sm btn-success" onclick="openPaymentModal(${staff.id}, '${salary ? salary.id : ''}')">Pay Now</button>` :
                            `<button class="btn btn-sm btn-outline-dark" onclick="viewSlip(${salary.id})">Slip</button>`
                        }
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        function renderHistoryTable() {
            const tbody = document.getElementById('historyTableBody');
            tbody.innerHTML = '';

            salaries.filter(s => s.status === 'Paid').forEach(s => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${new Date(s.payment_date).toLocaleDateString()}</td>
                    <td>${s.user_id}</td>
                    <td>${s.month}</td>
                    <td><div class="fw-bold text-dark">$${parseFloat(s.net_salary).toLocaleString()}</div></td>
                    <td><span class="badge bg-success">Paid</span></td>
                    <td><button class="btn btn-sm btn-link" onclick="viewSlip(${s.id})"><i class="fas fa-file-pdf"></i></button></td>
                `;
                tbody.appendChild(tr);
            });
        }

        async function openPaymentModal(staffId, salaryId) {
            const staff = staffList.find(s => s.id === staffId);
            const month = document.getElementById('payrollMonth').value;
            
            document.getElementById('payEmpName').innerText = staff.name;
            document.getElementById('payEmpId').value = staffId;
            document.getElementById('payMonth').value = month;
            document.getElementById('payAmountDisplay').innerText = '$50,000'; // Simulation
            document.getElementById('payAmount').value = 50000;

            const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
            modal.show();
        }

        async function processSalaryPayment() {
            const userId = document.getElementById('payEmpId').value;
            const month = document.getElementById('payMonth').value;
            const amount = document.getElementById('payAmount').value;
            const method = document.getElementById('payMethod').value;

            try {
                const response = await fetch('/api/salaries', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        user_id: userId,
                        base_salary: amount,
                        month: month,
                        status: 'Paid',
                        payment_date: new Date().toISOString().split('T')[0],
                        payment_method: method
                    })
                });

                const result = await response.json();
                if (result.success) {
                    showToast('Payment successful!', 'success');
                    bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();
                    await loadSalaries();
                    updateStats();
                }
            } catch (error) {
                console.error('Error processing payment:', error);
            }
        }

        function updateStats() {
            document.getElementById('statTotalStaff').innerText = staffList.length;
            const totalPaid = salaries.filter(s => s.status === 'Paid').reduce((sum, s) => sum + parseFloat(s.net_salary), 0);
            document.getElementById('statTotalPaid').innerText = `$${totalPaid.toLocaleString()}`;
        }

        function populateStaffSuggestions() {
            const list = document.getElementById('staffSuggestions');
            list.innerHTML = '';
            staffList.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.name;
                list.appendChild(opt);
            });
        }

        function viewSlip(id) {
            showToast('Slip generation coming soon (PDF export)', 'info');
        }

        async function loadPayrollTable() {
            await loadSalaries();
        }

        function handleStaffSubmit(e) { e.preventDefault(); showToast('Staff structure updates coming soon', 'info'); }
        function handleEditStaffSubmit(e) { e.preventDefault(); showToast('Staff structure updates coming soon', 'info'); }
    </script>
</body>

</html>