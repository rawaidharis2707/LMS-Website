<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="fas fa-university fa-lg"></i>
            Lumina Academy
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="{{ url('/#home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/#portals') }}">Portals</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/#academics') }}">Academics</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/#campus') }}">Campus Life</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/#admissions') }}">Admissions</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/#news') }}">News</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/#contact') }}">Contact</a></li>
                <li class="nav-item ms-lg-3">
                    <a href="{{ url('/admission') }}" class="btn btn-primary text-white px-4">Apply Now</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
