<?php 
require_once 'includes/config.php';

$current_page = 'home';
$page_title = SITE_TAGLINE . ' | ' . SITE_NAME;
$page_description = 'Delivering cutting-edge PLC automation, control systems, and custom electronics for modern manufacturing.';
$page_keywords = 'industrial automation, PLC programming, control panels, mechatronics, IoT solutions, manufacturing';

include 'includes/header.php'; 

?>

<!-- HERO SECTION -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge">
                <span>🏆 Industry Leader Since 2009</span>
            </div>
            <h1>Industrial Automation & Mechatronics Solutions</h1>
            <p class="hero-subtitle">Delivering cutting-edge PLC automation, control systems, and custom electronics for modern manufacturing.</p>
            <div class="hero-buttons">
                <a href="services.php" class="btn btn-white">
                    <span>Our Services</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="contact.php" class="btn btn-secondary">
                    <span>Get a Quote</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            <div class="hero-stats">
                <div class="stat">
                    <strong>15+</strong>
                    <span>Years Experience</span>
                </div>
                <div class="stat">
                    <strong>200+</strong>
                    <span>Projects Completed</span>
                </div>
                <div class="stat">
                    <strong>50+</strong>
                    <span>Industrial Clients</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TRUST BADGES -->
<section class="trust-badges">
    <div class="container">
        <div class="badges-grid">
            <div class="badge-item">
                <div class="badge-icon">🏆</div>
                <div class="badge-content">
                    <h4>ISO 9001 Certified</h4>
                    <p>Quality Management System</p>
                </div>
            </div>
            <div class="badge-item">
                <div class="badge-icon">🔒</div>
                <div class="badge-content">
                    <h4>24/7 Support</h4>
                    <p>Round-the-clock assistance</p>
                </div>
            </div>
            <div class="badge-item">
                <div class="badge-icon">⚡</div>
                <div class="badge-content">
                    <h4>Fast Response</h4>
                    <p>Under 2-hour response time</p>
                </div>
            </div>
            <div class="badge-item">
                <div class="badge-icon">🌍</div>
                <div class="badge-content">
                    <h4>Global Delivery</h4>
                    <p>Worldwide implementation</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES OVERVIEW -->
<section class="section services-section">
    <div class="container">
        <div class="section-header">
            <span class="section-label">Our Expertise</span>
            <h2 class="section-title">Our Core Services</h2>
            <p class="section-subtitle">Comprehensive industrial automation solutions tailored to your manufacturing needs</p>
        </div>
        
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">⚙️</div>
                <div class="service-content">
                    <h3>PLC Automation</h3>
                    <p>Advanced programmable logic controller systems for industrial process automation and control.</p>
                    <ul class="service-features">
                        <li>Siemens/Allen-Bradley PLC</li>
                        <li>SCADA Integration</li>
                        <li>Process Optimization</li>
                    </ul>
                    <a href="services.php#plc" class="service-link">
                        <span>Learn more</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="service-card">
                <div class="service-icon">🔌</div>
                <div class="service-content">
                    <h3>Control Panels</h3>
                    <p>Custom-designed electrical control panels built to international standards and specifications.</p>
                    <ul class="service-features">
                        <li>UL/CE Certified</li>
                        <li>MCC & PCC Panels</li>
                        <li>Safety Systems</li>
                    </ul>
                    <a href="services.php#panels" class="service-link">
                        <span>Learn more</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="service-card">
                <div class="service-icon">💡</div>
                <div class="service-content">
                    <h3>Custom Electronics</h3>
                    <p>Tailored electronic solutions for specialized industrial applications and unique requirements.</p>
                    <ul class="service-features">
                        <li>PCB Design</li>
                        <li>Embedded Systems</li>
                        <li>Sensor Integration</li>
                    </ul>
                    <a href="services.php#electronics" class="service-link">
                        <span>Learn more</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="service-card">
                <div class="service-icon">🌐</div>
                <div class="service-content">
                    <h3>IoT Solutions</h3>
                    <p>Industrial Internet of Things integration for smart manufacturing and real-time monitoring.</p>
                    <ul class="service-features">
                        <li>Real-time Monitoring</li>
                        <li>Predictive Maintenance</li>
                        <li>Cloud Analytics</li>
                    </ul>
                    <a href="services.php#iot" class="service-link">
                        <span>Learn more</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- STATS SECTION -->
<section class="section stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number" data-count="15">0</div>
                <div class="stat-label">Years Experience</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-count="200">0</div>
                <div class="stat-label">Projects Completed</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-count="50">0</div>
                <div class="stat-label">Industrial Clients</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-count="24">0</div>
                <div class="stat-label">/7 Support</div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURED PROJECTS -->
<section class="section projects-section">
    <div class="container">
        <div class="section-header">
            <span class="section-label">Portfolio</span>
            <h2 class="section-title">Featured Projects</h2>
            <p class="section-subtitle">Explore our portfolio of successful automation implementations</p>
        </div>
        
        <div class="projects-grid">
            <div class="project-card">
                <div class="project-image">🏭</div>
                <div class="project-content">
                    <div class="project-category">Manufacturing</div>
                    <h3>Automotive Assembly Line</h3>
                    <p>Complete PLC automation system for high-speed automotive component assembly.</p>
                    <div class="project-tech">
                        <span class="tech-tag">Siemens PLC</span>
                        <span class="tech-tag">SCADA</span>
                        <span class="tech-tag">Robotics</span>
                    </div>
                    <a href="projects.php" class="project-link">
                        <span>View details</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="project-card">
                <div class="project-image">🔋</div>
                <div class="project-content">
                    <div class="project-category">Energy</div>
                    <h3>Power Distribution Control</h3>
                    <p>Advanced control panel design for industrial power distribution system.</p>
                    <div class="project-tech">
                        <span class="tech-tag">Allen-Bradley</span>
                        <span class="tech-tag">Energy Monitoring</span>
                        <span class="tech-tag">Safety PLC</span>
                    </div>
                    <a href="projects.php" class="project-link">
                        <span>View details</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="project-card">
                <div class="project-image">📊</div>
                <div class="project-content">
                    <div class="project-category">IoT</div>
                    <h3>Smart Factory Monitoring</h3>
                    <p>Real-time IoT monitoring system for production line optimization.</p>
                    <div class="project-tech">
                        <span class="tech-tag">IoT Platform</span>
                        <span class="tech-tag">Cloud Analytics</span>
                        <span class="tech-tag">Dashboard</span>
                    </div>
                    <a href="projects.php" class="project-link">
                        <span>View details</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="section-footer">
            <a href="projects.php" class="btn btn-secondary">View All Projects</a>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="section cta-section">
    <div class="container">
        <div class="cta-content">
            <h2>Ready to Automate Your Operations?</h2>
            <p>Let's discuss how our industrial automation solutions can transform your manufacturing process.</p>
            <div class="cta-buttons">
                <a href="contact.php" class="btn btn-primary">
                    <span>Contact Us Today</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="tel:<?php echo SITE_PHONE; ?>" class="btn btn-white">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>
                    </svg>
                    <span><?php echo SITE_PHONE; ?></span>
                </a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?> ?>