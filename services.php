<?php 
require_once 'includes/config.php';

$current_page = 'services';
$page_title = 'Our Services | ' . SITE_NAME;
$page_description = 'PLC automation, control panels, custom electronics, and IoT solutions for industrial manufacturing.';
$page_keywords = 'PLC services, control panel design, custom electronics, IoT solutions, automation services';

include 'includes/header.php'; 
include 'includes/navbar.php'; 
?>

<!-- PAGE HEADER -->
<section class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <h1>Our Services</h1>
            <p>Comprehensive industrial automation solutions designed for your success</p>
        </div>
    </div>
</section>

<!-- SERVICES NAV -->
<section class="services-nav">
    <div class="container">
        <div class="services-nav-links">
            <a href="#plc" class="service-nav-link active">
                <span class="nav-icon">⚙️</span>
                <span>PLC Automation</span>
            </a>
            <a href="#panels" class="service-nav-link">
                <span class="nav-icon">🔌</span>
                <span>Control Panels</span>
            </a>
            <a href="#electronics" class="service-nav-link">
                <span class="nav-icon">💡</span>
                <span>Custom Electronics</span>
            </a>
            <a href="#iot" class="service-nav-link">
                <span class="nav-icon">🌐</span>
                <span>IoT Solutions</span>
            </a>
        </div>
    </div>
</section>

<!-- PLC AUTOMATION -->
<section class="service-detail-section" id="plc">
    <div class="container">
        <div class="service-detail">
            <div class="service-detail-content">
                <div class="service-label">Core Service</div>
                <h2 class="service-title">⚙️ PLC Automation</h2>
                <h3 class="service-subtitle">Programmable Logic Controller Systems</h3>
                <div class="service-description">
                    <p>Our PLC automation services provide comprehensive control solutions for industrial processes. We design, program, and implement PLC systems using industry-leading platforms including Siemens, Allen-Bradley, and Mitsubishi.</p>
                    <p>We specialize in complex automation projects requiring precise control, high reliability, and seamless integration with existing systems.</p>
                </div>
                
                <div class="service-features-list">
                    <h4>Key Features</h4>
                    <div class="features-grid">
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>PLC programming & configuration</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>SCADA/HMI system integration</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>Process automation design</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>System troubleshooting & optimization</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>Motion control systems</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>Safety system integration</span>
                        </div>
                    </div>
                </div>
                
                <div class="service-technologies">
                    <h4>Technologies We Use</h4>
                    <div class="tech-tags">
                        <span class="tech-tag">Siemens S7/TIA Portal</span>
                        <span class="tech-tag">Allen-Bradley RSLogix</span>
                        <span class="tech-tag">Mitsubishi GX Works</span>
                        <span class="tech-tag">SCADA Systems</span>
                        <span class="tech-tag">HMI Development</span>
                    </div>
                </div>
            </div>
            
            <div class="service-detail-visual">
                <div class="service-visual-card">
                    <div class="visual-icon">⚙️</div>
                    <div class="visual-content">
                        <h4>Typical Project Timeline</h4>
                        <div class="timeline">
                            <div class="timeline-item">
                                <span class="timeline-step">1</span>
                                <span>Consultation & Analysis</span>
                                <span class="timeline-duration">1-2 weeks</span>
                            </div>
                            <div class="timeline-item">
                                <span class="timeline-step">2</span>
                                <span>Design & Planning</span>
                                <span class="timeline-duration">2-4 weeks</span>
                            </div>
                            <div class="timeline-item">
                                <span class="timeline-step">3</span>
                                <span>Implementation</span>
                                <span class="timeline-duration">4-8 weeks</span>
                            </div>
                            <div class="timeline-item">
                                <span class="timeline-step">4</span>
                                <span>Testing & Training</span>
                                <span class="timeline-duration">1-2 weeks</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CONTROL PANELS -->
<section class="service-detail-section alt-section" id="panels">
    <div class="container">
        <div class="service-detail reverse">
            <div class="service-detail-content">
                <div class="service-label">Core Service</div>
                <h2 class="service-title">🔌 Control Panels</h2>
                <h3 class="service-subtitle">Custom Electrical Control Solutions</h3>
                <div class="service-description">
                    <p>We design and manufacture custom control panels that meet your specific requirements and comply with international standards (IEC, UL, CE, CSA).</p>
                    <p>Our panels are built for durability, safety, and optimal performance in industrial environments.</p>
                </div>
                
                <div class="service-features-list">
                    <h4>Key Features</h4>
                    <div class="features-grid">
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>Custom panel design & fabrication</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>Motor control centers (MCC)</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>Power distribution panels</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>Safety system integration</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>Wiring & termination</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>Testing & certification</span>
                        </div>
                    </div>
                </div>
                
                <div class="service-technologies">
                    <h4>Standards Compliance</h4>
                    <div class="tech-tags">
                        <span class="tech-tag">UL 508A</span>
                        <span class="tech-tag">IEC 61439</span>
                        <span class="tech-tag">NFPA 70</span>
                        <span class="tech-tag">CE Marking</span>
                        <span class="tech-tag">CSA Certified</span>
                    </div>
                </div>
            </div>
            
            <div class="service-detail-visual">
                <div class="service-visual-card">
                    <div class="visual-icon">🔌</div>
                    <div class="visual-content">
                        <h4>Panel Types</h4>
                        <div class="panel-types">
                            <div class="panel-type">
                                <strong>MCC Panels</strong>
                                <span>Motor Control Centers</span>
                            </div>
                            <div class="panel-type">
                                <strong>PCC Panels</strong>
                                <span>Power Control Centers</span>
                            </div>
                            <div class="panel-type">
                                <strong>PLC Panels</strong>
                                <span>Control & Automation</span>
                            </div>
                            <div class="panel-type">
                                <strong>Distribution</strong>
                                <span>Power Distribution</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CUSTOM ELECTRONICS -->
<section class="service-detail-section" id="electronics">
    <div class="container">
        <div class="service-detail">
            <div class="service-detail-content">
                <div class="service-label">Core Service</div>
                <h2 class="service-title">💡 Custom Electronics</h2>
                <h3 class="service-subtitle">Tailored Electronic Solutions</h3>
                <div class="service-description">
                    <p>Our custom electronics services provide specialized solutions for unique industrial challenges, from PCB design to complete system integration.</p>
                    <p>We develop bespoke electronic systems that meet specific industrial requirements not addressed by off-the-shelf solutions.</p>
                </div>
                
                <div class="service-features-list">
                    <h4>Key Features</h4>
                    <div class="features-grid">
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>PCB design & prototyping</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>Embedded systems development</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>Sensor integration</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>Custom HMI solutions</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>Prototype development</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>Testing & validation</span>
                        </div>
                    </div>
                </div>
                
                <div class="service-technologies">
                    <h4>Development Tools</h4>
                    <div class="tech-tags">
                        <span class="tech-tag">Altium Designer</span>
                        <span class="tech-tag">ARM Cortex</span>
                        <span class="tech-tag">ESP32/Arduino</span>
                        <span class="tech-tag">Raspberry Pi</span>
                        <span class="tech-tag">Embedded C/C++</span>
                    </div>
                </div>
            </div>
            
            <div class="service-detail-visual">
                <div class="service-visual-card">
                    <div class="visual-icon">💡</div>
                    <div class="visual-content">
                        <h4>Development Process</h4>
                        <div class="process-steps">
                            <div class="process-step">
                                <span class="step-number">1</span>
                                <div>
                                    <strong>Requirements Analysis</strong>
                                    <span>Understanding needs</span>
                                </div>
                            </div>
                            <div class="process-step">
                                <span class="step-number">2</span>
                                <div>
                                    <strong>Design & Simulation</strong>
                                    <span>Circuit design</span>
                                </div>
                            </div>
                            <div class="process-step">
                                <span class="step-number">3</span>
                                <div>
                                    <strong>Prototyping</strong>
                                    <span>Build & test</span>
                                </div>
                            </div>
                            <div class="process-step">
                                <span class="step-number">4</span>
                                <div>
                                    <strong>Production</strong>
                                    <span>Manufacturing</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- IOT SOLUTIONS -->
<section class="service-detail-section alt-section" id="iot">
    <div class="container">
        <div class="service-detail reverse">
            <div class="service-detail-content">
                <div class="service-label">Core Service</div>
                <h2 class="service-title">🌐 IoT Solutions</h2>
                <h3 class="service-subtitle">Industrial Internet of Things</h3>
                <div class="service-description">
                    <p>Transform your manufacturing with smart, connected systems that provide real-time data, predictive maintenance, and remote monitoring capabilities.</p>
                    <p>Our IoT solutions bridge the gap between physical equipment and digital intelligence for Industry 4.0 transformation.</p>
                </div>
                
                <div class="service-features-list">
                    <h4>Key Features</h4>
                    <div class="features-grid">
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>Industrial IoT platform integration</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>Real-time monitoring dashboards</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>Predictive maintenance systems</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>Cloud connectivity & data analytics</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>Remote monitoring & control</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-check">✓</span>
                            <span>Data visualization & reporting</span>
                        </div>
                    </div>
                </div>
                
                <div class="service-technologies">
                    <h4>Platform Integration</h4>
                    <div class="tech-tags">
                        <span class="tech-tag">AWS IoT</span>
                        <span class="tech-tag">Azure IoT</span>
                        <span class="tech-tag">MQTT Protocol</span>
                        <span class="tech-tag">Node-RED</span>
                        <span class="tech-tag">Grafana</span>
                    </div>
                </div>
            </div>
            
            <div class="service-detail-visual">
                <div class="service-visual-card">
                    <div class="visual-icon">🌐</div>
                    <div class="visual-content">
                        <h4>IoT Architecture</h4>
                        <div class="iot-architecture">
                            <div class="arch-layer">
                                <strong>Sensors & Devices</strong>
                                <span>Data collection layer</span>
                            </div>
                            <div class="arch-layer">
                                <strong>Gateway & Edge</strong>
                                <span>Data processing layer</span>
                            </div>
                            <div class="arch-layer">
                                <strong>Cloud Platform</strong>
                                <span>Storage & analytics</span>
                            </div>
                            <div class="arch-layer">
                                <strong>Applications</strong>
                                <span>User interface layer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SERVICE CTA -->
<section class="section service-cta">
    <div class="container">
        <div class="service-cta-content">
            <h2>Need a Custom Solution?</h2>
            <p>Let's discuss your specific automation requirements and develop the perfect solution.</p>
            <div class="cta-buttons">
                <a href="contact.php" class="btn btn-primary">Request Consultation</a>
                <a href="tel:<?php echo SITE_PHONE; ?>" class="btn btn-secondary">Call Now</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>