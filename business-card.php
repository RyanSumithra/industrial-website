<?php 
require_once 'includes/config.php';

$current_page = 'business-card';
$page_title = 'Digital Identity | ' . SITE_NAME;

include 'includes/header.php'; 
?>

<style>
    /* --- PAGE SPECIFIC VARIABLES --- */
    :root {
        --mono: 'JetBrains Mono', 'Courier New', monospace;
        --sans: 'Inter', system-ui, -apple-system, sans-serif;
    }

    body {
        background-color: var(--bg-body);
        color: var(--text-main);
        font-family: var(--sans);
        margin: 0;
        overflow-x: hidden;
    }

    /* --- UTILITIES --- */
    .section-pad { padding: 120px 5%; border-bottom: 1px solid var(--border-color); }
    @media (max-width: 768px) { .section-pad { padding: 80px 5%; } }
    
    .label-mono { 
        color: var(--primary-red); font-family: var(--mono); font-weight: 700; 
        letter-spacing: 2px; font-size: 0.8rem; display: block; margin-bottom: 1.5rem; 
        text-transform: uppercase;
    }

    .display-2 {
        font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; text-transform: uppercase;
        color: var(--text-main); margin-bottom: 1rem; line-height: 1; letter-spacing: -1px;
    }

    /* =========================================
       1. HERO SECTION
       ========================================= */
    .display-1 { 
        font-size: clamp(2.5rem, 8vw, 6.5rem); 
        font-weight: 800; 
        line-height: 0.95; 
        letter-spacing: -0.03em; 
        margin-bottom: 2rem;
        text-transform: uppercase;
        color: var(--text-main);
    }

    .outline-text {
        -webkit-text-stroke: 1px rgba(128,128,128,0.5);
        color: transparent;
        transition: 0.3s;
    }
    .hero-wrap:hover .outline-text {
        color: var(--primary-red);
    }
    
    .lead-text { 
        font-size: clamp(1rem, 2vw, 1.25rem); 
        color: var(--text-muted); 
        line-height: 1.6; 
        max-width: 650px; 
        font-weight: 400;
        margin-bottom: 40px;
    }

    .hero-wrap {
        min-height: 100vh;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        border-bottom: 1px solid var(--border-color);
        padding: 140px 5% 100px;
        text-align: center;
    }

    /* Mobile Hero Adjustment */
    @media (max-width: 768px) {
        .hero-wrap { padding: 120px 20px 60px; min-height: auto; }
        .display-1 { margin-bottom: 1.5rem; }
    }

    .hero-bg {
        position: absolute; inset: 0;
        background: url('https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=2070&auto=format&fit=crop') no-repeat center center/cover;
        filter: grayscale(100%) brightness(0.3) contrast(1.2);
        transform: scale(1.1);
        z-index: 0;
        transition: 0.3s;
    }

    body.light-mode .hero-bg {
        filter: none !important; opacity: 1 !important; filter: blur(4px) !important;
    }

    .hero-overlay {
        position: absolute; inset: 0;
        background: radial-gradient(circle at center, rgba(20,20,20,0.4) 0%, var(--bg-body) 90%);
        z-index: 1;
    }
    body.light-mode .hero-overlay { background: rgba(0, 0, 0, 0.4); }

    .hero-content {
        position: relative; z-index: 10;
        max-width: 1200px; margin: 0 auto; width: 100%;
    }
    
    body.light-mode .hero-content .display-1,
    body.light-mode .hero-content .lead-text,
    body.light-mode .hero-content .label-mono {
        color: white !important;
        text-shadow: 0 2px 10px rgba(0,0,0,0.5);
    }
    body.light-mode .hero-content .outline-text {
        -webkit-text-stroke: 1px rgba(255,255,255,0.5);
    }

    .monitor-frame {
        width: 100%; max-width: 800px; margin: 40px auto 0;
        border: 1px solid var(--border-color); background: #000;
        padding: 10px 10px 30px 10px; border-radius: 4px;
        box-shadow: 0 0 100px rgba(0,0,0,0.8); position: relative;
    }
    .monitor-frame::after {
        content: 'LIVE FEED'; position: absolute; bottom: 8px; right: 15px;
        font-family: var(--mono); color: var(--primary-red); font-size: 0.7rem; letter-spacing: 1px;
        animation: blink 2s infinite;
    }
    @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }

    .video-embed { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; background: #111; }
    .video-embed iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }


    /* =========================================
       2. FEATURES (BENTO GRID STYLE)
       ========================================= */
    .bento-section { 
        padding: 120px 5%; 
        border-bottom: 1px solid var(--border-color); 
        background: var(--bg-surface); 
    }
    
    .bento-grid {
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 60px;
    }

    .bento-card {
        background: var(--bg-surface-2);
        border: 1px solid var(--border-color);
        padding: 40px;
        transition: 0.4s;
        display: flex; flex-direction: column; justify-content: flex-start;
        position: relative;
        overflow: hidden;
    }
    @media (max-width: 768px) {
        .bento-card { padding: 30px 25px; }
    }
    
    .bento-card:hover { 
        border-color: var(--primary-red); 
        transform: translateY(-5px); 
        filter: brightness(1.1);
    }
    
    .bento-card::before {
        content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%;
        background: var(--primary-red); transform: scaleY(0); transition: 0.3s;
    }
    .bento-card:hover::before { transform: scaleY(1); }

    .feat-icon { font-size: 2.5rem; margin-bottom: 20px; color: var(--primary-red); display: block; }
    
    .bento-title { 
        font-size: 1.4rem; font-weight: 800; color: var(--text-main); margin-bottom: 15px; 
        text-transform: uppercase; letter-spacing: 0.5px;
    }
    .bento-desc { color: var(--text-muted); line-height: 1.6; font-size: 0.95rem; }


    /* =========================================
       3. MOBILE SHOWCASE
       ========================================= */
    .showcase-section {
        padding: 100px 5%;
        background: radial-gradient(circle at center, var(--bg-surface-2) 0%, var(--bg-body) 100%);
        border-bottom: 1px solid var(--border-color);
        text-align: center;
    }
    .showcase-img {
        max-width: 100%; height: auto;
        filter: drop-shadow(0 30px 60px rgba(0,0,0,0.8));
        animation: float 6s ease-in-out infinite;
    }
    body.light-mode .showcase-img {
        filter: drop-shadow(0 30px 60px rgba(0,0,0,0.2));
    }
    
    @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-15px); } }


    /* =========================================
       4. REQUEST FORM (REDESIGNED)
       ========================================= */
    .request-section { 
        padding: 120px 5%; 
        background: var(--bg-body); 
        position: relative;
    }
    @media (max-width: 768px) { .request-section { padding: 80px 5%; } }
    
    .req-grid {
        display: grid; grid-template-columns: 1fr 1.6fr; gap: 80px;
        max-width: 1400px; margin: 0 auto;
        align-items: start;
    }
    @media(max-width: 900px) { .req-grid { grid-template-columns: 1fr; gap: 40px; } }

    /* --- LEFT INFO SIDE --- */
    .req-info { padding-top: 20px; }
    .price-display { 
        font-size: 4.5rem; font-weight: 800; color: var(--primary-red); 
        line-height: 1; letter-spacing: -2px; display: inline-block;
    }
    .price-sub { 
        color: var(--text-muted); font-family: var(--mono); font-size: 0.9rem; 
        text-transform: uppercase; margin-top: 10px; display: block; 
    }
    @media (max-width: 600px) { .price-display { font-size: 3.5rem; } }

    .spec-list { list-style: none; padding: 0; margin-top: 50px; }
    .spec-list li {
        padding: 18px 0; border-bottom: 1px solid var(--border-color); color: var(--text-muted);
        display: flex; justify-content: space-between; font-family: var(--mono); font-size: 0.85rem;
    }
    .spec-list li span { color: var(--text-main); font-weight: 700; }

    /* --- RIGHT FORM SIDE (New Design) --- */
    .req-form {
        /* Dark Mode Default: Glassmorphism */
        background: rgba(15, 15, 15, 0.6);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-top: 2px solid var(--primary-red); /* Top accent */
        padding: 50px;
        border-radius: 12px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        position: relative;
        overflow: hidden;
    }
    
    /* Diagonal Pattern Overlay for Tech feel */
    .req-form::before {
        content: ''; position: absolute; inset: 0;
        background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255,255,255,0.01) 10px, rgba(255,255,255,0.01) 11px);
        pointer-events: none; z-index: 0;
    }

    /* Light Mode Form: Clean, Document Style */
    body.light-mode .req-form {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-top: 4px solid var(--primary-red);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
    }
    body.light-mode .req-form::before { display: none; }

    @media (max-width: 600px) { .req-form { padding: 30px 20px; } }

    /* Form Content Wrapper */
    .form-content { position: relative; z-index: 1; }

    .form-group { margin-bottom: 25px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    @media(max-width: 600px) { .form-row { grid-template-columns: 1fr; gap: 15px; } }

    label { 
        display: block; color: var(--text-muted); font-size: 0.7rem; font-weight: 700; 
        margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px; font-family: var(--mono);
    }
    
    /* Input Styling */
    .input-industrial {
        width: 100%; 
        background: rgba(255, 255, 255, 0.03); 
        border: 1px solid var(--border-color); 
        border-radius: 6px;
        color: var(--text-main);
        padding: 14px 16px; 
        font-family: 'Inter', sans-serif; font-size: 0.95rem;
        box-sizing: border-box; transition: all 0.3s ease;
    }
    
    /* Light Mode Input */
    body.light-mode .input-industrial {
        background: #f8f9fa;
        border-color: #e0e0e0;
        color: #111;
    }
    
    .input-industrial:focus { 
        border-color: var(--primary-red); outline: none; 
        background: rgba(255, 51, 51, 0.05);
        box-shadow: 0 0 0 4px rgba(255, 51, 51, 0.1);
    }
    
    textarea.input-industrial { resize: vertical; min-height: 100px; }

    /* Upload Buttons (Dashed Zone) */
    .upload-group {
        border: 1px dashed var(--border-color); 
        background: rgba(255,255,255,0.01);
        border-radius: 8px;
        padding: 25px; text-align: center; margin-bottom: 0;
        transition: 0.3s; cursor: pointer; position: relative;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 10px; height: 100%;
    }
    body.light-mode .upload-group { background: #f8f9fa; border-color: #ccc; }

    .upload-group:hover { 
        border-color: var(--primary-red); 
        background: rgba(255,51,51,0.05); 
        transform: translateY(-2px);
    }
    .upload-group input[type="file"] {
        position: absolute; top:0; left:0; width:100%; height:100%; opacity: 0; cursor: pointer;
    }
    .upload-icon { font-size: 1.5rem; color: var(--text-muted); transition: 0.3s; }
    .upload-group:hover .upload-icon { color: var(--primary-red); transform: scale(1.1); }
    .upload-text { color: var(--text-main); font-size: 0.75rem; font-weight: 600; pointer-events: none; }

    /* Submit Button */
    .btn-submit {
        width: 100%; padding: 18px; 
        background: var(--primary-red); 
        color: white; border: none; border-radius: 6px;
        font-weight: 800; text-transform: uppercase; letter-spacing: 2px; cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
        font-size: 0.95rem; margin-top: 10px;
        box-shadow: 0 10px 30px rgba(255, 51, 51, 0.3);
    }
    .btn-submit:hover { 
        background: #fff; 
        color: #cc0000; 
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(255, 51, 51, 0.4);
    }
    
    body.light-mode .btn-submit {
        background: #111; color: white; box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    body.light-mode .btn-submit:hover {
        background: var(--primary-red); color: white;
    }

</style>

<div class="noise-overlay"></div>

<section class="hero-wrap">
    <div class="hero-bg" id="heroBg"></div>
    <div class="hero-overlay"></div>
    
    <div class="hero-content">
        <span class="label-mono">// DIGITAL NETWORKING</span>
        
        <h1 class="display-1">
            INSTANT DIGITAL<br>
            <span class="outline-text">CONNECTION</span>
        </h1>
        
        <p class="lead-text" style="margin: 0 auto 40px auto;">
            Access our contact details, services, and key resources instantly. 
            Save, share, or connect with one tap. No apps required.
        </p>

        <a href="https://techasiamechatronics.com/vcard/" target="_blank" style="color:white; text-decoration:none; border-bottom: 1px solid var(--primary-red); padding-bottom: 5px; font-family: var(--mono); font-size: 0.9rem;">
            [ VIEW LIVE PREVIEW ↗ ]
        </a>

        <div class="monitor-frame">
            <div class="video-embed">
                <iframe src="https://www.youtube-nocookie.com/embed/U-5adrExIQM?autoplay=1&mute=1&loop=1&playlist=U-5adrExIQM&controls=0&showinfo=0" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</section>

<section class="bento-section">
    <div style="text-align: center;">
        <span class="label-mono">/// CAPABILITIES</span>
        <h2 class="display-2">Why Go Digital?</h2>
    </div>

    <div class="bento-grid">
        <div class="bento-card">
            <div class="feat-icon">🤝</div>
            <h3 class="bento-title">First Impression</h3>
            <p class="bento-desc">Stand out from the crowd with a modern, tech-savvy approach that clients remember.</p>
        </div>
        <div class="bento-card">
            <div class="feat-icon">♻️</div>
            <h3 class="bento-title">Eco-Friendly</h3>
            <p class="bento-desc">Eliminate paper waste. No need to carry bunches of cards for exhibitions.</p>
        </div>
        <div class="bento-card">
            <div class="feat-icon">🔄</div>
            <h3 class="bento-title">Live Updates</h3>
            <p class="bento-desc">Changed your number? Update once, and everyone sees the new info immediately.</p>
        </div>
        <div class="bento-card">
            <div class="feat-icon">👆</div>
            <h3 class="bento-title">Interactive</h3>
            <p class="bento-desc">Recipients can click to Call, WhatsApp, Email, or Navigate instantly.</p>
        </div>
        <div class="bento-card">
            <div class="feat-icon">💰</div>
            <h3 class="bento-title">Cost Effective</h3>
            <p class="bento-desc">Save thousands on printing costs every year. Pay once for unlimited usage.</p>
        </div>
        <div class="bento-card">
            <div class="feat-icon">🗑️</div>
            <h3 class="bento-title">Zero Waste</h3>
            <p class="bento-desc">Paper cards end up in the trash. Digital cards are saved directly to the phone.</p>
        </div>
    </div>
</section>

<section class="showcase-section">
    <div style="max-width: 1000px; margin: 0 auto;">
        <img src="images/mobile2-1.png" alt="Card Preview" class="showcase-img">
    </div>
</section>

<section class="request-section" id="requestForm">
    <div class="req-grid">
        
        <div class="req-info">
            <span class="label-mono">/// INITIALIZE REQUEST</span>
            <h2 class="display-2" style="font-size: 2.5rem; margin-bottom: 20px;">Get Access</h2>
            <p style="color: var(--text-muted); line-height:1.6; margin-bottom:40px; font-size:1.1rem;">
                Complete the form to generate your interactive digital business card. 
                Our team will configure your NFC profile and hosting.
            </p>
            
            <div style="margin-bottom: 40px;">
                <span class="price-display">₹999</span>
                <div class="price-sub">/ Year (Billed Annually)</div>
            </div>

            <ul class="spec-list">
                <li>Unlimited Views <span>INCLUDED</span></li>
                <li>Unlimited Sharing <span>INCLUDED</span></li>
                <li>Custom Branding <span>INCLUDED</span></li>
                <li>Dedicated URL <span>INCLUDED</span></li>
                <li>QR Code Generation <span>INCLUDED</span></li>
                <li>VCF Download <span>INCLUDED</span></li>
            </ul>
        </div>

        <div class="req-form">
            <div class="form-content">
                <?php
                if (isset($_GET['success'])) {
                    echo '<div style="background:rgba(40,167,69,0.1); color:#4cd16e; padding:15px; border-radius:6px; border:1px solid #28a745; margin-bottom:20px; font-family:var(--mono);">[STATUS: SUCCESS] Request Transmitted.</div>';
                }
                if (isset($_GET['error'])) {
                    echo '<div style="background:rgba(255,51,51,0.1); color:#ff6666; padding:15px; border-radius:6px; border:1px solid #ff3333; margin-bottom:20px; font-family:var(--mono);">[STATUS: ERROR] Check Inputs.</div>';
                }
                ?>

                <form action="process-card-request.php" method="POST" enctype="multipart/form-data">
                    
                    <div class="form-row">
                        <div class="upload-group">
                            <span class="upload-icon">📸</span>
                            <span class="upload-text">UPLOAD PHOTO</span>
                            <input type="file" name="user_image" accept="image/*" onchange="this.previousElementSibling.innerText = '✓ PHOTO SELECTED'">
                        </div>
                        <div class="upload-group">
                            <span class="upload-icon">🏢</span>
                            <span class="upload-text">UPLOAD LOGO</span>
                            <input type="file" name="company_logo" accept="image/*" onchange="this.previousElementSibling.innerText = '✓ LOGO SELECTED'">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Full Name *</label>
                            <input type="text" name="name" class="input-industrial" required placeholder="Ex: John Doe">
                        </div>
                        <div class="form-group">
                            <label>Contact No. *</label>
                            <input type="text" name="contact" class="input-industrial" required placeholder="+91...">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email Address *</label>
                        <input type="email" name="email" class="input-industrial" required placeholder="name@company.com">
                    </div>

                    <div class="form-group">
                        <label>Website URL</label>
                        <input type="text" name="website_url" class="input-industrial" placeholder="www.yoursite.com">
                    </div>

                    <div class="form-group">
                        <label>Physical Address</label>
                        <textarea name="address" class="input-industrial" rows="2" placeholder="Full office address..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>Tagline / Services</label>
                        <textarea name="tagline" class="input-industrial" rows="2" placeholder="Automation Expert | PLC Specialist..."></textarea>
                    </div>

                    <button type="submit" class="btn-submit">SUBMIT REQUEST</button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    if (window.innerWidth > 900) {
        window.addEventListener('scroll', () => {
            const scrolled = window.scrollY;
            const heroBg = document.getElementById('heroBg');
            if(heroBg) heroBg.style.transform = `translateY(${scrolled * 0.5}px) scale(1.1)`;
        });
    }
</script>

<?php include 'includes/footer.php'; ?>