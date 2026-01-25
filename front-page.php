<?php
get_header();

$issue_products = aakaari_get_issue_products(6);
$placeholders = [
    [
        'title' => __('White Screen of Death (WSOD)', 'aakaari'),
        'price' => __('From $79', 'aakaari'),
        'duration' => __('24 hours', 'aakaari'),
        'description' => __('Your WordPress site displays a blank white screen with no error message.', 'aakaari'),
        'badge' => __('Popular', 'aakaari'),
    ],
    [
        'title' => __('WooCommerce Checkout Not Working', 'aakaari'),
        'price' => __('From $99', 'aakaari'),
        'duration' => __('24 hours', 'aakaari'),
        'description' => __('Customers cannot complete purchases on your WooCommerce checkout.', 'aakaari'),
        'badge' => __('Popular', 'aakaari'),
    ],
    [
        'title' => __('Slow Loading Website', 'aakaari'),
        'price' => __('From $129', 'aakaari'),
        'duration' => __('48 hours', 'aakaari'),
        'description' => __('Your WordPress site takes too long to load, affecting user experience.', 'aakaari'),
        'badge' => __('Popular', 'aakaari'),
    ],
    [
        'title' => __('Hacked Site / Malware Removal', 'aakaari'),
        'price' => __('From $199', 'aakaari'),
        'duration' => __('48 hours', 'aakaari'),
        'description' => __('Your site has been compromised with malware or hacked content.', 'aakaari'),
        'badge' => __('Popular', 'aakaari'),
    ],
    [
        'title' => __('PHP Fatal Error', 'aakaari'),
        'price' => __('From $89', 'aakaari'),
        'duration' => __('24 hours', 'aakaari'),
        'description' => __('Your site shows PHP errors or stops working due to code issues.', 'aakaari'),
        'badge' => __('Popular', 'aakaari'),
    ],
    [
        'title' => __('My Issue Is Not Listed', 'aakaari'),
        'price' => __('From $49', 'aakaari'),
        'duration' => __('24 hours', 'aakaari'),
        'description' => __('Describe your unique WordPress or WooCommerce problem.', 'aakaari'),
        'badge' => __('Popular', 'aakaari'),
    ],
];
?>

<section class="section hero hero-centered">
    <div class="container hero-content hero-animate" data-animate>
        <div class="hero-pill">
            <span class="pill-dot"></span>
            Premium WordPress &amp; WooCommerce Support Platform
        </div>
        <h1 class="hero-title">
            Fix WordPress Issues
            <span class="hero-highlight">Fast &amp; Fair</span>
        </h1>
        <p class="hero-subtitle">Choose your issue. Pay a fixed price. Share details. Get it fixed.</p>
        <p class="hero-note">No bidding. No surprises. No delays.</p>
        <div class="button-group hero-actions">
            <a class="btn btn-primary" href="<?php echo esc_url(home_url('/fix-an-issue/')); ?>">
                Fix an Issue Now
                <span aria-hidden="true">→</span>
            </a>
            <a class="btn btn-outline" href="<?php echo esc_url(home_url('/plans/')); ?>">View Maintenance Plans</a>
        </div>
        <div class="trust-cards" data-animate>
            <div class="trust-card">
                <span class="trust-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" role="img">
                        <circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="2" />
                        <path d="M8 12.5l2.5 2.5L16 9.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                <span>Fixed Pricing</span>
            </div>
            <div class="trust-card">
                <span class="trust-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" role="img">
                        <path d="M12 3v4m0 10v4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        <path d="M6 7a7 7 0 1 1-1 7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        <path d="M5 14l-1.5 3.5L7 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                <span>Upgrade or Refund</span>
            </div>
            <div class="trust-card">
                <span class="trust-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" role="img">
                        <rect x="6" y="11" width="12" height="8" rx="2" fill="none" stroke="currentColor" stroke-width="2" />
                        <path d="M8 11V8a4 4 0 0 1 8 0v3" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </span>
                <span>Secure Payments</span>
            </div>
            <div class="trust-card">
                <span class="trust-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" role="img">
                        <circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="2" />
                        <path d="M12 7v5l3 2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                <span>Delivery Tracking</span>
            </div>
        </div>
    </div>
</section>

<section class="section section-muted">
    <div class="container" data-animate>
        <div class="section-heading center issues-heading">
            <h2>Popular Issues We Fix</h2>
            <p class="muted">Browse our most common fixes with transparent, fixed pricing</p>
        </div>
        <div class="grid grid-3 issues-grid">
            <?php for ($i = 0; $i < 6; $i++) : ?>
                <?php $product = $issue_products[$i] ?? null; ?>
                <div class="card issue-card issue-card-alt" data-animate>
                    <div class="issue-card-header">
                        <div class="issue-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" role="img">
                                <path d="M13 2L3 14h7l-1 8 12-14h-7l1-8z" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <span class="issue-badge"><?php echo esc_html($placeholders[$i]['badge']); ?></span>
                    </div>
                    <div class="issue-card-body">
                        <h3>
                            <?php if ($product) : ?>
                                <?php echo esc_html($product->get_name()); ?>
                            <?php else : ?>
                                <?php echo esc_html($placeholders[$i]['title']); ?>
                            <?php endif; ?>
                        </h3>
                        <p class="muted">
                            <?php
                            if ($product && $product->get_short_description()) {
                                echo wp_kses_post(wp_trim_words($product->get_short_description(), 18));
                            } else {
                                echo esc_html($placeholders[$i]['description']);
                            }
                            ?>
                        </p>
                    </div>
                    <div class="issue-card-price">
                        <span class="price-label">Starting at</span>
                        <span class="price-amount">
                            <?php if ($product && $product->get_price()) : ?>
                                <?php echo wp_kses_post(wc_price($product->get_price())); ?>
                            <?php else : ?>
                                <?php echo esc_html(str_replace('From ', '', $placeholders[$i]['price'])); ?>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="issue-card-meta">
                        <span class="meta-item">
                            <span class="meta-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" role="img">
                                    <circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="2" />
                                    <path d="M12 7v5l3 2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <?php echo esc_html($product ? __('24 hours', 'aakaari') : $placeholders[$i]['duration']); ?>
                        </span>
                        <span class="meta-item">Fixed Price</span>
                    </div>
                    <div class="issue-card-footer">
                        <a class="btn btn-primary" href="<?php echo esc_url($product ? $product->get_permalink() : home_url('/fix-an-issue/')); ?>">
                            View Details
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        <div class="center" data-animate>
            <a class="btn btn-outline" href="<?php echo esc_url(home_url('/fix-an-issue/')); ?>">
                View All Issues
                <span aria-hidden="true">→</span>
            </a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container" data-animate>
        <div class="section-heading center">
            <h2>How It Works</h2>
            <p class="muted">Three simple steps to get your site fixed</p>
        </div>
        <div class="grid grid-3 steps-grid">
            <div class="step-card" data-animate>
                <div class="step-number">1</div>
                <h3>Choose Issue</h3>
                <p class="muted">Select your specific WordPress or WooCommerce problem from our list.</p>
            </div>
            <div class="step-card" data-animate>
                <div class="step-number">2</div>
                <h3>Pay Fixed Price</h3>
                <p class="muted">Know exactly what you’ll pay. Choose Basic, Advanced, or Critical tier.</p>
            </div>
            <div class="step-card" data-animate>
                <div class="step-number">3</div>
                <h3>Share Details → We Fix</h3>
                <p class="muted">After payment, provide access details. We fix your issue within the timeframe.</p>
            </div>
        </div>
        <div class="notice-card" data-animate>
            <strong>Fair Pricing Guarantee:</strong> If the selected tier doesn’t match complexity, we’ll offer a clear upgrade or a full refund.
        </div>
    </div>
</section>

<section class="section section-muted">
    <div class="container" data-animate>
        <div class="section-heading center">
            <h2>Issue Categories</h2>
            <p class="muted">Find your specific problem type</p>
        </div>
        <div class="grid grid-3 categories-grid">
            <div class="card category-card" data-animate>
                <div class="category-icon">⌘</div>
                <h3>WordPress Core</h3>
            </div>
            <div class="card category-card" data-animate>
                <div class="category-icon">🛒</div>
                <h3>WooCommerce</h3>
            </div>
            <div class="card category-card" data-animate>
                <div class="category-icon">⚡</div>
                <h3>Performance</h3>
            </div>
            <div class="card category-card" data-animate>
                <div class="category-icon">🔒</div>
                <h3>Security</h3>
            </div>
            <div class="card category-card" data-animate>
                <div class="category-icon">↗</div>
                <h3>Custom Code / PHP</h3>
            </div>
            <div class="card category-card" data-animate>
                <div class="category-icon">→</div>
                <h3>My Issue Is Not Listed</h3>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container" data-animate>
        <div class="section-heading center">
            <h2>Maintenance Plans</h2>
            <p class="muted">Ongoing support and care for your WordPress site</p>
        </div>
        <div class="grid grid-3 plans-grid">
            <div class="card plan-card" data-animate>
                <h3>Basic Care</h3>
                <p class="muted">Small sites</p>
                <p class="price">$99<span class="muted">/month</span></p>
                <a class="btn btn-outline" href="<?php echo esc_url(home_url('/plans/')); ?>">Learn More</a>
            </div>
            <div class="card plan-card featured" data-animate>
                <span class="badge">Most Popular</span>
                <h3>Business Care</h3>
                <p class="muted">Business sites</p>
                <p class="price">$199<span class="muted">/month</span></p>
                <a class="btn btn-primary" href="<?php echo esc_url(home_url('/plans/')); ?>">Learn More</a>
            </div>
            <div class="card plan-card" data-animate>
                <h3>Store Care</h3>
                <p class="muted">WooCommerce stores</p>
                <p class="price">$299<span class="muted">/month</span></p>
                <a class="btn btn-outline" href="<?php echo esc_url(home_url('/plans/')); ?>">Learn More</a>
            </div>
        </div>
    </div>
</section>

<section class="section section-muted">
    <div class="container" data-animate>
        <div class="section-heading center">
            <h2>Build Solutions</h2>
            <p class="muted">Need something built from scratch? We can help.</p>
        </div>
        <div class="grid grid-3 build-grid">
            <div class="card build-card" data-animate>
                <h3>WooCommerce Store Setup</h3>
                <a class="btn btn-outline" href="<?php echo esc_url(home_url('/build/')); ?>">Request Quote</a>
            </div>
            <div class="card build-card" data-animate>
                <h3>Custom WooCommerce Features</h3>
                <a class="btn btn-outline" href="<?php echo esc_url(home_url('/build/')); ?>">Request Quote</a>
            </div>
            <div class="card build-card" data-animate>
                <h3>Custom PHP Website</h3>
                <a class="btn btn-outline" href="<?php echo esc_url(home_url('/build/')); ?>">Request Quote</a>
            </div>
        </div>
    </div>
</section>

<section class="section cta-strip">
    <div class="container cta-inner" data-animate>
        <div>
            <h2>Fix it today — choose your issue now.</h2>
            <p>Professional WordPress support with transparent, fixed pricing.</p>
        </div>
        <a class="btn btn-outline" href="<?php echo esc_url(home_url('/fix-an-issue/')); ?>">Fix an Issue →</a>
    </div>
</section>

<?php get_footer(); ?>
