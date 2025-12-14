<footer class="footer" style="
    background-color: #050505; 
    color: #ffffff; 
    padding: 80px 0 30px; 
    border-top: 1px solid rgba(255, 51, 51, 0.2); 
    font-family: 'Inter', sans-serif;
    position: relative;
    overflow: hidden;
">
    <div style="
        position: absolute; top: 0; left: 20%; width: 400px; height: 1px; 
        box-shadow: 0 0 100px 5px rgba(255, 51, 51, 0.15); pointer-events: none;
    "></div>

    <div class="container">
        
        <div class="footer-content" style="
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
            gap: 4rem; 
            margin-bottom: 60px;
        ">
            
            <div class="footer-about">
                <a href="index.php" style="text-decoration: none; font-size: 1.8rem; font-weight: 800; color: #fff; display: block; margin-bottom: 1.5rem;">
                   AsiaTech<span style="color: #ff3333;"> Mechatronics</span>
                </a>
                <p style="color: #888; line-height: 1.7; margin-bottom: 2rem; font-size: 0.95rem;">
                    Leading provider of industrial automation, mechatronics engineering, and custom electronics solutions for modern manufacturing.
                </p>
                
                <div class="footer-contact" style="display: flex; flex-direction: column; gap: 12px;">
                    <div style="display: flex; align-items: center; gap: 10px; color: #ccc;">
                        <span style="color: #ff3333;">📧</span>
                        <a href="mailto:<?php echo defined('SITE_EMAIL') ? SITE_EMAIL : 'info@industrialtech.com'; ?>" style="color: #ccc; text-decoration: none; transition: 0.3s;" onmouseover="this.style.color='#ff3333'" onmouseout="this.style.color='#ccc'">
                            <?php echo defined('SITE_EMAIL') ? SITE_EMAIL : 'info@industrialtech.com'; ?>
                        </a>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; color: #ccc;">
                        <span style="color: #ff3333;">📞</span>
                        <a href="tel:<?php echo defined('SITE_PHONE') ? SITE_PHONE : '+1 (555) 123-4567'; ?>" style="color: #ccc; text-decoration: none; transition: 0.3s;" onmouseover="this.style.color='#ff3333'" onmouseout="this.style.color='#ccc'">
                            <?php echo defined('SITE_PHONE') ? SITE_PHONE : '+1 (555) 123-4567'; ?>
                        </a>
                    </div>
                </div>

                <div class="footer-social" style="margin-top: 2rem; display: flex; gap: 15px;">
                    <?php 
                        $socials = [
                            'Linkedin' => '💼', 
                            'Twitter' => '🐦', 
                            'Instagram' => '📸', 
                            'Youtube' => '📺'
                        ];
                        foreach($socials as $name => $icon) {
                            echo '<a href="#" style="
                                width: 40px; height: 40px; background: #1a1a1a; border-radius: 50%; 
                                display: flex; align-items: center; justify-content: center; 
                                text-decoration: none; font-size: 1.2rem; transition: all 0.3s ease;
                                border: 1px solid #333;
                            " onmouseover="this.style.background=\'#ff3333\'; this.style.borderColor=\'#ff3333\'; this.style.transform=\'translateY(-3px)\';" 
                              onmouseout="this.style.background=\'#1a1a1a\'; this.style.borderColor=\'#333\'; this.style.transform=\'translateY(0)\';">
                                '.$icon.'
                            </a>';
                        }
                    ?>
                </div>
            </div>

            <div class="footer-section">
                <h4 style="color: #fff; font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 1px;">Quick Links</h4>
                <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 12px;">
                    <li><a href="index.php" style="color: #888; text-decoration: none; transition: 0.3s;" onmouseover="this.style.color='#ff3333'; this.style.paddingLeft='5px'" onmouseout="this.style.color='#888'; this.style.paddingLeft='0'">Home</a></li>
                    <li><a href="about.php" style="color: #888; text-decoration: none; transition: 0.3s;" onmouseover="this.style.color='#ff3333'; this.style.paddingLeft='5px'" onmouseout="this.style.color='#888'; this.style.paddingLeft='0'">About Us</a></li>
                    <li><a href="services.php" style="color: #888; text-decoration: none; transition: 0.3s;" onmouseover="this.style.color='#ff3333'; this.style.paddingLeft='5px'" onmouseout="this.style.color='#888'; this.style.paddingLeft='0'">Services</a></li>
                    <li><a href="projects.php" style="color: #888; text-decoration: none; transition: 0.3s;" onmouseover="this.style.color='#ff3333'; this.style.paddingLeft='5px'" onmouseout="this.style.color='#888'; this.style.paddingLeft='0'">Projects</a></li>
                    <li><a href="contact.php" style="color: #888; text-decoration: none; transition: 0.3s;" onmouseover="this.style.color='#ff3333'; this.style.paddingLeft='5px'" onmouseout="this.style.color='#888'; this.style.paddingLeft='0'">Contact</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4 style="color: #fff; font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 1px;">Expertise</h4>
                <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 12px;">
                    <li><a href="services.php#plc" style="color: #888; text-decoration: none; transition: 0.3s;" onmouseover="this.style.color='#ff3333'; this.style.paddingLeft='5px'" onmouseout="this.style.color='#888'; this.style.paddingLeft='0'">PLC Automation</a></li>
                    <li><a href="services.php#panels" style="color: #888; text-decoration: none; transition: 0.3s;" onmouseover="this.style.color='#ff3333'; this.style.paddingLeft='5px'" onmouseout="this.style.color='#888'; this.style.paddingLeft='0'">Control Panels</a></li>
                    <li><a href="services.php#electronics" style="color: #888; text-decoration: none; transition: 0.3s;" onmouseover="this.style.color='#ff3333'; this.style.paddingLeft='5px'" onmouseout="this.style.color='#888'; this.style.paddingLeft='0'">Custom Electronics</a></li>
                    <li><a href="services.php#iot" style="color: #888; text-decoration: none; transition: 0.3s;" onmouseover="this.style.color='#ff3333'; this.style.paddingLeft='5px'" onmouseout="this.style.color='#888'; this.style.paddingLeft='0'">IoT Solutions</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4 style="color: #fff; font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 1px;">Stay Updated</h4>
                <p style="color: #888; margin-bottom: 1.5rem; font-size: 0.9rem;">Subscribe for technical updates.</p>
                
                <form class="newsletter-form" style="display: flex; gap: 0; margin-bottom: 2rem;">
                    <input type="email" placeholder="Email address" required style="
                        background: #111; border: 1px solid #333; color: white; padding: 12px 15px; 
                        width: 100%; outline: none; border-radius: 4px 0 0 4px;
                    " onfocus="this.style.borderColor='#ff3333'" onblur="this.style.borderColor='#333'">
                    
                    <button type="submit" style="
                        background: #ff3333; border: none; color: white; padding: 0 15px; 
                        cursor: pointer; border-radius: 0 4px 4px 0; transition: 0.3s;
                    " onmouseover="this.style.background='#cc0000'" onmouseout="this.style.background='#ff3333'">
                        ➜
                    </button>
                </form>
                
                <div class="footer-hours" style="background: #111; padding: 15px; border-radius: 6px; border-left: 3px solid #ff3333;">
                    <h5 style="color: #fff; font-size: 0.9rem; margin-bottom: 5px;">Business Hours</h5>
                    <p style="color: #888; font-size: 0.85rem; margin: 0;">Mon-Fri: 8AM - 6PM</p>
                    <p style="color: #888; font-size: 0.85rem; margin: 0;">Sat: 9AM - 2PM</p>
                </div>
            </div>

        </div>

        <div class="footer-bottom" style="
            border-top: 1px solid #1a1a1a; 
            padding-top: 25px; 
            display: flex; 
            flex-wrap: wrap; 
            justify-content: space-between; 
            align-items: center; 
            gap: 20px;
        ">
            <p class="copyright" style="color: #555; font-size: 0.9rem; margin: 0;">
                &copy; <?php echo date('Y'); ?> <?php echo defined('SITE_NAME') ? SITE_NAME : 'IndustrialTech'; ?>. All rights reserved.
            </p>
            
            <div class="footer-legal" style="display: flex; gap: 20px; flex-wrap: wrap;">
                <a href="#" style="color: #555; text-decoration: none; font-size: 0.9rem; transition: 0.3s;" onmouseover="this.style.color='#ff3333'" onmouseout="this.style.color='#555'">Privacy Policy</a>
                <a href="#" style="color: #555; text-decoration: none; font-size: 0.9rem; transition: 0.3s;" onmouseover="this.style.color='#ff3333'" onmouseout="this.style.color='#555'">Terms</a>
                <a href="#" style="color: #555; text-decoration: none; font-size: 0.9rem; transition: 0.3s;" onmouseover="this.style.color='#ff3333'" onmouseout="this.style.color='#555'">Cookies</a>
            </div>
        </div>
    </div>
</footer>

<button id="backToTop" style="
    position: fixed; bottom: 30px; right: 30px; 
    background: #ff3333; color: white; border: none; 
    width: 45px; height: 45px; border-radius: 50%; 
    cursor: pointer; display: none; align-items: center; justify-content: center;
    box-shadow: 0 4px 15px rgba(255, 51, 51, 0.4); z-index: 999;
    transition: all 0.3s ease;
" onclick="window.scrollTo({top: 0, behavior: 'smooth'});">
    ↑
</button>

<script>
    // Simple Back to Top Logic
    window.addEventListener('scroll', function() {
        var btn = document.getElementById('backToTop');
        if (window.scrollY > 300) {
            btn.style.display = 'flex';
        } else {
            btn.style.display = 'none';
        }
    });

    // Mobile Menu Logic (Re-added just in case)
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    if(navToggle) {
        navToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            navToggle.classList.toggle('active');
        });
    }
</script>
</body>
</html>