// Assignment Submission Enhancement
class AssignmentSubmission {
    constructor() {
        this.maxFileSize = 10 * 1024 * 1024; // 10MB
        this.allowedTypes = ['.pdf', '.doc', '.docx', '.zip', '.jpg', '.png'];
    }

    validateFile(file) {
        const errors = [];

        // Check file size
        if (file.size > this.maxFileSize) {
            errors.push(`File size exceeds 10MB limit (${(file.size / 1024 / 1024).toFixed(2)}MB)`);
        }

        // Check file type
        const ext = '.' + file.name.split('.').pop().toLowerCase();
        if (!this.allowedTypes.includes(ext)) {
            errors.push(`File type ${ext} not allowed. Allowed: ${this.allowedTypes.join(', ')}`);
        }

        return {
            valid: errors.length === 0,
            errors: errors
        };
    }

    submitAssignment(assignmentId, file, comments) {
        return new Promise((resolve, reject) => {
            const validation = this.validateFile(file);

            if (!validation.valid) {
                reject(validation.errors);
                return;
            }

            // Simulate upload with progress
            const submission = {
                id: Date.now(),
                assignmentId: assignmentId,
                fileName: file.name,
                fileSize: file.size,
                comments: comments,
                submittedAt: new Date().toISOString(),
                status: 'submitted'
            };

            // Save to localStorage
            const submissions = storage.get('submissions', []);
            submissions.push(submission);
            storage.set('submissions', submissions);

            // Add notification
            if (typeof notificationSystem !== 'undefined') {
                notificationSystem.addNotification({
                    type: 'assignment',
                    title: 'Assignment Submitted',
                    message: `Your submission for "${file.name}" has been received`,
                    icon: 'fas fa-check-circle',
                    color: 'success'
                });
            }

            resolve(submission);
        });
    }

    getSubmissions(assignmentId) {
        const submissions = storage.get('submissions', []);
        if (assignmentId) {
            return submissions.filter(s => s.assignmentId === assignmentId);
        }
        return submissions;
    }
}

// Form Validation
class FormValidator {
    constructor(formElement) {
        this.form = formElement;
        this.init();
    }

    init() {
        this.form.addEventListener('submit', (e) => {
            if (!this.validateForm()) {
                e.preventDefault();
                e.stopPropagation();
            }
            this.form.classList.add('was-validated');
        });

        // Real-time validation
        this.form.querySelectorAll('input, textarea, select').forEach(field => {
            field.addEventListener('blur', () => this.validateField(field));
            field.addEventListener('input', () => {
                if (field.classList.contains('is-invalid')) {
                    this.validateField(field);
                }
            });
        });
    }

    validateForm() {
        let isValid = true;
        this.form.querySelectorAll('input, textarea, select').forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });
        return isValid;
    }

    validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';

        // Required validation
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'This field is required';
        }

        // Email validation
        if (field.type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Please enter a valid email address';
            }
        }

        // Min/Max length
        if (field.hasAttribute('minlength') && value.length < parseInt(field.getAttribute('minlength'))) {
            isValid = false;
            errorMessage = `Minimum ${field.getAttribute('minlength')} characters required`;
        }

        if (field.hasAttribute('maxlength') && value.length > parseInt(field.getAttribute('maxlength'))) {
            isValid = false;
            errorMessage = `Maximum ${field.getAttribute('maxlength')} characters allowed`;
        }

        // Pattern validation
        if (field.hasAttribute('pattern') && value) {
            const pattern = new RegExp(field.getAttribute('pattern'));
            if (!pattern.test(value)) {
                isValid = false;
                errorMessage = field.getAttribute('title') || 'Invalid format';
            }
        }

        // Update field state
        if (isValid) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
        } else {
            field.classList.remove('is-valid');
            field.classList.add('is-invalid');
            this.showError(field, errorMessage);
        }

        return isValid;
    }

    showError(field, message) {
        let feedback = field.nextElementSibling;
        if (!feedback || !feedback.classList.contains('invalid-feedback')) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            field.parentNode.insertBefore(feedback, field.nextSibling);
        }
        feedback.textContent = message;
    }
}

// Keyboard Shortcuts
class KeyboardShortcuts {
    constructor() {
        this.shortcuts = {
            'ctrl+k': () => globalSearch?.openSearch(),
            'ctrl+d': () => window.location.href = 'dashboard.html',
            'ctrl+p': () => window.location.href = 'profile.html',
            'escape': () => this.closeModals()
        };
        this.init();
    }

    init() {
        document.addEventListener('keydown', (e) => {
            const key = this.getKeyCombo(e);
            if (this.shortcuts[key]) {
                e.preventDefault();
                this.shortcuts[key]();
            }
        });
    }

    getKeyCombo(e) {
        const parts = [];
        if (e.ctrlKey || e.metaKey) parts.push('ctrl');
        if (e.shiftKey) parts.push('shift');
        if (e.altKey) parts.push('alt');
        parts.push(e.key.toLowerCase());
        return parts.join('+');
    }

    closeModals() {
        document.querySelectorAll('.modal.show').forEach(modal => {
            const modalInstance = bootstrap.Modal.getInstance(modal);
            if (modalInstance) modalInstance.hide();
        });
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    window.assignmentSubmission = new AssignmentSubmission();
    window.keyboardShortcuts = new KeyboardShortcuts();

    // Auto-validate all forms
    document.querySelectorAll('form').forEach(form => {
        if (!form.hasAttribute('novalidate')) {
            new FormValidator(form);
        }
    });
});
