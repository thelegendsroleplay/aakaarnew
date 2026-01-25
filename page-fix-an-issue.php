<?php
get_header();

$issue_cards = [
    [
        'category' => __('WordPress Core', 'aakaari'),
        'title' => __('White Screen of Death (WSOD)', 'aakaari'),
        'description' => __('Your WordPress site displays a blank white screen with no error messages.', 'aakaari'),
        'symptoms' => [
            __('Blank white screen on frontend', 'aakaari'),
            __('White screen on admin dashboard', 'aakaari'),
            __('+2 more...', 'aakaari'),
        ],
        'price' => '$79',
        'eta' => __('ETA: 24 hours', 'aakaari'),
    ],
    [
        'category' => __('WooCommerce', 'aakaari'),
        'title' => __('WooCommerce Checkout Not Working', 'aakaari'),
        'description' => __('Customers cannot complete purchases on your WooCommerce store.', 'aakaari'),
        'symptoms' => [
            __('Place order button not working', 'aakaari'),
            __('Payment gateway errors', 'aakaari'),
            __('+2 more...', 'aakaari'),
        ],
        'price' => '$99',
        'eta' => __('ETA: 24 hours', 'aakaari'),
    ],
    [
        'category' => __('Performance', 'aakaari'),
        'title' => __('Slow Loading Website', 'aakaari'),
        'description' => __('Your WordPress site takes too long to load, affecting user experience and SEO.', 'aakaari'),
        'symptoms' => [
            __('Pages take more than 3 seconds to load', 'aakaari'),
            __('High bounce rates', 'aakaari'),
            __('+2 more...', 'aakaari'),
        ],
        'price' => '$129',
        'eta' => __('ETA: 48 hours', 'aakaari'),
    ],
    [
        'category' => __('Security', 'aakaari'),
        'title' => __('Hacked Site / Malware Removal', 'aakaari'),
        'description' => __('Your site has been compromised with malware or hacked content.', 'aakaari'),
        'symptoms' => [
            __('Google safe browsing warning', 'aakaari'),
            __('Redirects to spam sites', 'aakaari'),
            __('+2 more...', 'aakaari'),
        ],
        'price' => '$199',
        'eta' => __('ETA: 48 hours', 'aakaari'),
    ],
    [
        'category' => __('Custom Code / PHP', 'aakaari'),
        'title' => __('PHP Fatal Error', 'aakaari'),
        'description' => __('Your site shows PHP errors or stops working due to code issues.', 'aakaari'),
        'symptoms' => [
            __('PHP error messages on screen', 'aakaari'),
            __('Site partially broken', 'aakaari'),
            __('+2 more...', 'aakaari'),
        ],
        'price' => '$89',
        'eta' => __('ETA: 24 hours', 'aakaari'),
    ],
    [
        'category' => __('WordPress Core', 'aakaari'),
        'title' => __('My Issue Is Not Listed', 'aakaari'),
        'description' => __('Describe your unique WordPress or WooCommerce problem.', 'aakaari'),
        'symptoms' => [
            __('Custom issue', 'aakaari'),
            __('Unique problem', 'aakaari'),
            __('+1 more...', 'aakaari'),
        ],
        'price' => '$49',
        'eta' => __('ETA: 24 hours', 'aakaari'),
    ],
];
?>

<section class="section issue-hero">
    <div class="container issue-hero-inner" data-animate>
        <h1>Fix an Issue</h1>
        <p class="lead">Select your specific problem and get a fixed price instantly. Pay first, share details after.</p>
        <div class="issue-filters">
            <button class="filter-pill is-active" type="button">All Issues</button>
            <button class="filter-pill" type="button">WordPress Core</button>
            <button class="filter-pill" type="button">WooCommerce</button>
            <button class="filter-pill" type="button">Performance</button>
            <button class="filter-pill" type="button">Security</button>
            <button class="filter-pill" type="button">Custom Code / PHP</button>
        </div>
    </div>
</section>

<section class="section">
    <div class="container" data-animate>
        <div class="grid grid-3 issue-detail-grid">
            <?php foreach ($issue_cards as $card) : ?>
                <div class="card issue-detail-card" data-animate>
                    <span class="issue-tag"><?php echo esc_html($card['category']); ?></span>
                    <h3><?php echo esc_html($card['title']); ?></h3>
                    <p class="muted"><?php echo esc_html($card['description']); ?></p>
                    <div class="issue-symptoms">
                        <strong>Common symptoms:</strong>
                        <ul>
                            <?php foreach ($card['symptoms'] as $symptom) : ?>
                                <li><?php echo esc_html($symptom); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="issue-pricing">
                        <div>
                            <span class="price-label">Starting from</span>
                            <span class="issue-eta"><?php echo esc_html($card['eta']); ?></span>
                        </div>
                        <span class="issue-price"><?php echo esc_html($card['price']); ?></span>
                    </div>
                    <a class="btn btn-primary issue-action" href="<?php echo esc_url(home_url('/fix-an-issue/')); ?>">
                        Select &amp; Choose Tier
                        <span aria-hidden="true">→</span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="card issue-callout" data-animate>
            <div>
                <h3>Can't find your issue?</h3>
                <p class="muted">Select "My Issue Is Not Listed" for a diagnostic analysis. We'll provide a fixed price quote after reviewing your specific problem.</p>
            </div>
            <a class="btn btn-outline" href="<?php echo esc_url(home_url('/contact/')); ?>">
                Describe Your Issue
                <span aria-hidden="true">→</span>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
