<?php
/**
 * Template Name: Maintenance Plans
 */
?><!doctype html>
<html <?php language_attributes(); ?> data-theme="light">
<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Aakaari | Enterprise WordPress Engineering</title>

  <?php wp_head(); ?>

  <!-- Perf: preconnect for fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet" />

  <style>
    /* =========================
       1) DESIGN SYSTEM
    ========================== */
    :root {
      /* Brand */
      --primary: #2563EB;
      --primary-dark: #1D4ED8;
      --primary-light: #EFF6FF;

      /* Status */
      --success: #10B981;
      --warning: #F59E0B;
      --danger:  #EF4444;

      /* Surfaces */
      --bg-page: #FFFFFF;
      --bg-secondary: #F8FAFC;
      --bg-dark: #0F172A;
      --bg-elev: #FFFFFF;

      /* Text */
      --text-head: #111827;
      --text-body: #475569;
      --text-muted: #94A3B8;

      /* Borders */
      --border: #E2E8F0;

      /* Layout */
      --max-w: 1280px;
      --section-gap: 8rem;
      --radius: 12px;

      /* Effects */
      --shadow-sm: 0 1px 3px 0 rgba(0,0,0,0.08);
      --shadow-card: 0 6px 18px rgba(15, 23, 42, 0.06);
      --shadow-lift: 0 20px 30px rgba(15, 23, 42, 0.10);

      /* Motion */
      --ease: cubic-bezier(.2,.8,.2,1);
      --dur: 220ms;

      /* Table */
      --table-head-bg: #F8FAFC;

      /* Code/Terminal */
      --term-bg: #0F172A;
      --term-bar: #1E293B;
      --term-border: #334155;
      --term-text: #E2E8F0;

      /* Focus ring */
      --focus: rgba(37, 99, 235, .45);
    }

    /* Dark theme (optional toggle ready) */
    [data-theme="dark"]{
      --bg-page: #0B1020;
      --bg-secondary: #0F172A;
      --bg-elev: #0F172A;

      --text-head: #F8FAFC;
      --text-body: #CBD5E1;
      --text-muted: #94A3B8;

      --border: #1F2A44;
      --shadow-card: 0 10px 30px rgba(0,0,0,.35);
      --shadow-lift: 0 25px 60px rgba(0,0,0,.45);

      --table-head-bg: #0B1224;
    }

    /* =========================
       2) RESET + BASE
    ========================== */
    * { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body {
      font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, "Helvetica Neue", Arial, sans-serif;
      color: var(--text-body);
      background: var(--bg-page);
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
      text-rendering: optimizeLegibility;
    }

    /* Skip link */
    .skip-link{
      position: absolute;
      left: -999px;
      top: 12px;
      z-index: 2000;
      background: var(--bg-elev);
      border: 1px solid var(--border);
      padding: 10px 12px;
      border-radius: 10px;
      box-shadow: var(--shadow-sm);
      color: var(--text-head);
      font-weight: 700;
    }
    .skip-link:focus{
      left: 12px;
      outline: 3px solid var(--focus);
      outline-offset: 3px;
    }

    /* Focus ring */
    :focus-visible{
      outline: 3px solid var(--focus);
      outline-offset: 3px;
      border-radius: 12px;
    }

    a { text-decoration: none; transition: color var(--dur) var(--ease), background var(--dur) var(--ease), border-color var(--dur) var(--ease), transform var(--dur) var(--ease), box-shadow var(--dur) var(--ease); }
    ul { list-style: none; }
    h1,h2,h3,h4 { color: var(--text-head); font-weight: 800; letter-spacing: -0.025em; line-height: 1.15; }
    p { font-size: 1.125rem; }

    /* Reduce motion */
    @media (prefers-reduced-motion: reduce){
      html{ scroll-behavior: auto; }
      *{ animation-duration: 0.01ms !important; animation-iteration-count: 1 !important; transition-duration: 0.01ms !important; }
    }

    /* =========================
       3) LAYOUT UTILITIES
    ========================== */
    .container {
      max-width: var(--max-w);
      margin: 0 auto;
      padding: 0 32px;
      width: 100%;
    }

    .section-wrap { padding: var(--section-gap) 0; }
    .bg-offset { background: var(--bg-secondary); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); }

    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; }
    .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; }
    .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; }

    @media(max-width: 1024px) {
      .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; gap: 2.25rem; }
      .container{ padding: 0 20px; }
    }

    .header-center {
      text-align: center;
      margin-bottom: 4rem;
      max-width: 820px;
      margin-left: auto;
      margin-right: auto;
    }
    .header-center p{ color: var(--text-body); }

    /* =========================
       5) HERO
    ========================== */
    .hero{
      padding: 7rem 0 5.5rem;
      text-align: center;
      background:
        radial-gradient(900px 450px at 50% 0%, rgba(37,99,235,0.10), transparent 55%);
    }

    .hero-badge{
      background: var(--primary-light);
      color: var(--primary);
      padding: 8px 16px;
      border-radius: 999px;
      font-weight: 900;
      font-size: 0.85rem;
      display: inline-block;
      margin-bottom: 2rem;
      border: 1px solid rgba(37,99,235,0.18);
    }

    .hero h1{
      font-size: clamp(2.6rem, 4.2vw, 4rem);
      margin-bottom: 1.2rem;
    }

    .hero .hero-accent{ color: var(--primary); }

    .hero p{
      max-width: 760px;
      margin: 0 auto 2.7rem;
      color: var(--text-body);
      font-size: clamp(1.05rem, 1.5vw, 1.25rem);
    }

    .btn-group {
      display: flex;
      gap: 14px;
      justify-content: center;
      margin-bottom: 0; /* removed bento grid gap */
      flex-wrap: wrap;
    }

    .btn{
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 12px;
      font-weight: 900;
      cursor: pointer;
      border: 1px solid transparent;
      transition: transform var(--dur) var(--ease), box-shadow var(--dur) var(--ease), background var(--dur) var(--ease), border-color var(--dur) var(--ease);
      user-select: none;
    }
    .btn-xl{
      padding: 16px 28px;
      font-size: 1.05rem;
    }
    .btn-pri{
      background: var(--primary);
      color: white;
      box-shadow: 0 10px 24px rgba(37,99,235,0.25);
      border-color: rgba(37,99,235,0.25);
    }
    .btn-pri:hover{
      transform: translateY(-2px);
      background: var(--primary-dark);
      box-shadow: 0 18px 40px rgba(37,99,235,0.32);
    }
    .btn-sec{
      background: var(--bg-elev);
      color: var(--text-head);
      border-color: var(--border);
      box-shadow: var(--shadow-sm);
    }
    .btn-sec:hover{
      transform: translateY(-1px);
      border-color: rgba(15,23,42,0.35);
    }

    /* =========================
       6) COMPARISON
    ========================== */
    .comp-card{
      padding: 2.5rem;
      border-radius: 18px;
      border: 1px solid var(--border);
      background: var(--bg-elev);
      box-shadow: var(--shadow-card);
    }
    .comp-card.highlight{
      border: 2px solid rgba(37,99,235,0.65);
      background: linear-gradient(180deg, rgba(37,99,235,0.06), transparent 55%);
      position: relative;
    }
    .comp-badge{
      position: absolute;
      top: -14px;
      right: 28px;
      background: var(--primary);
      color: white;
      padding: 6px 12px;
      border-radius: 999px;
      font-weight: 900;
      font-size: 0.78rem;
      letter-spacing: 0.4px;
      box-shadow: 0 10px 22px rgba(37,99,235,0.22);
    }

    .check-list li{
      display: flex;
      gap: 12px;
      margin-bottom: 14px;
      align-items: flex-start;
      font-size: 1.02rem;
      color: var(--text-body);
    }
    .check-list li strong{ color: var(--text-head); }
    .icon{
      width: 24px;
      height: 24px;
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      font-weight: 900;
      font-size: 0.85rem;
      line-height: 1;
      margin-top: 2px;
      border: 1px solid transparent;
    }
    .icon.x{ background: rgba(239,68,68,0.12); color: var(--danger); border-color: rgba(239,68,68,0.18); }
    .icon.c{ background: rgba(16,185,129,0.12); color: var(--success); border-color: rgba(16,185,129,0.18); }
    .icon.p{ background: rgba(37,99,235,0.12); color: var(--primary); border-color: rgba(37,99,235,0.18); }

    /* =========================
       7) PRICING
    ========================== */
    .price-card{
      background: var(--bg-elev);
      border: 1px solid var(--border);
      border-radius: 18px;
      padding: 2.4rem;
      position: relative;
      overflow: hidden;
      height: 100%;
      display: flex;
      flex-direction: column;
      box-shadow: var(--shadow-card);
      transition: transform 260ms var(--ease), box-shadow 260ms var(--ease), border-color 260ms var(--ease);
      will-change: transform;
    }

    /* Spotlight overlay (disabled on touch, enabled only on hover capable devices) */
    .price-card::before{
      content: "";
      position: absolute;
      inset: 0;
      background: radial-gradient(600px circle at var(--mouse-x, 50%) var(--mouse-y, 0%), rgba(37,99,235,0.10), transparent 45%);
      opacity: 0;
      transition: opacity 420ms var(--ease);
      pointer-events: none;
      z-index: 0;
    }
    @media (hover: hover) and (pointer: fine){
      .price-card:hover::before{ opacity: 1; }
      .price-card:hover{
        transform: translateY(-4px);
        box-shadow: var(--shadow-lift);
        border-color: rgba(37,99,235,0.30);
      }
    }

    .card-content{
      position: relative;
      z-index: 1;
      display: flex;
      flex-direction: column;
      height: 100%;
      gap: 10px;
    }

    .plan-kicker{
      font-size: 0.92rem;
      font-weight: 800;
      color: var(--text-muted);
    }
    .plan-kicker.green{ color: #10B981; }
    .plan-kicker.purple{ color: #7C3AED; }

    .price-card h3{ font-size: 1.45rem; }
    .price-amount{
      font-size: 3.2rem;
      font-weight: 900;
      color: var(--text-head);
      margin: 1.0rem 0 1.2rem;
      letter-spacing: -1px;
      line-height: 1;
    }
    .price-amount span{
      font-size: 1rem;
      color: var(--text-body);
      font-weight: 700;
      margin-left: 6px;
    }

    .price-btn{
      width: 100%;
      padding: 14px;
      border-radius: 12px;
      font-weight: 900;
      text-align: center;
      margin-top: auto;
      cursor: pointer;
      border: 1px solid transparent;
      font-size: 1rem;
    }
    .btn-outline{
      background: transparent;
      border-color: var(--border);
      color: var(--text-head);
    }
    .btn-outline:hover{ border-color: rgba(15,23,42,0.35); }

    .btn-solid{
      background: var(--primary);
      color: white;
      border-color: rgba(37,99,235,0.25);
      box-shadow: 0 10px 22px rgba(37,99,235,0.22);
    }
    .btn-solid:hover{
      background: var(--primary-dark);
      transform: translateY(-1px);
      box-shadow: 0 16px 30px rgba(37,99,235,0.30);
    }

    /* Featured plan */
    .price-card.featured{
      border: 2px solid rgba(37,99,235,0.60);
      box-shadow: 0 18px 40px rgba(37,99,235,0.10);
    }
    .plan-badge{
      position: absolute;
      top: 18px;
      right: 18px;
      background: rgba(37,99,235,0.12);
      color: var(--primary);
      border: 1px solid rgba(37,99,235,0.20);
      padding: 6px 10px;
      border-radius: 999px;
      font-size: 0.78rem;
      font-weight: 900;
      z-index: 2;
    }

    .emergency-note{
      text-align: center;
      margin-top: 2rem;
      font-size: 0.98rem;
      color: var(--text-body);
    }
    .tag-emergency{
      background: rgba(239,68,68,0.12);
      color: var(--danger);
      padding: 3px 10px;
      border-radius: 999px;
      font-weight: 900;
      font-size: 0.80rem;
      margin-right: 10px;
      border: 1px solid rgba(239,68,68,0.18);
      display: inline-block;
    }

    /* =========================
       8) TABLE (A11Y + THEME SAFE)
    ========================== */
    .table-wrapper{
      overflow-x: auto;
      border: 1px solid var(--border);
      border-radius: 16px;
      background: var(--bg-elev);
      margin-top: 4rem;
      box-shadow: var(--shadow-card);
    }
    table{
      width: 100%;
      border-collapse: collapse;
      min-width: 860px;
    }
    caption{
      text-align: left;
      padding: 14px 18px;
      font-weight: 900;
      color: var(--text-head);
      border-bottom: 1px solid var(--border);
      background: rgba(37,99,235,0.06);
    }
    th{
      background: var(--table-head-bg);
      text-align: left;
      padding: 1.25rem 1.5rem;
      font-size: 0.82rem;
      text-transform: uppercase;
      color: var(--text-muted);
      letter-spacing: 1px;
      border-bottom: 1px solid var(--border);
    }
    td{
      padding: 1.25rem 1.5rem;
      border-top: 1px solid var(--border);
      color: var(--text-body);
      font-size: 0.98rem;
    }
    td:first-child{
      font-weight: 900;
      color: var(--text-head);
      width: 28%;
    }
    .col-highlight{ background: rgba(37,99,235,0.05); }
    .t-strong{ font-weight: 900; color: var(--primary); }

    /* =========================
       9) TERMINAL (SAFE TYPEWRITER)
    ========================== */
    .terminal-container{
      background: var(--term-bg);
      border-radius: 16px;
      box-shadow: var(--shadow-lift);
      max-width: 920px;
      margin: 0 auto;
      font-family: 'JetBrains Mono', ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
      border: 1px solid var(--term-border);
      overflow: hidden;
    }
    .term-bar{
      background: var(--term-bar);
      padding: 12px 18px;
      display: flex;
      gap: 8px;
      align-items: center;
      border-bottom: 1px solid var(--term-border);
    }
    .dot{ width: 12px; height: 12px; border-radius: 50%; }
    .term-title{
      margin-left: auto;
      font-size: 0.82rem;
      color: #94A3B8;
      font-weight: 800;
    }
    .term-content{
      padding: 2.6rem;
      color: var(--term-text);
      font-size: 0.95rem;
      line-height: 1.75;
      min-height: 320px;
      white-space: pre-wrap;
      word-break: break-word;
    }

    .cursor{
      display: inline-block;
      width: 8px;
      height: 18px;
      background: var(--primary);
      animation: blink 1s infinite;
      vertical-align: middle;
      border-radius: 2px;
      margin-left: 2px;
    }
    @keyframes blink { 50% { opacity: 0; } }

    /* =========================
       10) FAQ (ACCORDION)
    ========================== */
    .faq-accordion{
      max-width: 920px;
      margin: 0 auto;
      display: grid;
      gap: 14px;
    }

    .faq-item{
      background: var(--bg-elev);
      border: 1px solid var(--border);
      border-radius: 16px;
      box-shadow: var(--shadow-card);
      overflow: hidden;
    }

    .faq-q{
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      padding: 18px 18px;
      background: transparent;
      border: 0;
      cursor: pointer;
      text-align: left;
      color: var(--text-head);
      font-weight: 900;
      font-size: 1.05rem;
    }

    .faq-q:hover{
      background: rgba(37,99,235,0.04);
    }

    .faq-ico{
      width: 28px;
      height: 28px;
      border-radius: 999px;
      border: 1px solid var(--border);
      position: relative;
      flex-shrink: 0;
      background: var(--bg-page);
    }

    .faq-ico::before,
    .faq-ico::after{
      content: "";
      position: absolute;
      left: 50%;
      top: 50%;
      width: 12px;
      height: 2px;
      background: var(--text-body);
      transform: translate(-50%, -50%);
      transition: transform var(--dur) var(--ease), opacity var(--dur) var(--ease);
      border-radius: 999px;
    }

    .faq-ico::after{
      transform: translate(-50%, -50%) rotate(90deg);
    }

    .faq-item.is-open .faq-ico{
      border-color: rgba(37,99,235,0.35);
    }

    .faq-item.is-open .faq-ico::after{
      opacity: 0; /* + to - */
    }

    .faq-a{
      height: 0;
      overflow: hidden;
      transition: height 260ms var(--ease);
    }

    .faq-a-inner{
      padding: 0 18px 18px 18px;
      color: var(--text-body);
      font-size: 1rem;
      line-height: 1.7;
    }

    .faq-item.is-open{
      border-color: rgba(37,99,235,0.35);
      box-shadow: var(--shadow-lift);
    }

    /* =========================
       12) REVEAL (IntersectionObserver)
    ========================== */
    .reveal{
      opacity: 0;
      transform: translateY(18px);
      transition: opacity 700ms var(--ease), transform 700ms var(--ease);
    }
    .reveal.active{
      opacity: 1;
      transform: translateY(0);
    }
    .delay-1{ transition-delay: 120ms; }
    .delay-2{ transition-delay: 240ms; }
    .delay-3{ transition-delay: 360ms; }
  </style>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <a class="skip-link" href="#main">Skip to content</a>

  <main id="main">
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
  </main>

  <script>
    /* =========================================
       1) REVEAL (IntersectionObserver)
    ========================================= */
    (function initReveal(){
      const els = document.querySelectorAll(".reveal");
      if (!("IntersectionObserver" in window)) {
        els.forEach(el => el.classList.add("active"));
        return;
      }
      const io = new IntersectionObserver((entries) => {
        for (const entry of entries) {
          if (entry.isIntersecting) {
            entry.target.classList.add("active");
            io.unobserve(entry.target);
          }
        }
      }, { threshold: 0.12 });
      els.forEach(el => io.observe(el));
    })();

    /* =========================================
       2) PRICING SPOTLIGHT (hover devices only)
    ========================================= */
    (function initSpotlight(){
      const canHover = window.matchMedia("(hover: hover) and (pointer: fine)").matches;
      if (!canHover) return;

      const grid = document.getElementById("pricing-grid");
      const cards = grid ? grid.querySelectorAll(".price-card") : [];
      if (!grid || !cards.length) return;

      let raf = null;
      let lastEvent = null;

      const update = () => {
        raf = null;
        if (!lastEvent) return;
        const e = lastEvent;
        cards.forEach(card => {
          const rect = card.getBoundingClientRect();
          const x = e.clientX - rect.left;
          const y = e.clientY - rect.top;
          card.style.setProperty("--mouse-x", x + "px");
          card.style.setProperty("--mouse-y", y + "px");
        });
      };

      grid.addEventListener("mousemove", (e) => {
        lastEvent = e;
        if (!raf) raf = requestAnimationFrame(update);
      });
    })();

    /* =========================================
       3) TYPEWRITER (safe: no innerHTML)
    ========================================= */
    (function initTypewriter(){
      const prefersReduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
      const target = document.getElementById("typewriter-text");
      const section = document.getElementById("terminal-section");
      if (!target || !section) return;

      const text =
`// INCLUDED_TASKS (We Handle)
const fixPluginConflict = true;
const fixCssLayout = true;
const debugContactForm = true;
const wooCheckoutError = true;

// EXCLUDED_TASKS (Custom Quote)
const buildNewFeature = false;
const fullSiteRedesign = false;
const createCustomPlugin = false;

// NOTE: Major work is always quoted separately.`;

      if (prefersReduced) {
        target.textContent = text;
        return;
      }

      let i = 0;
      let started = false;

      const type = () => {
        const chunk = text.slice(i, i + 2);
        target.append(chunk);
        i += 2;
        if (i < text.length) setTimeout(type, 18);
      };

      if (!("IntersectionObserver" in window)) {
        type();
        return;
      }

      const io = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting && !started) {
          started = true;
          type();
          io.disconnect();
        }
      }, { threshold: 0.35 });

      io.observe(section);
    })();

    /* =========================================
       4) FAQ ACCORDION (single-open)
    ========================================= */
    (function initFAQAccordion(){
      const acc = document.querySelector(".faq-accordion");
      if(!acc) return;

      const mode = acc.getAttribute("data-accordion") || "single"; // single | multi
      const items = Array.from(acc.querySelectorAll(".faq-item"));

      const closeItem = (item) => {
        const btn = item.querySelector(".faq-q");
        const panel = item.querySelector(".faq-a");
        item.classList.remove("is-open");
        btn.setAttribute("aria-expanded", "false");
        panel.style.height = "0px";
      };

      const openItem = (item) => {
        const btn = item.querySelector(".faq-q");
        const panel = item.querySelector(".faq-a");
        item.classList.add("is-open");
        btn.setAttribute("aria-expanded", "true");
        panel.style.height = panel.scrollHeight + "px";
      };

      // initial state (optional: open first item)
      items.forEach(item => closeItem(item));
      // openItem(items[0]); // uncomment if you want first open by default

      items.forEach(item => {
        const btn = item.querySelector(".faq-q");
        const panel = item.querySelector(".faq-a");

        btn.addEventListener("click", () => {
          const isOpen = item.classList.contains("is-open");

          if(mode === "single"){
            items.forEach(i => { if(i !== item) closeItem(i); });
          }

          if(isOpen) closeItem(item);
          else openItem(item);
        });

        window.addEventListener("resize", () => {
          if(item.classList.contains("is-open")){
            panel.style.height = panel.scrollHeight + "px";
          }
        });
      });
    })();
  </script>

  <?php wp_footer(); ?>
</body>
</html>
