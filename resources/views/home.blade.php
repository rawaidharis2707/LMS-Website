@extends('layouts.app')

@section('content')
<style>
.portal-card {
    height: 100%;
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.portal-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.portal-card .card-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.portal-card .btn {
    margin-top: auto;
}

.portal-header img {
    height: 200px;
    object-fit: cover;
    width: 100%;
}
</style>
    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&q=80&w=1920" alt="University Campus"
            class="hero-bg" fetchpriority="high">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge animate-fade-in">
                    <i class="fas fa-star text-warning"></i> #1 Ranked International Academy
                </div>
                <h1 class="display-3 fw-extrabold mb-4 animate-fade-in-delay">Empowering Tomorrow's Leaders Today</h1>
                <p class="lead mb-5 opacity-90 animate-fade-in-delay-2">
                    Join a community dedicated to academic excellence, innovation, and holistic development. Your future
                    begins at Lumina International Academy.
                </p>
                <div class="d-flex flex-wrap gap-3 animate-fade-in-delay-3">
                    <a href="{{ route('admission') }}" class="btn btn-primary btn-lg">Start Application</a>
                    <a href="#campus" class="btn btn-outline-white btn-lg"><i class="fas fa-play me-2"></i> Virtual
                        Tour</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Portals Section -->
    <section id="portals" class="section-padding bg-light"
        style="margin-top: -80px; position: relative; z-index: 10;">
        <div class="container">
            <div class="row g-4">
                <!-- Student Portal -->
                <div class="col-md-6 col-lg-3">
                    <div class="portal-card">
                        <div class="portal-header">
                            <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=400"
                                alt="Student" loading="lazy">
                        </div>
                        <div class="card-body text-center pt-5 pb-4 px-4">
                            <h4 class="mb-2">Student Portal</h4>
                            <p class="text-muted small mb-4">Access course materials, check grades, and view timetable.
                            </p>
                            <button class="btn btn-outline-primary w-100"
                                onclick="openLoginModal('student')">Login</button>
                        </div>
                    </div>
                </div>

                <!-- Teacher Portal -->
                <div class="col-md-6 col-lg-3">
                    <div class="portal-card">
                        <div class="portal-header">
                            <img src="https://images.unsplash.com/photo-1544531586-fde5298cdd40?auto=format&fit=crop&q=80&w=400"
                                alt="Teacher" loading="lazy">
                        </div>
                        <div class="card-body text-center pt-5 pb-4 px-4">
                            <h4 class="mb-2">Teacher Portal</h4>
                            <p class="text-muted small mb-4">Manage attendance, upload marks, and schedule classes.</p>
                            <button class="btn btn-outline-primary w-100"
                                onclick="openLoginModal('teacher')">Login</button>
                        </div>
                    </div>
                </div>

                <!-- Admin Portal -->
                <div class="col-md-6 col-lg-3">
                    <div class="portal-card">
                        <div class="portal-header">
                            <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&q=80&w=400"
                                alt="Admin" loading="lazy">
                        </div>
                        <div class="card-body text-center pt-5 pb-4 px-4">
                            <h4 class="mb-2">Admin Portal</h4>
                            <p class="text-muted small mb-4">Manage admissions, fee records, and HR operations.</p>
                            <button class="btn btn-outline-primary w-100"
                                onclick="openLoginModal('admin')">Login</button>
                        </div>
                    </div>
                </div>

                <!-- Super Admin Portal -->
                <div class="col-md-6 col-lg-3">
                    <div class="portal-card">
                        <div class="portal-header">
                            <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&q=80&w=400"
                                alt="Super Admin" loading="lazy">
                        </div>
                        <div class="card-body text-center pt-5 pb-4 px-4">
                            <h4 class="mb-2">Super Admin Portal</h4>
                            <p class="text-muted small mb-4">System configuration, backups, and security logs.</p>
                            <button class="btn btn-outline-primary w-100"
                                onclick="openLoginModal('superadmin')">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About / Stats Section -->
    <section class="stats-section section-padding">
        <div class="container">
            <div class="text-center text-white mb-5">
                <h2 class="text-white">A Legacy of Excellence</h2>
                <p class="lead opacity-75">Building character and shaping futures since 2010</p>
            </div>
            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">15+</span>
                        <span class="stat-label">Years of Excellence</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">2500+</span>
                        <span class="stat-label">Active Students</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">150+</span>
                        <span class="stat-label">Expert Teachers</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">100%</span>
                        <span class="stat-label">University Placement</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Academics Section -->
    <section id="academics" class="section-padding">
        <div class="container">
            <div class="text-center mb-5">
                <span class="text-primary fw-bold text-uppercase ls-1">Academics</span>
                <h2 class="display-5 fw-bold">Our Programs</h2>
                <p class="text-muted lead mx-auto" style="max-width: 600px;">
                    We offer a comprehensive curriculum designed to challenge and inspire students at every level.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="program-card">
                        <div class="program-icon">
                            <i class="fas fa-flask"></i>
                        </div>
                        <h4>Science & Technology</h4>
                        <p class="text-muted">Physics, Chemistry, Biology, and Computer Science programs with
                            state-of-the-art labs.</p>
                        <a href="#" class="btn btn-link text-primary mt-2">Learn More <i
                                class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="program-card">
                        <div class="program-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Commerce & Business</h4>
                        <p class="text-muted">Accounting, Economics, and Business Studies preparing future
                            entrepreneurs.</p>
                        <a href="#" class="btn btn-link text-primary mt-2">Learn More <i
                                class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="program-card">
                        <div class="program-icon">
                            <i class="fas fa-palette"></i>
                        </div>
                        <h4>Arts & Humanities</h4>
                        <p class="text-muted">Literature, History, Psychology, and Fine Arts fostering creativity and
                            critical thinking.</p>
                        <a href="#" class="btn btn-link text-primary mt-2">Learn More <i
                                class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features / Facilities -->
    <section id="campus" class="section-padding bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <h2 class="display-5 fw-bold mb-4">World-Class Facilities</h2>
                    <p class="lead text-muted mb-4">
                        Our campus provides the perfect environment for holistic learning and development.
                    </p>
                    <div class="d-flex flex-column gap-3">
                        <div class="feature-box">
                            <div class="feature-icon-box">
                                <i class="fas fa-wifi"></i>
                            </div>
                            <div>
                                <h5>Smart Campus</h5>
                                <p class="text-muted mb-0">High-speed Wi-Fi and digital classrooms for modern learning.
                                </p>
                            </div>
                        </div>
                        <div class="feature-box">
                            <div class="feature-icon-box">
                                <i class="fas fa-book-reader"></i>
                            </div>
                            <div>
                                <h5>Digital Library</h5>
                                <p class="text-muted mb-0">Access to thousands of e-books and research journals.</p>
                            </div>
                        </div>
                        <div class="feature-box">
                            <div class="feature-icon-box">
                                <i class="fas fa-running"></i>
                            </div>
                            <div>
                                <h5>Sports Complex</h5>
                                <p class="text-muted mb-0">Indoor and outdoor facilities for complete physical
                                    development.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&q=80&w=1200" alt="Campus Facilities"
                            class="img-fluid rounded-4 shadow-xl" loading="lazy">
                        <div class="position-absolute bottom-0 start-0 bg-white p-4 rounded-3 shadow-lg m-4"
                            style="max-width: 250px;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-success text-white rounded-circle p-3">
                                    <i class="fas fa-leaf fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">Eco-Friendly</h6>
                                    <small class="text-muted">Green Campus Award 2024</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Admissions Section -->
    <section id="admissions" class="section-padding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 order-lg-2">
                    <h2 class="display-5 fw-bold mb-4">Join Our Community</h2>
                    <p class="lead text-muted mb-4">
                        We welcome bright minds from around the world. Our admission process is designed to be simple
                        and transparent.
                    </p>
                    <div class="timeline ps-3 border-start border-3 border-primary-light">
                        <div class="mb-4 ps-4 position-relative">
                            <span
                                class="position-absolute top-0 start-0 translate-middle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 30px; height: 30px; left: -2px !important;">1</span>
                            <h5 class="fw-bold">Online Application</h5>
                            <p class="text-muted">Fill out the admission form on our website.</p>
                        </div>
                        <div class="mb-4 ps-4 position-relative">
                            <span
                                class="position-absolute top-0 start-0 translate-middle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 30px; height: 30px; left: -2px !important;">2</span>
                            <h5 class="fw-bold">Entrance Test</h5>
                            <p class="text-muted">Complete the aptitude assessment for your grade level.</p>
                        </div>
                        <div class="mb-4 ps-4 position-relative">
                            <span
                                class="position-absolute top-0 start-0 translate-middle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 30px; height: 30px; left: -2px !important;">3</span>
                            <h5 class="fw-bold">Interview</h5>
                            <p class="text-muted">Meet with our academic counselors for a personal interview.</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admission') }}" class="btn btn-primary btn-lg px-5">Apply Now</a>
                        <a href="{{ asset('assets/prospectus.txt') }}" class="btn btn-outline-primary btn-lg ms-3"
                            download>Download
                            Prospectus</a>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1 mb-5 mb-lg-0">
                    <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?auto=format&fit=crop&q=80&w=1200" alt="Join Our Community"
                        class="img-fluid rounded-4 shadow-lg" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- News & Events -->
    <section id="news" class="section-padding bg-light">
        <div class="container">
            <h2 class="display-5 fw-bold text-center mb-5">Latest News & Events</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="news-card">
                        <div class="news-image">
                            <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&q=80&w=600"
                                alt="Graduation" loading="lazy">
                            <div class="date-badge">
                                <span class="day">15</span>
                                <span class="month">Dec</span>
                            </div>
                        </div>
                        <div class="news-content">
                            <span class="text-primary fw-bold small text-uppercase mb-2">Events</span>
                            <h5 class="fw-bold mb-3">Annual Convocation Ceremony 2024</h5>
                            <p class="text-muted mb-4 small">Celebrating the achievements of our graduating class with
                                distinguished guests.</p>
                            <a href="#" class="text-primary fw-bold mt-auto">Read More <i
                                    class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="news-card">
                        <div class="news-image">
                            <img src="https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&q=80&w=600"
                                alt="Sports" loading="lazy">
                            <div class="date-badge">
                                <span class="day">22</span>
                                <span class="month">Dec</span>
                            </div>
                        </div>
                        <div class="news-content">
                            <span class="text-primary fw-bold small text-uppercase mb-2">Sports</span>
                            <h5 class="fw-bold mb-3">Inter-School Football Championship</h5>
                            <p class="text-muted mb-4 small">Our team advances to the finals in the regional
                                championship.</p>
                            <a href="#" class="text-primary fw-bold mt-auto">Read More <i
                                    class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="news-card">
                        <div class="news-image">
                            <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&q=80&w=600"
                                alt="Workshop" loading="lazy">
                            <div class="date-badge">
                                <span class="day">05</span>
                                <span class="month">Jan</span>
                            </div>
                        </div>
                        <div class="news-content">
                            <span class="text-primary fw-bold small text-uppercase mb-2">Academic</span>
                            <h5 class="fw-bold mb-3">Robotics and AI Workshop</h5>
                            <p class="text-muted mb-4 small">A hands-on workshop for students interested in future
                                technologies.</p>
                            <a href="#" class="text-primary fw-bold mt-auto">Read More <i
                                    class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Us Section -->
    <section id="contact" class="section-padding bg-light position-relative overflow-hidden">
        <!-- Background Decor -->
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-white" style="opacity: 0.5; z-index: 0;"></div>
        <div class="position-absolute top-50 start-50 translate-middle"
            style="width: 600px; height: 600px; background: radial-gradient(circle, rgba(14, 165, 233, 0.05) 0%, rgba(255,255,255,0) 70%); z-index: 0;">
        </div>

        <div class="container position-relative" style="z-index: 1;">
            <div class="text-center mb-5 animate-fade-in">
                <span
                    class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mb-3 fw-bold ls-1">CONTACT
                    US</span>
                <h2 class="display-4 fw-bold mb-3">Let's Start a Conversation</h2>
                <p class="text-muted lead mx-auto" style="max-width: 600px;">
                    Whether you're a prospective student, a parent, or looking for partnership opportunities, we're here
                    to help.
                </p>
            </div>

            <!-- Main Contact Content -->
            <div class="row g-0 rounded-5 overflow-hidden shadow-lg bg-white">
                <!-- Left: Contact Info & Map -->
                <div class="col-lg-5 position-relative bg-primary text-white p-5">

                    <div class="position-relative z-1 h-100 d-flex flex-column">
                        <h3 class="fw-bold text-white mb-4">Contact Information</h3>
                        <p class="opacity-75 mb-5">Fill up the form and our Team will get back to you within 24 hours.
                        </p>

                        <div class="d-flex flex-column gap-4 mb-5">
                            <div class="d-flex gap-3 align-items-center">
                                <div class="bg-white bg-opacity-25 rounded-circle p-3 d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-light mb-0">Our Location</h6>
                                    <span class="opacity-75 small">123 Education Lane, NY 10012</span>
                                </div>
                            </div>

                            <div class="d-flex gap-3 align-items-center">
                                <div class="bg-white bg-opacity-25 rounded-circle p-3 d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-light mb-0">Phone Number</h6>
                                    <span class="opacity-75 small">+1 (555) 123-4567</span>
                                </div>
                            </div>

                            <div class="d-flex gap-3 align-items-center">
                                <div class="bg-white bg-opacity-25 rounded-circle p-3 d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-light mb-0">Email Address</h6>
                                    <span class="opacity-75 small">admissions@lumina.edu</span>
                                </div>
                            </div>
                        </div>

                        <!-- Mini Map -->
                        <div class="mt-auto rounded-3 overflow-hidden shadow-sm border border-white border-opacity-25"
                            style="height: 200px;">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.1422937950147!2d-73.98731968482413!3d40.75889497932681!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25855c6480299%3A0x55194ec5a1ae072e!2sTimes%20Square!5e0!3m2!1sen!2sus!4v1633023222534!5m2!1sen!2sus"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                            </iframe>
                        </div>
                    </div>
                </div>

                <!-- Right: Form -->
                <div class="col-lg-7 p-5">
                    <h3 class="fw-bold mb-4">Send a Message</h3>
                    <form id="contactForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="contactName"
                                    class="form-label small fw-bold text-muted text-uppercase">Name</label>
                                <input type="text" class="form-control bg-light border-0 py-2" id="contactName"
                                    placeholder="Your Name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="contactEmail"
                                    class="form-label small fw-bold text-muted text-uppercase">Email</label>
                                <input type="email" class="form-control bg-light border-0 py-2" id="contactEmail"
                                    placeholder="name@example.com" required>
                            </div>
                            <div class="col-12">
                                <label for="contactSubject"
                                    class="form-label small fw-bold text-muted text-uppercase">Subject</label>
                                <input type="text" class="form-control bg-light border-0 py-2" id="contactSubject"
                                    placeholder="What is this regarding?" required>
                            </div>
                            <div class="col-12">
                                <label for="contactMessage"
                                    class="form-label small fw-bold text-muted text-uppercase">Message</label>
                                <textarea class="form-control bg-light border-0 py-2" id="contactMessage" rows="4"
                                    placeholder="How can we help you?" required></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3">
                                    SEND MESSAGE <i class="fas fa-paper-plane ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // Contact Form Handling
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('contactForm');
            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    // Get values
                    const name = document.getElementById('contactName').value;
                    const email = document.getElementById('contactEmail').value;
                    const subject = document.getElementById('contactSubject').value;
                    const message = document.getElementById('contactMessage').value;

                    // Simulate loading
                    const btn = form.querySelector('button[type="submit"]');
                    const originalText = btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-2"></span> Sending...';

                    setTimeout(() => {
                        // Store in localStorage (Demo)
                        const messages = JSON.parse(localStorage.getItem('lms_contact_messages') || '[]');
                        messages.push({
                            id: Date.now(),
                            name,
                            email,
                            subject,
                            message,
                            date: new Date().toISOString()
                        });
                        localStorage.setItem('lms_contact_messages', JSON.stringify(messages));

                        // Success Feedback
                        if (typeof showToast === 'function') {
                            showToast(
                                'Message sent successfully! We will get back to you soon.',
                                'success'
                            );
                        } else {
                            alert('Message sent successfully!');
                        }

                        // Reset Form
                        form.reset();
                        btn.disabled = false;
                        btn.innerHTML = originalText;

                    }, 1500);
                });
            }
        });
    </script>
    <script>
        // Password Toggle Logic
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            if (togglePassword && password) {
                togglePassword.addEventListener('click', function (e) {
                    // toggle the type attribute
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);

                    // toggle the eye slash icon
                    const icon = this.querySelector('i');
                    if (type === 'text') {
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            }
        });
    </script>
@endsection

