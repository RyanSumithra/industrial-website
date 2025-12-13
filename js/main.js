// Main JavaScript - IndustrialTech Website
document.addEventListener('DOMContentLoaded', function() {
    // Remove loading class
    document.body.classList.remove('js-loading');
    
    // ===== MOBILE NAVIGATION =====
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    const navbar = document.getElementById('navbar');

    if (navToggle && navMenu) {
        navToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            navMenu.classList.toggle('active');
            navToggle.classList.toggle('active');
            document.body.style.overflow = navMenu.classList.contains('active') ? 'hidden' : '';
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!navToggle.contains(e.target) && !navMenu.contains(e.target)) {
                navMenu.classList.remove('active');
                navToggle.classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        // Close menu when clicking a link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
                navToggle.classList.remove('active');
                document.body.style.overflow = '';
            });
        });
    }

    // ===== NAVBAR SCROLL EFFECT =====
    let lastScroll = 0;
    const scrollThreshold = 100;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > scrollThreshold) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
        
        // Hide/show navbar on scroll
        if (currentScroll > lastScroll && currentScroll > 200) {
            navbar.style.transform = 'translateY(-100%)';
        } else {
            navbar.style.transform = 'translateY(0)';
        }
        
        lastScroll = currentScroll;
    });

    // ===== SMOOTH SCROLL FOR ANCHOR LINKS =====
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Skip if it's just "#"
            if (href === '#') return;
            
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                
                // Close mobile menu if open
                if (navMenu && navMenu.classList.contains('active')) {
                    navMenu.classList.remove('active');
                    navToggle.classList.remove('active');
                    document.body.style.overflow = '';
                }
                
                window.scrollTo({
                    top: target.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });

    // ===== SCROLL PROGRESS INDICATOR =====
    const scrollProgress = document.getElementById('scrollProgress');
    const scrollProgressBar = document.getElementById('scrollProgressBar');

    if (scrollProgress && scrollProgressBar) {
        window.addEventListener('scroll', () => {
            const windowHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (window.pageYOffset / windowHeight) * 100;
            scrollProgressBar.style.width = scrolled + '%';
            
            // Show/hide progress bar
            if (window.pageYOffset > 300) {
                scrollProgress.style.opacity = '1';
            } else {
                scrollProgress.style.opacity = '0';
            }
        });
    }

    // ===== BACK TO TOP BUTTON =====
    const backToTop = document.getElementById('backToTop');

    if (backToTop) {
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 500) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });

        backToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // ===== ANIMATED COUNTERS =====
    function animateCounter(element, target, duration = 2000) {
        let start = 0;
        const increment = target / (duration / 16); // 60fps
        const timer = setInterval(() => {
            start += increment;
            if (start >= target) {
                element.textContent = target + (element.dataset.count.includes('.') ? '' : '+');
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(start);
            }
        }, 16);
    }

    // Observe counter elements
    const counterElements = document.querySelectorAll('.stat-number');
    if (counterElements.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    const target = parseFloat(element.dataset.count);
                    
                    if (element.dataset.count.includes('.')) {
                        // For decimal numbers
                        let current = 0;
                        const increment = target / 100;
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= target) {
                                element.textContent = target.toFixed(1);
                                clearInterval(timer);
                            } else {
                                element.textContent = current.toFixed(1);
                            }
                        }, 16);
                    } else {
                        // For whole numbers
                        animateCounter(element, target);
                    }
                    
                    observer.unobserve(element);
                }
            });
        }, { threshold: 0.5 });

        counterElements.forEach(counter => observer.observe(counter));
    }

    // ===== FADE IN ANIMATIONS =====
    const fadeElements = document.querySelectorAll('.service-card, .project-card, .value-card, .mission-card');
    const fadeObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, { threshold: 0.1 });

    fadeElements.forEach(el => fadeObserver.observe(el));

    // ===== PROJECT FILTER =====
    const filterButtons = document.querySelectorAll('.filter-btn');
    const projectCards = document.querySelectorAll('.project-card');

    if (filterButtons.length > 0 && projectCards.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Update active button
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                
                const filterValue = button.dataset.filter;
                
                // Filter projects
                projectCards.forEach(card => {
                    if (filterValue === 'all' || card.dataset.category === filterValue) {
                        card.style.display = 'block';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, 10);
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });
    }

    // ===== FORM VALIDATION =====
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const messageInput = document.getElementById('message');
        const charCount = document.getElementById('charCount');
        
        // Character counter for message
        if (messageInput && charCount) {
            messageInput.addEventListener('input', () => {
                const length = messageInput.value.length;
                charCount.textContent = length;
                
                if (length > 1000) {
                    charCount.style.color = '#DC2626';
                } else if (length > 800) {
                    charCount.style.color = '#F59E0B';
                } else {
                    charCount.style.color = 'var(--text-secondary)';
                }
            });
        }
        
        // Real-time validation
        [nameInput, emailInput, messageInput].forEach(input => {
            if (input) {
                input.addEventListener('blur', () => validateField(input));
                input.addEventListener('input', () => clearError(input));
            }
        });
        
        function validateField(field) {
            const errorElement = document.getElementById(field.id + 'Error');
            
            if (field.required && !field.value.trim()) {
                showError(field, 'This field is required');
                return false;
            }
            
            if (field.type === 'email' && field.value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(field.value)) {
                    showError(field, 'Please enter a valid email address');
                    return false;
                }
            }
            
            clearError(field);
            return true;
        }
        
        function showError(field, message) {
            const errorElement = document.getElementById(field.id + 'Error');
            if (errorElement) {
                errorElement.textContent = message;
                field.classList.add('error');
            }
        }
        
        function clearError(field) {
            const errorElement = document.getElementById(field.id + 'Error');
            if (errorElement) {
                errorElement.textContent = '';
                field.classList.remove('error');
            }
        }
        
        // Form submission
        contactForm.addEventListener('submit', function(e) {
            let isValid = true;
            
            [nameInput, emailInput, messageInput].forEach(input => {
                if (!validateField(input)) {
                    isValid = false;
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                
                // Scroll to first error
                const firstError = contactForm.querySelector('.error');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            } else {
                // Show loading state
                const submitBtn = contactForm.querySelector('.btn-submit');
                const btnText = submitBtn.querySelector('.btn-text');
                const btnLoader = submitBtn.querySelector('.btn-loader');
                
                if (btnText && btnLoader) {
                    btnText.style.display = 'none';
                    btnLoader.style.display = 'flex';
                    submitBtn.disabled = true;
                }
            }
        });
    }

    // ===== SERVICE NAVIGATION =====
    const serviceNavLinks = document.querySelectorAll('.service-nav-link');
    if (serviceNavLinks.length > 0) {
        // Update active nav link on scroll
        const serviceSections = document.querySelectorAll('.service-detail-section');
        
        window.addEventListener('scroll', () => {
            let current = '';
            
            serviceSections.forEach(section => {
                const sectionTop = section.offsetTop - 100;
                const sectionHeight = section.clientHeight;
                
                if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
                    current = section.id;
                }
            });
            
            serviceNavLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        });
        
        // Smooth scroll for service links
        serviceNavLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                const targetSection = document.querySelector(targetId);
                
                if (targetSection) {
                    // Update active state
                    serviceNavLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Scroll to section
                    window.scrollTo({
                        top: targetSection.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    // ===== LAZY LOADING IMAGES =====
    const lazyImages = document.querySelectorAll('img[data-src]');
    if (lazyImages.length > 0) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        });
        
        lazyImages.forEach(img => imageObserver.observe(img));
    }

    // ===== PARALLAX EFFECT =====
    const heroSection = document.querySelector('.hero');
    if (heroSection) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.5;
            heroSection.style.transform = `translate3d(0, ${rate}px, 0)`;
        });
    }

    // ===== CURRENT YEAR =====
    const yearElements = document.querySelectorAll('.current-year');
    yearElements.forEach(el => {
        el.textContent = new Date().getFullYear();
    });

    // ===== PRELOADER (Optional) =====
    window.addEventListener('load', () => {
        const preloader = document.querySelector('.preloader');
        if (preloader) {
            setTimeout(() => {
                preloader.style.opacity = '0';
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 500);
            }, 500);
        }
    });

    // ===== TOOLTIPS =====
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    tooltipElements.forEach(el => {
        el.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = this.dataset.tooltip;
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
            tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
            
            this.tooltip = tooltip;
        });
        
        el.addEventListener('mouseleave', function() {
            if (this.tooltip) {
                this.tooltip.remove();
                this.tooltip = null;
            }
        });
    });
});

// Add global utility functions
window.debounce = function(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
};

window.throttle = function(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
};