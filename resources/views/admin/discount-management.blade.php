<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discount Management - Admin Portal</title>

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
                <li class="sidebar-menu-item"><a href="{{ url('admin/dashboard') }}" class="sidebar-link"><i
                            class="fas fa-home"></i><span>Dashboard</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/admissions') }}" class="sidebar-link"><i
                            class="fas fa-user-plus"></i><span>Admissions</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/timetable-input') }}" class="sidebar-link"><i
                            class="fas fa-calendar-plus"></i><span>Timetable Input</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/announcements') }}" class="sidebar-link"><i
                            class="fas fa-bullhorn"></i><span>Announcements</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/class-management') }}" class="sidebar-link"><i
                            class="fas fa-users-cog"></i><span>Class Management</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/subject-assignment') }}" class="sidebar-link"><i
                            class="fas fa-chalkboard-teacher"></i><span>Subject Assignment</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/student-promotion') }}" class="sidebar-link"><i
                            class="fas fa-user-graduate"></i><span>Student Promotion</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/data-correction') }}" class="sidebar-link"><i
                            class="fas fa-edit"></i><span>Data Correction</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/fee-vouchers') }}" class="sidebar-link"><i
                            class="fas fa-file-invoice-dollar"></i><span>Fee Vouchers</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/fines') }}" class="sidebar-link"><i
                            class="fas fa-exclamation-triangle"></i><span>Fine Management</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/discount-management') }}" class="sidebar-link active"><i
                            class="fas fa-percent"></i><span>Discounts</span></a></li>
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
                <h1 class="page-title mb-0">Discount Management</h1>
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
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="card-modern animate-fade-in shadow-lg border-0 h-100">
                        <div class="card-header bg-white border-0 py-4 px-4 border-bottom">
                            <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-plus-circle text-primary me-2"></i>
                                Issue Discount</h5>
                            <p class="text-muted small mb-0 mt-1">Implement academic or financial incentives for student
                                profiles.</p>
                        </div>
                        <div class="card-body p-4">
                            <form id="discountForm">
                                <div class="mb-4">
                                    <label class="form-label fw-bold small text-uppercase tracking-wider">Student Name</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control bg-light border-0 py-3 px-4 shadow-none"
                                            id="studentInput" placeholder="Student Name..." autocomplete="off"
                                            required>
                                        <input type="hidden" id="selectedStudentId">
                                        <ul class="list-group position-absolute w-100 shadow-lg border-0"
                                            id="studentSuggestions"
                                            style="display:none; z-index: 1000; max-height: 250px; overflow-y: auto; border-radius: 12px; margin-top: 5px;">
                                            <!-- Suggestions via JS -->
                                        </ul>
                                    </div>
                                </div>
                                <div class="mb-4 animate-fade-in" id="voucherSelectContainer" style="display: none;">
                                    <label class="form-label fw-bold small text-uppercase tracking-wider">Voucher ID</label>
                                    <select class="form-select bg-light border-0 py-3 px-4 shadow-none"
                                        id="voucherSelect">
                                        <option value="">Voucher ID...</option>
                                    </select>
                                </div>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-uppercase tracking-wider">Discount
                                            Type</label>
                                        <select class="form-select bg-light border-0 py-3 px-4 shadow-none"
                                            id="discountType" required>
                                            <option value="percentage">Percentage (%)</option>
                                            <option value="fixed">Fixed Value ($)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label
                                            class="form-label fw-bold small text-uppercase tracking-wider">Discount
                                            Value</label>
                                        <input type="number"
                                            class="form-control bg-light border-0 py-3 px-4 shadow-none"
                                            id="discountValue" required placeholder="Numerical value">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-bold small text-uppercase tracking-wider">Discount
                                        Reason</label>
                                    <select class="form-select bg-light border-0 py-3 px-4 shadow-none"
                                        id="reasonSelect" required>
                                        <option value="">Choose Discount Reason...</option>
                                        <option value="Merit-based">Merit-based Distinction</option>
                                        <option value="Financial Aid">Fiscal Subsidy</option>
                                        <option value="Sibling Discount">Kinship Privilege</option>
                                        <option value="Other">Miscellaneous Strategic Adjustment</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-bold small text-uppercase tracking-wider">Discount
                                        Details</label>
                                    <textarea class="form-control bg-light border-0 py-3 px-4 shadow-none" id="notes"
                                        rows="2" placeholder="Discount Details..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold lift shadow-sm">
                                    <i class="fas fa-check-double me-2"></i> Apply Discount
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card-modern animate-fade-in shadow-lg border-0 mb-4">
                        <div class="card-header bg-white border-0 py-4 px-4 border-bottom">
                            <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-chart-pie text-info me-2"></i> Discount
                                Analytics</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4" id="statsRow">
                                <!-- Stats injected via JS -->
                                <div class="col-12">
                                    <div class="alert bg-info-subtle text-info border-0 p-4 mb-0 animate-pulse">
                                        <i class="fas fa-sync-alt fa-spin me-2"></i> Loading Discount Analytics...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-modern animate-fade-in shadow-lg border-0">
                        <div class="card-header bg-white border-0 py-4 px-4 border-bottom">
                            <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-list text-success me-2"></i> Active
                                Concession Registry</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light text-muted small text-uppercase fw-bold">
                                        <tr class="border-0">
                                            <th class="ps-4">Discount ID</th>
                                            <th>Student</th>
                                            <th>Discount</th>
                                            <th>Reason</th>
                                            <th class="pe-4 text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="discountsTableBody">
                                        <!-- Populated via JS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
    <script src="{{ asset('assets/js/student-functions.js') }}"></script>
    <script src="{{ asset('assets/js/voucher-functions.js') }}"></script>
    <script src="{{ asset('assets/js/discount-functions.js') }}"></script>
    <script>
        protectPage('admin');

        document.addEventListener('DOMContentLoaded', async function () {
            initDashboardUser();
            
            loadActiveDiscounts();

            // Setup Autocomplete
            const studentInput = document.getElementById('studentInput');
            const suggestionsList = document.getElementById('studentSuggestions');

            studentInput.addEventListener('input', async function () {
                const query = this.value.toLowerCase();
                suggestionsList.innerHTML = '';

                if (query.length < 1) {
                    suggestionsList.style.display = 'none';
                    return;
                }

                const response = await fetch(`/api/students`);
                const allStudents = await response.json();
                
                const filtered = allStudents.filter(s =>
                    s.name.toLowerCase().includes(query) ||
                    (s.roll_number && s.roll_number.toLowerCase().includes(query))
                );

                if (filtered.length > 0) {
                    suggestionsList.style.display = 'block';
                    filtered.forEach(s => {
                        const li = document.createElement('li');
                        li.className = 'list-group-item list-group-item-action cursor-pointer';
                        li.style.cursor = 'pointer';
                        li.innerHTML = `<strong>${s.name}</strong> <small class="text-muted">(${s.roll_number || 'N/A'})</small>`;
                        li.onclick = () => selectStudent(s);
                        suggestionsList.appendChild(li);
                    });
                } else {
                    suggestionsList.style.display = 'none';
                }
            });

            // ... rest of event listeners
        });

        function selectStudent(student) {
            document.getElementById('studentInput').value = `${student.name} (${student.roll_number || 'N/A'})`;
            document.getElementById('selectedStudentId').value = student.id;
            document.getElementById('studentSuggestions').style.display = 'none';
        }

        async function applyDiscountForm() {
            const userId = document.getElementById('selectedStudentId').value;
            const type = document.getElementById('discountType').value;
            const value = parseFloat(document.getElementById('discountValue').value);
            const reason = document.getElementById('reasonSelect').value;
            const notes = document.getElementById('notes').value;

            if (!userId) {
                showToast('Please search and select a student', 'error');
                return;
            }

            const data = {
                user_id: userId,
                type: type,
                description: reason + ': ' + notes,
                is_active: true
            };

            if (type === 'percentage') {
                data.percentage = value;
            } else {
                data.amount = value;
            }

            const result = await applyDiscount(data);
            if (result.success) {
                showToast('Discount applied successfully!', 'success');
                document.getElementById('discountForm').reset();
                document.getElementById('studentInput').value = '';
                document.getElementById('selectedStudentId').value = '';
                loadActiveDiscounts();
            } else {
                showToast(result.message || 'Failed to apply discount', 'error');
            }
        }

        async function loadActiveDiscounts() {
            const discounts = await getAllDiscounts();
            const tbody = document.getElementById('discountsTableBody');

            if (discounts.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="p-5 text-center text-muted"><i class="fas fa-percent fs-1 mb-3 d-block opacity-25"></i>No active concessions identified in the registry.</td></tr>';
                return;
            }

            let html = '';
            discounts.forEach(d => {
                const typeLabel = d.percentage ? 'PERCENT' : 'FIXED';
                const valueLabel = d.percentage ? `${d.percentage}%` : `$${d.amount}`;
                const color = d.percentage ? 'info' : 'primary';

                html += `
                    <tr>
                        <td class="ps-4"><span class="badge-modern bg-light text-dark fw-bold tracking-tight">${d.id}</span></td>
                        <td>${d.user?.name}</td>
                        <td><span class="badge-modern bg-${color}-subtle text-${color} fw-bold">${typeLabel}</span></td>
                        <td><div class="fw-bold text-dark">${valueLabel}</div></td>
                        <td><div class="small fw-bold text-dark">${d.description || 'N/A'}</div></td>
                        <td class="pe-4 text-end">
                             <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-sm btn-outline-danger lift" onclick="revokeDiscount('${d.id}')" title="Revoke Privilege"><i class="fas fa-trash-alt"></i></button>
                             </div>
                        </td>
                    </tr>
                `;
            });
            tbody.innerHTML = html;
            updateDiscountStatistics(discounts);
        }

        function updateDiscountStatistics(discounts) {
            const totalCount = discounts.length;
            const statsRow = document.getElementById('statsRow');
            if (statsRow) {
                statsRow.innerHTML = `
                    <div class="col-md-6">
                        <div class="card-modern p-4 bg-success-subtle border-0 h-100">
                            <h6 class="text-success small text-uppercase fw-bold mb-3">Active Registry</h6>
                            <h3 class="fw-bold text-dark mb-1">${totalCount}</h3>
                            <div class="text-success small fw-bold">Allocated Privileges</div>
                        </div>
                    </div>
                `;
            }
        }

        async function revokeDiscount(id) {
            if (!confirm('Are you sure you want to remove this discount?')) return;
            const result = await deleteDiscount(id);
            if (result.success) {
                showToast('Discount removed successfully', 'success');
                loadActiveDiscounts();
            }
        }

        document.getElementById('discountForm').onsubmit = (e) => {
            e.preventDefault();
            applyDiscountForm();
        };
    </script>
</body>

</html>
