<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <!-- Company Info -->
            <div class="footer-about">
                <a href="index.php" class="footer-logo">
                    <span>INDUSTRIAL</span>TECH
                </a>
                <p class="footer-description">Leading provider of industrial automation, mechatronics engineering, and custom electronics solutions for modern manufacturing.</p>
                
                <div class="footer-contact">
                    <div class="contact-item">
                        <span class="contact-icon">📧</span>
                        <a href="mailto:<?php echo SITE_EMAIL; ?>"><?php echo SITE_EMAIL; ?></a>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon">📞</span>
                        <a href="tel:<?php echo SITE_PHONE; ?>"><?php echo SITE_PHONE; ?></a>
                    </div>
                </div>
                
                <div class="footer-social">
                    <a href="<?php echo SOCIAL_LINKEDIN; ?>" target="_blank" class="social-link" aria-label="LinkedIn">
                        <span class="social-icon">💼</span>
                    </a>
                    <a href="<?php echo SOCIAL_TWITTER; ?>" target="_blank" class="social-link" aria-label="Twitter">
                        <span class="social-icon">🐦</span>
                    </a>
                    <a href="<?php echo SOCIAL_INSTAGRAM; ?>" target="_blank" class="social-link" aria-label="Instagram">
                        <span class="social-icon">📸</span>
                    </a>
                    <a href="<?php echo SOCIAL_YOUTUBE; ?>" target="_blank" class="social-link" aria-label="YouTube">
                        <span class="social-icon">📺</span>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="footer-section">
                <h4 class="footer-heading">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="index.php" class="footer-link">Home</a></li>
                    <li><a href="about.php" class="footer-link">About Us</a></li>
                    <li><a href="services.php" class="footer-link">Services</a></li>
                    <li><a href="projects.php" class="footer-link">Projects</a></li>
                    <li><a href="contact.php" class="footer-link">Contact</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div class="footer-section">
                <h4 class="footer-heading">Services</h4>
                <ul class="footer-links">
                    <li><a href="services.php#plc" class="footer-link">PLC Automation</a></li>
                    <li><a href="services.php#panels" class="footer-link">Control Panels</a></li>
                    <li><a href="services.php#electronics" class="footer-link">Custom Electronics</a></li>
                    <li><a href="services.php#iot" class="footer-link">IoT Solutions</a></li>
                    <li><a href="services.php" class="footer-link">All Services</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="footer-section">
                <h4 class="footer-heading">Stay Updated</h4>
                <p class="footer-newsletter-text">Subscribe to our newsletter for the latest in industrial automation.</p>
                <form class="newsletter-form" id="newsletterForm">
                    <div class="form-group">
                        <input type="email" placeholder="Your email address" required>
                        <button type="submit" class="btn-newsletter">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </form>
                
                <div class="footer-hours">
                    <h5>Business Hours</h5>
                    <p>Mon-Fri: 8AM-6PM</p>
                    <p>Sat: 9AM-2PM</p>
                    <p>Sun: Closed</p>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <p class="copyright">&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
                
                <div class="footer-legal">
                    <a href="#" class="legal-link">Privacy Policy</a>
                    <a href="#" class="legal-link">Terms of Service</a>
                    <a href="#" class="legal-link">Cookie Policy</a>
                    <a href="sitemap.php" class="legal-link">Sitemap</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button class="back-to-top" id="backToTop" aria-label="Back to top">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M18 15l-6-6-6 6"/>
    </svg>
</button>

<!-- JavaScript -->
<script src="js/main.js"></script>
</body>
</html>