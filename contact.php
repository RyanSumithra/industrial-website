<?php 
require_once 'includes/config.php';

$current_page = 'contact';
$page_title = 'Contact Us | ' . SITE_NAME;
$page_description = 'Get in touch with our industrial automation experts. We\'re here to help with your automation needs.';

// Handle form submission message
$success_message = isset($_GET['success']) ? true : false;
$error_message = isset($_GET['error']) ? true : false;

include 'includes/header.php'; 

?>

<!-- PAGE HEADER -->
<section class="hero" style="padding: 80px 0;">
    <div class="container">
        <div class="hero-content">
            <h1>Contact Us</h1>
            <p>Get in touch with our automation experts</p>
        </div>
    </div>
</section>

<!-- CONTACT SECTION -->
<section class="section">
    <div class="container">
        <?php if ($success_message): ?>
            <div style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; text-align: center;">
                <strong>Thank you!</strong> Your message has been sent successfully. We'll get back to you soon.
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; text-align: center;">
                <strong>Error!</strong> There was a problem sending your message. Please try again.
            </div>
        <?php endif; ?>

        <div class="contact-wrapper">
            <!-- Contact Information -->
            <div class="contact-info">
                <h3>Get In Touch</h3>
                <p style="margin-bottom: 2rem;">Have a question or need assistance? Our team is here to help you with all your industrial automation needs.</p>

                <div class="contact-item">
                    <div class="contact-icon">📧</div>
                    <div class="contact-details">
                        <h4>Email Us</h4>
                        <p><?php echo SITE_EMAIL; ?></p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">📞</div>
                    <div class="contact-details">
                        <h4>Call Us</h4>
                        <p><?php echo SITE_PHONE; ?></p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">📍</div>
                    <div class="contact-details">
                        <h4>Visit Us</h4>
                        <p><?php echo SITE_ADDRESS; ?></p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">🕒</div>
                    <div class="contact-details">
                        <h4>Business Hours</h4>
                        <p>Monday - Friday: 8:00 AM - 6:00 PM<br>
                        Saturday: 9:00 AM - 2:00 PM<br>
                        Sunday: Closed</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form">
                <h3 style="margin-bottom: 1.5rem;">Send Us a Message</h3>
                <form method="POST" action="process-contact.php" id="contactForm">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone">
                    </div>

                    <div class="form-group">
                        <label for="company">Company Name</label>
                        <input type="text" id="company" name="company">
                    </div>

                    <div class="form-group">
                        <label for="service">Service Interest</label>
                        <select id="service" name="service" style="width: 100%; padding: 12px 16px; border: 1px solid var(--gray-300); border-radius: 4px; font-family: var(--font-primary); font-size: 1rem;">
                            <option value="">Select a service...</option>
                            <option value="plc">PLC Automation</option>
                            <option value="panels">Control Panels</option>
                            <option value="electronics">Custom Electronics</option>
                            <option value="iot">IoT Solutions</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>