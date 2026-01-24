<?php
?>
</main>
<footer class="site-footer">
    <div class="container footer-grid">
        <div>
            <h5>Services</h5>
            <ul>
                <li><a href="<?php echo esc_url(home_url('/fix-an-issue/')); ?>">Fix an Issue</a></li>
                <li><a href="<?php echo esc_url(home_url('/plans/')); ?>">Maintenance Plans</a></li>
                <li><a href="<?php echo esc_url(home_url('/build/')); ?>">Build Solutions</a></li>
                <li><a href="<?php echo esc_url(home_url('/knowledge-base/')); ?>">Knowledge Base</a></li>
            </ul>
        </div>
        <div>
            <h5>Company</h5>
            <ul>
                <li><a href="<?php echo esc_url(home_url('/about/')); ?>">About Us</a></li>
                <li><a href="<?php echo esc_url(home_url('/how-it-works/')); ?>">How It Works</a></li>
                <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a></li>
            </ul>
        </div>
        <div>
            <h5>Legal</h5>
            <ul>
                <li><a href="<?php echo esc_url(home_url('/privacy/')); ?>">Privacy Policy</a></li>
                <li><a href="<?php echo esc_url(home_url('/terms/')); ?>">Terms of Service</a></li>
                <li><a href="<?php echo esc_url(home_url('/refund-policy/')); ?>">Refund Policy</a></li>
            </ul>
        </div>
        <div>
            <h5>Contact</h5>
            <ul>
                <li><a href="mailto:support@aakaari.com">support@aakaari.com</a></li>
                <li class="muted">Response within 24 hours</li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container footer-bottom-inner">
            <span class="muted">&copy; <?php echo esc_html(date('Y')); ?> Aakaari. All rights reserved.</span>
            <span class="muted">Professional WordPress &amp; WooCommerce support with fixed pricing.</span>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
