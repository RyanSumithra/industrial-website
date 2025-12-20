<?php 
require_once 'includes/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_page = 'contact';
$page_title = 'Contact Us | ' . (defined('SITE_NAME') ? SITE_NAME : 'Industrial Intelligence');

// Check if coming from product page
$product_name = isset($_GET['product']) ? urldecode($_GET['product']) : '';
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

// Handle form messages
$success_message = isset($_GET['success']);
$error_message = isset($_GET['error']);
$form_data = $_SESSION['form_data'] ?? [];
$form_errors = $_SESSION['form_errors'] ?? [];

unset($_SESSION['form_data']);
unset($_SESSION['form_errors']);

include 'includes/header.php'; 
?>

<style>
    /* --- PAGE SPECIFIC VARIABLES --- */
    :root {
        --mono: 'JetBrains Mono', 'Courier New', monospace;
        --sans: 'Inter', system-ui, -apple-system, sans-serif;
    }

    /* 1. HERO SECTION */
    .contact-hero {
        min-height: 40vh;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 100px 5% 60px;
        background: var(--bg-body);
        border-bottom: 1px solid var(--border-color);
        overflow: hidden;
    }

    .contact-hero::before {
        content: ''; position: absolute; inset: 0;
        background-image: 
            linear-gradient(var(--border-color) 1px, transparent 1px),
            linear-gradient(90deg, var(--border-color) 1px, transparent 1px);
        background-size: 40px 40px;
        opacity: 0.1;
        z-index: 0;
    }

    .hero-overlay {
        position: absolute; inset: 0;
        background: radial-gradient(circle at 50% 30%, rgba(255, 51, 51, 0.05), var(--bg-body) 80%);
        z-index: 1;
    }
    
    body.light-mode .hero-overlay {
        background: radial-gradient(circle at 50% 30%, rgba(255, 51, 51, 0.05), rgba(255,255,255,0) 80%);
    }

    .contact-hero-content { position: relative; z-index: 10; max-width: 800px; width: 100%; }

    .hero-title {
        font-size: clamp(2.2rem, 5vw, 4rem);
        font-weight: 900;
        color: var(--text-main);
        margin-bottom: 15px;
        letter-spacing: -1px;
    }
    
    .hero-title span { color: var(--primary-red); }

    .hero-subtitle {
        color: var(--text-muted);
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* 2. CONTACT LAYOUT */
    .contact-section {
        padding: 60px 5%;
        background: var(--bg-body);
    }
    
    .contact-wrapper {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 50px;
        max-width: 1400px; margin: 0 auto;
    }
    
    /* INFO CARDS (Left Side) */
    .contact-info-header h2 {
        font-size: 1.8rem; font-weight: 800; color: var(--text-main); margin-bottom: 15px;
    }
    .contact-info-header p {
        color: var(--text-muted); margin-bottom: 30px; line-height: 1.6;
    }

    .contact-method {
        display: flex; gap: 15px; margin-bottom: 20px;
        background: var(--bg-surface-2);
        padding: 20px; border-radius: 8px;
        border: 1px solid var(--border-color);
        transition: 0.3s;
    }
    
    .contact-method:hover {
        border-color: var(--primary-red);
        transform: translateX(5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .method-icon {
        width: 45px; height: 45px;
        background: rgba(255, 51, 51, 0.1);
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; color: var(--primary-red);
        flex-shrink: 0;
    }
    
    .method-details h3 {
        color: var(--text-main); font-size: 1rem; margin: 0 0 5px 0; font-weight: 700;
    }
    .method-details p, .method-details address {
        color: var(--text-muted); font-style: normal; margin: 0; font-size: 0.9rem; line-height: 1.5;
    }
    .method-details a {
        color: var(--text-muted); text-decoration: none; transition: 0.3s;
    }
    .method-details a:hover { color: var(--primary-red); }

    /* 3. FORM STYLES (Right Side) */
    .contact-form-wrapper {
        background: var(--bg-surface);
        padding: 40px; border-radius: 12px;
        border: 1px solid var(--border-color);
        position: relative;
        box-shadow: 0 20px 50px rgba(0,0,0,0.2);
    }
    body.light-mode .contact-form-wrapper {
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
    }
    
    .contact-form-wrapper::before {
        content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px;
        background: linear-gradient(90deg, var(--primary-red), transparent);
    }

    .form-header h2 { color: var(--text-main); margin-bottom: 10px; font-weight: 800; font-size: 1.6rem; }
    .form-header p { color: var(--text-muted); margin-bottom: 25px; font-size: 0.95rem; }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-group { margin-bottom: 20px; }

    label {
        display: block; color: var(--text-muted); font-size: 0.8rem;
        font-weight: 700; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;
    }
    .required::after { content: " *"; color: var(--primary-red); }

    .form-input {
        width: 100%; padding: 12px 15px;
        background: var(--bg-body);
        border: 1px solid var(--border-color);
        color: var(--text-main);
        font-family: 'Inter', sans-serif; font-size: 1rem;
        border-radius: 4px; transition: 0.3s;
    }
    
    body.light-mode .form-input {
        background: #ffffff;
        border-color: #ccc;
    }

    .form-input:focus {
        outline: none; border-color: var(--primary-red);
        box-shadow: 0 0 0 3px rgba(255, 51, 51, 0.1);
    }
    
    textarea.form-input { min-height: 120px; resize: vertical; }

    .btn-submit {
        width: 100%; padding: 15px;
        background: var(--primary-red); color: white;
        border: none; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;
        border-radius: 4px; cursor: pointer; transition: 0.3s;
        margin-top: 10px; display: flex; justify-content: center; align-items: center; gap: 10px;
    }
    .btn-submit:hover {
        background: var(--text-main);
        color: var(--bg-body);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    .product-inquiry-banner {
        background: rgba(255, 51, 51, 0.05);
        border: 1px solid rgba(255, 51, 51, 0.2);
        border-radius: 8px;
        padding: 20px; margin-bottom: 30px;
        display: flex; align-items: center; gap: 15px;
    }
    .product-inquiry-info h4 { margin: 0 0 5px 0; color: var(--text-main); font-size: 1rem; }
    .product-inquiry-info p { margin: 0; color: var(--text-muted); font-size: 0.9rem; }

    /* 4. MAP SECTION (FIXED FOR COLOR & BOX REMOVAL) */
    .map-section { 
        position: relative; 
        /* Set a fixed container height */
        height: 500px; 
        width: 100%; 
        overflow: hidden; /* Crucial for cropping */
        border-top: 1px solid var(--border-color); 
        background: var(--bg-body);
    }
    
    .map-frame { 
        width: 100%; 
        height: 130%; /* Taller than container to allow cropping */
        border: 0;
        
        /* 1. CROP TOP: -150px margin pulls the iframe UP, hiding the Google top-left box.
           2. ZOOM: scale(1.2) zooms the map in.
        */
        margin-top: -150px; 
        transform: scale(1.8); 
        transform-origin: center center;
        
        /* Default Dark Mode: Just dim brightness slightly, KEEP COLORS */
        filter: invert(90%) hue-rotate(180deg) brightness(95%) contrast(90%); 
    }
    
    /* Light Mode Map: Full Brightness, Full Color */
    body.light-mode .map-frame {
        filter: none;
    }

    /* Floating Card */
    .map-overlay-card { 
        position: absolute; 
        bottom: 30px; /* Moved to bottom so it doesn't conflict with cropped top */
        left: 30px; 
        background: var(--bg-surface);
        backdrop-filter: blur(15px); 
        padding: 30px; 
        border-radius: 8px; 
        border: 1px solid var(--border-color); 
        border-left: 4px solid var(--primary-red); 
        box-shadow: 0 20px 40px rgba(0,0,0,0.5); 
        max-width: 350px; 
        z-index: 20; 
    }
    
    body.light-mode .map-overlay-card { 
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15); 
    }

    .location-pointer { 
        display: flex; align-items: center; gap: 15px; margin-bottom: 20px; 
    }
    .pointer-icon { font-size: 1.8rem; animation: bounce 2s infinite; }
    @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

    .map-btn { 
        display: inline-flex; align-items: center; gap: 10px; 
        background: var(--text-main); color: var(--bg-body); 
        font-weight: 700; padding: 12px 24px; border-radius: 4px; 
        text-decoration: none; margin-top: 20px; transition: 0.3s; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .map-btn:hover { 
        opacity: 0.9; transform: translateY(-2px); 
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
    }

    .honeypot { display: none; }

    /* --- RESPONSIVE ADJUSTMENTS --- */
    @media (max-width: 1024px) {
        .contact-wrapper { grid-template-columns: 1fr; gap: 40px; }
    }
    
    @media (max-width: 768px) {
        /* Mobile Hero */
        .contact-hero { padding: 100px 5% 40px; min-height: auto; }
        .hero-title { font-size: 2.2rem; }
        
        /* Mobile Layout */
        .contact-section { padding: 40px 5%; }
        .contact-form-wrapper { padding: 25px 20px; }
        .form-grid { grid-template-columns: 1fr; }
        
        /* Mobile Map Stack */
        .map-section { 
            height: auto; 
            display: flex; 
            flex-direction: column-reverse; /* Map bottom, card top */
        }
        
        /* Adjust Map for Mobile */
        .map-frame { 
            height: 400px; 
            margin-top: -100px; /* Less aggressive crop on mobile */
            transform: scale(1); /* Reset zoom on mobile to prevent overflow issues */
            width: 100%;
        }
        
        /* Card above Map */
        .map-overlay-card { 
            position: relative; 
            bottom: auto; left: auto; transform: none; 
            width: 100%; max-width: 100%; 
            border-radius: 0; 
            border: none;
            border-bottom: 4px solid var(--primary-red); 
            background: var(--bg-surface);
            padding: 30px 20px;
            box-shadow: none;
            order: 2;
        }
    }
    
    /* Animation Utility */
    .animate-up { animation: fadeUp 0.6s ease forwards; opacity: 0; }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="noise-overlay"></div>

<section class="contact-hero">
    <div class="hero-overlay"></div>
    <div class="contact-hero-content animate-up">
        <h1 class="hero-title">Contact <span>Us</span></h1>
        <p class="hero-subtitle">
            <?php echo !empty($product_name) ? "Get a comprehensive quote for " . htmlspecialchars($product_name) : "Visit our Head Office in Dombivli or send us a message."; ?>
        </p>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        
        <?php if ($success_message): ?>
            <div style="background: rgba(40,167,69,0.1); border: 1px solid #28a745; color:#28a745; padding:15px; border-radius:6px; margin-bottom:30px; text-align:center;">
                <strong>Message Sent!</strong> Thank you. We will respond within 24 hours.
            </div>
        <?php endif; ?>

        <?php if ($error_message && !empty($form_errors)): ?>
            <div style="background: rgba(220,53,69,0.1); border: 1px solid #dc3545; color:#dc3545; padding:15px; border-radius:6px; margin-bottom:30px; text-align:center;">
                <strong>Error!</strong> <?php echo implode('<br>', $form_errors); ?>
            </div>
        <?php endif; ?>

        <div class="contact-wrapper">
            
            <div class="contact-info animate-up delay-1">
                <div class="contact-info-header">
                    <h2>Get In Touch</h2>
                    <p>Ready to automate your operations? Reach out to our engineering team for a free consultation.</p>
                </div>

                <div class="contact-methods">
                    <div class="contact-method">
                        <div class="method-icon">📍</div>
                        <div class="method-details">
                            <h3>Head Office</h3>
                            <address>
                                302, Pandurang Smruti C,<br>
                                Dombivli East, Maharashtra 421203
                            </address>
                        </div>
                    </div>

                    <div class="contact-method">
                        <div class="method-icon">📧</div>
                        <div class="method-details">
                            <h3>Email Us</h3>
                            <a href="mailto:<?php echo SITE_EMAIL; ?>"><?php echo SITE_EMAIL; ?></a>
                        </div>
                    </div>

                    <div class="contact-method">
                        <div class="method-icon">📞</div>
                        <div class="method-details">
                            <h3>Call Us</h3>
                            <a href="tel:<?php echo SITE_PHONE; ?>"><?php echo SITE_PHONE; ?></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contact-form-wrapper animate-up delay-2">
                <?php if (!empty($product_name)): ?>
                    <div class="product-inquiry-banner">
                        <div class="method-icon" style="width: 40px; height: 40px; font-size: 1.2rem;">📦</div>
                        <div class="product-inquiry-info">
                            <h4>Product Inquiry</h4>
                            <p>You're inquiring about: <strong><?php echo htmlspecialchars($product_name); ?></strong></p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="form-header">
                    <h2><?php echo !empty($product_name) ? "Request Quote" : "Send a Message"; ?></h2>
                    <p><?php echo !empty($product_name) ? "Tell us your requirements for this product." : "Tell us about your project or requirement."; ?></p>
                </div>

                <form method="POST" action="process-contact.php" id="contactForm">
                    <div class="honeypot">
                        <label for="website">Website</label>
                        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <?php if (!empty($product_name)): ?>
                        <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>">
                        <?php if ($product_id > 0): ?>
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <?php endif; ?>
                    <?php endif; ?>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name" class="required">Full Name</label>
                            <input type="text" id="name" name="name" class="form-input" required 
                                   value="<?php echo htmlspecialchars($form_data['name'] ?? ''); ?>"
                                   placeholder="John Doe">
                        </div>
                        <div class="form-group">
                            <label for="email" class="required">Email</label>
                            <input type="email" id="email" name="email" class="form-input" required 
                                   value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>"
                                   placeholder="john@company.com">
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" class="form-input"
                                   value="<?php echo htmlspecialchars($form_data['phone'] ?? ''); ?>"
                                   placeholder="+91 9876543210">
                        </div>
                        
                        <?php if (empty($product_name)): ?>
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <select id="subject" name="subject" class="form-input">
                                    <option value="">Select a subject</option>
                                    <option value="general">General Inquiry</option>
                                    <option value="quote">Request Quote</option>
                                    <option value="technical">Technical Support</option>
                                    <option value="partnership">Partnership</option>
                                </select>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="message" class="required">Message</label>
                        <textarea id="message" name="message" class="form-input" rows="5" required placeholder="How can we help you?"><?php echo htmlspecialchars($form_data['message'] ?? ''); ?></textarea>
                    </div>

                    <button type="submit" class="btn-submit">
                        <?php echo !empty($product_name) ? "Request Quote ➜" : "Send Message ➜"; ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="map-section animate-up delay-2">
    <div class="map-overlay-card">
        <div class="location-pointer">
            <div class="pointer-icon">📍</div>
            <div>
                <h3 style="color: var(--text-main); margin: 0; font-size: 1.3rem; font-weight: 800;">Head Office</h3>
                <span style="color: var(--primary-red); font-size: 0.85rem; text-transform: uppercase; font-weight: 700;">techAsia Mechatronics</span>
            </div>
        </div>
        
        <p style="color: var(--text-muted); line-height: 1.5; margin-bottom: 25px; font-size: 0.95rem;">
            302, Pandurang Smruti C, H.S,<br>
            Dawadi Gaon Rd, near Regency Estate,<br>
            Shivshakti Nagar, Sonar Pada,<br>
            Dombivli East, Maharashtra 421203
        </p>
        
        <a href="https://maps.app.goo.gl/rxAkECeZoMVR7u228" target="_blank" class="map-btn">
            Get Directions ↗
        </a>
    </div>

    <iframe 
        class="map-frame" 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d961881.8126551467!2d72.50688727790582!3d19.655032395298505!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7bf878e333687%3A0xe888f9ff8893f96e!2stechAsia%20Mechatronics%20Private%20Limited!5e0!3m2!1sen!2sin!4v1766236965727!5m2!1sen!2sin" 
        width="600" 
        height="450" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</section>

<script>
    // Simple Form Validation & Loading State
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        const btn = this.querySelector('.btn-submit');
        const originalText = btn.innerText;
        btn.innerText = 'Sending...';
        btn.style.opacity = '0.7';
    });
</script>

<?php include 'includes/footer.php'; ?>