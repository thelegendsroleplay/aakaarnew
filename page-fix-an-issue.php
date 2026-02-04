<?php
get_header();

if (!function_exists('aakaari_fix_wc_is_active')) {
  function aakaari_fix_wc_is_active() {
    return class_exists('WooCommerce') && function_exists('wc_get_product');
  }
}

if (!function_exists('aakaari_fix_product_for_slug')) {
  function aakaari_fix_product_for_slug($slug) {
    if (!aakaari_fix_wc_is_active()) {
      return null;
    }

    $slug = sanitize_title((string) $slug);
    if ($slug === '') {
      return null;
    }

    $post = get_page_by_path($slug, OBJECT, 'product');
    if (!$post) {
      return null;
    }

    $product = wc_get_product($post->ID);
    return $product ? $product : null;
  }
}

if (!function_exists('aakaari_fix_issue_slug')) {
  function aakaari_fix_issue_slug($issue) {
    if (!empty($issue['product_slug'])) {
      return (string) $issue['product_slug'];
    }

    return sanitize_title((string) ($issue['title'] ?? ''));
  }
}

if (!function_exists('aakaari_fix_money')) {
  function aakaari_fix_money($amount) {
    $amount = (float) $amount;

    if (function_exists('wc_price')) {
      return wp_strip_all_tags(wc_price($amount));
    }

    return '$' . number_format_i18n($amount, 0);
  }
}

if (!function_exists('aakaari_fix_issue_price_text')) {
  function aakaari_fix_issue_price_text($issue) {
    $fallback = isset($issue['from']) ? (float) $issue['from'] : 0.0;
    $fallback_text = $fallback > 0 ? ('From ' . aakaari_fix_money($fallback)) : 'View pricing';

    $product = aakaari_fix_product_for_slug(aakaari_fix_issue_slug($issue));
    if (!$product) {
      return $fallback_text;
    }

    $price = $product->get_price();
    if ($price === '' || $price === null) {
      return $fallback_text;
    }

    $min_price = $product->is_type('variable')
      ? (float) $product->get_variation_price('min', true)
      : (float) $price;

    return 'From ' . aakaari_fix_money($min_price);
  }
}

if (!function_exists('aakaari_fix_issue_eta')) {
  function aakaari_fix_issue_eta($issue) {
    $from = isset($issue['from']) ? (float) $issue['from'] : 0.0;

    if ($from <= 15) {
      return '1-2 hours';
    }
    if ($from <= 19) {
      return '2-4 hours';
    }
    if ($from <= 29) {
      return '4-8 hours';
    }
    if ($from <= 39) {
      return 'Same day';
    }

    return '1-2 days';
  }
}

if (!function_exists('aakaari_fix_issue_urls')) {
  function aakaari_fix_issue_urls($issue) {
    $contact_url = home_url('/contact/');
    $checkout_base = function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout/');

    $product = aakaari_fix_product_for_slug(aakaari_fix_issue_slug($issue));
    if (!$product) {
      return array(
        'product' => $contact_url,
        'checkout' => $contact_url,
        'contact' => $contact_url,
      );
    }

    $product_id = (int) $product->get_id();
    $product_url = get_permalink($product_id);
    $checkout_url = add_query_arg('add-to-cart', $product_id, $checkout_base);

    return array(
      'product' => $product_url,
      'checkout' => $checkout_url,
      'contact' => $contact_url,
    );
  }
}

$sections = array(
  array(
    'id' => 'core',
    'accent' => '59 130 246',
    'icon' => 'code-xml',
    'title' => 'WordPress Core Issues',
    'subtitle' => 'Downtime, errors, and broken functionality in WordPress.',
    'issues' => array(
      array(
        'title' => 'Website Not Opening / Site Down',
        'from' => 19,
        'icon' => 'alert-triangle',
        'desc' => 'Your site is down, stuck loading, or showing an error page.',
        'includes' => array(
          'Server + WordPress diagnostics to find the root cause',
          'Fix the issue and restore the site safely',
          'Basic checks to prevent the same failure again',
        ),
      ),
      array(
        'title' => 'White Screen of Death',
        'from' => 19,
        'icon' => 'monitor-x',
        'desc' => 'Blank page caused by fatal errors, memory limits, or conflicts.',
        'includes' => array(
          'Identify the exact error via logs + debug',
          'Resolve theme/plugin conflict or PHP issue',
          'Bring the site back online without data loss',
        ),
      ),
      array(
        'title' => 'Plugin Conflict',
        'from' => 19,
        'icon' => 'puzzle',
        'desc' => 'Broken features after plugin updates or compatibility issues.',
        'includes' => array(
          'Isolate the conflicting plugin(s) quickly',
          'Safe rollback or patch to restore compatibility',
          'Functional test after fix to confirm stability',
        ),
      ),
      array(
        'title' => 'Forms Not Working',
        'from' => 15,
        'icon' => 'mail',
        'desc' => 'Contact forms not sending, not saving, or failing silently.',
        'includes' => array(
          'Fix mail delivery / SMTP setup (if required)',
          'Test submission end-to-end (admin + inbox)',
          'Basic anti-spam + validation improvements',
        ),
      ),
    ),
  ),
  array(
    'id' => 'hosting',
    'accent' => '139 92 246',
    'icon' => 'server',
    'title' => 'Infrastructure & Hosting',
    'subtitle' => 'Server errors, DNS issues, migrations, and hosting setup.',
    'issues' => array(
      array(
        'title' => '500 Internal Server Error',
        'from' => 19,
        'icon' => 'server-crash',
        'desc' => 'Server returns 500 due to config, PHP, or permission issues.',
        'includes' => array(
          'Audit logs + configuration (htaccess/nginx/php)',
          'Fix permissions, memory, or rewrite issues',
          'Confirm site loads and key pages work',
        ),
      ),
      array(
        'title' => 'Database Connection Error',
        'from' => 19,
        'icon' => 'database',
        'desc' => 'Database credentials, corrupted tables, or a down DB server.',
        'includes' => array(
          'Verify DB connection + server health',
          'Repair tables / fix wp-config settings',
          'Validate admin + frontend after recovery',
        ),
      ),
      array(
        'title' => 'Email Not Sending',
        'from' => 15,
        'icon' => 'mail-x',
        'desc' => 'WP emails not delivered (password reset, orders, notifications).',
        'includes' => array(
          'Diagnose delivery + server mail settings',
          'Configure SMTP/provider if needed',
          'Test common email flows on your site',
        ),
      ),
      array(
        'title' => 'Server Configuration Issue',
        'from' => 39,
        'icon' => 'settings',
        'desc' => 'PHP, caching, SSL, redirects, or server rules misconfigured.',
        'includes' => array(
          'Review server setup and current configuration',
          'Apply correct settings for WordPress + WooCommerce',
          'Confirm performance and stability after changes',
        ),
      ),
      array(
        'title' => 'DNS / Domain Issue',
        'from' => 15,
        'icon' => 'globe',
        'desc' => 'Domain not pointing correctly, propagation, or SSL mismatch.',
        'includes' => array(
          'Fix DNS records and verify propagation',
          'Resolve redirects / WWW / HTTPS alignment',
          'Confirm site and email records are correct',
        ),
      ),
      array(
        'title' => 'Backup / Migration',
        'from' => 29,
        'icon' => 'hard-drive',
        'desc' => 'Move your site to a new host or restore from backups.',
        'includes' => array(
          'Full backup + migration plan (safe steps)',
          'Move files + DB and update URLs',
          'Post-migration checks: links, forms, checkout',
        ),
      ),
    ),
  ),
  array(
    'id' => 'security',
    'accent' => '239 68 68',
    'icon' => 'shield-alert',
    'title' => 'Security & Hacking',
    'subtitle' => 'Malware cleanup, redirects, SSL problems, and hardening.',
    'issues' => array(
      array(
        'title' => 'Website Hacked / Malware',
        'from' => 39,
        'icon' => 'skull',
        'desc' => 'Unexpected changes, warnings, or malicious files/requests.',
        'includes' => array(
          'Malware scan + removal (core/theme/plugin review)',
          'Close the vulnerability and patch the entry point',
          'Basic hardening + post-cleanup verification',
        ),
      ),
      array(
        'title' => 'Virus / Spam Injection',
        'from' => 29,
        'icon' => 'bug',
        'desc' => 'Spam links/content injected into pages or database.',
        'includes' => array(
          'Clean injected content from DB + files',
          'Fix the source (plugin/theme vulnerabilities)',
          'Verify search + sitemap health after cleanup',
        ),
      ),
      array(
        'title' => 'Redirect Hack',
        'from' => 29,
        'icon' => 'external-link',
        'desc' => 'Users are redirected to spam or malicious websites.',
        'includes' => array(
          'Trace redirects to the exact origin',
          'Remove malicious rules/scripts',
          'Lock down access and re-test from clean devices',
        ),
      ),
      array(
        'title' => 'SSL Error',
        'from' => 15,
        'icon' => 'lock',
        'desc' => 'HTTPS certificate errors or incorrect forced redirects.',
        'includes' => array(
          'Fix certificate chain / install verification',
          'Correct HTTPS redirects and canonical URLs',
          'Confirm checkout + login work securely',
        ),
      ),
      array(
        'title' => 'Mixed Content',
        'from' => 15,
        'icon' => 'shield-off',
        'desc' => 'HTTPS page loading insecure assets and showing warnings.',
        'includes' => array(
          'Replace insecure URLs and assets site-wide',
          'Fix theme/plugin sources causing mixed content',
          'Verify padlock + key pages after changes',
        ),
      ),
    ),
  ),
  array(
    'id' => 'commerce',
    'accent' => '16 185 129',
    'icon' => 'shopping-cart',
    'title' => 'WooCommerce & eCommerce',
    'subtitle' => 'Payments, checkout issues, and order processing fixes.',
    'issues' => array(
      array(
        'title' => 'Payment Gateway',
        'from' => 39,
        'icon' => 'credit-card',
        'desc' => 'Payment failures, gateway errors, or missing payment options.',
        'includes' => array(
          'Diagnose gateway errors and logs',
          'Fix gateway configuration + checkout flow',
          'Test order + payment end-to-end',
        ),
      ),
      array(
        'title' => 'Checkout Issue',
        'from' => 29,
        'icon' => 'shopping-bag',
        'desc' => 'Checkout not loading, fields broken, or checkout not completing.',
        'includes' => array(
          'Fix checkout UI + validation problems',
          'Resolve conflicts with plugins/themes',
          'Confirm order creation and email triggers',
        ),
      ),
      array(
        'title' => 'Order Not Processing',
        'from' => 25,
        'icon' => 'package',
        'desc' => 'Orders stuck, statuses not updating, or webhooks failing.',
        'includes' => array(
          'Review payment/webhook + order status pipeline',
          'Fix automation + plugin conflicts',
          'Verify notifications and order lifecycle',
        ),
      ),
    ),
  ),
  array(
    'id' => 'performance',
    'accent' => '245 158 11',
    'icon' => 'zap',
    'title' => 'Performance Optimization',
    'subtitle' => 'Speed fixes, Core Web Vitals improvements, mobile tuning.',
    'issues' => array(
      array(
        'title' => 'Slow Website',
        'from' => 29,
        'icon' => 'gauge',
        'desc' => 'Slow loading pages, timeouts, or heavy scripts/plugins.',
        'includes' => array(
          'Find bottlenecks (plugins, queries, assets)',
          'Apply safe optimizations (cache, images, CSS/JS)',
          'Re-test key pages and report improvements',
        ),
      ),
      array(
        'title' => 'Core Web Vitals',
        'from' => 35,
        'icon' => 'activity',
        'desc' => 'Improve LCP, CLS, and INP for better SEO and UX.',
        'includes' => array(
          'Audit CWV metrics and identify causes',
          'Fix layout shifts + render-blocking resources',
          'Validate improvements on desktop and mobile',
        ),
      ),
      array(
        'title' => 'Mobile Responsive',
        'from' => 19,
        'icon' => 'smartphone',
        'desc' => 'Layout issues on phones/tablets, overflow, or broken menus.',
        'includes' => array(
          'Fix responsive CSS and common breakpoints',
          'Improve tap targets + spacing for mobile UX',
          'Test on mobile, tablet, and desktop widths',
        ),
      ),
    ),
  ),
  array(
    'id' => 'auth',
    'accent' => '99 102 241',
    'icon' => 'key',
    'title' => 'Authentication & Access',
    'subtitle' => 'Login errors, admin access issues, and role problems.',
    'issues' => array(
      array(
        'title' => 'Login Not Working',
        'from' => 15,
        'icon' => 'log-in',
        'desc' => 'Login loops, errors, or users can\'t sign in.',
        'includes' => array(
          'Fix login loop/cookie/redirect issues',
          'Check plugins and security rules affecting auth',
          'Confirm login works for affected roles',
        ),
      ),
      array(
        'title' => 'Admin Panel Not Accessible',
        'from' => 19,
        'icon' => 'user-x',
        'desc' => 'wp-admin blocked, permission errors, or white screens.',
        'includes' => array(
          'Restore admin access safely',
          'Fix permission rules and plugin conflicts',
          'Validate dashboard + critical settings pages',
        ),
      ),
    ),
  ),
  array(
    'id' => 'design',
    'accent' => '236 72 153',
    'icon' => 'layout',
    'title' => 'Design & Layout',
    'subtitle' => 'Broken layouts, theme issues, and UI fixes.',
    'issues' => array(
      array(
        'title' => 'Theme / Layout Broken',
        'from' => 19,
        'icon' => 'layers',
        'desc' => 'UI broken after updates, CSS issues, or missing components.',
        'includes' => array(
          'Identify theme/CSS breakage or conflicts',
          'Fix layout and component rendering issues',
          'Test across desktop, tablet, and mobile',
        ),
      ),
    ),
  ),
);

$wizard_sections = array();
foreach ($sections as $section) {
  $issues = array();
  foreach ($section['issues'] as $issue) {
    $issues[] = array(
      'title' => $issue['title'] ?? '',
      'desc' => $issue['desc'] ?? '',
      'includes' => $issue['includes'] ?? array(),
      'from' => isset($issue['from']) ? (float) $issue['from'] : 0.0,
      'price_text' => aakaari_fix_issue_price_text($issue),
      'icon' => $issue['icon'] ?? '',
      'slug' => aakaari_fix_issue_slug($issue),
      'eta' => aakaari_fix_issue_eta($issue),
      'urls' => aakaari_fix_issue_urls($issue),
    );
  }

  $wizard_sections[] = array(
    'id' => $section['id'],
    'title' => $section['title'],
    'subtitle' => $section['subtitle'],
    'accent' => $section['accent'],
    'icon' => $section['icon'],
    'issues' => $issues,
  );
}
?>

<div class="fix-page">
  <!-- SVG Sprite Definitions -->
  <svg xmlns="http://www.w3.org/2000/svg" class="fix-svg-sprite" aria-hidden="true">
    <defs>
      <linearGradient id="fix-gradient-hero" x1="0%" y1="0%" x2="100%" y2="100%">
        <stop offset="0%" stop-color="#667eea"/>
        <stop offset="50%" stop-color="#764ba2"/>
        <stop offset="100%" stop-color="#f093fb"/>
      </linearGradient>
    </defs>

    <!-- Icons -->
    <symbol id="fix-icon-code-xml" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m18 16 4-4-4-4"/><path d="m6 8-4 4 4 4"/><path d="m14.5 4-5 16"/>
    </symbol>
    <symbol id="fix-icon-server" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <rect width="20" height="8" x="2" y="2" rx="2" ry="2"/><rect width="20" height="8" x="2" y="14" rx="2" ry="2"/><line x1="6" x2="6.01" y1="6" y2="6"/><line x1="6" x2="6.01" y1="18" y2="18"/>
    </symbol>
    <symbol id="fix-icon-shield-alert" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="M12 8v4"/><path d="M12 16h.01"/>
    </symbol>
    <symbol id="fix-icon-shopping-cart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
    </symbol>
    <symbol id="fix-icon-zap" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.9 6.02a1 1 0 0 0 .95 1.33h6.43a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.9-6.02A1 1 0 0 0 11.4 14z"/>
    </symbol>
    <symbol id="fix-icon-key" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m15.5 7.5 2.3 2.3a1 1 0 0 0 1.4 0l2.1-2.1a1 1 0 0 0 0-1.4L19 4"/><path d="m21 2-9.6 9.6"/><circle cx="7.5" cy="15.5" r="5.5"/>
    </symbol>
    <symbol id="fix-icon-layout" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/>
    </symbol>
    <symbol id="fix-icon-alert-triangle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m21.73 18-8-14a2 2 0 0 0-3.46 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/>
    </symbol>
    <symbol id="fix-icon-monitor-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M14.5 12.5 10 8"/><path d="m10 12.5 4.5-4.5"/><rect width="20" height="14" x="2" y="3" rx="2"/><path d="M12 17v4"/><path d="M8 21h8"/>
    </symbol>
    <symbol id="fix-icon-puzzle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M15.39 4.39a1 1 0 0 0 0 1.68l.39.39H14a2 2 0 0 0-2 2v1.78l-.39-.39a1 1 0 0 0-1.68 0l-.39.39a1 1 0 0 0 0 1.68l.39.39H8a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h1.78l-.39.39a1 1 0 0 0 0 1.68l.39.39a1 1 0 0 0 1.68 0l.39-.39H14a2 2 0 0 0 2-2v-1.78l.39.39a1 1 0 0 0 1.68 0l.39-.39a1 1 0 0 0 0-1.68l-.39-.39H20a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-1.78l.39-.39a1 1 0 0 0 0-1.68l-.39-.39a1 1 0 0 0-1.68 0l-.39.39V6a2 2 0 0 0-2-2h-2"/>
    </symbol>
    <symbol id="fix-icon-mail" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
    </symbol>
    <symbol id="fix-icon-server-crash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M6 10H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-2"/><path d="M6 14H4a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-2"/><path d="M6 6h.01"/><path d="M6 18h.01"/><path d="m13 6-4 6h6l-4 6"/>
    </symbol>
    <symbol id="fix-icon-database" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5V19A9 3 0 0 0 21 19V5"/><path d="M3 12A9 3 0 0 0 21 12"/>
    </symbol>
    <symbol id="fix-icon-mail-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h9"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/><path d="m17 17 4 4"/><path d="m21 17-4 4"/>
    </symbol>
    <symbol id="fix-icon-settings" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/>
    </symbol>
    <symbol id="fix-icon-globe" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/>
    </symbol>
    <symbol id="fix-icon-hard-drive" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <line x1="22" x2="2" y1="12" y2="12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/><line x1="6" x2="6.01" y1="16" y2="16"/><line x1="10" x2="10.01" y1="16" y2="16"/>
    </symbol>
    <symbol id="fix-icon-skull" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="9" cy="12" r="1"/><circle cx="15" cy="12" r="1"/><path d="M8 20v2h8v-2"/><path d="m12.5 17-.5-1-.5 1h1z"/><path d="M16 20a2 2 0 0 0 1.56-3.25 8 8 0 1 0-11.12 0A2 2 0 0 0 8 20"/>
    </symbol>
    <symbol id="fix-icon-bug" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m8 2 1.88 1.88"/><path d="M14.12 3.88 16 2"/><path d="M9 7.13v-1a3.003 3.003 0 1 1 6 0v1"/><path d="M12 20c-3.3 0-6-2.7-6-6v-3a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v3c0 3.3-2.7 6-6 6"/><path d="M12 20v-9"/><path d="M6.53 9C4.6 8.8 3 7.1 3 5"/><path d="M6 13H2"/><path d="M3 21c0-2.1 1.7-3.9 3.8-4"/><path d="M20.97 5c0 2.1-1.6 3.8-3.5 4"/><path d="M22 13h-4"/><path d="M17.2 17c2.1.1 3.8 1.9 3.8 4"/>
    </symbol>
    <symbol id="fix-icon-external-link" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
    </symbol>
    <symbol id="fix-icon-lock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
    </symbol>
    <symbol id="fix-icon-shield-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m2 2 20 20"/><path d="M5 5a1 1 0 0 0-1 1v7c0 5 3.5 7.5 7.67 8.94a1 1 0 0 0 .67.01c2.35-.82 4.48-1.97 5.9-3.71"/><path d="M9.309 3.652A12.252 12.252 0 0 0 11.24 2.28a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1v7a9.784 9.784 0 0 1-.08 1.264"/>
    </symbol>
    <symbol id="fix-icon-credit-card" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/>
    </symbol>
    <symbol id="fix-icon-shopping-bag" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/>
    </symbol>
    <symbol id="fix-icon-package" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/>
    </symbol>
    <symbol id="fix-icon-gauge" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m12 14 4-4"/><path d="M3.34 19a10 10 0 1 1 17.32 0"/>
    </symbol>
    <symbol id="fix-icon-activity" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2"/>
    </symbol>
    <symbol id="fix-icon-smartphone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/>
    </symbol>
    <symbol id="fix-icon-log-in" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/>
    </symbol>
    <symbol id="fix-icon-user-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="17" x2="22" y1="8" y2="13"/><line x1="22" x2="17" y1="8" y2="13"/>
    </symbol>
    <symbol id="fix-icon-layers" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83Z"/><path d="m22 17.65-9.17 4.16a2 2 0 0 1-1.66 0L2 17.65"/><path d="m22 12.65-9.17 4.16a2 2 0 0 1-1.66 0L2 12.65"/>
    </symbol>
    <symbol id="fix-icon-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <path d="M20 6 9 17l-5-5"/>
    </symbol>
    <symbol id="fix-icon-chevron-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m6 9 6 6 6-6"/>
    </symbol>
    <symbol id="fix-icon-arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
    </symbol>
    <symbol id="fix-icon-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
    </symbol>
    <symbol id="fix-icon-headphones" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M3 14h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7a9 9 0 0 1 18 0v7a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"/>
    </symbol>
    <symbol id="fix-icon-dollar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
    </symbol>
    <symbol id="fix-icon-message-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/>
    </symbol>
  </svg>

  <!-- Hero Section -->
  <section class="fix-hero">
    <div class="fix-hero-bg">
      <div class="fix-hero-gradient"></div>
      <div class="fix-hero-pattern"></div>
      <div class="fix-hero-orbs">
        <div class="fix-hero-orb fix-hero-orb-1"></div>
        <div class="fix-hero-orb fix-hero-orb-2"></div>
        <div class="fix-hero-orb fix-hero-orb-3"></div>
      </div>
    </div>

    <div class="fix-container">
      <div class="fix-hero-content">
        <div class="fix-hero-badge">
          <svg class="fix-hero-badge-icon"><use href="#fix-icon-zap"/></svg>
          <span>Fast & Professional Support</span>
        </div>

        <h1 class="fix-hero-title">
          What Needs <span class="fix-hero-title-highlight">Fixing?</span>
        </h1>

        <p class="fix-hero-subtitle">
          Select your issue below and get expert help. Transparent pricing, fast turnaround, and satisfaction guaranteed.
        </p>

        <div class="fix-hero-stats">
          <div class="fix-hero-stat">
            <div class="fix-hero-stat-icon">
              <svg><use href="#fix-icon-headphones"/></svg>
            </div>
            <div class="fix-hero-stat-content">
              <span class="fix-hero-stat-value">24/7</span>
              <span class="fix-hero-stat-label">Expert Support</span>
            </div>
          </div>
          <div class="fix-hero-stat">
            <div class="fix-hero-stat-icon">
              <svg><use href="#fix-icon-clock"/></svg>
            </div>
            <div class="fix-hero-stat-content">
              <span class="fix-hero-stat-value">&lt; 2 hrs</span>
              <span class="fix-hero-stat-label">Avg Response</span>
            </div>
          </div>
          <div class="fix-hero-stat">
            <div class="fix-hero-stat-icon">
              <svg><use href="#fix-icon-dollar"/></svg>
            </div>
            <div class="fix-hero-stat-content">
              <span class="fix-hero-stat-value">Fixed</span>
              <span class="fix-hero-stat-label">Pricing</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Issue Fixer Wizard -->
  <section class="fix-wizard" aria-labelledby="fix-wizard-title">
    <div class="fix-container">
      <div class="fix-wizard-shell" data-fix-wizard data-contact-url="<?php echo esc_url(home_url('/contact/')); ?>">
        <div class="fix-wizard-top">
          <div class="fix-wizard-intro">
            <p class="fix-wizard-eyebrow">Issue Fixer Wizard</p>
            <h2 id="fix-wizard-title" class="fix-wizard-title">Find the right fix in minutes</h2>
            <p class="fix-wizard-subtitle">Describe the symptoms or pick a category. We will recommend the right repair with price and ETA.</p>
          </div>
          <div class="fix-wizard-trust">
            <div class="fix-wizard-trust-item">
              <span class="fix-wizard-trust-value">5,000+</span>
              <span class="fix-wizard-trust-label">Issues fixed</span>
            </div>
            <div class="fix-wizard-trust-item">
              <span class="fix-wizard-trust-value">4.9/5</span>
              <span class="fix-wizard-trust-label">Customer rating</span>
            </div>
            <div class="fix-wizard-trust-item">
              <span class="fix-wizard-trust-value">2 hrs</span>
              <span class="fix-wizard-trust-label">Avg response</span>
            </div>
          </div>
        </div>

        <ol class="fix-stepper" role="list">
          <li class="fix-stepper-item is-active" data-fix-step-item>
            <span class="fix-stepper-dot">1</span>
            <span class="fix-stepper-label">Describe</span>
          </li>
          <li class="fix-stepper-item" data-fix-step-item>
            <span class="fix-stepper-dot">2</span>
            <span class="fix-stepper-label">Select</span>
          </li>
          <li class="fix-stepper-item" data-fix-step-item>
            <span class="fix-stepper-dot">3</span>
            <span class="fix-stepper-label">Review</span>
          </li>
        </ol>
        <div class="fix-stepper-track">
          <span class="fix-stepper-progress" data-fix-progress></span>
        </div>
        <div class="fix-stepper-status">
          <span class="fix-stepper-status-label">Current step</span>
          <span class="fix-stepper-status-value" data-fix-step-label>Describe</span>
        </div>

        <div class="fix-step is-active" data-fix-step>
          <div class="fix-step-grid">
            <div class="fix-step-panel">
              <label class="fix-step-label" for="fix-issue-search">Describe your issue</label>
              <div class="fix-search">
                <input id="fix-issue-search" class="fix-search-input" type="text" placeholder="Example: site down, payment failing, critical error" data-fix-search />
                <button type="button" class="fix-search-clear" data-fix-clear>Clear</button>
              </div>
              <div class="fix-suggestions">
                <button type="button" class="fix-suggestion" data-fix-suggestion="site down">Site down</button>
                <button type="button" class="fix-suggestion" data-fix-suggestion="payment failing">Payment failing</button>
                <button type="button" class="fix-suggestion" data-fix-suggestion="slow website">Slow website</button>
                <button type="button" class="fix-suggestion" data-fix-suggestion="hacked">Hacked site</button>
                <button type="button" class="fix-suggestion" data-fix-suggestion="white screen">White screen</button>
              </div>
              <p class="fix-step-note">Not sure what to type? Pick a category and we will narrow it down for you.</p>
            </div>

            <div class="fix-step-panel">
              <p class="fix-step-label">Pick a category</p>
              <div class="fix-category-grid">
                <button type="button" class="fix-category-card is-active" data-fix-category="all" style="--accent: 99 102 241;">
                  <span class="fix-category-icon">
                    <svg><use href="#fix-icon-layers"/></svg>
                  </span>
                  <span class="fix-category-title">All Issues</span>
                  <span class="fix-category-desc">Browse every available fix.</span>
                </button>
                <?php foreach ($sections as $section) { ?>
                  <button type="button" class="fix-category-card" data-fix-category="<?php echo esc_attr($section['id']); ?>" style="--accent: <?php echo esc_attr($section['accent']); ?>;">
                    <span class="fix-category-icon">
                      <svg><use href="#fix-icon-<?php echo esc_attr($section['icon']); ?>"/></svg>
                    </span>
                    <span class="fix-category-title"><?php echo esc_html($section['title']); ?></span>
                    <span class="fix-category-desc"><?php echo esc_html($section['subtitle']); ?></span>
                  </button>
                <?php } ?>
                <a class="fix-category-card fix-category-card-ghost" href="<?php echo esc_url(home_url('/contact/')); ?>">
                  <span class="fix-category-icon">
                    <svg><use href="#fix-icon-message-circle"/></svg>
                  </span>
                  <span class="fix-category-title">Not sure?</span>
                  <span class="fix-category-desc">Tell us what is happening.</span>
                </a>
              </div>
            </div>
          </div>

          <div class="fix-step-actions">
            <button type="button" class="fix-primary-btn" data-fix-continue>Show matching issues</button>
            <a class="fix-secondary-btn" href="<?php echo esc_url(home_url('/contact/')); ?>">I am not sure</a>
          </div>
        </div>

        <div class="fix-step" data-fix-step hidden>
          <div class="fix-results-header">
            <div>
              <p class="fix-results-kicker">Step 2</p>
              <h3 class="fix-results-title">Select the issue that matches</h3>
              <p class="fix-results-meta"><span data-fix-count>0</span> matches <span data-fix-filter></span></p>
            </div>
            <div class="fix-results-actions">
              <button type="button" class="fix-secondary-btn" data-fix-back="0">Back</button>
              <button type="button" class="fix-secondary-btn" data-fix-reset>Reset</button>
            </div>
          </div>
          <div class="fix-results-search">
            <input class="fix-search-input" type="text" placeholder="Filter results (ex: checkout, malware, DNS)" data-fix-search />
          </div>
          <div class="fix-results-grid" data-fix-results></div>
          <div class="fix-results-footer">
            <div class="fix-results-help">
              <span>Still not sure? Describe the problem and we will route you to the right expert.</span>
              <a class="fix-link" href="<?php echo esc_url(home_url('/contact/')); ?>">Contact support</a>
            </div>
          </div>
        </div>

        <div class="fix-step" data-fix-step hidden>
          <div class="fix-results-header">
            <div>
              <p class="fix-results-kicker">Step 3</p>
              <h3 class="fix-results-title">Review and checkout</h3>
              <p class="fix-results-meta">Confirm the fix scope, ETA, and pricing before checkout.</p>
            </div>
            <div class="fix-results-actions">
              <button type="button" class="fix-secondary-btn" data-fix-back="1">Back</button>
            </div>
          </div>
          <div class="fix-review-grid">
            <div class="fix-review-slot" data-fix-review></div>
            <aside class="fix-review-sidebar">
              <div class="fix-review-panel">
                <h4>What affects pricing</h4>
                <ul>
                  <li>Severity and number of affected pages</li>
                  <li>Third-party access (hosting, DNS, payment gateways)</li>
                  <li>Advanced recovery or security hardening needs</li>
                </ul>
              </div>
              <div class="fix-review-panel fix-review-panel-accent">
                <h4>Satisfaction guaranteed</h4>
                <p>If we cannot resolve your issue, we will refund you. You will always know the price before work begins.</p>
              </div>
              <div class="fix-review-panel">
                <h4>Need this done urgently?</h4>
                <p>Let us know during checkout. We can prioritize critical issues and schedule an immediate response.</p>
              </div>
            </aside>
          </div>
        </div>
      </div>
    </div>
  </section>

  <details class="fix-browse">
    <summary class="fix-browse-summary">
      <span>Browse all issues</span>
      <svg class="fix-browse-chevron"><use href="#fix-icon-chevron-down"/></svg>
    </summary>

    <!-- Category Navigation -->
    <nav class="fix-nav" aria-label="Issue categories">
      <div class="fix-container">
        <div class="fix-nav-scroll">
          <?php foreach ($sections as $section) { ?>
            <a class="fix-nav-item" href="#fix-<?php echo esc_attr($section['id']); ?>" style="--accent: <?php echo esc_attr($section['accent']); ?>;">
              <span class="fix-nav-item-dot"></span>
              <span class="fix-nav-item-text"><?php echo esc_html($section['title']); ?></span>
            </a>
          <?php } ?>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="fix-main">
      <div class="fix-container">
        <?php foreach ($sections as $section) { ?>
          <section id="fix-<?php echo esc_attr($section['id']); ?>" class="fix-section" style="--accent: <?php echo esc_attr($section['accent']); ?>;">
            <header class="fix-section-header">
              <div class="fix-section-icon-wrap">
                <div class="fix-section-icon">
                  <svg><use href="#fix-icon-<?php echo esc_attr($section['icon']); ?>"/></svg>
                </div>
                <div class="fix-section-icon-glow"></div>
              </div>
              <div class="fix-section-info">
                <h2 class="fix-section-title"><?php echo esc_html($section['title']); ?></h2>
                <p class="fix-section-desc"><?php echo esc_html($section['subtitle']); ?></p>
              </div>
            </header>

            <div class="fix-cards">
              <?php foreach ($section['issues'] as $issue) { ?>
                <?php
                $price_text = aakaari_fix_issue_price_text($issue);
                $urls = aakaari_fix_issue_urls($issue);
                ?>
                <article class="fix-card">
                  <div class="fix-card-header">
                    <div class="fix-card-icon">
                      <svg><use href="#fix-icon-<?php echo esc_attr($issue['icon']); ?>"/></svg>
                    </div>
                    <div class="fix-card-badge"><?php echo esc_html($price_text); ?></div>
                  </div>

                  <div class="fix-card-content">
                    <h3 class="fix-card-title"><?php echo esc_html($issue['title']); ?></h3>
                    <p class="fix-card-desc"><?php echo esc_html($issue['desc']); ?></p>
                  </div>

                  <div class="fix-card-features">
                    <div class="fix-card-features-label">What's included:</div>
                    <ul class="fix-card-features-list">
                      <?php foreach ($issue['includes'] as $item) { ?>
                        <li>
                          <svg class="fix-card-check"><use href="#fix-icon-check"/></svg>
                          <span><?php echo esc_html($item); ?></span>
                        </li>
                      <?php } ?>
                    </ul>
                  </div>

                  <div class="fix-card-actions">
                    <a class="fix-card-btn fix-card-btn-primary" href="<?php echo esc_url($urls['checkout']); ?>">
                      <span>Select &amp; Checkout</span>
                      <svg><use href="#fix-icon-arrow-right"/></svg>
                    </a>
                    <a class="fix-card-btn fix-card-btn-secondary" href="<?php echo esc_url($urls['product']); ?>">
                      View Details
                    </a>
                  </div>
                </article>
              <?php } ?>
            </div>
          </section>
        <?php } ?>

        <!-- Help CTA Section -->
        <section class="fix-help">
          <div class="fix-help-content">
            <div class="fix-help-icon">
              <svg><use href="#fix-icon-message-circle"/></svg>
            </div>
            <div class="fix-help-text">
              <h3 class="fix-help-title">Not sure which issue to pick?</h3>
              <p class="fix-help-desc">Tell us what you're experiencing and we'll route you to the right expert.</p>
            </div>
          </div>
          <a class="fix-help-btn" href="<?php echo esc_url(home_url('/contact/')); ?>">
            <span>Contact Support</span>
            <svg><use href="#fix-icon-arrow-right"/></svg>
          </a>
        </section>
      </div>
    </main>
  </details>
</div>

<script type="application/json" id="aakaari-fix-data"><?php echo wp_json_encode($wizard_sections); ?></script>
<script>
(() => {
  const dataEl = document.getElementById('aakaari-fix-data');
  if (!dataEl) return;

  let sections = [];
  try {
    sections = JSON.parse(dataEl.textContent || '[]');
  } catch (error) {
    return;
  }

  const wizard = document.querySelector('[data-fix-wizard]');
  if (!wizard) return;

  const contactUrl = wizard.getAttribute('data-contact-url') || '/contact/';
  const stepEls = Array.from(wizard.querySelectorAll('[data-fix-step]'));
  const stepItems = Array.from(wizard.querySelectorAll('[data-fix-step-item]'));
  const progressEl = wizard.querySelector('[data-fix-progress]');
  const stepLabelEl = wizard.querySelector('[data-fix-step-label]');
  const searchInputs = Array.from(wizard.querySelectorAll('[data-fix-search]'));
  const suggestionBtns = Array.from(wizard.querySelectorAll('[data-fix-suggestion]'));
  const categoryBtns = Array.from(wizard.querySelectorAll('[data-fix-category]'));
  const continueBtn = wizard.querySelector('[data-fix-continue]');
  const clearBtn = wizard.querySelector('[data-fix-clear]');
  const backBtns = Array.from(wizard.querySelectorAll('[data-fix-back]'));
  const resetBtn = wizard.querySelector('[data-fix-reset]');
  const resultsEl = wizard.querySelector('[data-fix-results]');
  const countEl = wizard.querySelector('[data-fix-count]');
  const filterEl = wizard.querySelector('[data-fix-filter]');
  const reviewEl = wizard.querySelector('[data-fix-review]');

  const stepTitles = ['Describe', 'Select', 'Review'];
  const state = { step: 0, category: 'all', query: '', issue: null };

  const escapeHtml = (value) => String(value ?? '').replace(/[&<>"']/g, (match) => ({
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#39;',
  }[match]));

  const allIssues = sections.flatMap((section) => {
    const issues = Array.isArray(section.issues) ? section.issues : [];
    return issues.map((issue) => ({
      ...issue,
      sectionId: section.id,
      sectionTitle: section.title,
      accent: section.accent,
      sectionIcon: section.icon,
    }));
  });

  const setActiveCategory = () => {
    categoryBtns.forEach((btn) => {
      const isActive = btn.getAttribute('data-fix-category') === state.category;
      btn.classList.toggle('is-active', isActive);
    });
  };

  const setQuery = (value) => {
    state.query = value;
    searchInputs.forEach((input) => {
      if (input.value !== value) {
        input.value = value;
      }
    });
  };

  const matchesQuery = (issue, query) => {
    const trimmed = query.trim().toLowerCase();
    if (!trimmed) return true;
    const tokens = trimmed.split(/\s+/).filter(Boolean);
    const haystack = [
      issue.title,
      issue.desc,
      issue.sectionTitle,
      Array.isArray(issue.includes) ? issue.includes.join(' ') : '',
    ].join(' ').toLowerCase();
    return tokens.every((token) => haystack.includes(token));
  };

  const renderResults = () => {
    if (!resultsEl) return;
    const filtered = allIssues.filter((issue) => {
      const matchesCategory = state.category === 'all' || issue.sectionId === state.category;
      return matchesCategory && matchesQuery(issue, state.query);
    });

    if (countEl) {
      countEl.textContent = filtered.length.toString();
    }

    if (filterEl) {
      const categoryLabel = state.category === 'all'
        ? 'across all categories'
        : `in ${escapeHtml((sections.find((section) => section.id === state.category) || {}).title || 'selected category')}`;
      filterEl.textContent = categoryLabel;
    }

    if (!filtered.length) {
      resultsEl.innerHTML = `
        <div class="fix-empty">
          <h4>No matching issues found</h4>
          <p>Try another keyword or describe the symptoms and we will guide you.</p>
          <a class="fix-primary-btn" href="${escapeHtml(contactUrl)}">Contact support</a>
        </div>
      `;
      return;
    }

    const cards = filtered.map((issue) => `
      <article class="fix-result-card" style="--accent: ${escapeHtml(issue.accent)};">
        <div class="fix-result-header">
          <div class="fix-result-icon">
            <svg><use href="#fix-icon-${escapeHtml(issue.icon)}"/></svg>
          </div>
          <div class="fix-result-badge">${escapeHtml(issue.price_text)}</div>
        </div>
        <h4 class="fix-result-title">${escapeHtml(issue.title)}</h4>
        <p class="fix-result-desc">${escapeHtml(issue.desc)}</p>
        <div class="fix-result-meta">
          <span>ETA ${escapeHtml(issue.eta)}</span>
          <span>${escapeHtml(issue.sectionTitle)}</span>
        </div>
        <div class="fix-result-actions">
          <button type="button" class="fix-primary-btn" data-fix-select="${escapeHtml(issue.slug)}">Select issue</button>
          <a class="fix-secondary-btn" href="${escapeHtml(issue.urls.product)}">View details</a>
        </div>
      </article>
    `).join('');

    resultsEl.innerHTML = cards;
  };

  const renderReview = (issue) => {
    if (!reviewEl || !issue) return;
    const includes = Array.isArray(issue.includes)
      ? issue.includes.map((item) => `<li><svg class="fix-review-check"><use href="#fix-icon-check"/></svg><span>${escapeHtml(item)}</span></li>`).join('')
      : '';

    reviewEl.innerHTML = `
      <article class="fix-review-card">
        <div class="fix-review-header">
          <div class="fix-review-icon" style="--accent: ${escapeHtml(issue.accent)};">
            <svg><use href="#fix-icon-${escapeHtml(issue.icon)}"/></svg>
          </div>
          <div class="fix-review-title-wrap">
            <p class="fix-review-kicker">${escapeHtml(issue.sectionTitle)}</p>
            <h3 class="fix-review-title">${escapeHtml(issue.title)}</h3>
          </div>
          <div class="fix-review-price">
            <span class="fix-review-price-label">Starting at</span>
            <span class="fix-review-price-value">${escapeHtml(issue.price_text)}</span>
            <span class="fix-review-price-meta">ETA ${escapeHtml(issue.eta)}</span>
          </div>
        </div>
        <p class="fix-review-desc">${escapeHtml(issue.desc)}</p>
        <div class="fix-review-includes">
          <h4>What is included</h4>
          <ul>${includes}</ul>
        </div>
        <div class="fix-review-actions">
          <a class="fix-primary-btn" href="${escapeHtml(issue.urls.checkout)}">Select & Checkout</a>
          <a class="fix-secondary-btn" href="${escapeHtml(issue.urls.product)}">View details</a>
        </div>
        <div class="fix-review-footer">
          <span>Need help choosing? <a class="fix-link" href="${escapeHtml(contactUrl)}">Talk to an expert</a></span>
        </div>
      </article>
    `;
  };

  const updateStep = (nextStep) => {
    state.step = nextStep;
    stepEls.forEach((step, index) => {
      const isActive = index === nextStep;
      step.hidden = !isActive;
      step.classList.toggle('is-active', isActive);
    });
    stepItems.forEach((item, index) => {
      item.classList.toggle('is-active', index <= nextStep);
    });
    if (progressEl) {
      progressEl.style.width = `${((nextStep + 1) / stepEls.length) * 100}%`;
    }
    if (stepLabelEl) {
      stepLabelEl.textContent = stepTitles[nextStep] || '';
    }
    if (nextStep === 1) {
      renderResults();
    }
    if (nextStep === 2 && state.issue) {
      renderReview(state.issue);
    }
  };

  setActiveCategory();
  updateStep(0);

  searchInputs.forEach((input) => {
    input.addEventListener('input', (event) => {
      setQuery(event.target.value);
      if (state.step >= 1) {
        renderResults();
      }
    });
  });

  suggestionBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
      const value = btn.getAttribute('data-fix-suggestion') || '';
      setQuery(value);
      if (state.step >= 1) {
        renderResults();
      }
    });
  });

  categoryBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
      state.category = btn.getAttribute('data-fix-category') || 'all';
      setActiveCategory();
    });
  });

  if (continueBtn) {
    continueBtn.addEventListener('click', () => updateStep(1));
  }

  if (clearBtn) {
    clearBtn.addEventListener('click', () => {
      setQuery('');
      if (state.step >= 1) {
        renderResults();
      }
    });
  }

  backBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
      const target = parseInt(btn.getAttribute('data-fix-back') || '', 10);
      if (!Number.isNaN(target)) {
        updateStep(target);
      } else {
        updateStep(Math.max(state.step - 1, 0));
      }
    });
  });

  if (resetBtn) {
    resetBtn.addEventListener('click', () => {
      state.category = 'all';
      setQuery('');
      setActiveCategory();
      renderResults();
    });
  }

  if (resultsEl) {
    resultsEl.addEventListener('click', (event) => {
      const button = event.target.closest('[data-fix-select]');
      if (!button) return;
      const slug = button.getAttribute('data-fix-select');
      const issue = allIssues.find((item) => item.slug === slug);
      if (!issue) return;
      state.issue = issue;
      updateStep(2);
    });
  }
})();
</script>

<?php
get_footer();
?>
