<?php
?>
</main>
<footer class="site-footer">
    <div class="container footer-grid">
        <div>
            <h4>Aakaari</h4>
            <p class="muted">Premium WordPress & WooCommerce fixes with fixed pricing.</p>
        </div>
        <div>
            <h5>Services</h5>
            <ul>
                <li><a href="<?php echo esc_url(home_url('/fix-an-issue/')); ?>">Fix an Issue</a></li>
                <li><a href="<?php echo esc_url(home_url('/plans/')); ?>">Maintenance Plans</a></li>
                <li><a href="<?php echo esc_url(home_url('/build/')); ?>">Build Solutions</a></li>
            </ul>
        </div>
        <div>
            <h5>Company</h5>
            <ul>
                <li><a href="<?php echo esc_url(home_url('/knowledge-base/')); ?>">Knowledge Base</a></li>
                <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a></li>
                <li><a href="<?php echo esc_url(home_url('/about/')); ?>">About</a></li>
            </ul>
        </div>
        <div>
            <h5>Policies</h5>
            <ul>
                <li><a href="<?php echo esc_url(home_url('/privacy/')); ?>">Privacy</a></li>
                <li><a href="<?php echo esc_url(home_url('/terms/')); ?>">Terms</a></li>
                <li><a href="<?php echo esc_url(home_url('/refund-policy/')); ?>">Refund Policy</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container footer-bottom-inner">
            <span>&copy; <?php echo esc_html(date('Y')); ?> Aakaari. All rights reserved.</span>
            <span class="muted">Invoices, history, and delivery tracking included.</span>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
