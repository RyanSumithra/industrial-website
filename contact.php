<?php 
require_once 'includes/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_page = 'contact';
$page_title = 'Contact Us | ' . SITE_NAME;

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
    /* Animations */
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-up { animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
    .delay-1 { animation-delay: 0.1s; } .delay-2 { animation-delay: 0.2s; }

    /* Page Hero */
    .page-hero {
        background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)),
                    repeating-linear-gradient(90deg, transparent, transparent 20px, rgba(255, 51, 51, 0.03) 20px, rgba(255, 51, 51, 0.03) 21px),
                    linear-gradient(180deg, #050505 0%, #111 100%);
        padding: 100px 0 80px;
        border-bottom: 1px solid #222;
        text-align: center;
    }
    .page-hero h1 { font-size: 3.5rem; font-weight: 900; color: white; margin-bottom: 1rem; letter-spacing: -1px; }
    .page-hero p { color: #888; font-size: 1.2rem; }

    /* Layout */
    .contact-wrapper { display: grid; grid-template-columns: 1fr 1.5fr; gap: 60px; margin-top: 40px; }
    @media(max-width: 900px) { .contact-wrapper { grid-template-columns: 1fr; } }

    /* Contact Info Cards */
    .contact-info-header h2 { color: white; font-size: 2rem; font-weight: 800; margin-bottom: 15px; }
    .contact-info-header p { color: #888; margin-bottom: 40px; line-height: 1.6; }

    .contact-method {
        display: flex; gap: 20px; margin-bottom: 30px;
        background: #0a0a0a; padding: 25px; border-radius: 8px; border: 1px solid #222;
        transition: 0.3s;
    }
    .contact-method:hover { border-color: var(--primary-red); transform: translateX(5px); }
    
    .method-icon {
        width: 50px; height: 50px; background: #151515; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
        border: 1px solid #333; color: white;
    }
    .method-details h3 { color: white; font-size: 1.1rem; margin-bottom: 5px; font-weight: 700; }
    .method-details p, .method-details address { color: #777; font-style: normal; margin: 0; font-size: 0.9rem; }
    .method-details a { color: #ccc; text-decoration: none; transition: 0.3s; }
    .method-details a:hover { color: var(--primary-red); }

    /* Form Styles */
    .contact-form-wrapper {
        background: #111; padding: 40px; border-radius: 12px; border: 1px solid #222;
        box-shadow: 0 20px 50px rgba(0,0,0,0.5); position: relative;
    }
    .contact-form-wrapper::before {
        content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px;
        background: linear-gradient(90deg, var(--primary-red), #990000);
    }
    .form-header h2 { color: white; margin-bottom: 10px; font-weight: 800; }
    .form-header p { color: #666; margin-bottom: 30px; }

    .form-group { margin-bottom: 20px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    @media(max-width: 600px) { .form-grid { grid-template-columns: 1fr; } }

    label { display: block; color: #ccc; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; }
    .required::after { content: " *"; color: var(--primary-red); }

    input, select, textarea {
        width: 100%; background: #0a0a0a; border: 1px solid #333; color: white;
        padding: 12px 15px; border-radius: 4px; font-family: inherit; font-size: 0.95rem;
        transition: 0.3s;
    }
    input:focus, select:focus, textarea:focus {
        border-color: var(--primary-red); outline: none; background: #0f0f0f;
        box-shadow: 0 0 10px rgba(255, 51, 51, 0.1);
    }
    
    .btn-submit {
        width: 100%; padding: 15px; font-size: 1rem; font-weight: 700;
        display: flex; justify-content: center; align-items: center; gap: 10px;
        margin-top: 10px; cursor: pointer;
    }
    .form-note { font-size: 0.8rem; color: #555; text-align: center; margin-top: 20px; }

    /* --- NEW MAP SECTION STYLES --- */
    .map-section { 
        position: relative; 
        height: 550px; 
        width: 100%; 
        overflow: hidden;
        border-top: 1px solid #222;
    }
    
    /* Dark Mode Map Filter */
    .map-frame {
        width: 100%;
        height: 100%;
        border: 0;
        filter: invert(90%) hue-rotate(180deg) brightness(95%) contrast(90%);
    }

    /* Floating Location Card */
    .map-overlay-card {
        position: absolute;
        top: 50%;
        left: 10%;
        transform: translateY(-50%);
        background: rgba(10, 10, 10, 0.95);
        backdrop-filter: blur(10px);
        padding: 40px;
        border-radius: 12px;
        border: 1px solid #333;
        border-left: 4px solid var(--primary-red);
        box-shadow: 0 20px 40px rgba(0,0,0,0.6);
        max-width: 400px;
        z-index: 10;
    }
    @media(max-width: 768px) {
        .map-overlay-card {
            position: relative; top: auto; left: auto; transform: none;
            width: 100%; max-width: 100%; border-radius: 0; border-left: none; border-bottom: 4px solid var(--primary-red);
        }
        .map-section { height: auto; display: flex; flex-direction: column-reverse; }
        .map-frame { height: 400px; }
    }

    .location-pointer {
        display: flex; align-items: center; gap: 15px; margin-bottom: 20px;
    }
    .pointer-icon { 
        font-size: 2rem; 
        animation: bounce 2s infinite; 
    }
    @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

    .map-btn {
        display: inline-flex; align-items: center; gap: 10px;
        background: white; color: black; font-weight: 700;
        padding: 12px 24px; border-radius: 4px; text-decoration: none;
        margin-top: 20px; transition: 0.3s;
    }
    .map-btn:hover { background: #ccc; transform: translateY(-2px); }

    .honeypot { display: none; }
</style>

<section class="page-hero">
    <div class="container animate-up">
        <h1>Contact <span style="color: var(--primary-red);">Us</span></h1>
        <p>Visit our Head Office in Dombivli or send us a message.</p>
    </div>
</section>

<section class="section contact-section" style="background: #050505; padding: 60px 0 100px;">
    <div class="container">
        
        <?php if ($success_message): ?>
            <div class="alert alert-success animate-up" style="background: rgba(40,167,69,0.1); border: 1px solid #28a745; color:#28a745; padding:15px; border-radius:6px; margin-bottom:30px;">
                <strong>Message Sent!</strong> Thank you. We will respond within 24 hours.
            </div>
        <?php endif; ?>

        <div class="contact-wrapper">
            
            <div class="contact-info animate-up delay-1">
                <div class="contact-info-header">
                    <h2>Get In Touch</h2>
                    <p>Ready to automate your operations? Reach out to our engineering team.</p>
                </div>

                <div class="contact-methods">
                    <div class="contact-method">
                        <div class="method-icon">📍</div>
                        <div class="method-details">
                            <h3>Head Office</h3>
                            <address style="line-height: 1.5;">
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
                <div class="form-header">
                    <h2>Send a Message</h2>
                    <p>Tell us about your project.</p>
                </div>

                <form method="POST" action="process-contact.php" id="contactForm">
                    <div class="honeypot">
                        <label for="website">Website</label>
                        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name" class="required">Full Name</label>
                            <input type="text" id="name" name="name" required placeholder="John Doe">
                        </div>
                        <div class="form-group">
                            <label for="email" class="required">Email</label>
                            <input type="email" id="email" name="email" required placeholder="john@company.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message" class="required">Message</label>
                        <textarea id="message" name="message" rows="5" required placeholder="How can we help you?"></textarea>
                    </div>

                    <button type="submit" class="btn-primary btn-submit">Send Message ➜</button>
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
                <h3 style="color: white; margin: 0; font-size: 1.5rem; font-weight: 800;">Head Office</h3>
                <span style="color: var(--primary-red); font-size: 0.9rem; text-transform: uppercase; font-weight: 700;">TechAsia Mecha</span>
            </div>
        </div>
        
        <p style="color: #ccc; line-height: 1.6; margin-bottom: 25px; font-size: 1rem;">
            302, Pandurang Smruti C, H.S,<br>
            Dawadi Gaon Rd, near Regency Estate,<br>
            Shivshakti Nagar, Sonar Pada,<br>
            Dombivli East, Maharashtra 421203
        </p>
        
        <a href="https://www.google.com/maps/search/?api=1&query=302+Pandurang+Smruti+C+Dombivli+East+421203" target="_blank" class="map-btn">
            Get Directions ↗
        </a>
    </div>

    <iframe 
        class="map-frame"
        src="https://maps.google.com/maps?q=302%2C%20Pandurang%20Smruti%20C%2C%20H.S%2C%20Dawadi%20Gaon%20Rd%2C%20near%20Regency%20Estate%2C%20Shivshakti%20Nagar%2C%20Sonar%20Pada%2C%20Dombivli%20East%2C%20Dombivli%2C%20Maharashtra%20421203&t=&z=15&ie=UTF8&iwloc=&output=embed"
        allowfullscreen
        loading="lazy">
    </iframe>
</section>

<?php include 'includes/footer.php'; ?>