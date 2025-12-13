<?php 
require_once 'includes/config.php';

$current_page = 'projects';
$page_title = 'Projects & Case Studies | ' . SITE_NAME;
$page_description = 'Explore our portfolio of successful industrial automation projects across various industries.';
$page_keywords = 'automation projects, case studies, portfolio, industrial solutions';

include 'includes/header.php'; 

?>

<!-- PAGE HEADER WITH ANIMATION -->
<section class="page-hero projects-hero">
    <div class="container">
        <div class="page-hero-content animated-content">
            <div class="hero-badge pulse-animation">
                <span>🏆 Award-Winning Projects</span>
            </div>
            <h1 class="text-glow">Our <span class="text-accent">Projects</span></h1>
            <p class="hero-subtitle">Real-world automation solutions delivering measurable results for leading industries</p>
            <div class="hero-stats">
                <div class="stat-card">
                    <div class="stat-number">200+</div>
                    <div class="stat-label">Projects Completed</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Client Satisfaction</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">15</div>
                    <div class="stat-label">Industries Served</div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-waves">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="currentColor"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="currentColor"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="currentColor"></path>
        </svg>
    </div>
</section>

<!-- PROJECT FILTER WITH INTERACTIVE DESIGN -->
<section class="section filter-section">
    <div class="container">
        <div class="filter-container">
            <div class="filter-header">
                <h2>Browse Our <span class="text-accent">Portfolio</span></h2>
                <p>Filter by industry or technology to find relevant case studies</p>
            </div>
            
            <div class="filter-tags">
                <button class="filter-tag active" data-filter="all">
                    <span class="filter-icon">⭐</span>
                    <span>All Projects</span>
                </button>
                <button class="filter-tag" data-filter="manufacturing">
                    <span class="filter-icon">🏭</span>
                    <span>Manufacturing</span>
                </button>
                <button class="filter-tag" data-filter="energy">
                    <span class="filter-icon">⚡</span>
                    <span>Energy</span>
                </button>
                <button class="filter-tag" data-filter="iot">
                    <span class="filter-icon">🌐</span>
                    <span>IoT & Smart Factory</span>
                </button>
                <button class="filter-tag" data-filter="food">
                    <span class="filter-icon">🥤</span>
                    <span>Food & Beverage</span>
                </button>
                <button class="filter-tag" data-filter="automotive">
                    <span class="filter-icon">🚗</span>
                    <span>Automotive</span>
                </button>
                <button class="filter-tag" data-filter="pharmaceutical">
                    <span class="filter-icon">💊</span>
                    <span>Pharmaceutical</span>
                </button>
            </div>
            
            <div class="filter-stats">
                <div class="stat-bubble">
                    <span class="stat-count">6</span>
                    <span>Featured Projects</span>
                </div>
                <div class="stat-bubble">
                    <span class="stat-count">15+</span>
                    <span>Years Experience</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURED PROJECTS - GRID LAYOUT -->
<section class="section projects-showcase">
    <div class="container">
        <div class="showcase-header">
            <div class="section-label">Featured Work</div>
            <h2 class="section-title">Success <span class="text-accent">Stories</span></h2>
            <p class="section-subtitle">Discover how we've transformed manufacturing processes across industries</p>
        </div>

        <div class="projects-grid">
            <!-- Project 1 - Featured (Large) -->
            <div class="project-card featured-card" data-category="manufacturing">
                <div class="project-badge">
                    <span class="badge-text">Featured</span>
                    <span class="badge-year">2023</span>
                </div>
                <div class="project-media">
                    <div class="project-image" style="background: linear-gradient(135deg, #4F46E5, #7C3AED);">
                        <div class="image-overlay">
                            <div class="industry-icon">🏭</div>
                            <div class="project-duration">12 Weeks • Large Scale</div>
                        </div>
                        <div class="project-tech-stack">
                            <span class="tech-badge">Siemens S7-1500</span>
                            <span class="tech-badge">SCADA</span>
                            <span class="tech-badge">Robotics</span>
                        </div>
                    </div>
                </div>
                <div class="project-content">
                    <div class="project-meta">
                        <span class="project-category">Manufacturing</span>
                        <span class="project-client">AutoParts Inc.</span>
                    </div>
                    <h3 class="project-title">Automotive Assembly Line Automation</h3>
                    <p class="project-description">Complete PLC-based automation system for high-speed automotive component assembly, achieving unprecedented efficiency and quality control.</p>
                    
                    <div class="project-challenges">
                        <h4>Challenge</h4>
                        <p>Manual processes causing 15% defect rates and production bottlenecks. Needed 24/7 operation with consistent quality.</p>
                    </div>
                    
                    <div class="project-results-grid">
                        <div class="result-metric">
                            <div class="metric-value">35%</div>
                            <div class="metric-label">Efficiency Increase</div>
                        </div>
                        <div class="result-metric">
                            <div class="metric-value">50%</div>
                            <div class="metric-label">Defect Reduction</div>
                        </div>
                        <div class="result-metric">
                            <div class="metric-value">99.9%</div>
                            <div class="metric-label">Uptime Achieved</div>
                        </div>
                    </div>
                    
                    <div class="project-cta">
                        <a href="#" class="btn btn-primary">
                            <span>View Case Study</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                        <button class="btn btn-text project-quickview" data-project="1">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <span>Quick View</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Project 2 -->
            <div class="project-card" data-category="energy">
                <div class="project-media">
                    <div class="project-image" style="background: linear-gradient(135deg, #F59E0B, #D97706);">
                        <div class="image-overlay">
                            <div class="industry-icon">⚡</div>
                            <div class="project-duration">16 Weeks • 10MW System</div>
                        </div>
                    </div>
                    <div class="project-tech-stack">
                        <span class="tech-badge">Allen-Bradley</span>
                        <span class="tech-badge">Energy Monitoring</span>
                    </div>
                </div>
                <div class="project-content">
                    <div class="project-meta">
                        <span class="project-category">Energy</span>
                        <span class="project-client">PowerGrid Solutions</span>
                    </div>
                    <h3 class="project-title">Smart Power Distribution System</h3>
                    <p class="project-description">Advanced control panel design for industrial power distribution with real-time monitoring and load balancing.</p>
                    
                    <div class="project-highlights">
                        <div class="highlight">
                            <span class="highlight-icon">✅</span>
                            <span>99.9% system uptime</span>
                        </div>
                        <div class="highlight">
                            <span class="highlight-icon">✅</span>
                            <span>15% energy savings</span>
                        </div>
                        <div class="highlight">
                            <span class="highlight-icon">✅</span>
                            <span>Remote monitoring</span>
                        </div>
                    </div>
                    
                    <div class="project-footer">
                        <div class="project-stats">
                            <div class="stat">
                                <div class="stat-number">99.9%</div>
                                <div class="stat-label">Uptime</div>
                            </div>
                            <div class="stat">
                                <div class="stat-number">$250K</div>
                                <div class="stat-label">Annual Savings</div>
                            </div>
                        </div>
                        <a href="#" class="project-link">
                            <span>Details</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Project 3 -->
            <div class="project-card" data-category="iot">
                <div class="project-media">
                    <div class="project-image" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);">
                        <div class="image-overlay">
                            <div class="industry-icon">🌐</div>
                            <div class="project-duration">20 Weeks • 500+ Sensors</div>
                        </div>
                    </div>
                    <div class="project-tech-stack">
                        <span class="tech-badge">Industrial IoT</span>
                        <span class="tech-badge">Cloud Analytics</span>
                    </div>
                </div>
                <div class="project-content">
                    <div class="project-meta">
                        <span class="project-category">IoT Solutions</span>
                        <span class="project-client">Precision Manufacturing</span>
                    </div>
                    <h3 class="project-title">Smart Factory Monitoring Platform</h3>
                    <p class="project-description">Comprehensive IoT solution providing real-time monitoring and predictive maintenance for manufacturing facility.</p>
                    
                    <div class="project-highlights">
                        <div class="highlight">
                            <span class="highlight-icon">✅</span>
                            <span>40% downtime reduction</span>
                        </div>
                        <div class="highlight">
                            <span class="highlight-icon">✅</span>
                            <span>Predictive maintenance</span>
                        </div>
                        <div class="highlight">
                            <span class="highlight-icon">✅</span>
                            <span>Real-time dashboards</span>
                        </div>
                    </div>
                    
                    <div class="project-footer">
                        <div class="project-stats">
                            <div class="stat">
                                <div class="stat-number">40%</div>
                                <div class="stat-label">Downtime ↓</div>
                            </div>
                            <div class="stat">
                                <div class="stat-number">25%</div>
                                <div class="stat-label">Maintenance Cost ↓</div>
                            </div>
                        </div>
                        <a href="#" class="project-link">
                            <span>Details</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Project 4 -->
            <div class="project-card" data-category="food">
                <div class="project-media">
                    <div class="project-image" style="background: linear-gradient(135deg, #10B981, #059669);">
                        <div class="image-overlay">
                            <div class="industry-icon">🥤</div>
                            <div class="project-duration">14 Weeks • 15K bottles/hour</div>
                        </div>
                    </div>
                    <div class="project-tech-stack">
                        <span class="tech-badge">Mitsubishi PLC</span>
                        <span class="tech-badge">Vision Systems</span>
                    </div>
                </div>
                <div class="project-content">
                    <div class="project-meta">
                        <span class="project-category">Food & Beverage</span>
                        <span class="project-client">BeverageCorp</span>
                    </div>
                    <h3 class="project-title">High-Speed Bottling Line Automation</h3>
                    <p class="project-description">Automated bottling and packaging process with precise control systems and quality assurance.</p>
                    
                    <div class="project-highlights">
                        <div class="highlight">
                            <span class="highlight-icon">✅</span>
                            <span>20% throughput increase</span>
                        </div>
                        <div class="highlight">
                            <span class="highlight-icon">✅</span>
                            <span>99.5% quality rate</span>
                        </div>
                        <div class="highlight">
                            <span class="highlight-icon">✅</span>
                            <span>Zero contamination</span>
                        </div>
                    </div>
                    
                    <div class="project-footer">
                        <div class="project-stats">
                            <div class="stat">
                                <div class="stat-number">99.5%</div>
                                <div class="stat-label">Quality Rate</div>
                            </div>
                            <div class="stat">
                                <div class="stat-number">20%</div>
                                <div class="stat-label">Throughput ↑</div>
                            </div>
                        </div>
                        <a href="#" class="project-link">
                            <span>Details</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Project 5 -->
            <div class="project-card" data-category="manufacturing">
                <div class="project-media">
                    <div class="project-image" style="background: linear-gradient(135deg, #8B5CF6, #7C3AED);">
                        <div class="image-overlay">
                            <div class="industry-icon">🏗️</div>
                            <div class="project-duration">18 Weeks • 50,000 sq.ft.</div>
                        </div>
                    </div>
                    <div class="project-tech-stack">
                        <span class="tech-badge">RFID Tracking</span>
                        <span class="tech-badge">WMS Integration</span>
                    </div>
                </div>
                <div class="project-content">
                    <div class="project-meta">
                        <span class="project-category">Material Handling</span>
                        <span class="project-client">Logistics Pro</span>
                    </div>
                    <h3 class="project-title">Warehouse Automation System</h3>
                    <p class="project-description">Automated material handling and inventory management system with real-time tracking.</p>
                    
                    <div class="project-highlights">
                        <div class="highlight">
                            <span class="highlight-icon">✅</span>
                            <span>60% time reduction</span>
                        </div>
                        <div class="highlight">
                            <span class="highlight-icon">✅</span>
                            <span>99.8% accuracy rate</span>
                        </div>
                        <div class="highlight">
                            <span class="highlight-icon">✅</span>
                            <span>Real-time inventory</span>
                        </div>
                    </div>
                    
                    <div class="project-footer">
                        <div class="project-stats">
                            <div class="stat">
                                <div class="stat-number">99.8%</div>
                                <div class="stat-label">Accuracy</div>
                            </div>
                            <div class="stat">
                                <div class="stat-number">60%</div>
                                <div class="stat-label">Time Saved</div>
                            </div>
                        </div>
                        <a href="#" class="project-link">
                            <span>Details</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Project 6 -->
            <div class="project-card" data-category="pharmaceutical">
                <div class="project-media">
                    <div class="project-image" style="background: linear-gradient(135deg, #EC4899, #DB2777);">
                        <div class="image-overlay">
                            <div class="industry-icon">💊</div>
                            <div class="project-duration">24 Weeks • SIL 3 Certified</div>
                        </div>
                    </div>
                    <div class="project-tech-stack">
                        <span class="tech-badge">Safety PLC</span>
                        <span class="tech-badge">DCS Integration</span>
                    </div>
                </div>
                <div class="project-content">
                    <div class="project-meta">
                        <span class="project-category">Pharmaceutical</span>
                        <span class="project-client">ChemTech Industries</span>
                    </div>
                    <h3 class="project-title">Process Control & Safety System</h3>
                    <p class="project-description">Safety-critical control systems for chemical processing with emergency shutdown protocols.</p>
                    
                    <div class="project-highlights">
                        <div class="highlight">
                            <span class="highlight-icon">✅</span>
                            <span>100% safety compliance</span>
                        </div>
                        <div class="highlight">
                            <span class="highlight-icon">✅</span>
                            <span>30% yield improvement</span>
                        </div>
                        <div class="highlight">
                            <span class="highlight-icon">✅</span>
                            <span>Zero incidents</span>
                        </div>
                    </div>
                    
                    <div class="project-footer">
                        <div class="project-stats">
                            <div class="stat">
                                <div class="stat-number">100%</div>
                                <div class="stat-label">Safety</div>
                            </div>
                            <div class="stat">
                                <div class="stat-number">30%</div>
                                <div class="stat-label">Yield ↑</div>
                            </div>
                        </div>
                        <a href="#" class="project-link">
                            <span>Details</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="projects-footer">
            <a href="contact.php" class="btn btn-primary btn-large">
                <span>Start Your Project</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
            <p class="footer-note">View more case studies in our detailed portfolio</p>
        </div>
    </div>
</section>

<!-- PROJECT STATISTICS -->
<section class="section stats-showcase">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card-large">
                <div class="stat-icon">📈</div>
                <div class="stat-content">
                    <div class="stat-number" data-count="35">0</div>
                    <div class="stat-label">Average Efficiency Increase</div>
                    <div class="stat-trend">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M23 6l-9.5 9.5-5-5L1 18"/>
                            <path d="M17 6h6v6"/>
                        </svg>
                        <span>Industry leading performance</span>
                    </div>
                </div>
            </div>
            
            <div class="stat-card-large">
                <div class="stat-icon">⏱️</div>
                <div class="stat-content">
                    <div class="stat-number" data-count="99.8">0</div>
                    <div class="stat-label">Average System Uptime</div>
                    <div class="stat-unit">%</div>
                    <div class="stat-trend">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M23 6l-9.5 9.5-5-5L1 18"/>
                            <path d="M17 6h6v6"/>
                        </svg>
                        <span>Highest reliability standards</span>
                    </div>
                </div>
            </div>
            
            <div class="stat-card-large">
                <div class="stat-icon">🎯</div>
                <div class="stat-content">
                    <div class="stat-number" data-count="50">0</div>
                    <div class="stat-label">Average Defect Reduction</div>
                    <div class="stat-trend">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M23 6l-9.5 9.5-5-5L1 18"/>
                            <path d="M17 6h6v6"/>
                        </svg>
                        <span>Quality improvement guaranteed</span>
                    </div>
                </div>
            </div>
            
            <div class="stat-card-large">
                <div class="stat-icon">💯</div>
                <div class="stat-content">
                    <div class="stat-number" data-count="100">0</div>
                    <div class="stat-label">Client Satisfaction Rate</div>
                    <div class="stat-unit">%</div>
                    <div class="stat-trend">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M23 6l-9.5 9.5-5-5L1 18"/>
                            <path d="M17 6h6v6"/>
                        </svg>
                        <span>Perfect track record</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- INDUSTRY EXPERTISE -->
<section class="section industries-section">
    <div class="container">
        <div class="section-header">
            <div class="section-label">Our Expertise</div>
            <h2 class="section-title">Industries We <span class="text-accent">Serve</span></h2>
            <p class="section-subtitle">Providing specialized automation solutions across diverse sectors</p>
        </div>
        
        <div class="industries-grid">
            <div class="industry-card">
                <div class="industry-icon">🏭</div>
                <div class="industry-content">
                    <h3>Manufacturing</h3>
                    <p>Assembly lines, robotics, quality control, and process optimization</p>
                    <div class="project-count">45 projects</div>
                </div>
            </div>
            
            <div class="industry-card">
                <div class="industry-icon">⚡</div>
                <div class="industry-content">
                    <h3>Energy & Utilities</h3>
                    <p>Power distribution, renewable energy, grid management</p>
                    <div class="project-count">28 projects</div>
                </div>
            </div>
            
            <div class="industry-card">
                <div class="industry-icon">🥤</div>
                <div class="industry-content">
                    <h3>Food & Beverage</h3>
                    <p>Processing, packaging, quality assurance, sanitation</p>
                    <div class="project-count">32 projects</div>
                </div>
            </div>
            
            <div class="industry-card">
                <div class="industry-icon">💊</div>
                <div class="industry-content">
                    <h3>Pharmaceutical</h3>
                    <p>Clean room automation, batch processing, validation</p>
                    <div class="project-count">18 projects</div>
                </div>
            </div>
            
            <div class="industry-card">
                <div class="industry-icon">🚗</div>
                <div class="industry-content">
                    <h3>Automotive</h3>
                    <p>Assembly automation, testing, supply chain integration</p>
                    <div class="project-count">39 projects</div>
                </div>
            </div>
            
            <div class="industry-card">
                <div class="industry-icon">📦</div>
                <div class="industry-content">
                    <h3>Logistics</h3>
                    <p>Warehouse automation, material handling, inventory systems</p>
                    <div class="project-count">27 projects</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PROJECT PROCESS -->
<section class="section process-section">
    <div class="container">
        <div class="section-header">
            <div class="section-label">Our Process</div>
            <h2 class="section-title">How We <span class="text-accent">Deliver</span></h2>
            <p class="section-subtitle">A structured approach ensuring project success from start to finish</p>
        </div>
        
        <div class="process-timeline">
            <div class="process-step">
                <div class="step-number">01</div>
                <div class="step-content">
                    <h3>Discovery & Analysis</h3>
                    <p>Comprehensive assessment of requirements, challenges, and goals</p>
                    <ul class="step-features">
                        <li>Needs analysis</li>
                        <li>Feasibility study</li>
                        <li>ROI calculation</li>
                    </ul>
                </div>
                <div class="step-icon">🔍</div>
            </div>
            
            <div class="process-step">
                <div class="step-number">02</div>
                <div class="step-content">
                    <h3>Design & Planning</h3>
                    <p>Detailed system architecture, component selection, and project planning</p>
                    <ul class="step-features">
                        <li>System architecture</li>
                        <li>Component selection</li>
                        <li>Timeline planning</li>
                    </ul>
                </div>
                <div class="step-icon">📐</div>
            </div>
            
            <div class="process-step">
                <div class="step-number">03</div>
                <div class="step-content">
                    <h3>Implementation</h3>
                    <p>Hardware installation, software development, and system integration</p>
                    <ul class="step-features">
                        <li>Hardware setup</li>
                        <li>Software development</li>
                        <li>System integration</li>
                    </ul>
                </div>
                <div class="step-icon">⚙️</div>
            </div>
            
            <div class="process-step">
                <div class="step-number">04</div>
                <div class="step-content">
                    <h3>Testing & Training</h3>
                    <p>Rigorous testing, staff training, and documentation handover</p>
                    <ul class="step-features">
                        <li>System testing</li>
                        <li>Staff training</li>
                        <li>Documentation</li>
                    </ul>
                </div>
                <div class="step-icon">🎓</div>
            </div>
            
            <div class="process-step">
                <div class="step-number">05</div>
                <div class="step-content">
                    <h3>Support & Maintenance</h3>
                    <p>Ongoing support, maintenance, and performance optimization</p>
                    <ul class="step-features">
                        <li>24/7 support</li>
                        <li>Regular maintenance</li>
                        <li>Performance updates</li>
                    </ul>
                </div>
                <div class="step-icon">🛠️</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="section cta-section project-cta">
    <div class="container">
        <div class="cta-content">
            <div class="cta-badge">
                <span>Ready to Transform?</span>
            </div>
            <h2>Start Your <span class="text-accent">Automation</span> Journey</h2>
            <p>Let's discuss how we can bring measurable results to your manufacturing process with proven solutions.</p>
            <div class="cta-buttons">
                <a href="contact.php" class="btn btn-primary btn-large">
                    <span>Discuss Your Project</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="services.php" class="btn btn-secondary btn-large">
                    <span>View Services</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            <div class="cta-contact">
                <div class="contact-item">
                    <span class="contact-icon">📞</span>
                    <a href="tel:<?php echo SITE_PHONE; ?>"><?php echo SITE_PHONE; ?></a>
                </div>
                <div class="contact-item">
                    <span class="contact-icon">📧</span>
                    <a href="mailto:<?php echo SITE_EMAIL; ?>"><?php echo SITE_EMAIL; ?></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- QUICK VIEW MODAL -->
<div class="modal" id="projectModal">
    <div class="modal-content">
        <button class="modal-close">&times;</button>
        <div class="modal-body" id="modalBody">
            <!-- Content loaded dynamically -->
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>