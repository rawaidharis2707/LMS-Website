<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lumina International Academy - Excellence in Education</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Prefetch Key Pages -->
    <link rel="prefetch" href="/admission">
    <link rel="prefetch" href="/admin/dashboard">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    
    @yield('styles')
</head>

<body>

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-none d-md-flex align-items-center gap-4">
                <span><i class="fas fa-phone-alt me-2 text-accent"></i> +1 (555) 123-4567</span>
                <span><i class="fas fa-envelope me-2 text-accent"></i> admissions@lumina.edu</span>
            </div>
            <div class="d-flex align-items-center gap-2 ms-auto">
                <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                <span class="mx-2 text-white-50">|</span>
                <a href="#" class="fw-bold" onclick="openLoginModal('student')"><i class="fas fa-lock me-1"></i>Student
                    Portal
                    Login</a>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    @include('layouts.navbar')

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Login Modal (Preserved Functionality) -->
    @include('layouts.login-modal')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="{{ asset('assets/js/animations.js') }}" defer></script>
    <script src="{{ asset('assets/js/auth.js') }}" defer></script>
    <script src="{{ asset('assets/js/main.js') }}" defer></script>
    <script src="{{ asset('assets/js/activity-functions.js') }}" defer></script>
    
    @yield('scripts')
</body>

</html>
