<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-header bg-primary text-white border-0 p-4">
                <h5 class="modal-title text-light fw-bold">
                    <i class="fas fa-lock me-2"></i> Portal Access
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 p-md-5 bg-surface">
                <form id="loginForm">
                    <input type="hidden" id="portalType" name="portal">

                    <div class="text-center mb-4">
                        <div class="avatar-circle bg-white shadow-sm p-3 d-inline-block rounded-circle mb-3">
                            <i class="fas fa-user-circle fa-3x text-primary"></i>
                        </div>
                        <h4 id="loginModalLabel" class="fw-bold text-primary">Login</h4>
                        <p class="text-muted small">Please enter your credentials to continue</p>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold small text-uppercase text-muted">Email
                            Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i
                                    class="fas fa-envelope text-primary"></i></span>
                            <input type="email" class="form-control border-start-0 ps-0" id="email"
                                placeholder="name@demo.com" autocomplete="username" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password"
                            class="form-label fw-bold small text-uppercase text-muted">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i
                                    class="fas fa-key text-primary"></i></span>
                            <input type="password" class="form-control border-start-0 border-end-0 ps-0"
                                id="password" placeholder="Enter your password" autocomplete="current-password"
                                required>
                            <button class="btn border border-start-0 bg-white text-muted" type="button"
                                id="togglePassword" style="border-color: #dee2e6;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe">
                            <label class="form-check-label small" for="rememberMe">Remember me</label>
                        </div>
                        <a href="#" class="small text-primary fw-bold">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 shadow-md fw-bold">
                        SECURE LOGIN <i class="fas fa-arrow-right ms-2"></i>
                    </button>

                    <div class="alert alert-info mt-4 mb-0 small border-0 bg-info-subtle text-info-emphasis">
                        <i class="fas fa-info-circle me-1"></i> <strong>Demo Credentials:</strong><br>
                        Email: <span id="demoEmail">student@demo.com</span><br>
                        Password: password
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
