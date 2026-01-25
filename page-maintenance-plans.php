<?php
/**
 * Template Name: Maintenance Plans
 */
get_header();
?>

<section class="plans-hero">
    <div class="container">
        <span class="plans-pill">Maintenance Plans</span>
        <h1>Website Care That Actually Prevents Problems</h1>
        <p class="plans-subtitle">
            Hosting keeps servers running. Aakaari keeps your website stable, secure, and updated<br />
            — with real human checks.
        </p>
        <div class="plans-highlights">
            <span class="highlight-pill">Fixed monthly care</span>
            <span class="highlight-pill">Manual checks (not just automation)</span>
            <span class="highlight-pill">Clear limits (no hidden charges)</span>
            <span class="highlight-pill">Upgrade anytime</span>
        </div>
        <div class="plans-actions">
            <a class="btn btn-primary" href="<?php echo esc_url(home_url('/plans/')); ?>">Choose a Plan</a>
            <a class="btn btn-outline" href="<?php echo esc_url(home_url('/contact/')); ?>">Talk to Us</a>
        </div>
    </div>
</section>

<section class="plans-section">
    <div class="container">
        <div class="section-heading center">
            <h2>Why Not Just Hosting?</h2>
        </div>
        <div class="plans-compare-grid">
            <article class="compare-card">
                <h3>Hosting Support</h3>
                <ul class="checklist">
                    <li>Server uptime</li>
                    <li>Auto updates</li>
                    <li class="is-negative">Website bugs</li>
                    <li class="is-negative">WooCommerce checkout help</li>
                    <li class="is-negative">Plugin conflicts</li>
                    <li class="is-negative">Revenue protection</li>
                </ul>
            </article>
            <article class="compare-card compare-card-highlight">
                <h3>Aakaari Care</h3>
                <ul class="checklist checklist-blue">
                    <li>Safe updates with backup</li>
                    <li>Fix small issues before they grow</li>
                    <li>WooCommerce testing (Store plan)</li>
                    <li>Human support</li>
                    <li>Clear reporting</li>
                </ul>
            </article>
        </div>
        <p class="plans-center-note">Hosting manages servers. Aakaari manages your website.</p>
    </div>
</section>

<section class="plans-section section-muted">
    <div class="container">
        <div class="section-heading center">
            <h2>Choose Your Plan</h2>
        </div>
        <div class="plan-grid">
            <article class="plan-card">
                <h3>Basic Care</h3>
                <p class="plan-tag plan-tag-green">Safe &amp; Updated</p>
                <p class="plan-meta">Best for: Simple websites, blogs, portfolios</p>
                <p class="plan-price">From $99<span>/mo</span></p>
                <p class="plan-description">Keep your site updated safely without breaking things.</p>
                <div class="plan-section">
                    <h4>Includes</h4>
                    <ul class="plan-list">
                        <li>Monthly WordPress + plugin + theme updates (safe cycle)</li>
                        <li>Manual backup before updates</li>
                        <li>Restore support if update breaks the site</li>
                        <li>Basic security scan</li>
                        <li>Monthly manual check</li>
                        <li>Email support (48h)</li>
                    </ul>
                </div>
                <div class="plan-section">
                    <h4>Limits</h4>
                    <ul class="plan-list plan-list-muted">
                        <li>No free fixes</li>
                        <li>No WooCommerce monitoring</li>
                        <li>No custom development</li>
                    </ul>
                </div>
                <a class="btn plan-btn plan-btn-green" href="<?php echo esc_url(home_url('/plans/')); ?>">Start Basic Care</a>
            </article>

            <article class="plan-card plan-card-featured">
                <span class="plan-badge">Most Popular</span>
                <h3>Business Care</h3>
                <p class="plan-tag plan-tag-blue">Stable Growth <span aria-hidden="true">★</span></p>
                <p class="plan-meta">Best for: Business websites &amp; lead generation</p>
                <p class="plan-price">From $199<span>/mo</span></p>
                <p class="plan-description">Stability + security + small fixes — the best balance.</p>
                <div class="plan-section">
                    <h4>Includes</h4>
                    <ul class="plan-list">
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
                    <h4>Limits</h4>
                    <ul class="plan-list plan-list-muted">
                        <li>No new feature development</li>
                        <li>No redesign work</li>
                    </ul>
                </div>
                <a class="btn plan-btn plan-btn-blue" href="<?php echo esc_url(home_url('/plans/')); ?>">Start Business Care</a>
            </article>

            <article class="plan-card">
                <h3>Store Care</h3>
                <p class="plan-tag plan-tag-purple">Revenue Protection</p>
                <p class="plan-meta">Best for: WooCommerce stores</p>
                <p class="plan-price">From $299<span>/mo</span></p>
                <p class="plan-description">Keep checkout, payments, and orders running smoothly.</p>
                <div class="plan-section">
                    <h4>Includes</h4>
                    <ul class="plan-list plan-list-purple">
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
                    <h4>Limits</h4>
                    <ul class="plan-list plan-list-muted">
                        <li>No major store rebuilds</li>
                        <li>No advanced feature builds</li>
                    </ul>
                </div>
                <a class="btn plan-btn plan-btn-purple" href="<?php echo esc_url(home_url('/plans/')); ?>">Start Store Care</a>
            </article>
        </div>
    </div>
</section>

<section class="plans-section">
    <div class="container">
        <div class="section-heading center">
            <h2>Plan Comparison</h2>
        </div>
        <div class="comparison-table-wrapper">
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Feature</th>
                        <th>Basic</th>
                        <th>Business</th>
                        <th>Store</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Safe monthly updates</td>
                        <td><span class="icon-check icon-green">✓</span></td>
                        <td><span class="icon-check icon-blue">✓</span></td>
                        <td><span class="icon-check icon-purple">✓</span></td>
                    </tr>
                    <tr>
                        <td>Backups before updates</td>
                        <td><span class="icon-check icon-green">✓</span></td>
                        <td><span class="icon-check icon-blue">✓</span></td>
                        <td><span class="icon-check icon-purple">✓</span></td>
                    </tr>
                    <tr>
                        <td>Restore support</td>
                        <td><span class="icon-check icon-green">✓</span></td>
                        <td><span class="icon-check icon-blue">✓</span></td>
                        <td><span class="icon-check icon-purple">✓</span></td>
                    </tr>
                    <tr>
                        <td>Security scan</td>
                        <td><span class="icon-check icon-green">✓</span></td>
                        <td><span class="icon-check icon-blue">✓</span></td>
                        <td><span class="icon-check icon-purple">✓</span></td>
                    </tr>
                    <tr>
                        <td>Malware cleanup</td>
                        <td><span class="icon-x">×</span></td>
                        <td><span class="icon-check icon-blue">✓</span></td>
                        <td><span class="icon-check icon-purple">✓</span></td>
                    </tr>
                    <tr>
                        <td>Checkups</td>
                        <td>1/mo</td>
                        <td>2/mo</td>
                        <td>2/mo + store checks</td>
                    </tr>
                    <tr>
                        <td>Performance cleanup</td>
                        <td><span class="icon-x">×</span></td>
                        <td>Monthly</td>
                        <td>Monthly</td>
                    </tr>
                    <tr>
                        <td>Minor fixes included</td>
                        <td><span class="icon-x">×</span></td>
                        <td>2/mo</td>
                        <td>3/mo (store-focused)</td>
                    </tr>
                    <tr>
                        <td>Woo checkout/payment testing</td>
                        <td><span class="icon-x">×</span></td>
                        <td><span class="icon-x">×</span></td>
                        <td><span class="icon-check icon-purple">✓</span></td>
                    </tr>
                    <tr>
                        <td>Support response</td>
                        <td>48h</td>
                        <td>24h</td>
                        <td>Priority</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<section class="plans-section section-muted">
    <div class="container">
        <div class="section-heading center">
            <h2>What Counts as a "Minor Fix"?</h2>
        </div>
        <div class="minor-grid">
            <article class="minor-card minor-included">
                <h3>✓ Included as Minor Fix</h3>
                <ul class="checklist">
                    <li>Plugin conflict resolution (small)</li>
                    <li>Layout break on one page</li>
                    <li>Forms not working</li>
                    <li>Payment config / minor checkout errors</li>
                    <li>Error messages / warnings</li>
                    <li>Small WooCommerce issues (Store plan)</li>
                </ul>
            </article>
            <article class="minor-card minor-excluded">
                <h3>✕ Not Included</h3>
                <ul class="checklist">
                    <li class="is-negative">New features / custom development</li>
                    <li class="is-negative">Full redesign / theme changes</li>
                    <li class="is-negative">Large migrations</li>
                    <li class="is-negative">Custom plugin development</li>
                    <li class="is-negative">Major performance engineering</li>
                </ul>
            </article>
        </div>
        <div class="minor-note">Major work is always quoted separately. You'll know before we start.</div>
    </div>
</section>

<section class="plans-section">
    <div class="container">
        <div class="section-heading center">
            <h2>How It Works</h2>
        </div>
        <div class="steps-grid">
            <div class="step-card">
                <span class="step-circle">1</span>
                <h3>Choose a plan</h3>
                <p>Select the plan that fits your needs</p>
            </div>
            <div class="step-card">
                <span class="step-circle">2</span>
                <h3>Add your website</h3>
                <p>Provide your website details</p>
            </div>
            <div class="step-card">
                <span class="step-circle">3</span>
                <h3>We maintain + check regularly</h3>
                <p>Regular updates and monitoring</p>
            </div>
            <div class="step-card">
                <span class="step-circle">4</span>
                <h3>Request fixes</h3>
                <p>Within your plan limits</p>
            </div>
        </div>
        <p class="plans-center-note">All work is tracked and confirmed. No hidden work.</p>
    </div>
</section>

<section class="plans-section section-muted">
    <div class="container">
        <div class="section-heading center">
            <h2>Frequently Asked Questions</h2>
        </div>
        <div class="faq-grid">
            <article class="faq-card">
                <h3>Is this the same as hosting maintenance?</h3>
                <p>No. Hosting manages servers. Aakaari manages your WordPress/WooCommerce website.</p>
            </article>
            <article class="faq-card">
                <h3>Can I upgrade later?</h3>
                <p>Yes, anytime.</p>
            </article>
            <article class="faq-card">
                <h3>What if I need more fixes this month?</h3>
                <p>You can upgrade or purchase one-time fixes.</p>
            </article>
            <article class="faq-card">
                <h3>Do you guarantee 24/7 monitoring?</h3>
                <p>We do scheduled manual checks and maintenance. We don't overpromise.</p>
            </article>
            <article class="faq-card">
                <h3>Can I cancel anytime?</h3>
                <p>Yes.</p>
            </article>
        </div>
    </div>
</section>

<section class="plans-cta">
    <div class="container">
        <h2>Let us handle your website — you focus on business.</h2>
        <div class="plans-actions">
            <a class="btn btn-light" href="<?php echo esc_url(home_url('/plans/')); ?>">Choose a Plan</a>
            <a class="btn btn-outline-light" href="<?php echo esc_url(home_url('/fix-an-issue/')); ?>">Fix an Issue Instead</a>
        </div>
    </div>
</section>

<?php
get_footer();
?>
