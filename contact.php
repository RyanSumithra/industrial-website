<?php 
require_once 'includes/config.php';

$current_page = 'contact';
$page_title = 'Contact Us | ' . SITE_NAME;
$page_description = 'Get in touch with our industrial automation experts. We\'re here to help with your automation needs.';

// Handle form submission message
session_start();
$success_message = isset($_GET['success']) ? true : false;
$error_message = isset($_GET['error']) ? true : false;

// Retrieve form data from session if exists
$form_data = $_SESSION['form_data'] ?? [];
$form_errors = $_SESSION['form_errors'] ?? [];

// Clear session data
unset($_SESSION['form_data']);
unset($_SESSION['form_errors']);

include 'includes/header.php'; 

?>

<!-- PAGE HEADER -->
<section class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <h1>Contact Us</h1>
            <p>Get in touch with our automation experts</p>
        </div>
    </div>
</section>

<!-- CONTACT SECTION -->
<section class="section contact-section">
    <div class="container">
        <?php if ($success_message): ?>
            <div class="alert alert-success">
                <div class="alert-icon">✓</div>
                <div class="alert-content">
                    <strong>Thank you!</strong> Your message has been sent successfully. We'll get back to you within 24 hours.
                </div>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="alert alert-error">
                <div class="alert-icon">⚠️</div>
                <div class="alert-content">
                    <strong>Error!</strong> Please check the form and try again.
                    <?php if (!empty($form_errors)): ?>
                        <ul class="error-list">
                            <?php foreach ($form_errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="contact-wrapper">
            <!-- Contact Information -->
            <div class="contact-info">
                <div class="contact-info-header">
                    <h2>Get In Touch</h2>
                    <p>Have a question or need assistance? Our team is here to help you with all your industrial automation needs.</p>
                </div>

                <div class="contact-methods">
                    <div class="contact-method">
                        <div class="method-icon">📧</div>
                        <div class="method-details">
                            <h3>Email Us</h3>
                            <a href="mailto:<?php echo SITE_EMAIL; ?>"><?php echo SITE_EMAIL; ?></a>
                            <p>Typically respond within 2 hours</p>
                        </div>
                    </div>

                    <div class="contact-method">
                        <div class="method-icon">📞</div>
                        <div class="method-details">
                            <h3>Call Us</h3>
                            <a href="tel:<?php echo SITE_PHONE; ?>"><?php echo SITE_PHONE; ?></a>
                            <p>Monday - Friday, 8 AM - 6 PM EST</p>
                        </div>
                    </div>

                    <div class="contact-method">
                        <div class="method-icon">📍</div>
                        <div class="method-details">
                            <h3>Visit Us</h3>
                            <address><?php echo SITE_ADDRESS; ?></address>
                            <p>Schedule an appointment first</p>
                        </div>
                    </div>

                    <div class="contact-method">
                        <div class="method-icon">🕒</div>
                        <div class="method-details">
                            <h3>Business Hours</h3>
                            <p><strong>Monday - Friday:</strong> 8:00 AM - 6:00 PM</p>
                            <p><strong>Saturday:</strong> 9:00 AM - 2:00 PM</p>
                            <p><strong>Sunday:</strong> Closed</p>
                        </div>
                    </div>
                </div>

                <div class="contact-social">
                    <h3>Follow Us</h3>
                    <div class="social-links">
                        <a href="<?php echo SOCIAL_LINKEDIN; ?>" class="social-link" target="_blank">
                            <span class="social-icon">💼</span>
                            <span>LinkedIn</span>
                        </a>
                        <a href="<?php echo SOCIAL_TWITTER; ?>" class="social-link" target="_blank">
                            <span class="social-icon">🐦</span>
                            <span>Twitter</span>
                        </a>
                        <a href="<?php echo SOCIAL_INSTAGRAM; ?>" class="social-link" target="_blank">
                            <span class="social-icon">📸</span>
                            <span>Instagram</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-wrapper">
                <div class="form-header">
                    <h2>Send Us a Message</h2>
                    <p>Fill out the form below and we'll get back to you as soon as possible.</p>
                </div>

                <form method="POST" action="process-contact.php" id="contactForm" class="contact-form" novalidate>
                    <!-- Honeypot field -->
                    <div class="honeypot">
                        <label for="website">Website</label>
                        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name" class="required">Full Name</label>
                            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($form_data['name'] ?? ''); ?>" required placeholder="Enter your full name">
                            <div class="form-error" id="nameError"></div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="required">Email Address</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>" required placeholder="you@company.com">
                            <div class="form-error" id="emailError"></div>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($form_data['phone'] ?? ''); ?>" placeholder="+1 (555) 123-4567">
                        </div>

                        <div class="form-group">
                            <label for="company">Company Name</label>
                            <input type="text" id="company" name="company" value="<?php echo htmlspecialchars($form_data['company'] ?? ''); ?>" placeholder="Your company name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="service">Service Interest</label>
                        <select id="service" name="service" class="form-select">
                            <option value="">Select a service...</option>
                            <option value="plc" <?php echo ($form_data['service'] ?? '') == 'plc' ? 'selected' : ''; ?>>PLC Automation</option>
                            <option value="panels" <?php echo ($form_data['service'] ?? '') == 'panels' ? 'selected' : ''; ?>>Control Panels</option>
                            <option value="electronics" <?php echo ($form_data['service'] ?? '') == 'electronics' ? 'selected' : ''; ?>>Custom Electronics</option>
                            <option value="iot" <?php echo ($form_data['service'] ?? '') == 'iot' ? 'selected' : ''; ?>>IoT Solutions</option>
                            <option value="consultation" <?php echo ($form_data['service'] ?? '') == 'consultation' ? 'selected' : ''; ?>>Consultation</option>
                            <option value="other" <?php echo ($form_data['service'] ?? '') == 'other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message" class="required">Message</label>
                        <textarea id="message" name="message" rows="6" required placeholder="Tell us about your project or requirements..."><?php echo htmlspecialchars($form_data['message'] ?? ''); ?></textarea>
                        <div class="char-counter">
                            <span id="charCount">0</span>/1000 characters
                        </div>
                        <div class="form-error" id="messageError"></div>
                    </div>

                    <div class="form-group">
                        <div class="form-checkbox">
                            <input type="checkbox" id="newsletter" name="newsletter" checked>
                            <label for="newsletter">Subscribe to our newsletter for updates and insights</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-submit">
                        <span class="btn-text">Send Message</span>
                        <span class="btn-loader" style="display: none;">
                            <span class="loader-dot"></span>
                            <span class="loader-dot"></span>
                            <span class="loader-dot"></span>
                        </span>
                    </button>

                    <p class="form-note">By submitting this form, you agree to our <a href="#" class="link">Privacy Policy</a>.</p>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- MAP SECTION (Optional) -->
<section class="map-section">
    <div class="container">
        <div class="map-placeholder">
            <div class="map-content">
                <h3>Our Location</h3>
                <p><?php echo SITE_ADDRESS; ?></p>
                <a href="https://maps.google.com/?q=<?php echo urlencode(SITE_ADDRESS); ?>" target="_blank" class="btn btn-secondary btn-sm">
                    <span>Open in Maps</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                </a>
            </div>
            <div class="map-visual">🗺️</div>
        </div>
    </div>
</section>

<!-- FAQ SECTION -->
<section class="section faq-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-subtitle">Quick answers to common questions</p>
        </div>
        
        <div class="faq-grid">
            <div class="faq-item">
                <h3>What is your typical project timeline?</h3>
                <p>Project timelines vary based on complexity. Small projects take 4-8 weeks, while larger implementations may take 3-6 months. We provide detailed timelines during consultation.</p>
            </div>
            <div class="faq-item">
                <h3>Do you offer emergency support?</h3>
                <p>Yes, we provide 24/7 emergency support for all our clients. Our response time is typically under 2 hours for critical issues.</p>
            </div>
            <div class="faq-item">
                <h3>What industries do you serve?</h3>
                <p>We serve manufacturing, energy, food & beverage, pharmaceuticals, automotive, and logistics industries among others.</p>
            </div>
            <div class="faq-item">
                <h3>Do you provide training?</h3>
                <p>Yes, comprehensive training is included with every project to ensure your team can operate and maintain the systems effectively.</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>