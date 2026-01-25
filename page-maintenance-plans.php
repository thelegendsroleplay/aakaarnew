<?php
get_header();
?>

<section class="section plans-hero">
    <div class="container plans-hero-inner" data-animate>
        <span class="plans-pill">Maintenance Plans</span>
        <h1>Website Care That Actually Prevents Problems</h1>
        <p class="lead">Hosting keeps servers running. Aakaari keeps your website stable, secure, and updated — with real human checks.</p>
        <div class="plans-badges">
            <span class="badge badge-outline">Fixed monthly care</span>
            <span class="badge badge-outline">Manual checks (not just automation)</span>
            <span class="badge badge-outline">Clear limits (no hidden charges)</span>
            <span class="badge badge-outline">Upgrade anytime</span>
        </div>
        <div class="button-group plans-actions">
            <a class="btn btn-primary" href="#plans">Choose a Plan</a>
            <a class="btn btn-outline" href="<?php echo esc_url(home_url('/contact/')); ?>">Talk to Us</a>
        </div>
    </div>
</section>

<section class="section section-muted">
    <div class="container" data-animate>
        <div class="section-heading center">
            <h2>Why Not Just Hosting?</h2>
        </div>
        <div class="grid grid-2 comparison-grid">
            <div class="card comparison-card comparison-card-hosting" data-animate>
                <h3>Hosting Support</h3>
                <ul class="comparison-list comparison-list-hosting">
                    <li>Server uptime</li>
                    <li>Auto updates</li>
                    <li>Website bugs</li>
                    <li>WooCommerce checkout help</li>
                    <li>Plugin conflicts</li>
                    <li>Revenue protection</li>
                </ul>
            </div>
            <div class="card comparison-card comparison-card-care" data-animate>
                <h3>Aakaari Care</h3>
                <ul class="comparison-list comparison-list-care">
                    <li>Safe updates with backup</li>
                    <li>Fix small issues before they grow</li>
                    <li>WooCommerce testing (Store plan)</li>
                    <li>Human support</li>
                    <li>Clear reporting</li>
                </ul>
            </div>
        </div>
        <p class="comparison-footnote">Hosting manages servers. Aakaari manages your website.</p>
    </div>
</section>

<section class="section" id="plans">
    <div class="container" data-animate>
        <div class="section-heading center">
            <h2>Choose Your Plan</h2>
        </div>
        <div class="grid grid-3 plan-grid">
            <div class="card plan-card-alt plan-basic" data-animate>
                <div class="plan-header">
                    <h3>Basic Care</h3>
                    <span class="plan-kicker plan-kicker-green">Safe &amp; Updated</span>
                </div>
                <p class="plan-best">Best for: Simple websites, blogs, portfolios</p>
                <p class="plan-price">From $99<span class="plan-price-period">/mo</span></p>
                <p class="muted">Keep your site updated safely without breaking things.</p>
                <div class="plan-section">
                    <strong>Includes</strong>
                    <ul class="plan-list plan-list-includes">
                        <li>Monthly WordPress + plugin + theme updates (safe cycle)</li>
                        <li>Manual backup before updates</li>
                        <li>Restore support if update breaks the site</li>
                        <li>Basic security scan</li>
                        <li>Monthly manual check</li>
                        <li>Email support (48h)</li>
                    </ul>
                </div>
                <div class="plan-section">
                    <strong>Limits</strong>
                    <ul class="plan-list plan-list-limits">
                        <li>No free fixes</li>
                        <li>No WooCommerce monitoring</li>
                        <li>No custom development</li>
                    </ul>
                </div>
                <a class="btn btn-primary plan-button plan-button-green" href="<?php echo esc_url(home_url('/contact/')); ?>">Start Basic Care</a>
            </div>
            <div class="card plan-card-alt featured plan-business" data-animate>
                <span class="plan-popular">Most Popular</span>
                <div class="plan-header">
                    <h3>Business Care</h3>
                    <span class="plan-kicker plan-kicker-blue">Stable Growth ★</span>
                </div>
                <p class="plan-best">Best for: Business websites &amp; lead generation</p>
                <p class="plan-price">From $199<span class="plan-price-period">/mo</span></p>
                <p class="muted">Stability + security + small fixes — the best balance.</p>
                <div class="plan-section">
                    <strong>Includes</strong>
                    <ul class="plan-list plan-list-includes">
                        <li>Everything in Basic Care</li>
                        <li>Two checkups per month</li>
                        <li>Monthly performance cleanup</li>
                        <li>Malware cleanup if needed</li>
                        <li>Up to 2 minor fixes/month</li>
                        <li>Priority support (24h)</li>
                        <li>Monthly health summary</li>
                    </ul>
                </div>
                <div class="plan-section">
                    <strong>Limits</strong>
                    <ul class="plan-list plan-list-limits">
                        <li>No new feature development</li>
                        <li>No redesign work</li>
                    </ul>
                </div>
                <a class="btn btn-primary plan-button" href="<?php echo esc_url(home_url('/contact/')); ?>">Start Business Care</a>
            </div>
            <div class="card plan-card-alt plan-store" data-animate>
                <div class="plan-header">
                    <h3>Store Care</h3>
                    <span class="plan-kicker plan-kicker-purple">Revenue Protection</span>
                </div>
                <p class="plan-best">Best for: WooCommerce stores</p>
                <p class="plan-price">From $299<span class="plan-price-period">/mo</span></p>
                <p class="muted">Keep checkout, payments, and orders running smoothly.</p>
                <div class="plan-section">
                    <strong>Includes</strong>
                    <ul class="plan-list plan-list-includes">
                        <li>Everything in Business Care</li>
                        <li>Monthly checkout + payment test</li>
                        <li>Order flow check (orders are being created correctly)</li>
                        <li>Database cleanup</li>
                        <li>Up to 3 store-related fixes/month</li>
                        <li>Limited emergency handling</li>
                        <li>Direct support channel (WhatsApp/priority)</li>
                    </ul>
                </div>
                <div class="plan-section">
                    <strong>Limits</strong>
                    <ul class="plan-list plan-list-limits">
                        <li>No major store rebuilds</li>
                        <li>No advanced feature builds</li>
                    </ul>
                </div>
                <a class="btn btn-primary plan-button plan-button-purple" href="<?php echo esc_url(home_url('/contact/')); ?>">Start Store Care</a>
            </div>
        </div>
    </div>
</section>

<section class="section section-muted">
    <div class="container" data-animate>
        <div class="section-heading center">
            <h2>Plan Comparison</h2>
        </div>
        <div class="comparison-table" data-animate>
            <div class="comparison-row comparison-header">
                <span>Feature</span>
                <span class="col-basic">Basic</span>
                <span class="col-business">Business</span>
                <span class="col-store">Store</span>
            </div>
            <div class="comparison-row">
                <span>Safe monthly updates</span>
                <span class="col-basic">✅</span>
                <span class="col-business">✅</span>
                <span class="col-store">✅</span>
            </div>
            <div class="comparison-row">
                <span>Backups before updates</span>
                <span class="col-basic">✅</span>
                <span class="col-business">✅</span>
                <span class="col-store">✅</span>
            </div>
            <div class="comparison-row">
                <span>Restore support</span>
                <span class="col-basic">✅</span>
                <span class="col-business">✅</span>
                <span class="col-store">✅</span>
            </div>
            <div class="comparison-row">
                <span>Security scan</span>
                <span class="col-basic">✅</span>
                <span class="col-business">✅</span>
                <span class="col-store">✅</span>
            </div>
            <div class="comparison-row">
                <span>Malware cleanup</span>
                <span class="col-basic">✕</span>
                <span class="col-business">✅</span>
                <span class="col-store">✅</span>
            </div>
            <div class="comparison-row">
                <span>Checkups</span>
                <span class="col-basic">1/mo</span>
                <span class="col-business">2/mo</span>
                <span class="col-store">2/mo + store checks</span>
            </div>
            <div class="comparison-row">
                <span>Performance cleanup</span>
                <span class="col-basic">✕</span>
                <span class="col-business">Monthly</span>
                <span class="col-store">Monthly</span>
            </div>
            <div class="comparison-row">
                <span>Minor fixes included</span>
                <span class="col-basic">✕</span>
                <span class="col-business">2/mo</span>
                <span class="col-store">3/mo (store-focused)</span>
            </div>
            <div class="comparison-row">
                <span>Woo checkout/payment testing</span>
                <span class="col-basic">✕</span>
                <span class="col-business">✕</span>
                <span class="col-store">✅</span>
            </div>
            <div class="comparison-row">
                <span>Support response</span>
                <span class="col-basic">48h</span>
                <span class="col-business">24h</span>
                <span class="col-store">Priority</span>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container" data-animate>
        <div class="section-heading center">
            <h2>What Counts as a “Minor Fix”?</h2>
        </div>
        <div class="grid grid-2 minor-fix-grid">
            <div class="card minor-fix-card minor-fix-included" data-animate>
                <h3>✓ Included as Minor Fix</h3>
                <ul class="minor-fix-list minor-fix-list-included">
                    <li>Plugin conflict resolution (small)</li>
                    <li>Layout break on one page</li>
                    <li>Forms not working</li>
                    <li>Payment config / minor checkout errors</li>
                    <li>Error messages / warnings</li>
                    <li>Small WooCommerce issues (Store plan)</li>
                </ul>
            </div>
            <div class="card minor-fix-card minor-fix-not" data-animate>
                <h3>✕ Not Included</h3>
                <ul class="minor-fix-list minor-fix-list-not">
                    <li>New features / custom development</li>
                    <li>Full redesign / theme changes</li>
                    <li>Large migrations</li>
                    <li>Custom plugin development</li>
                    <li>Major performance engineering</li>
                </ul>
            </div>
        </div>
        <p class="minor-fix-note highlight-note">Major work is always quoted separately. You’ll know before we start.</p>
    </div>
</section>

<section class="section section-muted">
    <div class="container" data-animate>
        <div class="section-heading center">
            <h2>How It Works</h2>
        </div>
        <div class="grid grid-4 plans-steps">
            <div class="card step-card-alt" data-animate>
                <div class="step-number">1</div>
                <h3>Choose a plan</h3>
                <p class="muted">Select the plan that fits your needs</p>
            </div>
            <div class="card step-card-alt" data-animate>
                <div class="step-number">2</div>
                <h3>Add your website</h3>
                <p class="muted">Provide your website details</p>
            </div>
            <div class="card step-card-alt" data-animate>
                <div class="step-number">3</div>
                <h3>We maintain + check regularly</h3>
                <p class="muted">Regular updates and monitoring</p>
            </div>
            <div class="card step-card-alt" data-animate>
                <div class="step-number">4</div>
                <h3>Request fixes</h3>
                <p class="muted">Within your plan limits</p>
            </div>
        </div>
        <p class="muted center">All work is tracked and confirmed. No hidden work.</p>
    </div>
</section>

<section class="section">
    <div class="container" data-animate>
        <div class="section-heading center">
            <h2>Frequently Asked Questions</h2>
        </div>
        <div class="faq-grid">
            <div class="card faq-card" data-animate>
                <h3>Is this the same as hosting maintenance?</h3>
                <p class="muted">No. Hosting manages servers. Aakaari manages your WordPress/WooCommerce website.</p>
            </div>
            <div class="card faq-card" data-animate>
                <h3>Can I upgrade later?</h3>
                <p class="muted">Yes, anytime.</p>
            </div>
            <div class="card faq-card" data-animate>
                <h3>What if I need more fixes this month?</h3>
                <p class="muted">You can upgrade or purchase one-time fixes.</p>
            </div>
            <div class="card faq-card" data-animate>
                <h3>Do you guarantee 24/7 monitoring?</h3>
                <p class="muted">We do scheduled manual checks and maintenance. We don’t overpromise.</p>
            </div>
            <div class="card faq-card" data-animate>
                <h3>Can I cancel anytime?</h3>
                <p class="muted">Yes.</p>
            </div>
        </div>
    </div>
</section>

<section class="section cta-strip plans-cta">
    <div class="container cta-inner" data-animate>
        <div class="cta-content">
            <h2>Let us handle your website — you focus on business.</h2>
            <p>Flexible plans, clear limits, and a real team you can trust.</p>
        </div>
        <div class="button-group cta-actions">
            <a class="btn btn-primary btn-light" href="#plans">Choose a Plan</a>
            <a class="btn btn-outline btn-light-outline" href="<?php echo esc_url(home_url('/fix-an-issue/')); ?>">Fix an Issue Instead</a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
