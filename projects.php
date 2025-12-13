<?php 
require_once 'includes/config.php';

$current_page = 'projects';
$page_title = 'Projects & Case Studies | ' . SITE_NAME;
$page_description = 'Explore our portfolio of successful industrial automation projects across various industries.';
$page_keywords = 'automation projects, case studies, portfolio, industrial solutions';

include 'includes/header.php'; 
include 'includes/navbar.php'; 
?>

<!-- PAGE HEADER -->
<section class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <h1>Our Projects</h1>
            <p>Real-world automation solutions delivering measurable results</p>
        </div>
    </div>
</section>

<!-- PROJECT FILTER -->
<section class="project-filter-section">
    <div class="container">
        <div class="filter-controls">
            <button class="filter-btn active" data-filter="all">All Projects</button>
            <button class="filter-btn" data-filter="manufacturing">Manufacturing</button>
            <button class="filter-btn" data-filter="energy">Energy</button>
            <button class="filter-btn" data-filter="iot">IoT</button>
            <button class="filter-btn" data-filter="food">Food & Beverage</button>
            <button class="filter-btn" data-filter="chemical">Chemical</button>
        </div>
    </div>
</section>

<!-- PROJECTS GRID -->
<section class="section projects-section">
    <div class="container">
        <div class="projects-grid">
            <!-- Project 1 -->
            <div class="project-card" data-category="manufacturing">
                <div class="project-image">
                    <div class="image-placeholder">🏭</div>
                    <div class="project-overlay">
                        <span class="project-year">2023</span>
                    </div>
                </div>
                <div class="project-content">
                    <div class="project-category">Manufacturing</div>
                    <h3>Automotive Assembly Line Automation</h3>
                    <p>Implemented a complete PLC-based automation system for a major automotive parts manufacturer, increasing production efficiency by 35% and reducing defect rates by 50%.</p>
                    
                    <div class="project-details">
                        <div class="detail-item">
                            <span class="detail-label">Client:</span>
                            <span class="detail-value">AutoParts Inc.</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Duration:</span>
                            <span class="detail-value">12 weeks</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">ROI:</span>
                            <span class="detail-value">8 months</span>
                        </div>
                    </div>
                    
                    <div class="project-tech">
                        <span class="tech-tag">Siemens S7-1500</span>
                        <span class="tech-tag">SCADA</span>
                        <span class="tech-tag">Servo Motors</span>
                    </div>
                    
                    <div class="project-results">
                        <h4>Results Achieved</h4>
                        <div class="results-grid">
                            <div class="result-item">
                                <strong>35%</strong>
                                <span>Efficiency Increase</span>
                            </div>
                            <div class="result-item">
                                <strong>50%</strong>
                                <span>Defect Reduction</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project 2 -->
            <div class="project-card" data-category="energy">
                <div class="project-image">
                    <div class="image-placeholder">🔋</div>
                    <div class="project-overlay">
                        <span class="project-year">2023</span>
                    </div>
                </div>
                <div class="project-content">
                    <div class="project-category">Energy</div>
                    <h3>Power Distribution Control System</h3>
                    <p>Designed and installed advanced control panels for industrial power distribution, ensuring 99.9% uptime and seamless load balancing across multiple production lines.</p>
                    
                    <div class="project-details">
                        <div class="detail-item">
                            <span class="detail-label">Client:</span>
                            <span class="detail-value">PowerGrid Solutions</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Duration:</span>
                            <span class="detail-value">16 weeks</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Scale:</span>
                            <span class="detail-value">10 MW System</span>
                        </div>
                    </div>
                    
                    <div class="project-tech">
                        <span class="tech-tag">Allen-Bradley</span>
                        <span class="tech-tag">Energy Monitoring</span>
                        <span class="tech-tag">Safety Systems</span>
                    </div>
                    
                    <div class="project-results">
                        <h4>Results Achieved</h4>
                        <div class="results-grid">
                            <div class="result-item">
                                <strong>99.9%</strong>
                                <span>System Uptime</span>
                            </div>
                            <div class="result-item">
                                <strong>15%</strong>
                                <span>Energy Savings</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project 3 -->
            <div class="project-card" data-category="iot">
                <div class="project-image">
                    <div class="image-placeholder">📊</div>
                    <div class="project-overlay">
                        <span class="project-year">2023</span>
                    </div>
                </div>
                <div class="project-content">
                    <div class="project-category">IoT</div>
                    <h3>Smart Factory Monitoring Platform</h3>
                    <p>Developed a comprehensive IoT solution providing real-time monitoring, predictive maintenance alerts, and production analytics for a large manufacturing facility.</p>
                    
                    <div class="project-details">
                        <div class="detail-item">
                            <span class="detail-label">Client:</span>
                            <span class="detail-value">Precision Manufacturing Co.</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Duration:</span>
                            <span class="detail-value">20 weeks</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Devices:</span>
                            <span class="detail-value">500+ Sensors</span>
                        </div>
                    </div>
                    
                    <div class="project-tech">
                        <span class="tech-tag">Industrial IoT</span>
                        <span class="tech-tag">Cloud Platform</span>
                        <span class="tech-tag">Data Analytics</span>
                    </div>
                    
                    <div class="project-results">
                        <h4>Results Achieved</h4>
                        <div class="results-grid">
                            <div class="result-item">
                                <strong>40%</strong>
                                <span>Downtime Reduction</span>
                            </div>
                            <div class="result-item">
                                <strong>25%</strong>
                                <span>Maintenance Cost</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project 4 -->
            <div class="project-card" data-category="food">
                <div class="project-image">
                    <div class="image-placeholder">🥤</div>
                    <div class="project-overlay">
                        <span class="project-year">2022</span>
                    </div>
                </div>
                <div class="project-content">
                    <div class="project-category">Food & Beverage</div>
                    <h3>Beverage Bottling Line Control</h3>
                    <p>Automated bottling and packaging process with precise control systems, achieving 15,000 bottles per hour with minimal waste and consistent quality.</p>
                    
                    <div class="project-details">
                        <div class="detail-item">
                            <span class="detail-label">Client:</span>
                            <span class="detail-value">BeverageCorp</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Duration:</span>
                            <span class="detail-value">14 weeks</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Capacity:</span>
                            <span class="detail-value">15K bottles/hour</span>
                        </div>
                    </div>
                    
                    <div class="project-tech">
                        <span class="tech-tag">Mitsubishi PLC</span>
                        <span class="tech-tag">Servo Control</span>
                        <span class="tech-tag">Vision Systems</span>
                    </div>
                    
                    <div class="project-results">
                        <h4>Results Achieved</h4>
                        <div class="results-grid">
                            <div class="result-item">
                                <strong>20%</strong>
                                <span>Throughput Increase</span>
                            </div>
                            <div class="result-item">
                                <strong>99.5%</strong>
                                <span>Quality Rate</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project 5 -->
            <div class="project-card" data-category="manufacturing">
                <div class="project-image">
                    <div class="image-placeholder">🏗️</div>
                    <div class="project-overlay">
                        <span class="project-year">2022</span>
                    </div>
                </div>
                <div class="project-content">
                    <div class="project-category">Material Handling</div>
                    <h3>Warehouse Automation System</h3>
                    <p>Implemented automated material handling and inventory management system, reducing processing time by 60% and improving accuracy to 99.8%.</p>
                    
                    <div class="project-details">
                        <div class="detail-item">
                            <span class="detail-label">Client:</span>
                            <span class="detail-value">Logistics Pro</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Duration:</span>
                            <span class="detail-value">18 weeks</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Area:</span>
                            <span class="detail-value">50,000 sq.ft.</span>
                        </div>
                    </div>
                    
                    <div class="project-tech">
                        <span class="tech-tag">Conveyor Control</span>
                        <span class="tech-tag">RFID</span>
                        <span class="tech-tag">WMS Integration</span>
                    </div>
                    
                    <div class="project-results">
                        <h4>Results Achieved</h4>
                        <div class="results-grid">
                            <div class="result-item">
                                <strong>60%</strong>
                                <span>Time Reduction</span>
                            </div>
                            <div class="result-item">
                                <strong>99.8%</strong>
                                <span>Accuracy Rate</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project 6 -->
            <div class="project-card" data-category="chemical">
                <div class="project-image">
                    <div class="image-placeholder">⚗️</div>
                    <div class="project-overlay">
                        <span class="project-year">2022</span>
                    </div>
                </div>
                <div class="project-content">
                    <div class="project-category">Chemical Processing</div>
                    <h3>Process Control & Safety System</h3>
                    <p>Designed safety-critical control systems for chemical processing plant, meeting stringent safety standards while optimizing production efficiency.</p>
                    
                    <div class="project-details">
                        <div class="detail-item">
                            <span class="detail-label">Client:</span>
                            <span class="detail-value">ChemTech Industries</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Duration:</span>
                            <span class="detail-value">24 weeks</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Safety:</span>
                            <span class="detail-value">SIL 3 Certified</span>
                        </div>
                    </div>
                    
                    <div class="project-tech">
                        <span class="tech-tag">Safety PLC</span>
                        <span class="tech-tag">DCS Integration</span>
                        <span class="tech-tag">Emergency Shutdown</span>
                    </div>
                    
                    <div class="project-results">
                        <h4>Results Achieved</h4>
                        <div class="results-grid">
                            <div class="result-item">
                                <strong>100%</strong>
                                <span>Safety Compliance</span>
                            </div>
                            <div class="result-item">
                                <strong>30%</strong>
                                <span>Yield Improvement</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- RESULTS SUMMARY -->
<section class="section stats-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Proven Results</h2>
            <p class="section-subtitle">Quantifiable benefits delivered to our clients</p>
        </div>
        
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number" data-count="35">0</div>
                <div class="stat-label">Avg. Efficiency Increase</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-count="99.8">0</div>
                <div class="stat-label">System Uptime</div>
                <div class="stat-unit">%</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-count="50">0</div>
                <div class="stat-label">Avg. Defect Reduction</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-count="100">0</div>
                <div class="stat-label">Client Satisfaction</div>
                <div class="stat-unit">%</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section cta-section">
    <div class="container">
        <div class="cta-content">
            <h2>Start Your Automation Journey</h2>
            <p>Let's discuss how we can transform your manufacturing process with proven solutions.</p>
            <div class="cta-buttons">
                <a href="contact.php" class="btn btn-primary">Discuss Your Project</a>
                <a href="services.php" class="btn btn-secondary">View Services</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>