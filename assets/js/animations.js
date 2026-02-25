// =====================================================
// Lumina LMS - Animations and Interactions (Optimized)
// =====================================================

// Animated Counter for Statistics
class AnimatedCounter {
    constructor(element, target, duration = 1500) { // Reduced duration
        this.element = element;
        this.target = target;
        this.duration = duration;
        this.startTime = null;
        this.observer = null;
    }

    easeOutQuad(t) {
        return t * (2 - t);
    }

    animate(currentTime) {
        if (!this.startTime) this.startTime = currentTime;
        const elapsed = currentTime - this.startTime;
        const progress = Math.min(elapsed / this.duration, 1);

        const current = Math.floor(this.target * this.easeOutQuad(progress));

        // Handle different formats
        const originalText = this.element.dataset.originalText || this.element.textContent;
        if (!this.element.dataset.originalText) {
            this.element.dataset.originalText = originalText;
        }

        if (originalText.includes('%')) {
            this.element.textContent = current + '%';
        } else if (originalText.includes('K+')) {
            this.element.textContent = (current / 1000).toFixed(1) + 'K+';
        } else if (originalText.includes('+')) {
            this.element.textContent = current + '+';
        } else {
            this.element.textContent = current;
        }

        if (progress < 1) {
            requestAnimationFrame((time) => this.animate(time));
        } else {
            this.element.textContent = originalText;
        }
    }

    start() {
        requestAnimationFrame((time) => this.animate(time));
    }

    observe() {
        this.observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.start();
                    this.observer.unobserve(this.element);
                }
            });
        }, { threshold: 0.5 });

        this.observer.observe(this.element);
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // 1. Unified Scroll Handler (Performance Optimization)
    let ticking = false;
    const navbar = document.querySelector('.navbar');
    const heroSection = document.querySelector('.hero-section');

    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                const scrolled = window.scrollY;

                // Navbar Logic
                if (navbar) {
                    if (scrolled > 50) {
                        navbar.classList.add('scrolled');
                    } else {
                        navbar.classList.remove('scrolled');
                    }
                }

                // Parallax Logic (Optional - can be disabled for performance)
                if (heroSection && scrolled < window.innerHeight) {
                    // Simple parallax usually nice, but removed heavy querySelectors inside loop
                    // If needed, cache elements outside
                }

                ticking = false;
            });
            ticking = true;
        }
    }, { passive: true });

    // 2. Animate Statistics
    const statElements = document.querySelectorAll('.stat-number');
    statElements.forEach(element => {
        const text = element.textContent.trim();
        let target = 0;

        if (text.includes('K+')) target = parseFloat(text.replace('K+', '')) * 1000;
        else if (text.includes('%')) target = parseFloat(text.replace('%', ''));
        else if (text.includes('+')) target = parseInt(text.replace('+', ''));
        else target = parseInt(text.replace(/,/g, ''));

        if (!isNaN(target) && target > 0) {
            new AnimatedCounter(element, target).observe();
        }
    });

    // 3. Smooth Scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href !== '#!' && !href.startsWith('#login')) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const headerOffset = 80;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    // 4. Stagger Animations (Optimized)
    const observeElements = (selector, animationClass, delay = 50) => { // Reduced delay to 50ms
        const elements = document.querySelectorAll(selector);
        if (elements.length === 0) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    // Use CSS variable index for cleaner CSS-driven animation if possible, 
                    // but keeping timeout for simplicity with existing setup
                    const timeout = index * delay;

                    setTimeout(() => {
                        window.requestAnimationFrame(() => {
                            entry.target.classList.add(animationClass);
                        });
                    }, timeout);

                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '50px' }); // Pre-load slightly before view

        elements.forEach(element => {
            observer.observe(element);
        });
    };

    // Apply scroll animations
    observeElements('.portal-card', 'animate-fade-in', 50);
    observeElements('.program-card', 'animate-fade-in', 50);
    observeElements('.feature-box', 'animate-fade-in', 50);
    observeElements('.news-card', 'animate-fade-in', 50);
    observeElements('.timeline > div', 'animate-fade-in', 100);

    // 5. Ripple Effect (CSS optimized)
    function createRipple(event) {
        const button = event.currentTarget;
        const ripple = document.createElement('span');
        const rect = button.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;

        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('ripple');

        button.appendChild(ripple);

        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

    document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', createRipple);
    });
});

// Add CSS for optimizations
const style = document.createElement('style');
style.textContent = `
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.4);
        transform: scale(0);
        animation: ripple-animation 0.5s ease-out;
        pointer-events: none;
    }

    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    /* Optimized Transitions */
    .portal-card, .program-card, .feature-box, .news-card, .timeline > div {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.4s ease-out, transform 0.4s ease-out; /* Faster transition */
    }
    
    .animate-fade-in {
        opacity: 1 !important;
        transform: translateY(0) !important;
    }
`;
document.head.appendChild(style);
