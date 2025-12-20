<?php 
require_once 'includes/config.php';

$current_page = 'services';
$page_title = 'Our Services | ' . SITE_NAME;
include 'includes/header.php'; 
?>

<style>
    /* --- ANIMATIONS & KEYFRAMES --- */
    @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes scanline { 0% { background-position: 0% 0%; } 100% { background-position: 0% 100%; } }
    @keyframes pulse { 0% { box-shadow: 0 0 0 0 rgba(255, 51, 51, 0.4); } 70% { box-shadow: 0 0 0 10px rgba(255, 51, 51, 0); } 100% { box-shadow: 0 0 0 0 rgba(255, 51, 51, 0); } }
    @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-5px); } 100% { transform: translateY(0px); } }

    .animate-up { animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
    
    /* --- 1. HERO SECTION WITH SCANNING GRID --- */
    .page-hero {
        position: relative;
        padding: 140px 0 100px;
        text-align: center;
        border-bottom: 1px solid var(--border-color);
        overflow: hidden;
        background: var(--bg-body);
    }
    
    /* Animated Grid Background */
    .page-hero::before {
        content: ''; position: absolute; inset: 0;
        background-image: 
            linear-gradient(var(--bg-body) 2px, transparent 2px),
            linear-gradient(90deg, var(--bg-body) 2px, transparent 2px),
            linear-gradient(rgba(255, 51, 51, 0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 51, 51, 0.05) 1px, transparent 1px);
        background-size: 100px 100px, 100px 100px, 20px 20px, 20px 20px;
        background-position: -2px -2px, -2px -2px, -1px -1px, -1px -1px;
        mask-image: radial-gradient(ellipse at center, black 40%, transparent 80%);
        z-index: 0;
    }

    /* Scanning Light Beam */
    .page-hero::after {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(180deg, transparent 0%, rgba(255, 51, 51, 0.05) 50%, transparent 100%);
        background-size: 100% 200%;
        animation: scanline 8s linear infinite;
        z-index: 0;
        pointer-events: none;
    }

    .hero-content-wrapper { position: relative; z-index: 2; }
    
    .page-hero h1 { 
        font-size: clamp(3rem, 5vw, 4.5rem); 
        font-weight: 900; color: var(--text-main); 
        margin-bottom: 1rem; letter-spacing: -2px; 
        text-transform: uppercase;
    }
    
    .hero-subtitle { 
        color: var(--text-muted); font-size: 1.25rem; 
        max-width: 600px; margin: 0 auto; 
        font-weight: 300; letter-spacing: 0.5px;
    }

    /* --- 2. FLOATING GLASS NAV --- */
    .services-nav {
        position: sticky; top: 100px; z-index: 90;
        display: flex; justify-content: center; padding: 20px 0;
        pointer-events: none; /* Let clicks pass through around the pill */
    }
    .services-nav-inner {
        pointer-events: auto;
        background: var(--nav-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--border-color);
        padding: 8px 12px;
        border-radius: 100px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        display: flex; gap: 5px; flex-wrap: wrap; justify-content: center;
    }
    .service-nav-link {
        color: var(--text-muted); text-decoration: none; 
        padding: 10px 24px; border-radius: 50px;
        font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent;
        display: flex; align-items: center; gap: 8px;
    }
    .service-nav-link:hover {
        color: var(--text-main); background: var(--bg-surface);
    }
    .service-nav-link:focus, .service-nav-link:active {
        background: var(--primary-red); color: white; box-shadow: 0 4px 15px rgba(255, 51, 51, 0.4);
    }

    /* --- 3. SECTIONS & CARDS --- */
    .service-detail-section { padding: 120px 0; border-bottom: 1px solid var(--border-color); background: var(--bg-body); scroll-margin-top: 100px; }
    .alt-section { background: var(--bg-surface); }
    
    .service-detail { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
    @media(max-width: 900px) { .service-detail { grid-template-columns: 1fr; gap: 50px; } }
    
    /* Order flipping */
    .reverse .service-detail-content { order: 2; }
    .reverse .service-detail-visual { order: 1; }
    @media(max-width: 900px) { .reverse .service-detail-content { order: 1; } .reverse .service-detail-visual { order: 2; } }

    /* Typography */
    .service-label { 
        color: var(--primary-red); font-weight: 800; 
        text-transform: uppercase; font-size: 0.8rem; letter-spacing: 3px; 
        margin-bottom: 15px; display: inline-block;
        padding: 4px 10px; border: 1px solid rgba(255, 51, 51, 0.3); border-radius: 4px;
    }
    .service-title { font-size: 3rem; color: var(--text-main); margin: 0 0 10px 0; font-weight: 900; letter-spacing: -1px; line-height: 1; }
    .service-subtitle { font-size: 1.25rem; color: var(--text-muted); font-weight: 400; margin-bottom: 25px; }
    
    .service-description p { 
        color: var(--text-muted); line-height: 1.8; margin-bottom: 1.2rem; font-size: 1.05rem; 
    }

    /* Features with Icons */
    .features-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 35px; }
    .feature-item { 
        display: flex; align-items: center; gap: 12px; 
        color: var(--text-main); font-size: 0.95rem; font-weight: 500;
        padding: 8px; border-radius: 6px; transition: 0.2s;
    }
    .feature-item:hover { background: var(--bg-surface-2); transform: translateX(5px); }
    .feature-check { 
        color: var(--primary-red); font-weight: bold; background: rgba(255, 51, 51, 0.1); 
        width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; border-radius: 50%; 
    }

    /* Modern Tech Tags */
    .service-technologies { margin-top: 40px; padding-top: 30px; border-top: 1px solid var(--border-color); }
    .service-technologies h4 { color: var(--text-muted); font-size: 0.8rem; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 1px; }
    .tech-tags { display: flex; flex-wrap: wrap; gap: 10px; }
    .tech-tag {
        background: transparent; color: var(--text-main); 
        padding: 8px 16px; font-size: 0.85rem; font-weight: 600;
        border-radius: 4px; border: 1px solid var(--border-color); 
        transition: all 0.3s;
        position: relative; overflow: hidden;
    }
    /* Tech Tag Hover Gradient */
    .tech-tag:hover { border-color: var(--primary-red); color: var(--primary-red); background: rgba(255, 51, 51, 0.05); }

    /* --- 4. VISUAL CARDS (GLASSMORPHISM) --- */
    .service-visual-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 16px; padding: 40px;
        position: relative; overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        transition: all 0.4s ease;
    }
    
    /* Hover Effect for Card */
    .service-visual-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 30px 70px rgba(255, 51, 51, 0.15);
        border-color: var(--primary-red);
    }

    /* Header inside card */
    .visual-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid var(--border-color); }
    .visual-header h4 { color: var(--text-main); margin: 0; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 1px; }
    .visual-icon { font-size: 2rem; filter: grayscale(100%); transition: 0.3s; }
    .service-visual-card:hover .visual-icon { filter: grayscale(0%); transform: rotate(10deg); }

    /* TIMELINE STYLING */
    .timeline { position: relative; padding-left: 30px; border-left: 2px dashed var(--border-color); }
    .timeline-item { position: relative; margin-bottom: 40px; }
    .timeline-item:last-child { margin-bottom: 0; }
    
    /* Pulsing Dot */
    .timeline-item::before {
        content: ''; position: absolute; left: -37px; top: 5px; width: 12px; height: 12px;
        background: var(--bg-surface); border: 2px solid var(--primary-red); border-radius: 50%;
        z-index: 2; transition: 0.3s;
    }
    .service-visual-card:hover .timeline-item::before {
        animation: pulse 2s infinite; background: var(--primary-red);
    }
    
    .timeline-step { display: block; font-size: 0.75rem; color: var(--primary-red); font-weight: 800; text-transform: uppercase; margin-bottom: 4px; letter-spacing: 1px; }
    .timeline-title { display: block; color: var(--text-main); font-weight: 700; font-size: 1.2rem; margin-bottom: 2px; }
    .timeline-duration { font-size: 0.85rem; color: var(--text-muted); font-family: monospace; background: var(--bg-surface-2); display: inline-block; padding: 2px 6px; border-radius: 4px; }

    /* PANEL TYPES GRID */
    .panel-types { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .panel-type { 
        background: var(--bg-surface-2); padding: 25px 20px; 
        border: 1px solid var(--border-color); border-radius: 8px; 
        text-align: center; transition: 0.3s; 
        position: relative; overflow: hidden;
    }
    .panel-type:hover { border-color: var(--primary-red); transform: translateY(-5px); background: rgba(255, 51, 51, 0.05); }
    .panel-type strong { display: block; color: var(--text-main); font-size: 1.1rem; margin-bottom: 5px; }
    .panel-type span { font-size: 0.85rem; color: var(--text-muted); }

    /* IOT STACK */
    .iot-architecture { display: flex; flex-direction: column; gap: 15px; }
    .arch-layer {
        background: var(--bg-surface-2); border: 1px solid var(--border-color); 
        padding: 18px 25px; border-radius: 8px;
        display: flex; justify-content: space-between; align-items: center; 
        transition: 0.3s; position: relative; z-index: 1;
    }
    /* Stack Hover Effect */
    .arch-layer:hover { 
        border-color: var(--primary-red); 
        background: var(--bg-surface);
        box-shadow: 0 0 20px rgba(255, 51, 51, 0.2);
        transform: scale(1.05) !important;
        z-index: 10;
    }
    
    /* Arrow Connector */
    .arch-layer:not(:last-child)::after {
        content: ''; position: absolute; bottom: -15px; left: 50%; transform: translateX(-50%);
        height: 15px; width: 2px; background: var(--border-color); z-index: -1;
    }

    /* --- CTA SECTION --- */
    .service-cta {
        background: linear-gradient(135deg, #cc0000 0%, #000000 100%);
        padding: 100px 0; text-align: center; position: relative;
        overflow: hidden;
    }
    .service-cta::before {
        content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: url('https://grainy-gradients.vercel.app/noise.svg'); opacity: 0.1;
    }
    .service-cta h2 { color: white !important; font-size: 3rem; font-weight: 900; margin-bottom: 1.5rem; text-transform: uppercase; }
    .service-cta p { color: rgba(255,255,255,0.8) !important; font-size: 1.2rem; margin-bottom: 3rem; max-width: 600px; margin-left: auto; margin-right: auto; }
    
    .cta-btn-group { display: flex; gap: 20px; justify-content: center; position: relative; z-index: 2; }
    .btn-glow {
        background: white; color: #cc0000; padding: 16px 40px; font-weight: 800; text-transform: uppercase; border-radius: 4px; text-decoration: none;
        transition: 0.3s; box-shadow: 0 0 20px rgba(255,255,255,0.3);
    }
    .btn-glow:hover { transform: translateY(-3px); box-shadow: 0 0 40px rgba(255,255,255,0.6); }

    /* Light Mode Adjustments */
    body.light-mode .service-cta {
        background: linear-gradient(135deg, #ff3333 0%, #ffffff 100%);
    }
    body.light-mode .service-cta h2 { color: white !important; text-shadow: 0 2px 10px rgba(0,0,0,0.2); }
    body.light-mode .service-cta p { color: white !important; text-shadow: 0 1px 5px rgba(0,0,0,0.2); }
    body.light-mode .btn-glow { color: #ff3333; }
    /* FIX: Solid Red Gradient for CTA in Light Mode */
    body.light-mode .service-cta {
        /* Deep Red Gradient */
        background: linear-gradient(135deg, #ff3333 0%, #cc0000 100%) !important;
    }
    
    /* Ensure text stays white on the red background */
    body.light-mode .service-cta h2,
    body.light-mode .service-cta p {
        color: #ffffff !important;
        text-shadow: none !important;
    }
    
    /* Make button white so it pops against the red */
    body.light-mode .btn-glow {
        background: #ffffff;
        color: #cc0000;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
</style>

<section class="page-hero">
    <div class="container hero-content-wrapper animate-up">
        <h1>Our <span style="color: var(--primary-red); text-shadow: 0 0 30px rgba(255,51,51,0.3);">Services</span></h1>
        <p class="hero-subtitle">Engineering intelligence for the modern industrial age.</p>
    </div>
</section>

<section class="services-nav">
    <div class="services-nav-inner animate-up" style="animation-delay: 0.1s;">
        <a href="#plc" class="service-nav-link"><span>⚙️ PLC Automation</span></a>
        <a href="#panels" class="service-nav-link"><span>🔌 Control Panels</span></a>
        <a href="#electronics" class="service-nav-link"><span>💡 Electronics</span></a>
        <a href="#iot" class="service-nav-link"><span>🌐 IoT & Cloud</span></a>
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
                
                <div class="features-grid">
                    <div class="feature-item"><span class="feature-check">✓</span> Advanced Logic Programming</div>
                    <div class="feature-item"><span class="feature-check">✓</span> SCADA/HMI Integration</div>
                    <div class="feature-item"><span class="feature-check">✓</span> Motion Control Systems</div>
                    <div class="feature-item"><span class="feature-check">✓</span> Legacy System Migration</div>
                    <div class="feature-item"><span class="feature-check">✓</span> Safety PLC Implementation</div>
                    <div class="feature-item"><span class="feature-check">✓</span> Process Loop Tuning</div>
                </div>
                
                <div class="service-technologies">
                    <h4>Technology Stack</h4>
                    <div class="tech-tags">
                        <span class="tech-tag">Siemens TIA</span>
                        <span class="tech-tag">Allen-Bradley</span>
                        <span class="tech-tag">Mitsubishi</span>
                        <span class="tech-tag">Ignition</span>
                        <span class="tech-tag">Wonderware</span>
                    </div>
                </div>
            </div>
            
            <div class="service-detail-visual animate-up" style="animation-delay: 0.2s;">
                <div class="service-visual-card">
                    <div class="visual-header">
                        <h4>Execution Lifecycle</h4>
                        <span class="visual-icon">⚙️</span>
                    </div>
                    <div class="timeline">
                        <div class="timeline-item">
                            <span class="timeline-step">Phase 01</span>
                            <span class="timeline-title">Analysis & Spec</span>
                            <span class="timeline-duration">1-2 Weeks</span>
                        </div>
                        <div class="timeline-item">
                            <span class="timeline-step">Phase 02</span>
                            <span class="timeline-title">Logic Design</span>
                            <span class="timeline-duration">2-4 Weeks</span>
                        </div>
                        <div class="timeline-item">
                            <span class="timeline-step">Phase 03</span>
                            <span class="timeline-title">Implementation</span>
                            <span class="timeline-duration">4-8 Weeks</span>
                        </div>
                        <div class="timeline-item">
                            <span class="timeline-step">Phase 04</span>
                            <span class="timeline-title">SAT & Handover</span>
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
                
                <div class="features-grid">
                    <div class="feature-item"><span class="feature-check">✓</span> Custom Enclosure Design</div>
                    <div class="feature-item"><span class="feature-check">✓</span> Motor Control Centers (MCC)</div>
                    <div class="feature-item"><span class="feature-check">✓</span> Power Distribution (PCC)</div>
                    <div class="feature-item"><span class="feature-check">✓</span> VFD & Servo Cabinets</div>
                    <div class="feature-item"><span class="feature-check">✓</span> Explosion Proof Panels</div>
                    <div class="feature-item"><span class="feature-check">✓</span> Field Wiring</div>
                </div>
                
                <div class="service-technologies">
                    <h4>Compliance Standards</h4>
                    <div class="tech-tags">
                        <span class="tech-tag">UL 508A</span>
                        <span class="tech-tag">IEC 61439</span>
                        <span class="tech-tag">NFPA 70/79</span>
                        <span class="tech-tag">CE Marking</span>
                        <span class="tech-tag">NEMA 4X</span>
                    </div>
                </div>
            </div>
            
            <div class="service-detail-visual animate-up">
                <div class="service-visual-card">
                    <div class="visual-header">
                        <h4>Panel Types</h4>
                        <span class="visual-icon">🔌</span>
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
                
                <div class="features-grid">
                    <div class="feature-item"><span class="feature-check">✓</span> Multi-layer PCB Design</div>
                    <div class="feature-item"><span class="feature-check">✓</span> Firmware Development</div>
                    <div class="feature-item"><span class="feature-check">✓</span> IoT Sensor Nodes</div>
                    <div class="feature-item"><span class="feature-check">✓</span> Signal Conditioning</div>
                    <div class="feature-item"><span class="feature-check">✓</span> Protocol Converters</div>
                    <div class="feature-item"><span class="feature-check">✓</span> Rapid Prototyping</div>
                </div>
                
                <div class="service-technologies">
                    <h4>Development Tools</h4>
                    <div class="tech-tags">
                        <span class="tech-tag">Altium</span>
                        <span class="tech-tag">STM32 / ARM</span>
                        <span class="tech-tag">ESP32</span>
                        <span class="tech-tag">Embedded C++</span>
                        <span class="tech-tag">Python</span>
                    </div>
                </div>
            </div>
            
            <div class="service-detail-visual animate-up">
                <div class="service-visual-card">
                    <div class="visual-header">
                        <h4>Development Flow</h4>
                        <span class="visual-icon">💡</span>
                    </div>
                    <div class="timeline">
                        <div class="timeline-item">
                            <span class="timeline-step">Step 01</span>
                            <span class="timeline-title">Schematic Design</span>
                            <span class="timeline-duration">Circuit Analysis</span>
                        </div>
                        <div class="timeline-item">
                            <span class="timeline-step">Step 02</span>
                            <span class="timeline-title">PCB Layout</span>
                            <span class="timeline-duration">Routing & Stackup</span>
                        </div>
                        <div class="timeline-item">
                            <span class="timeline-step">Step 03</span>
                            <span class="timeline-title">Fabrication</span>
                            <span class="timeline-duration">Assembly & Reflow</span>
                        </div>
                        <div class="timeline-item">
                            <span class="timeline-step">Step 04</span>
                            <span class="timeline-title">Validation</span>
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
                
                <div class="features-grid">
                    <div class="feature-item"><span class="feature-check">✓</span> Edge Gateway Setup</div>
                    <div class="feature-item"><span class="feature-check">✓</span> Cloud Dashboarding</div>
                    <div class="feature-item"><span class="feature-check">✓</span> Predictive Analytics</div>
                    <div class="feature-item"><span class="feature-check">✓</span> Remote Asset Control</div>
                    <div class="feature-item"><span class="feature-check">✓</span> OEE Monitoring</div>
                    <div class="feature-item"><span class="feature-check">✓</span> Secure VPN Access</div>
                </div>
                
                <div class="service-technologies">
                    <h4>Platform Stack</h4>
                    <div class="tech-tags">
                        <span class="tech-tag">AWS IoT</span>
                        <span class="tech-tag">Azure IoT Hub</span>
                        <span class="tech-tag">MQTT / OPC-UA</span>
                        <span class="tech-tag">Node-RED</span>
                        <span class="tech-tag">Grafana</span>
                    </div>
                </div>
            </div>
            
            <div class="service-detail-visual animate-up">
                <div class="service-visual-card">
                    <div class="visual-header">
                        <h4>Full Stack Architecture</h4>
                        <span class="visual-icon">🌐</span>
                    </div>
                    <div class="iot-architecture">
                        <div class="arch-layer" style="border-left: 3px solid var(--primary-red);">
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
        <h2>Ready to upgrade your systems?</h2>
        <p>From legacy retrofits to cutting-edge smart factories, we engineer solutions that deliver results.</p>
        <div class="cta-btn-group">
            <a href="contact.php" class="btn-glow">Start Project</a><br><br>
            <a href="tel:<?php echo SITE_PHONE; ?>" class="btn-link" style="color:white; border-color: rgba(255,255,255,0.5); margin: 10px;">Call Now</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>