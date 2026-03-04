<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Student Portal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body class="dashboard-body">

    <!-- Sidebar (same as dashboard) -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="{{ url('/') }}" class="sidebar-brand">
                <i class="fas fa-university"></i>
                <span>Lumina Academy</span>
            </a>
        </div>

        <nav class="sidebar-menu">
            <ul class="list-unstyled">
                <li class="sidebar-menu-item"><a href="dashboard.html" class="sidebar-link"><i
                            class="fas fa-home"></i><span>Dashboard</span></a></li>
                <li class="sidebar-menu-item"><a href="profile.html" class="sidebar-link active"><i
                            class="fas fa-user"></i><span>My Profile</span></a></li>
                <li class="sidebar-menu-item"><a href="subjects.html" class="sidebar-link"><i
                            class="fas fa-book"></i><span>Subjects</span></a></li>
                <li class="sidebar-menu-item"><a href="timetable.html" class="sidebar-link"><i
                            class="fas fa-calendar-alt"></i><span>Time Table</span></a></li>
                <li class="sidebar-menu-item"><a href="attendance.html" class="sidebar-link"><i
                            class="fas fa-user-check"></i><span>Attendance</span></a></li>
                <li class="sidebar-menu-item"><a href="results.html" class="sidebar-link"><i
                            class="fas fa-chart-bar"></i><span>Results</span></a></li>
                <li class="sidebar-menu-item"><a href="assignments.html" class="sidebar-link"><i
                            class="fas fa-tasks"></i><span>Assignments</span></a></li>
                <li class="sidebar-menu-item"><a href="quizzes.html" class="sidebar-link"><i
                            class="fas fa-question-circle"></i><span>Quizzes</span></a></li>
                <li class="sidebar-menu-item"><a href="notes.html" class="sidebar-link"><i
                            class="fas fa-file-pdf"></i><span>Notes & PDFs</span></a></li>
                <li class="sidebar-menu-item"><a href="lectures.html" class="sidebar-link"><i
                            class="fas fa-video"></i><span>Lecture Videos</span></a></li>
                <li class="sidebar-menu-item"><a href="announcements.html" class="sidebar-link"><i
                            class="fas fa-bullhorn"></i><span>Announcements</span></a></li>
                <li class="sidebar-menu-item"><a href="fees.html" class="sidebar-link"><i
                            class="fas fa-dollar-sign"></i><span>Fee Details</span></a></li>
                <li class="sidebar-menu-item"><a href="fines.html" class="sidebar-link"><i
                            class="fas fa-exclamation-triangle"></i><span>Fine Details</span></a></li>
                <li class="sidebar-menu-item"><a href="fee-vouchers.html" class="sidebar-link"><i
                            class="fas fa-receipt"></i><span>Fee Vouchers</span></a></li>
            </ul>
        </nav>

        <div class="sidebar-footer p-3 mt-auto">
            <button class="btn btn-outline-light w-100" onclick="logout()">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </button>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <nav class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="btn btn-link text-dark d-lg-none me-3" id="sidebarToggle">
                    <i class="fas fa-bars fs-4"></i>
                </button>
                <h1 class="page-title mb-0">My Profile</h1>
            </div>

            <div class="user-menu">
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
                            <!-- Notifications will be loaded here -->
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
            <div class="row g-4">
                <!-- Profile Card -->
                <div class="col-lg-4" id="profileSidebar">
                    <div class="card-modern animate-fade-in">
                        <div class="card-body text-center p-4" style="padding: 2rem !important;">
                            <div class="mb-3">
                                <div class="user-avatar mx-auto" style="width: 120px; height: 120px; font-size: 3rem;">
                                    JD</div>
                            </div>
                            <h4 class="fw-bold mb-1" id="profileName"></h4>
                            <p class="text-muted mb-1" id="profileClass"></p>
                            <p class="text-muted mb-3"><small id="profileEmail"></small></p>

                            <div class="d-grid">
                                <button class="btn btn-primary btn-sm" onclick="window.print()">
                                    <i class="fas fa-print me-2"></i> Print Profile
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="card-modern animate-fade-in mt-4">
                        <div class="card-header bg-white border-0" style="padding: 1.25rem 1.5rem;">
                            <h6 class="mb-0 fw-bold">Quick Stats</h6>
                        </div>
                        <div class="card-body" style="padding: 1.5rem;">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Attendance</span>
                                <span class="fw-bold text-success">92.5%</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Avg. Grade</span>
                                <span class="fw-bold text-primary">A</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Position</span>
                                <span class="fw-bold text-info">5th</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Details -->
                <div class="col-lg-8" id="profileContent">
                    <div class="card-modern animate-fade-in" id="profileDetails">
                        <div class="card-header bg-white border-0 py-3" style="padding: 1.25rem 1.5rem;">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-user-circle text-primary me-2"></i> Personal
                                Information</h5>
                        </div>
                        <div class="card-body" style="padding: 1.5rem;">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="text-muted small">Full Name</label>
                                    <p class="fw-bold" id="detailName"></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Roll Number</label>
                                    <p class="fw-bold" id="detailRoll"></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Class</label>
                                    <p class="fw-bold" id="detailClass"></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Section</label>
                                    <p class="fw-bold" id="detailSection"></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Date of Birth</label>
                                    <p class="fw-bold" id="detailDob"></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Gender</label>
                                    <p class="fw-bold" id="detailGender"></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Blood Group</label>
                                    <p class="fw-bold" id="detailBlood"></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Admission Date</label>
                                    <p class="fw-bold" id="detailAdmission"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="card-modern animate-fade-in mt-4">
                        <div class="card-header bg-white border-0 py-3" style="padding: 1.25rem 1.5rem;">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-address-book text-success me-2"></i> Contact
                                Information</h5>
                        </div>
                        <div class="card-body" style="padding: 1.5rem;">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="text-muted small">Email Address</label>
                                    <p class="fw-bold" id="detailEmailContact"></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Phone Number</label>
                                    <p class="fw-bold" id="detailPhone"></p>
                                </div>
                                <div class="col-12">
                                    <label class="text-muted small">Address</label>
                                    <p class="fw-bold" id="detailAddress"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Guardian Information -->
                    <div class="card-modern animate-fade-in mt-4">
                        <div class="card-header bg-white border-0 py-3" style="padding: 1.25rem 1.5rem;">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-user-friends text-info me-2"></i> Guardian
                                Information</h5>
                        </div>
                        <div class="card-body" style="padding: 1.5rem;">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="text-muted small">Guardian Name</label>
                                    <p class="fw-bold" id="detailGuardian"></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Guardian Phone</label>
                                    <p class="fw-bold" id="detailGuardianPhone"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Login Information -->
                    <div class="card-modern animate-fade-in mt-4">
                        <div class="card-header bg-white border-0 py-3" style="padding: 1.25rem 1.5rem;">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-key text-warning me-2"></i> Login Information</h5>
                        </div>
                        <div class="card-body" style="padding: 1.5rem;">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="text-muted small">Login Email</label>
                                    <p class="fw-bold" id="detailLoginEmail"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Teacher Remarks (New Section) -->
                    <div class="card-modern animate-fade-in mt-4">
                        <div class="card-header bg-white border-0 py-3" style="padding: 1.25rem 1.5rem;">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold"><i class="fas fa-comments text-primary me-2"></i> Teacher
                                    Remarks</h5>
                                <span class="badge bg-light text-dark" id="remarksCount">0</span>
                            </div>
                        </div>
                        <div class="card-body" style="padding: 1.5rem;">
                            <div id="studentRemarksList">
                                <!-- Remarks will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i> Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editProfileForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="editName">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="editEmail">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">New Password (Leave blank to keep current)</label>
                                <input type="password" class="form-control" id="editPassword">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="editPasswordConfirm">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveProfile()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/auth.js') }}?v=2"></script>
    <script src="{{ asset('assets/js/main.js') }}?v=2"></script>
    <script src="{{ asset('assets/js/data.js') }}?v=2"></script>
    <script src="{{ asset('assets/js/storage.js') }}?v=2"></script>
    <script src="{{ asset('assets/js/notifications.js') }}?v=2"></script>
    <script src="{{ asset('assets/js/search.js') }}?v=2"></script>
    <script src="{{ asset('assets/js/enhancements.js') }}?v=2"></script>
    <script src="{{ asset('assets/js/student-functions.js') }}?v=2"></script>
    <script src="{{ asset('assets/js/remark-functions.js') }}?v=2"></script>

    <script>
        protectPage('student');

        document.addEventListener('DOMContentLoaded', function () {
            initDashboardUser();
            loadProfile();
            loadMyRemarks();
        });

        async function loadProfile() {
            try {
                const response = await fetch('/user');
                const data = await response.json();
                
                if (!data.isLoggedIn || !data.user) {
                    console.error('User not logged in');
                    return;
                }
                
                const user = data.user;

                // Fill UI
                document.getElementById('profileName').innerText = user.name || 'N/A';
                document.getElementById('profileClass').innerText = user.enrolled_class || 'N/A';
                document.getElementById('profileEmail').innerText = user.email || 'N/A';
                
                document.getElementById('detailName').innerText = user.name || 'N/A';
                document.getElementById('detailRoll').innerText = user.roll_number || 'N/A';
                document.getElementById('detailClass').innerText = user.enrolled_class || 'N/A';
                document.getElementById('detailSection').innerText = user.enrolled_class ? user.enrolled_class.split('-')[1] || 'N/A' : 'N/A';
                document.getElementById('detailEmail').innerText = user.email || 'N/A';
                document.getElementById('detailLoginEmail').innerText = user.email || 'N/A';
                
                // Add placeholder data for missing fields
                document.getElementById('detailDob').innerText = '2008-05-15'; // Placeholder
                document.getElementById('detailGender').innerText = 'Male'; // Placeholder
                document.getElementById('detailBlood').innerText = 'B+'; // Placeholder
                document.getElementById('detailAdmission').innerText = '2024-03-01'; // Placeholder

                // Fill Edit Modal
                document.getElementById('editName').value = user.name || '';
                document.getElementById('editEmail').value = user.email || '';
                
                // Update avatar initials
                const initials = (user.name || 'User').split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2);
                document.querySelectorAll('.user-avatar').forEach(el => {
                    el.innerHTML = initials;
                });
                
                console.log('Profile loaded successfully:', user);
            } catch (error) {
                console.error('Error loading profile:', error);
                // Show error message
                document.getElementById('profileName').innerText = 'Error loading profile';
                document.getElementById('detailName').innerText = 'Error loading profile';
            }
        }

        async function saveProfile() {
            const name = document.getElementById('editName').value;
            const email = document.getElementById('editEmail').value;
            const password = document.getElementById('editPassword').value;
            const password_confirmation = document.getElementById('editPasswordConfirm').value;

            if (password && password !== password_confirmation) {
                showToast('Passwords do not match!', 'error');
                return;
            }

            try {
                const response = await fetch('/api/profile', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        name,
                        email,
                        password,
                        password_confirmation
                    })
                });

                const result = await response.json();

                if (result.success) {
                    showToast('Profile updated successfully!', 'success');
                    bootstrap.Modal.getInstance(document.getElementById('editProfileModal')).hide();
                    loadProfile();
                } else {
                    showToast(result.message || 'Failed to update profile', 'error');
                }
            } catch (error) {
                console.error('Error saving profile:', error);
                showToast('An error occurred during update', 'error');
            }
        }

        function loadMyRemarks() {
            // Simplified for now
            document.getElementById('studentRemarksList').innerHTML = '<p class="text-muted small">No remarks from teachers yet.</p>';
        }
    </script>
</body>
</html>

