<?php
/**
 * Template Name: Maintenance Plans
 */
wp_enqueue_style(
    'maintenance-plans-fonts',
    'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap',
    [],
    null
);
wp_enqueue_style(
    'maintenance-plans',
    get_template_directory_uri() . '/assets/css/maintenance-plans.css',
    ['maintenance-plans-fonts'],
    '2.0'
);
wp_enqueue_script(
    'maintenance-plans',
    get_template_directory_uri() . '/assets/js/maintenance-plans.js',
    [],
    '2.0',
    true
);
get_header();
?>

<div class="maintenance-plans-page" data-theme="light">
  <a class="skip-link" href="#content">Skip to content</a>
  <div id="content">
    <!-- HERO (no bento cards) -->
    <section class="hero reveal">
      <div class="container">
        <span class="hero-badge">WordPress Performance Engineering</span>

        <h1>
          Website Care That Actually<br />
          <span class="hero-accent">Prevents Problems</span>
        </h1>

        <p>
          Hosting keeps servers running. We engineer your website to be fast, secure, and error-free with real human developers.
        </p>

        <div class="btn-group" role="group" aria-label="Primary actions">
          <a href="#pricing" class="btn btn-xl btn-pri">View Plans</a>
          <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-xl btn-sec">Talk to Us</a>
        </div>
      </div>
    </section>

    <!-- COMPARISON -->
    <section class="section-wrap">
      <div class="container">
        <div class="header-center reveal">
          <h2>Why Not Just Hosting?</h2>
          <p>Hosting support stops at the server level. We manage the application layer.</p>
        </div>

        <div class="grid-2">
          <div class="comp-card reveal delay-1">
            <h3 style="margin-bottom:1.2rem; color: var(--danger);">Hosting Support</h3>
            <ul class="check-list">
              <li><div class="icon c">✓</div> Server uptime</li>
              <li><div class="icon c">✓</div> Automated updates (risk)</li>
              <li><div class="icon x">✕</div> Website-specific bugs</li>
              <li><div class="icon x">✕</div> WooCommerce checkout issues</li>
              <li><div class="icon x">✕</div> Plugin conflicts</li>
            </ul>
          </div>

          <div class="comp-card highlight reveal delay-2">
            <div class="comp-badge">Recommended</div>
            <h3 style="margin-bottom:1.2rem; color: var(--primary);">Aakaari Care</h3>
            <ul class="check-list">
              <li><div class="icon c">✓</div> Safe updates (staging first)</li>
              <li><div class="icon c">✓</div> <strong>Fix small issues before they grow</strong></li>
              <li><div class="icon c">✓</div> WooCommerce testing (Store plan)</li>
              <li><div class="icon c">✓</div> Human developer support</li>
              <li><div class="icon c">✓</div> Clear monthly reporting</li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- PRICING -->
    <section class="section-wrap bg-offset" id="pricing">
      <div class="container">
        <div class="header-center reveal">
          <h2>Transparent Retainers</h2>
          <p>Professional engineering support with no hidden clauses.</p>
        </div>

        <div class="grid-3" id="pricing-grid">
          <!-- Basic -->
          <article class="price-card reveal delay-1">
            <div class="card-content">
              <h3>Basic Care</h3>
              <div class="plan-kicker green">For Content Sites</div>

              <div class="price-amount">$79<span>/mo</span></div>

              <ul class="check-list">
                <li><div class="icon p">✓</div> Safe updates</li>
                <li><div class="icon p">✓</div> Daily backups</li>
                <li><div class="icon p">✓</div> 1 manual check</li>
                <li style="opacity:0.55"><div class="icon x">✕</div> No fixes included</li>
              </ul>

              <button class="price-btn btn-outline" type="button">Select Basic</button>
            </div>
          </article>

          <!-- Business (Featured) -->
          <article class="price-card featured reveal delay-2" aria-label="Business Care (Recommended)">
            <div class="plan-badge">Most Popular</div>
            <div class="card-content">
              <h3 style="color: var(--primary);">Business Care</h3>
              <div class="plan-kicker">For Lead Generation</div>

              <div class="price-amount">$179<span>/mo</span></div>

              <ul class="check-list">
                <li><div class="icon p">✓</div> Everything in Basic</li>
                <li><div class="icon p">✓</div> Malware removal</li>
                <li><div class="icon p">✓</div> 2 manual checks</li>
                <li><div class="icon p">✓</div> <strong>2 minor fixes included</strong></li>
              </ul>

              <button class="price-btn btn-solid" type="button">Start Business</button>
            </div>
          </article>

          <!-- Store -->
          <article class="price-card reveal delay-3">
            <div class="card-content">
              <h3>Store Care</h3>
              <div class="plan-kicker purple">For WooCommerce</div>

              <div class="price-amount">$279<span>/mo</span></div>

              <ul class="check-list">
                <li><div class="icon p">✓</div> Everything in Business</li>
                <li><div class="icon p">✓</div> Checkout testing</li>
                <li><div class="icon p">✓</div> Database optimization</li>
                <li><div class="icon p">✓</div> <strong>3 store fixes included</strong></li>
              </ul>

              <button class="price-btn btn-outline" type="button">Select Store</button>
            </div>
          </article>
        </div>

        <div class="emergency-note reveal">
          <span class="tag-emergency">Emergency?</span>
          One-time fix packs available for $99 (subject to availability).
        </div>

        <!-- SPECS TABLE -->
        <div class="table-wrapper reveal delay-2" id="specs" role="region" aria-label="Plan comparison table">
          <table>
            <caption>Plan Comparison (Technical Specs)</caption>
            <thead>
              <tr>
                <th scope="col">Feature</th>
                <th scope="col">Basic</th>
                <th scope="col" class="col-highlight" style="color: var(--primary);">Business</th>
                <th scope="col">Store</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Dev Hours Included</td>
                <td>None</td>
                <td class="col-highlight t-strong">2 fixes / mo</td>
                <td class="t-strong">3 fixes / mo</td>
              </tr>
              <tr>
                <td>Update Strategy</td>
                <td>Standard safe</td>
                <td class="col-highlight">Staging → Live</td>
                <td>Staging → Live</td>
              </tr>
              <tr>
                <td>Malware Removal</td>
                <td>Paid add-on</td>
                <td class="col-highlight">Included</td>
                <td>Included</td>
              </tr>
              <tr>
                <td>WooCommerce QA</td>
                <td>✕</td>
                <td class="col-highlight">✕</td>
                <td>Checkout tests</td>
              </tr>
              <tr>
                <td>Support SLA</td>
                <td>48 hours</td>
                <td class="col-highlight">24 hours</td>
                <td>Priority</td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </section>

    <!-- SCOPE / TERMINAL -->
    <section class="section-wrap">
      <div class="container">
        <div class="header-center reveal">
          <h2>Scope of Work</h2>
          <p>What exactly counts as a “Minor Fix”?</p>
        </div>

        <div class="terminal-container reveal" id="terminal-section" role="region" aria-label="Scope checker terminal">
          <div class="term-bar">
            <div class="dot" style="background:#EF4444"></div>
            <div class="dot" style="background:#F59E0B"></div>
            <div class="dot" style="background:#10B981"></div>
            <span class="term-title">scope_checker.js</span>
          </div>
          <div class="term-content">
            <span id="typewriter-text"></span><span class="cursor" aria-hidden="true"></span>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ (Accordion) -->
    <section class="section-wrap bg-offset" id="faq">
      <div class="container">
        <div class="header-center reveal">
          <h2>Frequently Asked Questions</h2>
          <p>Clear answers, no fluff.</p>
        </div>

        <div class="faq-accordion reveal" data-accordion="single">
          <div class="faq-item">
            <button class="faq-q" type="button" aria-expanded="false">
              <span>Is this the same as hosting maintenance?</span>
              <span class="faq-ico" aria-hidden="true"></span>
            </button>
            <div class="faq-a" role="region">
              <div class="faq-a-inner">
                No. Hosting manages servers (hardware). Aakaari manages your WordPress website (software)—performance, security, and bugs.
              </div>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-q" type="button" aria-expanded="false">
              <span>Can I upgrade later?</span>
              <span class="faq-ico" aria-hidden="true"></span>
            </button>
            <div class="faq-a" role="region">
              <div class="faq-a-inner">
                Yes, anytime. Upgrade from Basic → Business → Store as your site grows.
              </div>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-q" type="button" aria-expanded="false">
              <span>What if I need more fixes this month?</span>
              <span class="faq-ico" aria-hidden="true"></span>
            </button>
            <div class="faq-a" role="region">
              <div class="faq-a-inner">
                You can upgrade your plan or purchase additional fix credits (member pricing).
              </div>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-q" type="button" aria-expanded="false">
              <span>Do you guarantee 24/7 monitoring?</span>
              <span class="faq-ico" aria-hidden="true"></span>
            </button>
            <div class="faq-a" role="region">
              <div class="faq-a-inner">
                We run uptime monitoring and scheduled checks. When something breaks, you get a fast response from real engineers.
              </div>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-q" type="button" aria-expanded="false">
              <span>Can I cancel anytime?</span>
              <span class="faq-ico" aria-hidden="true"></span>
            </button>
            <div class="faq-a" role="region">
              <div class="faq-a-inner">
                Yes. Month-to-month. No lock-in contracts.
              </div>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-q" type="button" aria-expanded="false">
              <span>Do you work on WooCommerce issues?</span>
              <span class="faq-ico" aria-hidden="true"></span>
            </button>
            <div class="faq-a" role="region">
              <div class="faq-a-inner">
                Yes. Store Care includes checkout QA testing and store-specific fixes.
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<?php
get_footer();
?>
