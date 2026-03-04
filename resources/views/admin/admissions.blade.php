<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admission Management - EduPro LMS</title>
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
                <li class="sidebar-menu-item"><a href="{{ route('admin.dashboard') }}" class="sidebar-link"><i
                            class="fas fa-home"></i><span>Dashboard</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ route('admin.admissions') }}" class="sidebar-link active"><i
                            class="fas fa-user-plus"></i><span>Admissions</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/timetable-input.html') }}" class="sidebar-link"><i
                            class="fas fa-calendar-plus"></i><span>Timetable Input</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/announcements.html') }}" class="sidebar-link"><i
                            class="fas fa-bullhorn"></i><span>Announcements</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/class-management.html') }}" class="sidebar-link"><i
                            class="fas fa-school"></i><span>Class Management</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/subject-assignment.html') }}" class="sidebar-link"><i
                            class="fas fa-book"></i><span>Subject Assignment</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/student-promotion.html') }}" class="sidebar-link"><i
                            class="fas fa-level-up-alt"></i><span>Student Promotion</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/data-correction.html') }}" class="sidebar-link"><i
                            class="fas fa-user-edit"></i><span>Data Correction</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/fee-vouchers.html') }}" class="sidebar-link"><i
                            class="fas fa-receipt"></i><span>Fee Vouchers</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/fines.html') }}" class="sidebar-link"><i
                            class="fas fa-exclamation-triangle"></i><span>Fine Management</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/teacher-attendance.html') }}" class="sidebar-link"><i
                            class="fas fa-user-clock"></i><span>Teacher Attendance</span></a></li>
                <li class="sidebar-menu-item"><a href="{{ url('admin/discount-management.html') }}" class="sidebar-link"><i
                            class="fas fa-percentage"></i><span>Discount Management</span></a></li>
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
                <h1 class="page-title mb-0">Admissions Portal</h1>
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

        <div class="dashboard-content px-4 py-4">
            <!-- Stats -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card-modern animate-fade-in p-4 shadow-sm lift h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning-subtle text-warning rounded-circle p-3 me-3">
                                <i class="fas fa-clock-rotate-left fs-4"></i>
                            </div>
                            <h6 class="text-muted small text-uppercase fw-bold mb-0">Pending Review</h6>
                        </div>
                        <h2 class="fw-bold mb-0 text-dark" id="statPending">0</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-modern animate-fade-in p-4 shadow-sm lift h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success-subtle text-success rounded-circle p-3 me-3">
                                <i class="fas fa-user-check fs-4"></i>
                            </div>
                            <h6 class="text-muted small text-uppercase fw-bold mb-0">Verified & Paid</h6>
                        </div>
                        <h2 class="fw-bold mb-0 text-dark" id="statVerified">0</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-modern animate-fade-in p-4 shadow-sm lift h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-danger-subtle text-danger rounded-circle p-3 me-3">
                                <i class="fas fa-user-xmark fs-4"></i>
                            </div>
                            <h6 class="text-muted small text-uppercase fw-bold mb-0">Rejected</h6>
                        </div>
                        <h2 class="fw-bold mb-0 text-dark" id="statRejected">0</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-modern animate-fade-in p-4 shadow-sm lift h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary-subtle text-primary rounded-circle p-3 me-3">
                                <i class="fas fa-file-invoice fs-4"></i>
                            </div>
                            <h6 class="text-muted small text-uppercase fw-bold mb-0">Total Submissions</h6>
                        </div>
                        <h2 class="fw-bold mb-0 text-dark" id="statTotal">0</h2>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="card-modern animate-fade-in shadow-sm border-0">
                <div
                    class="card-header bg-white border-0 py-4 px-4 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-list-check text-primary me-2"></i> Application
                        Requests</h5>
                    <div class="d-flex gap-2">
                        <div class="input-group" style="width: 300px;">
                            <span class="input-group-text bg-light border-0"><i
                                    class="fas fa-search text-muted"></i></span>
                            <input type="text" class="form-control bg-light border-0 shadow-none" id="searchInput"
                                placeholder="Search by name or ID..." onkeyup="loadAdmissions()">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase fw-bold">
                                <tr class="border-0">
                                    <th class="ps-4">Application ID</th>
                                    <th>Applicant Details</th>
                                    <th>Class</th>
                                    <th>Date Applied</th>
                                    <th>Voucher ID</th>
                                    <th>Fee Registry</th>
                                    <th>Final Status</th>
                                    <th class="pe-4 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody id="admissionsTableBody">
                                <!-- Dynamic -->
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center py-5 text-muted opacity-50" id="noDataMsg" style="display: none;">
                        <i class="fas fa-folder-open fa-3x mb-3"></i>
                        <p class="fs-5 mb-0">Empty Registry</p>
                        <p class="small">No admission applications match your criteria.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Application Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="currentAppId">

                    <!-- Applicant Info -->
                    <h6 class="border-bottom pb-2 mb-3 text-primary">Student Information</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4"><strong>Full Name:</strong> <span id="dName"></span></div>
                        <div class="col-md-4"><strong>Father's Name:</strong> <span id="dFather"></span></div>
                        <div class="col-md-4"><strong>DOB:</strong> <span id="dDob"></span></div>
                        <div class="col-md-4"><strong>CNIC/B-Form:</strong> <span id="dCnic"></span></div>
                        <div class="col-md-4"><strong>Gender:</strong> <span id="dGender"></span></div>
                        <div class="col-md-4"><strong>Class Applied:</strong> <span id="dClass"></span></div>
                    </div>

                    <!-- Contact Info -->
                    <h6 class="border-bottom pb-2 mb-3 text-primary">Contact Details</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6"><strong>Phone:</strong> <span id="dPhone"></span></div>
                        <div class="col-md-6"><strong>Email:</strong> <span id="dEmail"></span></div>
                        <div class="col-md-12"><strong>Address:</strong> <span id="dAddress"></span></div>
                    </div>

                    <!-- Academic Info -->
                    <h6 class="border-bottom pb-2 mb-3 text-primary">Academic History</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6"><strong>Previous School:</strong> <span id="dSchool"></span></div>
                        <div class="col-md-3"><strong>Marks:</strong> <span id="dMarks"></span></div>
                        <div class="col-md-3"><strong>Percentage:</strong> <span id="dPerc"></span></div>
                    </div>

                    <!-- Fee Info -->
                    <h6 class="border-bottom pb-2 mb-3 text-primary">Fee & Payment</h6>
                    <div class="row g-3 mb-4 align-items-center bg-light p-3 rounded">
                        <div class="col-md-4"><strong>Voucher ID:</strong> <span id="dVoucher"></span></div>
                        <div class="col-md-4">
                            <strong>Status:</strong>
                            <span id="dFeeStatus" class="badge bg-secondary">Unverified</span>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-sm btn-outline-success" onclick="toggleFeeStatus()"
                                id="btnToggleFee">Mark Paid</button>
                        </div>
                    </div>

                    <!-- Documents -->
                    <h6 class="border-bottom pb-2 mb-3 text-primary">Documents</h6>
                    <div class="mb-3" id="docsContainer">
                        <small class="text-muted">No documents uploaded.</small>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" onclick="updateAppStatus('Rejected')">Reject
                        Application</button>
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" onclick="updateAppStatus('Admitted')">Approve &
                            Admit</button>
                    </div>
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

    <script>
        protectPage('admin');
        let detailsModal;
        let currentApp = null;

        document.addEventListener('DOMContentLoaded', function () {
            initDashboardUser();
            detailsModal = new bootstrap.Modal(document.getElementById('detailsModal'));
            loadAdmissions();
        });

        let admissionsCache = [];

        function getAdmissions() {
            return admissionsCache;
        }

        async function loadAdmissions() {
            try {
                const r = await fetch('/api/admissions?search=' + encodeURIComponent(document.getElementById('searchInput')?.value || ''));
                admissionsCache = await r.json();
                console.log('Loaded admissions:', admissionsCache); // Debug line
            } catch (e) {
                console.error('Error loading admissions:', e); // Debug line
                admissionsCache = [];
            }
            renderTable();
            updateStats();
        }

        function renderTable() {
            const data = getAdmissions();
            const filter = document.getElementById('searchInput').value.toLowerCase();
            const tbody = document.getElementById('admissionsTableBody');
            tbody.innerHTML = '';

            const filtered = data.filter(item =>
                (item.fullName || '').toLowerCase().includes(filter) ||
                (item.id || '').toLowerCase().includes(filter)
            );

            if (filtered.length === 0) {
                document.getElementById('noDataMsg').style.display = 'block';
                return;
            }
            document.getElementById('noDataMsg').style.display = 'none';

            filtered.forEach(item => {
                console.log('Rendering item with ID:', item.id, 'Data:', item); // Debug
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td><span class="fw-bold small text-muted">${item.id}</span></td>
                    <td>
                        <div class="fw-bold">${item.fullName}</div>
                        <div class="small text-muted">${item.fatherName}</div>
                    </td>
                    <td>${item.classApply}</td>
                    <td><small>${item.date || 'N/A'}</small></td>
                    <td><span class="font-monospace small">${item.voucherId || '-'}</span></td>
                    <td>${getFeeBadge(item.paymentStatus)}</td>
                    <td>${getStatusBadge(item.status)}</td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-primary" onclick="viewDetails('${item.id}')">
                            <i class="fas fa-eye"></i> View
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        function getFeeBadge(status) {
            if (status === 'Paid') return '<span class="badge-modern bg-success-subtle text-success fw-bold">Verified Paid</span>';
            return '<span class="badge-modern bg-warning-subtle text-warning fw-bold">Payment Due</span>';
        }

        function getStatusBadge(status) {
            if (status === 'Admitted') return '<span class="badge-modern bg-success text-white fw-bold">Admission Granted</span>';
            if (status === 'Rejected') return '<span class="badge-modern bg-danger-subtle text-danger fw-bold">Registry Denied</span>';
            return '<span class="badge-modern bg-info-subtle text-info fw-bold">Under Review</span>';
        }

        function updateStats() {
            const data = getAdmissions();
            document.getElementById('statTotal').innerText = data.length;
            document.getElementById('statPending').innerText = data.filter(x => x.status === 'Pending Review').length;
            document.getElementById('statVerified').innerText = data.filter(x => x.status === 'Admitted').length;
            document.getElementById('statRejected').innerText = data.filter(x => x.status === 'Rejected').length;
        }

        function viewDetails(id) {
            console.log('View Details called with ID:', id, 'Type:', typeof id); // Debug
            const data = getAdmissions();
            console.log('Available admissions:', data); // Debug
            console.log('Looking for match...'); // Debug
            
            // Convert both to strings for comparison
            currentApp = data.find(x => String(x.id) === String(id));
            console.log('Found app:', currentApp); // Debug
            
            if (!currentApp) {
                alert('Admission record not found!');
                console.log('No match found for ID:', id); // Debug
                console.log('Available IDs:', data.map(x => x.id)); // Debug
                return;
            }

            document.getElementById('currentAppId').value = currentApp.id;

            // Populate Fields
            setText('dName', currentApp.fullName);
            setText('dFather', currentApp.fatherName);
            setText('dDob', currentApp.dob);
            setText('dCnic', currentApp.cnic);
            setText('dGender', currentApp.gender);
            setText('dClass', currentApp.classApply);
            setText('dPhone', currentApp.mobile);
            setText('dEmail', currentApp.email);
            setText('dAddress', currentApp.address);
            setText('dSchool', currentApp.prevSchool);
            setText('dMarks', currentApp.marksObtained + ' / ' + currentApp.totalMarks);
            setText('dPerc', currentApp.percentage);
            setText('dVoucher', currentApp.voucherId);

            // Fee Status UI
            const feeStatusEl = document.getElementById('dFeeStatus');
            const toggleBtn = document.getElementById('btnToggleFee');

            feeStatusEl.className = currentApp.paymentStatus === 'Paid' ? 'badge bg-success' : 'badge bg-warning text-dark';
            feeStatusEl.innerText = currentApp.paymentStatus;

            toggleBtn.className = currentApp.paymentStatus === 'Paid' ? 'btn btn-sm btn-outline-warning' : 'btn btn-sm btn-outline-success';
            toggleBtn.innerText = currentApp.paymentStatus === 'Paid' ? 'Mark Unpaid' : 'Mark Paid';

            // Documents
            const dc = document.getElementById('docsContainer');
            const docs = currentApp.docs || {};
            const entries = [
                { key: 'photo', label: 'Photo', icon: 'far fa-image' },
                { key: 'feeReceipt', label: 'Receipt', icon: 'fas fa-file-invoice-dollar' },
                { key: 'studentCnic', label: 'Student CNIC', icon: 'far fa-id-card' },
                { key: 'guardianCnic', label: 'Guardian CNIC', icon: 'far fa-id-card' },
                { key: 'resultCard', label: 'Result Card', icon: 'fas fa-file-alt' },
                { key: 'characterCert', label: 'Character Cert', icon: 'fas fa-certificate' },
                { key: 'domicile', label: 'Domicile', icon: 'fas fa-home' },
            ];
            const items = entries.filter(e => docs[e.key]);
            if (items.length === 0) {
                dc.innerHTML = '<small class="text-muted">No documents uploaded.</small>';
            } else {
                dc.innerHTML = `
                    <div class="row g-3">
                        ${items.map(e => `
                            <div class="col-md-3">
                                <a href="${docs[e.key]}" target="_blank" class="text-decoration-none">
                                    <div class="border p-3 rounded text-center bg-light h-100">
                                        <i class="${e.icon} fa-2x text-primary mb-2"></i><br>
                                        <small class="fw-bold">${e.label}</small>
                                    </div>
                                </a>
                            </div>
                        `).join('')}
                    </div>
                `;
            }

            detailsModal.show();
        }

        function setText(id, val) {
            document.getElementById(id).innerText = val || '-';
        }

        async function toggleFeeStatus() {
            if (!currentApp) return;
            const newStatus = currentApp.paymentStatus === 'Paid' ? 'Unpaid' : 'Paid';
            try {
                const r = await fetch('/api/admissions/' + encodeURIComponent(currentApp.id), {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                    body: JSON.stringify({ payment_status: newStatus }),
                });
                const data = await r.json();
                if (data.success) {
                    currentApp.paymentStatus = newStatus;
                    viewDetails(currentApp.id);
                    loadAdmissions();
                }
            } catch (e) {
                alert('Failed to update payment status.');
            }
        }

        async function updateAppStatus(status) {
            if (!currentApp) return;
            if (!confirm(`Are you sure you want to mark this application as ${status}?`)) return;

            try {
                const r = await fetch('/api/admissions/' + encodeURIComponent(currentApp.id), {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                    body: JSON.stringify({ status }),
                });
                const data = await r.json();
                if (data.success) {
                    if (status === 'Admitted') {
                        alert(`Student account created for ${currentApp.fullName}.\nEmail: ${currentApp.email}\nDefault Password: 123`);
                    }
                    detailsModal.hide();
                    loadAdmissions();
                } else {
                    alert(data.message || 'Update failed.');
                }
            } catch (e) {
                alert('Failed to update status.');
            }
        }
    </script>
</body>

</html>
