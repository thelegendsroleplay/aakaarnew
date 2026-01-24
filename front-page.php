<?php
get_header();

$issue_products = aakaari_get_issue_products(4);
$placeholders = [
    [
        'title' => __('WooCommerce Checkout Not Working', 'aakaari'),
        'price' => __('From $49', 'aakaari'),
    ],
    [
        'title' => __('Payment Gateway Not Working', 'aakaari'),
        'price' => __('From $59', 'aakaari'),
    ],
    [
        'title' => __('WordPress Critical Error', 'aakaari'),
        'price' => __('From $69', 'aakaari'),
    ],
    [
        'title' => __('Website Speed Optimization', 'aakaari'),
        'price' => __('From $79', 'aakaari'),
    ],
];
?>

<section class="section hero">
    <div class="container hero-grid">
        <div class="hero-content">
            <span class="badge">Premium WordPress Fixes</span>
            <h1>Fix WordPress &amp; WooCommerce issues — fast.</h1>
            <p class="lead">Choose your issue, pay a fixed price, share details after checkout. No bidding. No delays.</p>
            <div class="button-group">
                <a class="btn btn-primary" href="<?php echo esc_url(home_url('/fix-an-issue/')); ?>">Fix an Issue</a>
                <a class="btn btn-outline" href="<?php echo esc_url(home_url('/plans/')); ?>">View Plans</a>
            </div>
            <div class="trust-badges">
                <span class="badge badge-light">Fixed pricing</span>
                <span class="badge badge-light">Upgrade or refund</span>
                <span class="badge badge-light">Secure payments</span>
                <span class="badge badge-light">Delivery tracking</span>
            </div>
        </div>
        <div class="hero-cards hero-panel">
            <div class="grid grid-2">
                <?php for ($i = 0; $i < 4; $i++) : ?>
                    <?php $product = $issue_products[$i] ?? null; ?>
                    <div class="card issue-card">
                        <h3>
                            <?php if ($product) : ?>
                                <?php echo esc_html($product->get_name()); ?>
                            <?php else : ?>
                                <?php echo esc_html($placeholders[$i]['title']); ?>
                            <?php endif; ?>
                        </h3>
                        <p class="price">
                            <?php if ($product && $product->get_price()) : ?>
                                <?php echo wp_kses_post(wc_price($product->get_price())); ?>
                            <?php else : ?>
                                <?php echo esc_html($placeholders[$i]['price']); ?>
                            <?php endif; ?>
                        </p>
                        <p class="muted">Typical: 24–72h</p>
                        <a class="btn btn-outline" href="<?php echo esc_url($product ? $product->get_permalink() : home_url('/fix-an-issue/')); ?>">Select</a>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>

<section class="section section-muted">
    <div class="container">
        <div class="section-heading">
            <span class="section-eyebrow">How it works</span>
            <h2>How it works</h2>
            <p class="muted">Issue-as-product means you know the price and timeline before you start.</p>
        </div>
        <div class="grid grid-3">
            <div class="card">
                <h3>1. Choose issue</h3>
                <p class="muted">Pick the closest issue from our catalog of fixes.</p>
            </div>
            <div class="card">
                <h3>2. Pay fixed price</h3>
                <p class="muted">Checkout securely with transparent pricing.</p>
            </div>
            <div class="card">
                <h3>3. Share details → We fix</h3>
                <p class="muted">Provide access, then track progress and delivery.</p>
            </div>
        </div>
        <p class="microcopy">If the selected tier doesn’t match complexity, we’ll offer a clear upgrade or a full refund.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading">
            <span class="section-eyebrow">Fix categories</span>
            <h2>Fix categories</h2>
            <p class="muted">Get help across core WordPress, WooCommerce, and custom builds.</p>
        </div>
        <div class="grid grid-5">
            <div class="card">
                <h3>WordPress Core</h3>
                <ul>
                    <li>Critical errors</li>
                    <li>Plugin conflicts</li>
                    <li>Login issues</li>
                </ul>
                <a class="text-link" href="<?php echo esc_url(home_url('/fix-an-issue/')); ?>">Browse</a>
            </div>
            <div class="card">
                <h3>WooCommerce</h3>
                <ul>
                    <li>Checkout bugs</li>
                    <li>Cart issues</li>
                    <li>Payment failures</li>
                </ul>
                <a class="text-link" href="<?php echo esc_url(home_url('/fix-an-issue/')); ?>">Browse</a>
            </div>
            <div class="card">
                <h3>Performance</h3>
                <ul>
                    <li>Speed tuning</li>
                    <li>Query cleanup</li>
                    <li>Cache setup</li>
                </ul>
                <a class="text-link" href="<?php echo esc_url(home_url('/fix-an-issue/')); ?>">Browse</a>
            </div>
            <div class="card">
                <h3>Security</h3>
                <ul>
                    <li>Malware cleanup</li>
                    <li>Hardening</li>
                    <li>Access audits</li>
                </ul>
                <a class="text-link" href="<?php echo esc_url(home_url('/fix-an-issue/')); ?>">Browse</a>
            </div>
            <div class="card">
                <h3>Custom Code / PHP</h3>
                <ul>
                    <li>Theme fixes</li>
                    <li>Custom plugins</li>
                    <li>API integrations</li>
                </ul>
                <a class="text-link" href="<?php echo esc_url(home_url('/fix-an-issue/')); ?>">Browse</a>
            </div>
        </div>
    </div>
</section>

<section class="section section-muted">
    <div class="container">
        <div class="section-heading">
            <span class="section-eyebrow">Maintenance Plans</span>
            <h2>Maintenance Plans</h2>
            <p class="muted">Ongoing care for growing WordPress and WooCommerce sites.</p>
        </div>
        <div class="grid grid-3">
            <div class="card">
                <span class="badge">Basic Care</span>
                <p class="muted">Best for brochure sites.</p>
                <ul>
                    <li>Core &amp; plugin updates</li>
                    <li>Monthly health checks</li>
                    <li>Email support</li>
                </ul>
                <p class="price">Starting from $79/mo</p>
                <a class="btn btn-outline" href="<?php echo esc_url(home_url('/plans/')); ?>">View Plans</a>
            </div>
            <div class="card">
                <span class="badge">Business Care</span>
                <p class="muted">Best for marketing teams.</p>
                <ul>
                    <li>Weekly updates</li>
                    <li>Performance monitoring</li>
                    <li>Priority response</li>
                </ul>
                <p class="price">Starting from $149/mo</p>
                <a class="btn btn-outline" href="<?php echo esc_url(home_url('/plans/')); ?>">View Plans</a>
            </div>
            <div class="card">
                <span class="badge">Store Care</span>
                <p class="muted">Best for WooCommerce stores.</p>
                <ul>
                    <li>Daily backups</li>
                    <li>Checkout monitoring</li>
                    <li>Incident response</li>
                </ul>
                <p class="price">Starting from $249/mo</p>
                <a class="btn btn-outline" href="<?php echo esc_url(home_url('/plans/')); ?>">View Plans</a>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading">
            <span class="section-eyebrow">Build Solutions</span>
            <h2>Build Solutions</h2>
            <p class="muted">From ecommerce launches to custom workflows.</p>
        </div>
        <div class="grid grid-3">
            <div class="card">
                <h3>WooCommerce Store Setup</h3>
                <p class="muted">Launch a clean, conversion-ready store.</p>
            </div>
            <div class="card">
                <h3>Custom WooCommerce Features</h3>
                <p class="muted">Subscriptions, bundles, and bespoke flows.</p>
            </div>
            <div class="card">
                <h3>Custom PHP Website</h3>
                <p class="muted">Build fast, secure, scalable web apps.</p>
            </div>
        </div>
        <a class="btn btn-primary" href="<?php echo esc_url(home_url('/build/')); ?>">Build Solutions</a>
    </div>
</section>

<section class="section section-muted">
    <div class="container">
        <div class="section-heading">
            <span class="section-eyebrow">Proof + Trust</span>
            <h2>Trusted by busy teams</h2>
            <p class="muted">Clear scope, clear delivery.</p>
        </div>
        <div class="grid grid-3">
            <div class="card">
                <p>“Aakaari resolved a critical checkout bug within 48 hours. Clear updates throughout.”</p>
                <p class="muted">— Store Operator</p>
            </div>
            <div class="card">
                <p>“Fixed pricing made it easy to approve. The upgrade option was transparent.”</p>
                <p class="muted">— Product Lead</p>
            </div>
            <div class="card">
                <p>“Great communication and delivery tracking. We’ll use Aakaari again.”</p>
                <p class="muted">— Agency Partner</p>
            </div>
        </div>
        <div class="trust-strip">
            <span>Clear scope</span>
            <span>Professional process</span>
            <span>Tracked delivery</span>
            <span>Invoices &amp; history</span>
        </div>
    </div>
</section>

<section class="section cta-strip">
    <div class="container cta-inner">
        <h2>Fix it today — choose your issue now.</h2>
        <a class="btn btn-primary" href="<?php echo esc_url(home_url('/fix-an-issue/')); ?>">Fix an Issue</a>
    </div>
</section>

<?php get_footer(); ?>
