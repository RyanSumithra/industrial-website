<?php 
require_once 'includes/config.php';

$current_page = 'home';
$page_title = SITE_NAME . ' | Industrial Intelligence';
include 'includes/header.php'; 
?>

<style>
    /* --- VARIABLES (Linked to header.php) --- */
    /* Light Mode: 
       --bg-body: Aliceblue (#f0f8ff)
       --text-main: Black (#111)
       --bg-surface: White
    */

    /* --- TYPOGRAPHY --- */
    .display-1 { 
        font-size: clamp(2.5rem, 8vw, 6.5rem); 
        font-weight: 800; 
        line-height: 0.95; 
        letter-spacing: -0.03em; 
        margin-bottom: 2rem;
        text-transform: uppercase;
        color: var(--text-main); /* Adaptive: White in Dark, Black in Light */
    }

    /* Override Hero Title to always be white because it sits on a full-color image */
    body.light-mode .hero-content .display-1,
    body.light-mode .hero-content .lead-text {
        color: #ffffff !important;
        text-shadow: 0 2px 10px rgba(0,0,0,0.5); /* Shadow for readability */
    }

   .outline-text {
        /* REMOVED STROKE */
        /* -webkit-text-stroke: 1px rgba(128, 128, 128, 0.5); */
        /* CHANGED COLOR TO SOLID RED */
        color: var(--primary-red);
        transition: 0.3s;
        /* Optional: add slight opacity if it's too aggressive */
        /* opacity: 0.9; */ 
    }
    .hero-wrap:hover .outline-text {
        /* REMOVED HOVER STROKE EFFECT */
        /* -webkit-text-stroke: 1px var(--primary-red); */
        /* opacity: 0.8; */
    }
    
    .display-2 { 
        font-size: clamp(1.8rem, 6vw, 3.5rem); 
        font-weight: 700; 
        line-height: 1.1; 
        letter-spacing: -1px; 
        text-transform: uppercase;
        color: var(--text-main);
    }
    
    .label-mono { 
        color: var(--primary-red); 
        font-family: 'Courier New', monospace; 
        font-weight: 700; 
        letter-spacing: 2px; 
        font-size: 0.8rem; 
        display: block; 
        margin-bottom: 1.5rem;
    }

    .lead-text { 
        font-size: clamp(1rem, 2vw, 1.25rem); 
        color: var(--text-muted); 
        line-height: 1.6; 
        max-width: 650px; 
        font-weight: 400;
        margin-bottom: 40px;
    }

    /* --- ANIMATIONS --- */
    .reveal { opacity: 0; transform: translateY(40px); transition: all 1s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal.active { opacity: 1; transform: translateY(0); }
    
    /* --- HERO SECTION --- */
   /* --- HERO SECTION --- */
    .hero-wrap {
        min-height: 100vh;
        position: relative;
        display: flex;
        align-items: center;
        overflow: hidden;
        border-bottom: 1px solid var(--border-color);
        padding: 100px 5%;
    }
    
    .hero-bg {
        position: absolute; inset: 0;
        background: url('https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=2070&auto=format&fit=crop') no-repeat center center/cover;
        /* Default Dark Mode: Dimmed */
        filter: grayscale(100%) brightness(0.3) contrast(1.2);
        transform: scale(1.1);
        z-index: 0;
        transition: 0.3s;
    }

    /* LIGHT MODE HERO IMAGE: Clear, Full Color */
    /* LIGHT MODE HERO IMAGE: Clear, Full Color but Blurred */
    body.light-mode .hero-bg {
        /* CHANGED filter: none TO filter: blur(5px) */
        filter: blur(5px) !important;
        opacity: 1 !important;
        transform: scale(1.1); 
    }

    .hero-overlay {
        position: absolute; inset: 0;
        /* Default Dark Mode Gradient */
        background: radial-gradient(circle at 70% 30%, transparent 0%, var(--bg-body) 90%);
        z-index: 1;
    }

    /* LIGHT MODE OVERLAY FIX: 
       Removes the "white fog" gradient. 
       Uses a flat, semi-transparent black tint so the image is clear 
       but white text remains readable. 
    */
    body.light-mode .hero-overlay {
        background: rgba(0, 0, 0, 0.4) !important; /* Adjust 0.4 to make it darker/lighter */
    }

    .hero-content {
        position: relative; z-index: 10;
        max-width: 1400px; margin: 0 auto; width: 100%;
    }
    /* --- BUTTONS --- */
    .btn-wrap { display: flex; gap: 20px; align-items: center; flex-wrap: wrap; }
    
    .btn-main {
        padding: 20px 50px;
        background: var(--text-main);
        color: var(--bg-body);
        font-weight: 800;
        text-transform: uppercase;
        text-decoration: none;
        display: inline-flex; align-items: center; gap: 10px;
        border: 1px solid var(--text-main);
        transition: 0.3s;
        font-size: 0.9rem; letter-spacing: 1px; white-space: nowrap;
    }
    .btn-main:hover { 
        background: var(--primary-red); 
        color: white; border-color: var(--primary-red);
        gap: 20px; 
        box-shadow: 0 0 30px rgba(255, 51, 51, 0.3); 
    }
    
    .btn-link {
        color: var(--text-main); 
        text-decoration: none; font-weight: 600; 
        text-transform: uppercase; letter-spacing: 1px; font-size: 0.9rem;
        border: 1px solid var(--border-color); padding: 19px 40px;
        transition: 0.3s; white-space: nowrap;
    }
    
    /* In Light Mode Hero, buttons need to stand out against the image */
    body.light-mode .hero-content .btn-link {
        color: white; border-color: white;
    }
    body.light-mode .hero-content .btn-main {
        background: white; color: black; border-color: white;
    }
    
    .btn-link:hover { border-color: var(--text-main); background: rgba(128,128,128,0.1); }

    /* --- MARQUEE --- */
    .marquee-wrap { 
        border-bottom: 1px solid var(--border-color); 
        padding: 25px 0; 
        background: var(--bg-surface); 
        overflow: hidden; 
    }
    .marquee-track { display: flex; gap: 60px; animation: scroll 30s linear infinite; }
    .marquee-item { 
        color: var(--bg-surface); 
        font-weight: 900; font-size: 3rem; 
        text-transform: uppercase; white-space: nowrap; 
        -webkit-text-stroke: 1px var(--text-muted); 
    }
    .marquee-item.highlight { 
        color: var(--primary-red); -webkit-text-stroke: 0; opacity: 0.8; 
    }
    @keyframes scroll { 0% { transform: translateX(0); } 100% { transform: translateX(-100%); } }

    /* --- BENTO GRID SERVICES --- */
    .bento-section { padding: 120px 5%; max-width: 1600px; margin: 0 auto; }
    .bento-grid {
        display: grid; 
        grid-template-columns: repeat(3, 1fr); 
        grid-template-rows: repeat(2, 400px);
        gap: 20px;
    }
    
    .bento-card {
        background: var(--bg-surface-2);
        border: 1px solid var(--border-color);
        padding: 40px;
        position: relative;
        overflow: hidden;
        display: flex; flex-direction: column; justify-content: flex-end;
        transition: 0.4s;
        box-shadow: var(--shadow);
    }
    .bento-card:hover { border-color: var(--primary-red); transform: translateY(-5px); }
    
    .bento-bg {
        position: absolute; inset: 0;
        background-size: cover; background-position: center;
        transition: transform 0.6s ease;
        z-index: 1;
        /* Dark Mode Default: Grayscale */
        filter: grayscale(100%) brightness(0.5);
    }

    /* LIGHT MODE BENTO IMAGES: Full Color & Full Visibility */
    body.light-mode .bento-bg {
        filter: none !important; /* Original Colors */
        opacity: 1 !important;   /* No Fading */
    }

    .bento-card:hover .bento-bg { transform: scale(1.1); filter: grayscale(0%) brightness(0.7); }
    
    .bento-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(0deg, var(--bg-surface) 10%, transparent 100%);
        z-index: 2;
    }
    
    /* LIGHT MODE BENTO OVERLAY:
       Since images are full color, we need a dark gradient overlay so text is readable.
       We CANNOT use white overlay here or the text will vanish.
    */
    body.light-mode .bento-overlay {
        background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);
    }

    .bento-content { position: relative; z-index: 3; }
    .bento-large { grid-column: span 2; }
    
    /* Bento Text Colors */
    .bento-num { 
        position: absolute; top: 30px; right: 30px; 
        font-family: monospace; color: var(--text-main); 
        opacity: 0.5; font-size: 1.5rem; font-weight: 700; z-index: 4; 
    }
    .bento-title { font-size: 2rem; font-weight: 700; margin-bottom: 10px; color: var(--text-main); }
    .bento-desc { color: var(--text-muted); line-height: 1.6; max-width: 95%; font-size: 1rem; margin-bottom: 10px; }
    .bento-link { color: var(--primary-red); text-transform: uppercase; font-weight: 700; font-size: 0.85rem; letter-spacing: 1px; display: inline-block; margin-top: 10px; }

    /* LIGHT MODE BENTO TEXT OVERRIDE:
       Because we are using Full Color Images as background, 
       the text MUST be White to be readable, even in light mode.
    */
    body.light-mode .bento-title, 
    body.light-mode .bento-desc,
    body.light-mode .bento-num {
        color: #ffffff !important;
        text-shadow: 0 2px 4px rgba(0,0,0,0.8);
    }

    /* --- PROJECTS --- */
    .projects-wrap { padding: 0; border-top: 1px solid var(--border-color); }
    .project-item {
        display: grid; grid-template-columns: 1fr 1fr;
        min-height: 700px;
        border-bottom: 1px solid var(--border-color);
    }
    
    /* Project Info stays Adaptive (White Bg / Black Text in Light Mode) */
    .project-info {
        padding: 100px 10%;
        display: flex; flex-direction: column; justify-content: center;
        background: var(--bg-body);
    }
    
    .project-img-wrap {
        position: relative; overflow: hidden; height: 100%; min-height: 400px; border-left: 1px solid var(--border-color);
    }
    .project-img {
        width: 100%; height: 115%; 
        background-size: cover; background-position: center;
        transition: transform 0.1s linear;
        filter: grayscale(100%);
    }
    
    /* LIGHT MODE PROJECTS: Full Color Image */
    body.light-mode .project-img {
        filter: none !important;
        opacity: 1 !important;
    }

    .project-item:hover .project-img { filter: grayscale(0%); transition: filter 0.5s; }

    .project-stat-row { display: flex; gap: 60px; margin-top: 50px; padding-top: 30px; border-top: 1px solid var(--border-color); }
    .project-stat-val { font-size: 3rem; font-weight: 800; color: var(--text-main); display: block; line-height: 1; }
    .project-stat-key { font-size: 0.85rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; font-weight: 700; margin-top: 10px; display: block; }

    /* --- STATS MATRIX --- */
    .stats-matrix {
        display: grid; 
        grid-template-columns: repeat(4, 1fr);
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-surface);
    }
    
    .stat-cell {
        padding: 80px 40px;
        border-right: 1px solid var(--border-color);
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        position: relative; overflow: hidden; transition: 0.3s;
    }
    .stat-cell:last-child { border-right: none; }
    .stat-cell:hover { background: var(--bg-surface-2); }
    
    .stat-cell::after {
        content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 2px;
        background: var(--primary-red); transform: scaleX(0); transition: 0.4s;
    }
    .stat-cell:hover::after { transform: scaleX(1); }

    .stat-big { font-size: 5rem; font-weight: 900; color: var(--text-main); line-height: 1; font-variant-numeric: tabular-nums; }
    .stat-suffix { color: var(--primary-red); font-size: 3rem; vertical-align: super; font-weight: 700; }
    .stat-label { margin-top: 15px; font-family: 'Courier New', monospace; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted); }

    /* --- CLIENTS SECTION (Upgraded) --- */
    .clients-section {
        background: var(--bg-surface-2);
        padding: 120px 0;
        overflow: hidden;
        border-top: 1px solid var(--border-color);
        position: relative;
    }
    
    .clients-heading { text-align: center; margin-bottom: 80px; }
    .clients-heading h2 {
        font-size: clamp(2.5rem, 6vw, 4rem);
        font-weight: 800;
        color: var(--text-main);
    }
    .clients-heading span { color: var(--primary-red); }
    
    /* Slider Container */
    .clients-slider { 
        width: 100%; 
        overflow: hidden; 
        position: relative;
        /* Add fade gradient on sides for premium feel */
        mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
        -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
    }
    
    .clients-track {
        display: flex; 
        gap: 30px; 
        width: max-content;
        /* Adjusted timing for smoother read speed */
        animation: clientsScroll 60s linear infinite; 
    }
    
    /* Pause on hover so users can read */
    .clients-track:hover { animation-play-state: paused; }
    
    @keyframes clientsScroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); } /* Moves exactly half way (one full set) then resets */
    }
    
    /* New Card Design */
    .client-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        width: 450px; 
        padding: 40px; 
        border-radius: 4px;
        display: flex; flex-direction: column; justify-content: space-between;
        flex-shrink: 0;
        position: relative;
        transition: all 0.3s ease;
    }
    
    /* Decorative Quote Icon */
    .client-card::before {
        content: '"';
        position: absolute; top: 20px; left: 20px;
        font-family: serif; font-size: 5rem; line-height: 1;
        color: var(--primary-red); opacity: 0.1;
        pointer-events: none;
    }
    
    .client-card:hover {
        border-color: var(--primary-red);
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        background: var(--bg-surface-2);
    }
    
    .client-card p {
        color: var(--text-muted);
        font-size: 1.05rem; 
        line-height: 1.6; 
        margin-bottom: 30px;
        position: relative; z-index: 1;
        font-style: italic;
    }
    
    /* Client Footer (Logo + Name) */
    .client-footer {
        display: flex; align-items: center; gap: 15px;
        border-top: 1px solid var(--border-color);
        padding-top: 20px;
    }
    
    .client-logo {
        width: 50px; height: 50px; border-radius: 50%;
        object-fit: contain; background: #fff;
        padding: 8px; border: 1px solid var(--border-color);
    }
    
    .client-info h4 { 
        color: var(--text-main); font-size: 1rem; margin: 0; font-weight: 700; 
    }
    .client-info span {
        font-size: 0.8rem; color: var(--primary-red); font-weight: 600; letter-spacing: 1px;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .client-card { width: 320px; padding: 30px; }
        .clients-heading h2 { font-size: 2.5rem; }
    }
    /* --- CTA --- */
    .cta-area { 
        padding: 180px 5%; text-align: center; 
        border-bottom: 1px solid var(--border-color); 
        background: var(--bg-surface); 
    }

    /* Responsive adjustments */
    @media (max-width: 1024px) { 
        .bento-grid { grid-template-columns: 1fr 1fr; grid-template-rows: auto; }
        .stat-big { font-size: 3.5rem; } .stat-suffix { font-size: 2rem; }
    }
    @media (max-width: 900px) { 
        .project-item { grid-template-columns: 1fr; min-height: auto; } 
        .project-img-wrap { order: -1; height: 350px; min-height: 350px; border-left: none; border-bottom: 1px solid var(--border-color); }
        .project-info { padding: 60px 5%; }
        .stats-matrix { grid-template-columns: 1fr 1fr; } 
        .stat-cell:nth-child(2) { border-right: none; }
        .stat-cell:nth-child(1), .stat-cell:nth-child(2) { border-bottom: 1px solid var(--border-color); }
    }
    @media (max-width: 768px) { 
        .bento-grid { grid-template-columns: 1fr; } 
        .bento-large { grid-column: span 1; }
        .bento-card { min-height: 350px; }
        .cta-area { padding: 100px 5%; }
    }
    @media (max-width: 600px) {
        .btn-wrap { flex-direction: column; align-items: stretch; gap: 15px; }
        .stats-matrix { grid-template-columns: 1fr; }
        .stat-cell { border-right: none !important; border-bottom: 1px solid var(--border-color); padding: 50px 20px; }
        .stat-cell:last-child { border-bottom: none; }
    }
    /* --- LIGHT MODE SPECIFIC: MARQUEE STRIP --- */
    
    /* 1. Make the background Black */
    body.light-mode .marquee-wrap {
        background: #000000 !important;
        /* Add subtle borders so it separates from the white sections */
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* 2. Fix the text to look like an "Outline" on the black background */
    body.light-mode .marquee-item {
        /* Set text fill to black (so it blends with bg) */
        color: #000000 !important; 
        /* Set the outline stroke to light grey */
        -webkit-text-stroke: 1px #666666 !important; 
    }

    /* 3. Keep the Highlighted (Red) words solid */
    body.light-mode .marquee-item.highlight {
        color: var(--primary-red) !important;
        -webkit-text-stroke: 0 !important;
    }
    bento-section { padding: 120px 5%; max-width: 1600px; margin: 0 auto; }
    .bento-grid {
        display: grid; 
        grid-template-columns: repeat(3, 1fr); 
        grid-template-rows: repeat(2, 400px);
        gap: 20px;
    }
    
    .bento-card {
        background: var(--surface);
        border: 1px solid var(--border);
        padding: 40px;
        position: relative;
        overflow: hidden;
        display: flex; flex-direction: column; justify-content: flex-end;
        transition: 0.4s;
    }
    .bento-card:hover { border-color: var(--primary); transform: translateY(-5px); }
    
    .bento-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    z-index: 1;
    transition: transform 0.6s ease, filter 0.6s ease;
    }
    
    .bento-card:hover .bento-bg {
        transform: scale(1.08);
        filter: grayscale(20%) brightness(0.75);
    }

    
    .bento-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(0deg, rgba(0,0,0,0.9) 20%, rgba(0,0,0,0.4) 100%);
        z-index: 2;
    }
    
    .bento-content { position: relative; z-index: 3; }
    .bento-large { grid-column: span 2; }
    
    .bento-num { position: absolute; top: 30px; right: 30px; font-family: monospace; color: white; opacity: 0.5; font-size: 1.5rem; font-weight: 700; z-index: 4; }
    .bento-card:hover .bento-num { opacity: 1; color: var(--primary); }
    .bento-title { font-size: 2rem; font-weight: 700; margin-bottom: 10px; color: white; }
    .bento-desc { color: #ccc; line-height: 1.6; max-width: 95%; font-size: 1rem; margin-bottom: 10px; }
    .bento-link { color: var(--primary); text-transform: uppercase; font-weight: 700; font-size: 0.85rem; letter-spacing: 1px; display: inline-block; margin-top: 10px; }

    /* Responsive Bento */
    @media (max-width: 1024px) { 
        .bento-grid { grid-template-columns: 1fr 1fr; grid-template-rows: auto; } 
    }
    @media (max-width: 768px) { 
        .bento-section { padding: 80px 5%; }
        .bento-grid { grid-template-columns: 1fr; } 
        .bento-large { grid-column: span 1; }
        .bento-card { min-height: 350px; } /* Ensure height on mobile */
    }
</style>
<div class="noise-overlay"></div>

<section class="hero-wrap">
    <div class="hero-bg" id="heroBg"></div>
    <div class="hero-overlay"></div>
    
    <div class="hero-content">
        <div class="reveal">
            <span class="label-mono">// SYSTEM INTEGRATORS</span>
            
            <h1 class="display-1">
                INDUSTRIAL AUTOMATION<br>
                <span style="color: #444;">&</span> MECHATRONICS<br>
                <span class="outline-text">SOLUTIONS</span>
            </h1>
            
            <p class="lead-text">
                Powering the future of manufacturing with cutting-edge PLC systems, robotics, and custom IoT integration.
            </p>
            
            <div class="btn-wrap">
                <a href="projects.php" class="btn-main">View Implementations</a>
                <a href="contact.php" class="btn-link">Contact Engineering</a>
            </div>
        </div>
    </div>
</section>

<div class="marquee-wrap">
    <div class="marquee-track">
        <span class="marquee-item">Automation</span>
        <span class="marquee-item highlight">Siemens</span>
        <span class="marquee-item">Robotics</span>
        <span class="marquee-item highlight">Allen-Bradley</span>
        <span class="marquee-item">SCADA</span>
        <span class="marquee-item highlight">IoT</span>
        <span class="marquee-item">Automation</span>
        <span class="marquee-item highlight">Siemens</span>
        <span class="marquee-item">Robotics</span>
        <span class="marquee-item highlight">Allen-Bradley</span>
        <span class="marquee-item">SCADA</span>
        <span class="marquee-item highlight">IoT</span>
    </div>
</div>

<section class="bento-section">
    <div class="reveal" style="margin-bottom: 80px;">
        <span class="label-mono">/// CORE COMPETENCIES</span>
        <h2 class="display-2">Engineered for<br>Absolute Performance.</h2>
    </div>

    <div class="bento-grid reveal">
        <!-- 01 -->
        <div class="bento-card bento-large">
            <div class="bento-bg" style="background-image: url('https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=2070&auto=format&fit=crop');"></div>
            <div class="bento-overlay"></div>
            <span class="bento-num">01</span>

            <div class="bento-content">
                <h3 class="bento-title">Custom Controller Design & Manufacturing</h3>
                <p class="bento-desc">
                    We design, develop, and manufacture custom electronic controllers for industrial and domestic applications.
                </p>
                <a href="services.php#controllers" class="bento-link">Explore Capabilities &rarr;</a>
            </div>
        </div>

        <!-- 02 -->
        <div class="bento-card">
            <div class="bento-bg" style="background-image: url('images/PLC.png');"></div>
            <div class="bento-overlay"></div>
            <span class="bento-num">02</span>

            <div class="bento-content">
                <h3 class="bento-title">PLC Automation Solutions</h3>
                <p class="bento-desc">
                    Tailored PLC-based automation from system design to final commissioning.
                </p>
                <a href="services.php#plc" class="bento-link">View Projects &rarr;</a>
            </div>
        </div>

        <!-- 03 -->
        <div class="bento-card">
            <div class="bento-bg" style="background-image: url('images/APFC_Panel.png');"></div>
            <div class="bento-overlay"></div>
            <span class="bento-num">03</span>

            <div class="bento-content">
                <h3 class="bento-title">APFC Panels & Power Optimization</h3>
                <p class="bento-desc">
                    Detailed electricity bill analysis to reduce penalties and improve power factor.
                </p>
                <a href="services.php#apfc" class="bento-link">Calculate Savings &rarr;</a>
            </div>
        </div>

        <!-- 04 -->
        <div class="bento-card bento-large">
            <div class="bento-bg" style="background-image: url('images/PCB.png');"></div>
            <div class="bento-overlay"></div>
            <span class="bento-num">04</span>

            <div class="bento-content">
                <h3 class="bento-title">PCB Design & Bulk Production</h3>
                <p class="bento-desc">
                    Complete manufacturing support for low to high volume requirements.
                </p>
                <a href="services.php#pcb" class="bento-link">View Capabilities &rarr;</a>
            </div>
        </div>
    </div>
</section>

<section class="projects-wrap">
    <div class="project-item">
        <div class="project-info reveal">
            <span class="label-mono">CASE STUDY: AUTOMOTIVE</span>
            <h2 class="display-2" style="margin-bottom: 20px;">Assembly Line<br>Optimization</h2>
            <p class="lead-text">
                Complete retrofit of a Tier-1 chassis assembly line. We replaced legacy relay logic with a distributed I/O network.
            </p>
            
            <div class="project-stat-row">
                <div>
                    <span class="project-stat-val">40%</span>
                    <span class="project-stat-key">Efficiency Gain</span>
                </div>
                <div>
                    <span class="project-stat-val">12</span>
                    <span class="project-stat-key">Week Timeline</span>
                </div>
            </div>
            <br>
            <a href="projects.php" class="btn-link" style="width: fit-content; border-color: #333; padding: 15px 30px;">Read Case Study &rarr;</a>
        </div>
        <div class="project-img-wrap">
            <div class="project-img" style="background-image: url('https://images.unsplash.com/photo-1621905252507-b35492cc74b4?q=80&w=2069&auto=format&fit=crop');"></div>
        </div>
    </div>

    <div class="project-item">
        <div class="project-img-wrap" style="order: -1;">
            <div class="project-img" style="background-image: url('https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?q=80&w=2070&auto=format&fit=crop');"></div>
        </div>
        <div class="project-info reveal">
            <span class="label-mono">CASE STUDY: UTILITIES</span>
            <h2 class="display-2" style="margin-bottom: 20px;">Smart Grid<br>Distribution</h2>
            <p class="lead-text">
                Implementing SIL-3 safety protocols for a regional power station. Redundant PLCs ensure 99.999% uptime.
            </p>
            <div class="project-stat-row">
                <div>
                    <span class="project-stat-val">SIL-3</span>
                    <span class="project-stat-key">Safety Rating</span>
                </div>
                <div>
                    <span class="project-stat-val">99.9%</span>
                    <span class="project-stat-key">Uptime</span>
                </div>
            </div>
            <br>
            <a href="projects.php" class="btn-link" style="width: fit-content; border-color: #333; padding: 15px 30px;">Read Case Study &rarr;</a>
        </div>
    </div>
</section>

<section class="stats-matrix reveal">
    <div class="stat-cell">
        <div>
            <span class="stat-big count-up" data-target="15">0</span><span class="stat-suffix">+</span>
        </div>
        <span class="stat-label">Years R&D</span>
    </div>
    
    <div class="stat-cell">
        <div>
            <span class="stat-big count-up" data-target="200">0</span><span class="stat-suffix">+</span>
        </div>
        <span class="stat-label">Deployments</span>
    </div>
    
    <div class="stat-cell">
        <div>
            <span class="stat-big count-up" data-target="99">0</span><span class="stat-suffix">%</span>
        </div>
        <span class="stat-label">System Uptime</span>
    </div>
    
    <div class="stat-cell">
        <div>
            <span class="stat-big">24</span><span class="stat-suffix">/7</span>
        </div>
        <span class="stat-label">Critical Support</span>
    </div>
</section>

<section class="clients-section reveal">
    <div class="clients-heading">
        <h2>Trusted by <span>Industry Leaders</span></h2>
    </div>

    <div class="clients-slider">
        <div class="clients-track">
            <?php 
            // array of clients
            $clients = [
                [
                    "text" => "We developed an automated manual control system using Allen-Bradley PLCs for pipe bending machines, improving precision and reliability for suppliers to ISRO, SpaceX, DRDO, and major automobile manufacturers.",
                    "logo" => "images/autoforms.png",
                    "name" => "Autoforms",
                    "role" => "Aerospace Supplier"
                ],
                [
                    "text" => "PLC-based retrofitting of a steel bottle base welding machine improved control accuracy and extended the life of legacy equipment for India’s first steel bottle manufacturer.",
                    "logo" => "images/riya.png",
                    "name" => "Riya Industries",
                    "role" => "Manufacturing"
                ],
                [
                    "text" => "A TechAsia digital timer with buzzer ensured precise monitoring of electrode powder mixing cycles, improving consistency for a leading welding rod manufacturer.",
                    "logo" => "images/orange.png",
                    "name" => "Orange Electrodes",
                    "role" => "Industrial Goods"
                ],
                [
                    "text" => "Water valve angle indicators and power factor correction panels improved efficiency and corrosion protection in municipal water supply pumping stations.",
                    "logo" => "images/mcgm.png",
                    "name" => "MCGM",
                    "role" => "Municipal Corp"
                ],
                [
                    "text" => "Controller and filter-life indicators enhanced monitoring and air quality control in hospital operation-theatre laminar air-flow systems.",
                    "logo" => "images/WIESPL.png",
                    "name" => "WIESPL",
                    "role" => "Healthcare Infra"
                ],
                [
                    "text" => "PLC-based automation of hydraulic pipe-bending machines enabled high-volume production for an Indo-American manufacturing venture.",
                    "logo" => "images/comfort.png",
                    "name" => "Comfort Products",
                    "role" => "JV Manufacturing"
                ],
                [
                    "text" => "Customized DVCB and Comby Controllers improved HVAC efficiency for a patented, innovation-driven engineering company.",
                    "logo" => "images/panasia.png",
                    "name" => "Panasia Engineers",
                    "role" => "HVAC Innovation"
                ]
            ];

            // LOOP TWICE to create the seamless infinite scroll effect
            foreach(range(1,2) as $i): 
                foreach($clients as $client): 
            ?>
                <div class="client-card">
                    <p>“<?php echo $client['text']; ?>”</p>
                    <div class="client-footer">
                        <img src="<?php echo $client['logo']; ?>" class="client-logo" alt="<?php echo $client['name']; ?>">
                        <div class="client-info">
                            <h4><?php echo $client['name']; ?></h4>
                            <span><?php echo $client['role']; ?></span>
                        </div>
                    </div>
                </div>
            <?php 
                endforeach; 
            endforeach; 
            ?>
        </div>
    </div>
</section>


<section class="cta-area">
    <div class="reveal">
        <h2 class="display-2" style="margin-bottom: 30px;">Ready to Scale?</h2>
        <p class="lead-text" style="margin: 0 auto 50px auto;">
            Stop dealing with downtime. Let's engineer a solution that works as hard as you do.
        </p>
        <a href="contact.php" class="btn-main">
            Initiate Consultation
        </a>
    </div>
</section>

<script>
    // 1. SCROLL REVEAL OBSERVER
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if(entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

    // 2. PARALLAX EFFECTS
    // Only run on non-mobile for performance
    if (window.innerWidth > 900) {
        window.addEventListener('scroll', () => {
            const scrolled = window.scrollY;
            
            // Hero Background
            const heroBg = document.getElementById('heroBg');
            if(heroBg) heroBg.style.transform = `translateY(${scrolled * 0.5}px) scale(1.1)`;

            // Project Images
            document.querySelectorAll('.project-img').forEach(img => {
                const speed = 0.1;
                const rect = img.parentElement.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    const yPos = (window.innerHeight - rect.top) * speed;
                    img.style.transform = `translateY(${yPos - 50}px)`;
                }
            });
        });
    }

    // 3. NUMBER COUNTERS (ANIMATED)
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if(entry.isIntersecting) {
                const target = +entry.target.getAttribute('data-target');
                const duration = 2000; // 2 seconds animation
                const fps = 60;
                const interval = 1000 / fps;
                const steps = duration / interval;
                const increment = target / steps;
                
                let current = 0;
                let counterElement = entry.target;
                
                const timer = setInterval(() => {
                    current += increment;
                    if(current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    counterElement.innerText = Math.floor(current);
                }, interval);
                
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('.count-up').forEach(el => counterObserver.observe(el));
</script>

<?php include 'includes/footer.php'; ?>