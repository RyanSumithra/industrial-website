<?php 
require_once 'includes/config.php';

$current_page = 'services';
$page_title = 'Our Services | ' . SITE_NAME;
$page_description = 'PLC automation, control panels, custom electronics, and IoT solutions for industrial manufacturing.';
$page_keywords = 'PLC services, control panel design, custom electronics, IoT solutions, automation services';

include 'includes/header.php'; 
?>

<style>
    /* Animations */
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-up { animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
    
    /* 1. Page Hero */
    .page-hero {
        background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)),
                    repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255, 51, 51, 0.05) 10px, rgba(255, 51, 51, 0.05) 11px),
                    linear-gradient(180deg, #050505 0%, #111 100%);
        padding: 120px 0 100px;
        border-bottom: 1px solid #222;
        text-align: center;
    }
    .page-hero h1 { font-size: 3.5rem; font-weight: 900; color: white; margin-bottom: 1rem; letter-spacing: -1px; }
    .page-hero p { color: #888; font-size: 1.2rem; max-width: 600px; margin: 0 auto; }

    /* 2. Sticky Services Nav */
    .services-nav {
        background: rgba(10, 10, 10, 0.9);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid #222;
        position: sticky;
        top: 0; /* Adjust based on your main header height */
        z-index: 99;
        padding: 15px 0;
    }
    .services-nav-links {
        display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;
    }
    .service-nav-link {
        color: #888; text-decoration: none; padding: 10px 20px; border-radius: 50px;
        font-size: 0.9rem; font-weight: 600; transition: 0.3s;
        border: 1px solid transparent; display: flex; align-items: center; gap: 8px;
    }
    .service-nav-link:hover, .service-nav-link:target {
        background: rgba(255, 51, 51, 0.1); color: var(--primary-red); border-color: var(--primary-red);
    }
    .nav-icon { font-size: 1.1rem; }

    /* 3. Service Detail Sections */
    .service-detail-section { padding: 100px 0; border-bottom: 1px solid #1a1a1a; scroll-margin-top: 80px; }
    .alt-section { background: #080808; } /* Darker background for alternating sections */
    
    .service-detail { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; }
    @media(max-width: 900px) { .service-detail { grid-template-columns: 1fr; } }
    
    /* Reverse Layout for alternating sections */
    .reverse .service-detail-content { order: 2; }
    .reverse .service-detail-visual { order: 1; }
    @media(max-width: 900px) { .reverse .service-detail-content { order: 1; } .reverse .service-detail-visual { order: 2; } }

    .service-label { color: var(--primary-red); font-weight: 800; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 2px; margin-bottom: 10px; display: block; }
    .service-title { font-size: 2.5rem; color: white; margin: 0 0 5px 0; font-weight: 900; }
    .service-subtitle { font-size: 1.2rem; color: #666; font-weight: 400; margin-bottom: 20px; }
    .service-description p { color: #999; line-height: 1.7; margin-bottom: 1rem; }

    /* Features Grid */
    .features-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 30px; }
    .feature-item { display: flex; align-items: center; gap: 10px; color: #ccc; font-size: 0.9rem; }
    .feature-check { color: var(--primary-red); font-weight: bold; }

    /* Tech Tags */
    .service-technologies { margin-top: 30px; padding-top: 30px; border-top: 1px solid #222; }
    .service-technologies h4 { color: white; font-size: 0.9rem; margin-bottom: 15px; text-transform: uppercase; }
    .tech-tags { display: flex; flex-wrap: wrap; gap: 10px; }
    .tech-tag {
        background: #151515; color: #888; padding: 6px 12px; font-size: 0.8rem;
        border-radius: 4px; border: 1px solid #333; transition: 0.3s;
    }
    .tech-tag:hover { border-color: var(--primary-red); color: white; }

    /* 4. Visual Diagrams (CSS Only) */
    .service-visual-card {
        background: #111; border: 1px solid #222; border-radius: 12px; padding: 30px;
        position: relative; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    }
    .service-visual-card::before {
        content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px;
        background: linear-gradient(90deg, var(--primary-red), transparent);
    }

    /* Timeline Diagram */
    .timeline { position: relative; margin-top: 20px; padding-left: 20px; border-left: 2px solid #222; }
    .timeline-item { position: relative; margin-bottom: 30px; padding-left: 20px; }
    .timeline-item::before {
        content: ''; position: absolute; left: -26px; top: 0; width: 10px; height: 10px;
        background: #000; border: 2px solid var(--primary-red); border-radius: 50%;
    }
    .timeline-step { display: block; font-size: 0.7rem; color: var(--primary-red); font-weight: 700; text-transform: uppercase; margin-bottom: 4px; }
    .timeline-item span:nth-child(2) { display: block; color: white; font-weight: 600; font-size: 1.1rem; }
    .timeline-duration { font-size: 0.8rem; color: #666; font-style: italic; }

    /* Panel Types Grid */
    .panel-types { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 20px; }
    .panel-type { 
        background: #0a0a0a; padding: 15px; border: 1px solid #333; border-radius: 6px; 
        text-align: center; transition: 0.3s; 
    }
    .panel-type:hover { border-color: var(--primary-red); transform: translateY(-3px); }
    .panel-type strong { display: block; color: white; margin-bottom: 5px; }
    .panel-type span { font-size: 0.8rem; color: #666; }

    /* IoT Stack Diagram */
    .iot-architecture { display: flex; flex-direction: column; gap: 10px; margin-top: 20px; }
    .arch-layer {
        background: #0a0a0a; border: 1px solid #333; padding: 15px; border-radius: 6px;
        display: flex; justify-content: space-between; align-items: center; transition: 0.3s;
        position: relative;
    }
    .arch-layer:hover { border-color: var(--primary-red); background: #151515; transform: scale(1.02); }
    /* Connecting lines for stack */
    .arch-layer:not(:last-child)::after {
        content: '↓'; position: absolute; bottom: -18px; left: 50%; transform: translateX(-50%);
        color: #333; font-size: 12px;
    }
    .arch-layer strong { color: white; font-size: 0.95rem; }
    .arch-layer span { color: #666; font-size: 0.8rem; }

    /* CTA Section */
    .service-cta {
        background: linear-gradient(135deg, #cc0000, #990000);
        padding: 80px 0; text-align: center;
    }
    .service-cta h2 { color: white; font-size: 2.5rem; font-weight: 900; margin-bottom: 1rem; }
    .service-cta p { color: rgba(255,255,255,0.9); font-size: 1.2rem; margin-bottom: 2rem; }
    .cta-buttons { display: flex; gap: 20px; justify-content: center; }
</style>

<section class="page-hero">
    <div class="container animate-up">
        <h1>Our <span style="color: var(--primary-red);">Services</span></h1>
        <p>Comprehensive industrial automation solutions designed for high-performance manufacturing.</p>
    </div>
</section>

<section class="services-nav">
    <div class="container">
        <div class="services-nav-links">
            <a href="#plc" class="service-nav-link">
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

<section class="service-detail-section" id="plc">
    <div class="container">
        <div class="service-detail">
            <div class="service-detail-content animate-up">
                <div class="service-label">Core Competency</div>
                <h2 class="service-title">PLC Automation</h2>
                <h3 class="service-subtitle">Programmable Logic Controller Systems</h3>
                <div class="service-description">
                    <p>We architect robust control solutions for complex industrial processes. Our team specializes in programming and implementing high-availability PLC systems using industry-leading platforms.</p>
                    <p>From single-machine control to plant-wide SCADA integration, we ensure precise control, reliability, and safety compliance.</p>
                </div>
                
                <div class="service-features-list">
                    <div class="features-grid">
                        <div class="feature-item"><span class="feature-check">✓</span> <span>Advanced Logic Programming</span></div>
                        <div class="feature-item"><span class="feature-check">✓</span> <span>SCADA/HMI Integration</span></div>
                        <div class="feature-item"><span class="feature-check">✓</span> <span>Motion Control Systems</span></div>
                        <div class="feature-item"><span class="feature-check">✓</span> <span>Legacy System Migration</span></div>
                        <div class="feature-item"><span class="feature-check">✓</span> <span>Safety PLC Implementation</span></div>
                        <div class="feature-item"><span class="feature-check">✓</span> <span>Process Loop Tuning</span></div>
                    </div>
                </div>
                
                <div class="service-technologies">
                    <h4>Technology Stack</h4>
                    <div class="tech-tags">
                        <span class="tech-tag">Siemens TIA Portal</span>
                        <span class="tech-tag">Allen-Bradley Studio 5000</span>
                        <span class="tech-tag">Mitsubishi GX Works</span>
                        <span class="tech-tag">Ignition SCADA</span>
                        <span class="tech-tag">Wonderware</span>
                    </div>
                </div>
            </div>
            
            <div class="service-detail-visual animate-up">
                <div class="service-visual-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h4 style="color:white; margin:0;">Project Lifecycle</h4>
                        <span style="font-size: 1.5rem;">⚙️</span>
                    </div>
                    <div class="timeline">
                        <div class="timeline-item">
                            <span class="timeline-step">PHASE 1</span>
                            <span>Analysis & Spec</span>
                            <span class="timeline-duration">1-2 Weeks</span>
                        </div>
                        <div class="timeline-item">
                            <span class="timeline-step">PHASE 2</span>
                            <span>Logic Design</span>
                            <span class="timeline-duration">2-4 Weeks</span>
                        </div>
                        <div class="timeline-item">
                            <span class="timeline-step">PHASE 3</span>
                            <span>Implementation</span>
                            <span class="timeline-duration">4-8 Weeks</span>
                        </div>
                        <div class="timeline-item">
                            <span class="timeline-step">PHASE 4</span>
                            <span>SAT & Handover</span>
                            <span class="timeline-duration">1-2 Weeks</span>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>

<section class="service-detail-section alt-section" id="panels">
    <div class="container">
        <div class="service-detail reverse">
            <div class="service-detail-content animate-up">
                <div class="service-label">Hardware Engineering</div>
                <h2 class="service-title">Control Panels</h2>
                <h3 class="service-subtitle">Custom Electrical Fabrication</h3>
                <div class="service-description">
                    <p>We design and manufacture industrial control panels that are built to last. Every panel is engineered to meet specific environmental and operational requirements while complying with international standards (UL, CE, CSA).</p>
                    <p>Our facility ensures neat wiring, proper thermal management, and rigorous testing before shipment.</p>
                </div>
                
                <div class="service-features-list">
                    <div class="features-grid">
                        <div class="feature-item"><span class="feature-check">✓</span> <span>Custom Enclosure Design</span></div>
                        <div class="feature-item"><span class="feature-check">✓</span> <span>Motor Control Centers (MCC)</span></div>
                        <div class="feature-item"><span class="feature-check">✓</span> <span>Power Distribution (PCC)</span></div>
                        <div class="feature-item"><span class="feature-check">✓</span> <span>VFD & Servo Cabinets</span></div>
                        <div class="feature-item"><span class="feature-check">✓</span> <span>Explosion Proof Panels</span></div>
                        <div class="feature-item"><span class="feature-check">✓</span> <span>Field Wiring & Termination</span></div>
                    </div>
                </div>
                
                <div class="service-technologies">
                    <h4>Compliance Standards</h4>
                    <div class="tech-tags">
                        <span class="tech-tag">UL 508A</span>
                        <span class="tech-tag">IEC 61439</span>
                        <span class="tech-tag">NFPA 70/79</span>
                        <span class="tech-tag">CE Marking</span>
                        <span class="tech-tag">NEMA 4X/12</span>
                    </div>
                </div>
            </div>
            
            <div class="service-detail-visual animate-up">
                <div class="service-visual-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h4 style="color:white; margin:0;">Panel Configurations</h4>
                        <span style="font-size: 1.5rem;">🔌</span>
                    </div>
                    <div class="panel-types">
                        <div class="panel-type">
                            <strong>MCC Panels</strong>
                            <span>Motor Control</span>
                        </div>
                        <div class="panel-type">
                            <strong>PCC Panels</strong>
                            <span>Power Center</span>
                        </div>
                        <div class="panel-type">
                            <strong>PLC Panels</strong>
                            <span>Automation Core</span>
                        </div>
                        <div class="panel-type">
                            <strong>R.I.O. Panels</strong>
                            <span>Remote I/O</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="service-detail-section" id="electronics">
    <div class="container">
        <div class="service-detail">
            <div class="service-detail-content animate-up">
                <div class="service-label">R&D Services</div>
                <h2 class="service-title">Custom Electronics</h2>
                <h3 class="service-subtitle">Tailored Embedded Solutions</h3>
                <div class="service-description">
                    <p>When off-the-shelf components don't fit the bill, we engineer custom electronic solutions. From specialized sensor interfaces to complete embedded control boards, we bridge the gap between standard hardware and unique requirements.</p>
                </div>
                
                <div class="service-features-list">
                    <div class="features-grid">
                        <div class="feature-item"><span class="feature-check">✓</span> <span>Multi-layer PCB Design</span></div>
                        <div class="feature-item"><span class="feature-check">✓</span> <span>Firmware Development</span></div>
                        <div class="feature-item"><span class="feature-check">✓</span> <span>IoT Sensor Nodes</span></div>
                        <div class="feature-item"><span class="feature-check">✓</span> <span>Signal Conditioning</span></div>
                        <div class="feature-item"><span class="feature-check">✓</span> <span>Protocol Converters</span></div>
                        <div class="feature-item"><span class="feature-check">✓</span> <span>Rapid Prototyping</span></div>
                    </div>
                </div>
                
                <div class="service-technologies">
                    <h4>Development Tools</h4>
                    <div class="tech-tags">
                        <span class="tech-tag">Altium Designer</span>
                        <span class="tech-tag">STM32 / ARM</span>
                        <span class="tech-tag">ESP32</span>
                        <span class="tech-tag">Embedded C++</span>
                        <span class="tech-tag">Python</span>
                    </div>
                </div>
            </div>
            
            <div class="service-detail-visual animate-up">
                <div class="service-visual-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h4 style="color:white; margin:0;">Development Flow</h4>
                        <span style="font-size: 1.5rem;">💡</span>
                    </div>
                    <div class="timeline" style="border-left-color: #333;">
                        <div class="timeline-item">
                            <span class="timeline-step" style="color: white;">STEP 1</span>
                            <span>Schematic Design</span>
                            <span class="timeline-duration">Circuit Analysis</span>
                        </div>
                        <div class="timeline-item">
                            <span class="timeline-step" style="color: white;">STEP 2</span>
                            <span>PCB Layout</span>
                            <span class="timeline-duration">Routing & Stackup</span>
                        </div>
                        <div class="timeline-item">
                            <span class="timeline-step" style="color: white;">STEP 3</span>
                            <span>Fabrication</span>
                            <span class="timeline-duration">Assembly & Reflow</span>
                        </div>
                        <div class="timeline-item">
                            <span class="timeline-step" style="color: white;">STEP 4</span>
                            <span>Validation</span>
                            <span class="timeline-duration">QA Testing</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="service-detail-section alt-section" id="iot">
    <div class="container">
        <div class="service-detail reverse">
            <div class="service-detail-content animate-up">
                <div class="service-label">Industry 4.0</div>
                <h2 class="service-title">IoT Solutions</h2>
                <h3 class="service-subtitle">Connected Manufacturing</h3>
                <div class="service-description">
                    <p>Unlock the power of your data. We connect your physical machinery to the digital cloud, providing real-time insights, predictive maintenance alerts, and remote monitoring capabilities.</p>
                </div>
                
                <div class="service-features-list">
                    <div class="features-grid">
                        <div class="feature-item"><span class="feature-check">✓</span> <span>Edge Gateway Setup</span></div>
                        <div class="feature-item"><span class="feature-check">✓</span> <span>Cloud Dashboarding</span></div>
                        <div class="feature-item"><span class="feature-check">✓</span> <span>Predictive Analytics</span></div>
                        <div class="feature-item"><span class="feature-check">✓</span> <span>Remote Asset Control</span></div>
                        <div class="feature-item"><span class="feature-check">✓</span> <span>OEE Monitoring</span></div>
                        <div class="feature-item"><span class="feature-check">✓</span> <span>Secure VPN Access</span></div>
                    </div>
                </div>
                
                <div class="service-technologies">
                    <h4>Platform Stack</h4>
                    <div class="tech-tags">
                        <span class="tech-tag">AWS IoT Core</span>
                        <span class="tech-tag">Azure IoT Hub</span>
                        <span class="tech-tag">MQTT / OPC-UA</span>
                        <span class="tech-tag">Node-RED</span>
                        <span class="tech-tag">Grafana</span>
                    </div>
                </div>
            </div>
            
            <div class="service-detail-visual animate-up">
                <div class="service-visual-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h4 style="color:white; margin:0;">IoT Stack</h4>
                        <span style="font-size: 1.5rem;">🌐</span>
                    </div>
                    <div class="iot-architecture">
                        <div class="arch-layer" style="border-color: var(--primary-red);">
                            <strong>Application Layer</strong>
                            <span>User Dashboard</span>
                        </div>
                        <div class="arch-layer">
                            <strong>Cloud Layer</strong>
                            <span>Analytics & Storage</span>
                        </div>
                        <div class="arch-layer">
                            <strong>Edge Layer</strong>
                            <span>Gateway Processing</span>
                        </div>
                        <div class="arch-layer">
                            <strong>Physical Layer</strong>
                            <span>Sensors & Machines</span>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>

<section class="service-cta">
    <div class="container animate-up">
        <h2>Need a Custom Solution?</h2>
        <p>Let's discuss your specific automation requirements.</p>
        <div class="cta-buttons">
            <a href="contact.php" class="btn btn-white">Request Consultation</a>
            <a href="tel:<?php echo SITE_PHONE; ?>" class="btn" style="color: white; border: 1px solid rgba(255,255,255,0.4); padding: 14px 32px; font-weight: 700; border-radius: 4px; text-decoration: none;">Call Now</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>