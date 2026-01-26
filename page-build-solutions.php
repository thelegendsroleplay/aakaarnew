<?php
/**
 * Template Name: Build Solutions
 */
get_header();
?>

<div class="build-solutions-page">
  <section class="hero reveal">
    <div class="container">
      <span class="hero-badge">Fixed Price Packages</span>
      <h1>We Build Scalable<br><span style="color:var(--primary)">WordPress Solutions</span></h1>
      <p>From starter stores to custom business systems. Transparent pricing, strict engineering standards, and no hidden costs.</p>
      <a href="#solutions" class="btn-header" style="padding: 16px 32px; font-size: 1.1rem;">View Packages</a>
    </div>
  </section>

  <section class="services-section" id="solutions">
    <div class="container">
      <div class="services-grid">
        <div class="service-card reveal delay-1">
          <div class="icon-box ib-green">🛒</div>
          <h3 class="s-title">Woo Starter Store</h3>
          <p class="s-desc">Perfect for first-time store owners. Get selling fast.</p>

          <ul class="check-list">
            <li><span class="check">✓</span> WordPress + Woo Setup</li>
            <li><span class="check">✓</span> Mobile-friendly Theme</li>
            <li><span class="check">✓</span> Payment &amp; Shipping Setup</li>
            <li><span class="check">✓</span> Up to 50 Products</li>
            <li><span class="check">✓</span> 7 Days Support</li>
          </ul>

          <div class="limits-box">
            <span class="limits-title">Not Included</span>
            <ul class="limits-list">
              <li><span class="cross">✕</span> Custom Plugin Dev</li>
              <li><span class="cross">✕</span> Scratch Design</li>
            </ul>
          </div>

          <div class="s-price">
            <span>Starting from</span>$699
          </div>
        </div>

        <div class="service-card reveal delay-2">
          <div class="icon-box ib-blue">⚡</div>
          <h3 class="s-title">Woo Enhancements</h3>
          <p class="s-desc">For existing stores that need specific new features.</p>

          <ul class="check-list">
            <li><span class="check">✓</span> <strong>1 Major Feature</strong> (or 3 small)</li>
            <li><span class="check">✓</span> Custom Checkout Logic</li>
            <li><span class="check">✓</span> Custom Fields / Workflows</li>
            <li><span class="check">✓</span> API Integration (Basic)</li>
            <li><span class="check">✓</span> Testing + Documentation</li>
          </ul>

          <div class="limits-box">
            <span class="limits-title">Not Included</span>
            <ul class="limits-list">
              <li><span class="cross">✕</span> Full Store Rebuild</li>
            </ul>
          </div>

          <div class="s-price">
            <span>Starting from</span>$399
          </div>
        </div>

        <div class="service-card reveal delay-3">
          <div class="icon-box ib-purple">🏗️</div>
          <h3 class="s-title">Custom Web System</h3>
          <p class="s-desc">Business tools &amp; platforms built on PHP / WP.</p>

          <ul class="check-list">
            <li><span class="check">✓</span> Custom PHP System</li>
            <li><span class="check">✓</span> Admin Panel &amp; Secure Login</li>
            <li><span class="check">✓</span> Database Design</li>
            <li><span class="check">✓</span> Performance Optimization</li>
            <li><span class="check">✓</span> Deployment Support</li>
          </ul>

          <div class="limits-box">
            <span class="limits-title">Not Included</span>
            <ul class="limits-list">
              <li><span class="cross">✕</span> Mobile Apps</li>
              <li><span class="cross">✕</span> SaaS Scaling</li>
            </ul>
          </div>

          <div class="s-price">
            <span>Starting from</span>$1,299
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="standards-section">
    <div class="container std-grid">
      <div class="reveal">
        <h2 style="color:white; font-size:2.5rem; margin-bottom:1.5rem;">The Engineering Standard</h2>
        <p style="color:#CBD5E1; margin-bottom:2rem;">
          Most agencies just install plugins. We follow strict software engineering protocols to ensure your build is scalable and secure.
        </p>
        <div style="background:#1E293B; padding:20px; border-radius:12px; font-family:'JetBrains Mono', monospace; color:#38BDF8; font-size:0.9rem;">
          &gt; git commit -m "Security Hardening"<br>
          &gt; running_tests... [OK]<br>
          &gt; deploy_to_production...
        </div>
      </div>
      <div class="reveal delay-1">
        <ul class="std-list">
          <li>
            <span class="std-icon">🛡️</span>
            <div>
              <span class="std-title">Security First Architecture</span>
              <span class="std-desc">We sanitize every input and validate every request. No SQL injection vulnerabilities.</span>
            </div>
          </li>
          <li>
            <span class="std-icon">🚀</span>
            <div>
              <span class="std-title">Performance by Default</span>
              <span class="std-desc">We write clean PHP that doesn't bloat your database. Guaranteed 90+ Mobile Score.</span>
            </div>
          </li>
          <li>
            <span class="std-icon">🔄</span>
            <div>
              <span class="std-title">Version Control (Git)</span>
              <span class="std-desc">Every line of code is tracked. We can roll back changes instantly if needed.</span>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </section>

  <section class="form-section" id="quote">
    <div class="container split-layout">
      <div class="reveal">
        <h2 style="margin-bottom:2rem;">How We Work</h2>
        <div class="process-step">
          <div class="step-num">1</div>
          <div class="step-content">
            <h4>Submit Request</h4>
            <p style="font-size:0.95rem;">Fill out the form with your project details.</p>
          </div>
        </div>
        <div class="process-step">
          <div class="step-num">2</div>
          <div class="step-content">
            <h4>Detailed Proposal</h4>
            <p style="font-size:0.95rem;">We send a PDF proposal with exact scope and cost.</p>
          </div>
        </div>
        <div class="process-step">
          <div class="step-num">3</div>
          <div class="step-content">
            <h4>Development</h4>
            <p style="font-size:0.95rem;">We build on a staging server. You track progress.</p>
          </div>
        </div>
        <div class="process-step">
          <div class="step-num">4</div>
          <div class="step-content">
            <h4>Launch &amp; Handover</h4>
            <p style="font-size:0.95rem;">We deploy to live and provide documentation.</p>
          </div>
        </div>
      </div>

      <div class="quote-form reveal delay-2">
        <h3 style="margin-bottom:1.5rem;">Request a Quote</h3>
        <form>
          <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
              <label class="form-label" for="quote-name">Name</label>
              <input id="quote-name" type="text" class="form-input" placeholder="John Doe">
            </div>
            <div class="form-group">
              <label class="form-label" for="quote-email">Email</label>
              <input id="quote-email" type="email" class="form-input" placeholder="john@company.com">
            </div>
          </div>

          <div class="form-group">
            <label class="form-label" for="quote-package">Select Package</label>
            <select id="quote-package" class="form-select">
              <option>Woo Starter Store ($699+)</option>
              <option>Custom Woo Enhancements ($399+)</option>
              <option>Custom Web System ($1,299+)</option>
              <option>Other / Not Sure</option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label" for="quote-details">Project Details</label>
            <textarea id="quote-details" class="form-textarea" rows="4" placeholder="Describe your requirements..."></textarea>
          </div>

          <button type="submit" class="btn-submit">Get Free Proposal →</button>
        </form>
      </div>
    </div>
  </section>
</div>

<?php
get_footer();
?>
