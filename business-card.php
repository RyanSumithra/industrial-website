<?php 
require_once 'includes/config.php';

$current_page = 'business-card';
$page_title = 'Digital Identity | ' . SITE_NAME;

include 'includes/header.php'; 
?>

<style>
    /* --- THEME VARIABLES --- */
    :root {
        --primary: #ff3333;
        --primary-dim: #cc0000;
        --bg: #030303;
        --surface: #0a0a0a;
        --border: #222;
        --text: #ffffff;
        --text-muted: #888;
        --mono: 'JetBrains Mono', monospace;
        --sans: 'Inter', system-ui, -apple-system, sans-serif;
    }

    body {
        background-color: var(--bg);
        color: var(--text);
        font-family: var(--sans);
        margin: 0;
        overflow-x: hidden;
    }

    /* --- UTILITIES --- */
    .section-pad { padding: 120px 5%; border-bottom: 1px solid var(--border); }
    
    .label-mono { 
        color: var(--primary); font-family: var(--mono); font-weight: 700; 
        letter-spacing: 2px; font-size: 0.8rem; display: block; margin-bottom: 1.5rem; 
        text-transform: uppercase;
    }

    .display-2 {
        font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; text-transform: uppercase;
        color: white; margin-bottom: 1rem; line-height: 1; letter-spacing: -1px;
    }

    /* =========================================
       1. HERO SECTION (KEPT EXACTLY AS PROVIDED)
       ========================================= */
    .display-1 { 
        font-size: clamp(2.5rem, 8vw, 6.5rem); 
        font-weight: 800; 
        line-height: 0.95; 
        letter-spacing: -0.03em; 
        margin-bottom: 2rem;
        text-transform: uppercase;
        color: white;
    }

    .outline-text {
        -webkit-text-stroke: 1px rgba(255,255,255,0.3);
        color: transparent;
        transition: 0.3s;
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
        border-bottom: 1px solid var(--border);
        padding: 140px 5% 100px;
        text-align: center;
    }

    .hero-bg {
        position: absolute; inset: 0;
        background: url('https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=2070&auto=format&fit=crop') no-repeat center center/cover;
        filter: grayscale(100%) brightness(0.3) contrast(1.2);
        transform: scale(1.1);
        z-index: 0;
    }

    .hero-overlay {
        position: absolute; inset: 0;
        background: radial-gradient(circle at center, rgba(20,20,20,0.4) 0%, var(--bg) 90%);
        z-index: 1;
    }

    .hero-content {
        position: relative; z-index: 10;
        max-width: 1200px; margin: 0 auto; width: 100%;
    }

    .monitor-frame {
        max-width: 800px; margin: 40px auto 0;
        border: 1px solid var(--border); background: #000;
        padding: 10px 10px 30px 10px; border-radius: 4px;
        box-shadow: 0 0 100px rgba(0,0,0,0.8); position: relative;
    }
    .monitor-frame::after {
        content: 'LIVE FEED'; position: absolute; bottom: 8px; right: 15px;
        font-family: var(--mono); color: var(--primary); font-size: 0.7rem; letter-spacing: 1px;
        animation: blink 2s infinite;
    }
    @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }

    .video-embed { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; background: #111; }
    .video-embed iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }


    /* =========================================
       2. FEATURES (BENTO GRID STYLE)
       ========================================= */
    .bento-section { padding: 120px 5%; border-bottom: 1px solid var(--border); background: #050505; }
    
    .bento-grid {
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 20px;
        margin-top: 60px;
    }

    .bento-card {
        background: var(--surface);
        border: 1px solid var(--border);
        padding: 40px;
        transition: 0.4s;
        display: flex; flex-direction: column; justify-content: flex-start;
        position: relative;
        overflow: hidden;
    }
    .bento-card:hover { border-color: var(--primary); transform: translateY(-5px); background: #0f0f0f; }
    
    /* Subtle hover glow */
    .bento-card::before {
        content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%;
        background: var(--primary); transform: scaleY(0); transition: 0.3s;
    }
    .bento-card:hover::before { transform: scaleY(1); }

    .feat-icon { font-size: 2.5rem; margin-bottom: 20px; color: var(--primary); display: block; }
    
    .bento-title { 
        font-size: 1.4rem; font-weight: 800; color: white; margin-bottom: 15px; 
        text-transform: uppercase; letter-spacing: 0.5px;
    }
    .bento-desc { color: #999; line-height: 1.6; font-size: 0.95rem; }


    /* =========================================
       3. MOBILE SHOWCASE
       ========================================= */
    .showcase-section {
        padding: 100px 5%;
        background: radial-gradient(circle at center, #111 0%, #000 100%);
        border-bottom: 1px solid var(--border);
        text-align: center;
    }
    .showcase-img {
        max-width: 100%; height: auto;
        filter: drop-shadow(0 30px 60px rgba(0,0,0,0.8));
        animation: float 6s ease-in-out infinite;
    }
    @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-15px); } }


    /* =========================================
       4. REQUEST FORM (CONTROL PANEL STYLE)
       ========================================= */
    .request-section { padding: 120px 5%; background: var(--bg); }
    
    .req-grid {
        display: grid; grid-template-columns: 1fr 1.6fr; gap: 80px;
        max-width: 1400px; margin: 0 auto;
    }
    @media(max-width: 900px) { .req-grid { grid-template-columns: 1fr; } }

    /* Left Info */
    .req-info { padding-top: 20px; }
    .price-display { font-size: 4.5rem; font-weight: 800; color: var(--primary); line-height: 1; letter-spacing: -2px; }
    .price-sub { color: #666; font-family: var(--mono); font-size: 0.9rem; text-transform: uppercase; margin-top: 10px; display: block;}

    .spec-list { list-style: none; padding: 0; margin-top: 50px; }
    .spec-list li {
        padding: 18px 0; border-bottom: 1px solid #222; color: #ccc;
        display: flex; justify-content: space-between; font-family: var(--mono); font-size: 0.85rem;
    }
    .spec-list li span { color: var(--primary); }

    /* Right Form - Control Panel Look */
    .req-form {
        background: #080808; 
        border: 1px solid var(--border); 
        padding: 60px;
        position: relative;
        background-image: linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
        background-size: 40px 40px;
    }
    /* "Connectors" aesthetic at corners */
    .req-form::before, .req-form::after {
        content: ''; position: absolute; width: 10px; height: 10px; border: 1px solid #444; background: #000;
    }
    .req-form::before { top: -6px; left: -6px; }
    .req-form::after { bottom: -6px; right: -6px; }

    .form-group { margin-bottom: 25px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
    @media(max-width: 600px) { .form-row { grid-template-columns: 1fr; } }

    label { 
        display: block; color: #666; font-size: 0.75rem; font-weight: 700; 
        margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px; font-family: var(--mono);
    }
    
    .input-industrial {
        width: 100%; background: #0c0c0c; border: 1px solid #333; color: white;
        padding: 16px; font-family: 'Inter', sans-serif; font-size: 1rem;
        box-sizing: border-box; transition: 0.3s;
    }
    .input-industrial:focus { border-color: var(--primary); outline: none; background: #000; }
    textarea.input-industrial { resize: vertical; min-height: 120px; }

    /* Custom File Upload Styling */
    .upload-group {
        border: 2px dashed #333; background: rgba(255,255,255,0.02);
        padding: 20px; text-align: center; margin-bottom: 20px;
        transition: 0.3s; cursor: pointer; position: relative;
    }
    .upload-group:hover { border-color: var(--primary); background: rgba(255,51,51,0.05); }
    .upload-group input[type="file"] {
        position: absolute; top:0; left:0; width:100%; height:100%; opacity: 0; cursor: pointer;
    }
    .upload-text { color: #888; font-size: 0.8rem; pointer-events: none; }

    .btn-submit {
        width: 100%; padding: 20px; background: var(--primary); color: white; border: none;
        font-weight: 800; text-transform: uppercase; letter-spacing: 2px; cursor: pointer;
        transition: 0.3s; font-size: 1rem; margin-top: 10px;
    }
    .btn-submit:hover { background: white; color: black; }

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

        <a href="https://techasiamechatronics.com/vcard/" target="_blank" style="color:white; text-decoration:none; border-bottom: 1px solid var(--primary); padding-bottom: 5px; font-family: var(--mono); font-size: 0.9rem;">
            [ VIEW LIVE PREVIEW ↗ ]
        </a>

        <div class="monitor-frame">
            <div class="video-embed">
                <iframe src="https://www.youtube-nocookie.com/embed/U-5adrExIQM?autoplay=1&mute=1&loop=1&playlist=U-5adrExIQM" frameborder="0" allowfullscreen></iframe>
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
            <p style="color:#aaa; line-height:1.6; margin-bottom:40px; font-size:1.1rem;">
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
            <?php
            if (isset($_GET['success'])) {
                echo '<div style="background:rgba(40,167,69,0.2); color:#4cd16e; padding:15px; border:1px solid #28a745; margin-bottom:20px; font-family:var(--mono);">[STATUS: SUCCESS] Request Transmitted.</div>';
            }
            if (isset($_GET['error'])) {
                echo '<div style="background:rgba(255,51,51,0.2); color:#ff6666; padding:15px; border:1px solid #ff3333; margin-bottom:20px; font-family:var(--mono);">[STATUS: ERROR] Check Inputs.</div>';
            }
            ?>

            <form action="process-card-request.php" method="POST" enctype="multipart/form-data">
                
                <div class="form-row">
                    <div class="upload-group">
                        <span class="upload-text">📸 UPLOAD PROFILE PHOTO</span>
                        <input type="file" name="user_image" accept="image/*" onchange="this.previousElementSibling.innerText = '✓ SELECTED'">
                    </div>
                    <div class="upload-group">
                        <span class="upload-text">🏢 UPLOAD LOGO</span>
                        <input type="file" name="company_logo" accept="image/*" onchange="this.previousElementSibling.innerText = '✓ SELECTED'">
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