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

// ===== PROJECTS PAGE INTERACTIONS =====

// Project Filtering
function initProjectFilter() {
    const filterTags = document.querySelectorAll('.filter-tag');
    const projectCards = document.querySelectorAll('.project-card');
    
    if (filterTags.length === 0 || projectCards.length === 0) return;
    
    filterTags.forEach(tag => {
        tag.addEventListener('click', () => {
            // Update active state
            filterTags.forEach(t => t.classList.remove('active'));
            tag.classList.add('active');
            
            const filterValue = tag.dataset.filter;
            
            // Filter projects with animation
            projectCards.forEach(card => {
                const category = card.dataset.category;
                
                if (filterValue === 'all' || category === filterValue) {
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
            
            // Update count
            updateProjectCount(filterValue);
        });
    });
}

function updateProjectCount(filter) {
    const projectCards = document.querySelectorAll('.project-card');
    let visibleCount = 0;
    
    if (filter === 'all') {
        visibleCount = projectCards.length;
    } else {
        projectCards.forEach(card => {
            if (card.dataset.category === filter) {
                visibleCount++;
            }
        });
    }
    
    const countElement = document.querySelector('.stat-count:first-child');
    if (countElement) {
        countElement.textContent = visibleCount;
    }
}

// Quick View Modal
function initQuickView() {
    const quickViewBtns = document.querySelectorAll('.project-quickview');
    const modal = document.getElementById('projectModal');
    const modalClose = modal?.querySelector('.modal-close');
    
    if (!modal || quickViewBtns.length === 0) return;
    
    quickViewBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const projectId = btn.dataset.project;
            loadProjectDetails(projectId);
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
    });
    
    // Close modal
    if (modalClose) {
        modalClose.addEventListener('click', () => {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        });
    }
    
    // Close on outside click
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    });
    
    // Close on ESC key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.style.display === 'flex') {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    });
}

function loadProjectDetails(projectId) {
    // This would typically fetch from an API or database
    // For now, we'll use static content
    const projectData = {
        '1': {
            title: 'Automotive Assembly Line Automation',
            category: 'Manufacturing',
            client: 'AutoParts Inc.',
            duration: '12 Weeks',
            budget: '$500K',
            description: 'Complete PLC-based automation system for high-speed automotive component assembly, achieving unprecedented efficiency and quality control.',
            challenge: 'Manual processes causing 15% defect rates and production bottlenecks. Needed 24/7 operation with consistent quality.',
            solution: 'Implemented Siemens S7-1500 PLC system with SCADA integration, robotic arms for precision assembly, and real-time quality monitoring.',
            results: [
                { metric: '35%', label: 'Efficiency Increase' },
                { metric: '50%', label: 'Defect Reduction' },
                { metric: '99.9%', label: 'System Uptime' },
                { metric: '8 months', label: 'ROI Period' }
            ],
            technologies: ['Siemens S7-1500', 'SCADA System', 'Robotic Arms', 'Vision Systems', 'HMI Panels'],
            image: '🏭'
        }
        // Add more project data as needed
    };
    
    const project = projectData[projectId] || projectData['1'];
    const modalBody = document.getElementById('modalBody');
    
    if (!modalBody) return;
    
    modalBody.innerHTML = `
        <div class="modal-project">
            <div class="modal-header">
                <div class="modal-category">${project.category}</div>
                <h2>${project.title}</h2>
                <div class="modal-meta">
                    <div class="meta-item">
                        <span class="meta-label">Client:</span>
                        <span class="meta-value">${project.client}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Duration:</span>
                        <span class="meta-value">${project.duration}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Budget:</span>
                        <span class="meta-value">${project.budget}</span>
                    </div>
                </div>
            </div>
            
            <div class="modal-image" style="background: linear-gradient(135deg, #4F46E5, #7C3AED);">
                <div class="image-icon">${project.image}</div>
            </div>
            
            <div class="modal-content">
                <div class="section">
                    <h3>Project Overview</h3>
                    <p>${project.description}</p>
                </div>
                
                <div class="section">
                    <h3>The Challenge</h3>
                    <p>${project.challenge}</p>
                </div>
                
                <div class="section">
                    <h3>Our Solution</h3>
                    <p>${project.solution}</p>
                </div>
                
                <div class="section">
                    <h3>Key Results</h3>
                    <div class="results-grid">
                        ${project.results.map(result => `
                            <div class="result-item">
                                <div class="result-metric">${result.metric}</div>
                                <div class="result-label">${result.label}</div>
                            </div>
                        `).join('')}
                    </div>
                </div>
                
                <div class="section">
                    <h3>Technologies Used</h3>
                    <div class="tech-tags">
                        ${project.technologies.map(tech => `
                            <span class="tech-tag">${tech}</span>
                        `).join('')}
                    </div>
                </div>
                
                <div class="modal-actions">
                    <a href="contact.php" class="btn btn-primary">Start Similar Project</a>
                    <button class="btn btn-secondary modal-close-btn">Close</button>
                </div>
            </div>
        </div>
    `;
    
    // Add event listener to close button inside modal
    const closeBtn = modalBody.querySelector('.modal-close-btn');
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            document.getElementById('projectModal').style.display = 'none';
            document.body.style.overflow = '';
        });
    }
}

// Add modal CSS
const modalCSS = `
.modal-project {
    padding: var(--space-lg);
}

.modal-header {
    margin-bottom: var(--space-2xl);
}

.modal-category {
    display: inline-block;
    color: var(--accent-red);
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: var(--space-sm);
}

.modal-header h2 {
    font-size: 2rem;
    margin-bottom: var(--space-lg);
}

.modal-meta {
    display: flex;
    gap: var(--space-xl);
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    flex-direction: column;
    gap: var(--space-xs);
}

.meta-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
    font-weight: 500;
}

.meta-value {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
}

.modal-image {
    height: 200px;
    border-radius: var(--radius-lg);
    margin-bottom: var(--space-2xl);
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-icon {
    font-size: 4rem;
    opacity: 0.8;
}

.modal-content .section {
    margin-bottom: var(--space-2xl);
}

.modal-content h3 {
    font-size: 1.5rem;
    margin-bottom: var(--space-lg);
    color: var(--text-primary);
}

.results-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: var(--space-lg);
}

.result-item {
    text-align: center;
    padding: var(--space-lg);
    background: var(--primary-bg);
    border-radius: var(--radius-lg);
}

.result-metric {
    font-size: 2rem;
    font-weight: 800;
    color: var(--accent-red);
    margin-bottom: var(--space-xs);
}

.result-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.tech-tags {
    display: flex;
    flex-wrap: wrap;
    gap: var(--space-sm);
}

.tech-tags .tech-tag {
    background: var(--gray-100);
    color: var(--text-secondary);
    padding: var(--space-xs) var(--space-sm);
    border-radius: var(--radius-full);
    font-size: 0.875rem;
    font-weight: 500;
}

.modal-actions {
    display: flex;
    gap: var(--space-lg);
    margin-top: var(--space-2xl);
    padding-top: var(--space-2xl);
    border-top: 1px solid var(--gray-200);
}

.modal-close-btn {
    background: transparent;
    color: var(--text-secondary);
    border: 1px solid var(--gray-300);
}

.modal-close-btn:hover {
    background: var(--gray-100);
}
`;

// Add modal CSS to document
const styleSheet = document.createElement('style');
styleSheet.textContent = modalCSS;
document.head.appendChild(styleSheet);

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    initProjectFilter();
    initQuickView();
    
    // Add scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    // Observe project cards
    document.querySelectorAll('.project-card, .industry-card, .stat-card-large').forEach(el => {
        observer.observe(el);
    });
});

// Add animation CSS
const animationCSS = `
.animate-in {
    animation: slideUp 0.6s ease forwards;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.project-card:nth-child(2) { animation-delay: 0.1s; }
.project-card:nth-child(3) { animation-delay: 0.2s; }
.project-card:nth-child(4) { animation-delay: 0.3s; }
.project-card:nth-child(5) { animation-delay: 0.4s; }
.project-card:nth-child(6) { animation-delay: 0.5s; }

.industry-card:nth-child(2) { animation-delay: 0.1s; }
.industry-card:nth-child(3) { animation-delay: 0.2s; }
.industry-card:nth-child(4) { animation-delay: 0.3s; }
.industry-card:nth-child(5) { animation-delay: 0.4s; }
.industry-card:nth-child(6) { animation-delay: 0.5s; }

.stat-card-large:nth-child(2) { animation-delay: 0.1s; }
.stat-card-large:nth-child(3) { animation-delay: 0.2s; }
.stat-card-large:nth-child(4) { animation-delay: 0.3s; }
`;

const animationStyle = document.createElement('style');
animationStyle.textContent = animationCSS;
document.head.appendChild(animationStyle);