<?php
/**
 * Template Name: Client Portal
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php bloginfo('name'); ?> | Client Portal</title>
  <?php wp_head(); ?>
</head>
<body <?php body_class('client-portal-page'); ?>>
<?php wp_body_open(); ?>

<aside class="sidebar">
  <div class="brand">AAKAARI <span>ADMIN</span></div>
  <div class="nav-scroll">
    <div class="nav-header">Core</div>
    <div class="nav-item active" onclick="clientPortal.nav('home', this)">🏠 Command Center</div>
    <div class="nav-item" onclick="clientPortal.nav('queue', this)">⚡ Work Queue <span class="nav-badge">5</span></div>
    <div class="nav-item" onclick="clientPortal.nav('inbox', this)">💬 Unified Inbox <span class="nav-badge" style="background:#EF4444">2</span></div>

    <div class="nav-header">Management</div>
    <div class="nav-item" onclick="clientPortal.nav('customers', this)">👥 Customers</div>
    <div class="nav-item" onclick="clientPortal.nav('maintenance', this)">🔁 Console</div>
    <div class="nav-item" onclick="clientPortal.nav('files', this)">📁 File Manager</div>

    <div class="nav-header">Admin</div>
    <div class="nav-item" onclick="clientPortal.nav('billing', this)">💳 Finance</div>
    <div class="nav-item" onclick="clientPortal.nav('reports', this)">📊 Reports</div>
    <div class="nav-item" onclick="clientPortal.nav('settings', this)">⚙️ Settings</div>
  </div>
</aside>

<main class="main">
  <header class="header">
    <div class="search-bar">
      <span>🔍</span>
      <input type="text" class="search-input" placeholder="Search orders, emails, domains (Cmd+K)">
    </div>
    <div style="display:flex; gap:16px; align-items:center;">
      <button class="btn btn-sm btn-ghost" type="button" style="color:#64748B; border:1px solid #E2E8F0;">🔔</button>
      <div style="width:32px; height:32px; background:#0F172A; border-radius:50%; color:white; display:flex; align-items:center; justify-content:center; font-size:0.8rem; font-weight:700;">AD</div>
    </div>
  </header>

  <div class="content-scroll">
    <div id="view-home" class="view-section active">
      <div class="action-bar">
        <div class="priority-text">
          <div class="priority-dot"></div>
          <span><strong>2 Overdue Orders</strong> require immediate attention.</span>
        </div>
        <button class="btn btn-action" type="button" onclick="clientPortal.openDetail(294)">Open Next Priority →</button>
      </div>

      <div class="kpi-grid">
        <div class="kpi-card">
          <div class="kpi-label">Open Orders</div>
          <div class="kpi-val">12</div>
        </div>
        <div class="kpi-card">
          <div class="kpi-label">Overdue</div>
          <div class="kpi-val kpi-alert">2</div>
        </div>
        <div class="kpi-card">
          <div class="kpi-label">Unread Msgs</div>
          <div class="kpi-val">5</div>
        </div>
        <div class="kpi-card">
          <div class="kpi-label">Rev (Today)</div>
          <div class="kpi-val text-green">$358</div>
        </div>
        <div class="kpi-card">
          <div class="kpi-label">Rev (Month)</div>
          <div class="kpi-val">$4,250</div>
        </div>
      </div>

      <div class="table-card">
        <div class="table-header">
          <h3 style="font-size:1rem;">Work Queue (Active)</h3>
          <div style="font-size:0.85rem; color:#64748B;">Sorted by: <strong>Due Date</strong></div>
        </div>
        <table>
          <thead>
          <tr><th>ID</th><th>Client</th><th>Task</th><th>Status</th><th>Due</th><th>Action</th></tr>
          </thead>
          <tbody>
          <tr onclick="clientPortal.openDetail(294)">
            <td>#294</td><td><strong>John Doe</strong></td><td>Mobile Menu Fix</td>
            <td><span class="badge b-overdue">Overdue</span></td>
            <td style="color:#EF4444;">-2h</td>
            <td><button class="btn btn-sm btn-ghost" type="button" style="color:var(--primary); border:1px solid #E2E8F0;">Open</button></td>
          </tr>
          <tr onclick="clientPortal.openDetail(291)">
            <td>#291</td><td><strong>Sarah Smith</strong></td><td>Speed Opt</td>
            <td><span class="badge b-waiting">Waiting Info</span></td>
            <td>Today</td>
            <td><button class="btn btn-sm btn-ghost" type="button" style="color:var(--primary); border:1px solid #E2E8F0;">Open</button></td>
          </tr>
          <tr onclick="clientPortal.openDetail(288)">
            <td>#288</td><td><strong>Mike Ross</strong></td><td>Malware Scan</td>
            <td><span class="badge b-active">In Progress</span></td>
            <td>Tomorrow</td>
            <td><button class="btn btn-sm btn-ghost" type="button" style="color:var(--primary); border:1px solid #E2E8F0;">Open</button></td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div id="view-queue" class="view-section">
      <div style="display:flex; justify-content:space-between; margin-bottom:16px;">
        <h2 style="font-size:1.2rem;">Global Work Queue</h2>
        <div style="display:flex; gap:8px;">
          <button class="btn btn-sm" type="button" style="background:#E2E8F0;">All</button>
          <button class="btn btn-sm" type="button" style="background:white; border:1px solid #E2E8F0;">Due Today</button>
          <button class="btn btn-sm" type="button" style="background:white; border:1px solid #E2E8F0;">Waiting</button>
        </div>
      </div>
      <div class="table-card">
        <table>
          <thead><tr><th>Priority</th><th>ID</th><th>Type</th><th>Client</th><th>Subject</th><th>Status</th><th>Assigned</th></tr></thead>
          <tbody>
          <tr onclick="clientPortal.openDetail(294)">
            <td>🔴 High</td><td>#294</td><td>Fix</td><td>John Doe</td><td>Mobile Menu Bug</td>
            <td><span class="badge b-overdue">Overdue</span></td><td>You</td>
          </tr>
          <tr onclick="clientPortal.openDetail(291)">
            <td>🟡 Med</td><td>#291</td><td>Project</td><td>Sarah Smith</td><td>Wholesale Plugin</td>
            <td><span class="badge b-waiting">Waiting</span></td><td>You</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div id="view-detail" class="view-section">
      <button class="btn btn-sm btn-ghost" type="button" onclick="clientPortal.nav('home')" style="color:#64748B; margin-bottom:16px;">← Back to Queue</button>

      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
        <div>
          <h2 style="font-size:1.4rem; margin-bottom:4px;">#294 Mobile Menu Bug</h2>
          <div style="font-size:0.9rem; color:#64748B;">Client: <strong>John Doe</strong> • Plan: <strong>Business Care</strong></div>
        </div>
        <div style="display:flex; gap:10px;">
          <button class="btn btn-sm" type="button" style="background:#FEF2F2; color:#EF4444;">Mark Overdue</button>
          <button class="btn btn-action" type="button">Complete Order ✓</button>
        </div>
      </div>

      <div class="workspace-grid">
        <div class="ws-col">
          <div class="ws-card" style="background:#FFFFEB; border-color:#FEF08A;">
            <div class="ws-head" style="color:#854D0E;">🔐 Internal Admin Notes</div>
            <textarea style="width:100%; background:transparent; border:none; resize:vertical; font-size:0.9rem;" rows="3">Customer is using Elementor Pro. Check CSS conflict in customizer first.</textarea>
          </div>

          <div class="ws-card">
            <div class="ws-head">
              <span>🔐 Access Credentials</span>
              <span style="font-size:0.75rem; color:#94A3B8;">Encrypted &amp; Logged</span>
            </div>
            <div class="cred-box">
              <span>WP Admin: admin_john</span>
              <span class="blur-text" onclick="this.classList.toggle('revealed')">P@ssw0rd123!</span>
            </div>
            <div class="cred-box">
              <span>SFTP Host: 192.168.1.1</span>
              <span class="blur-text" onclick="this.classList.toggle('revealed')">sftp_key_x9s</span>
            </div>
          </div>

          <div class="ws-card" style="flex:1; display:flex; flex-direction:column;">
            <div class="ws-head">Message Thread</div>
            <div class="admin-chat">
              <div class="chat-msgs">
                <div class="msg msg-client"><strong>John:</strong> Menu is broken on iPhone Safari.</div>
                <div class="msg msg-admin"><strong>You:</strong> Checking logs now. Do you have caching enabled?</div>
                <div class="msg msg-client"><strong>John:</strong> Yes, WP Rocket.</div>
              </div>
              <div style="padding:12px; border-top:1px solid #E2E8F0; background:white;">
                <textarea placeholder="Type reply (enters sent)..." style="width:100%; border:none; outline:none; resize:none;"></textarea>
                <div style="display:flex; justify-content:space-between; margin-top:8px;">
                  <button class="btn btn-sm btn-ghost" type="button" style="color:#64748B;">📎 Attach</button>
                  <button class="btn btn-sm btn-action" type="button">Send Reply</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="ws-col">
          <div class="ws-card">
            <div class="ws-head">Status &amp; ETA</div>
            <select style="width:100%; padding:8px; border:1px solid #E2E8F0; border-radius:6px; margin-bottom:12px;">
              <option>In Progress</option>
              <option>Waiting for Client</option>
              <option>Review</option>
            </select>
            <label style="font-size:0.8rem; font-weight:600; color:#64748B;">Due Date</label>
            <input type="date" value="2026-01-26" style="width:100%; padding:8px; border:1px solid #E2E8F0; border-radius:6px;">
          </div>

          <div class="ws-card">
            <div class="ws-head">Standard Checklist</div>
            <div class="checklist-item"><input type="checkbox" checked> <span>Check Backup</span></div>
            <div class="checklist-item"><input type="checkbox"> <span>Reproduce Issue</span></div>
            <div class="checklist-item"><input type="checkbox"> <span>Fix on Staging</span></div>
            <div class="checklist-item"><input type="checkbox"> <span>Deploy to Live</span></div>
            <div class="checklist-item"><input type="checkbox"> <span>Update Client</span></div>
          </div>

          <div class="ws-card">
            <div class="ws-head">Deliverables</div>
            <div style="border:2px dashed #E2E8F0; padding:20px; text-align:center; border-radius:6px; color:#94A3B8; font-size:0.85rem;">
              Drag report PDF here
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="view-inbox" class="view-section">
      <h2 style="margin-bottom:20px;">Unified Inbox (5 Unread)</h2>
      <div class="table-card">
        <div class="inbox-item unread" onclick="clientPortal.openDetail(294)">
          <div style="display:flex; justify-content:space-between;">
            <span class="inbox-sub">Checkout Button Issue</span>
            <span style="font-size:0.75rem; color:#94A3B8;">10m ago</span>
          </div>
          <div class="inbox-snip"><strong>John Doe:</strong> Hey, just following up on this. Is it fixed yet?</div>
        </div>
        <div class="inbox-item unread">
          <div style="display:flex; justify-content:space-between;">
            <span class="inbox-sub">Billing Question</span>
            <span style="font-size:0.75rem; color:#94A3B8;">1h ago</span>
          </div>
          <div class="inbox-snip"><strong>Sarah Smith:</strong> Can I get the PDF for last month?</div>
        </div>
        <div class="inbox-item">
          <div style="display:flex; justify-content:space-between;">
            <span class="inbox-sub">New Order #290</span>
            <span style="font-size:0.75rem; color:#94A3B8;">Yesterday</span>
          </div>
          <div class="inbox-snip">System: New order received for Maintenance Plan.</div>
        </div>
      </div>
    </div>

    <div id="view-customers" class="view-section"><h2>Customer Management</h2><p>Table of all clients...</p></div>
    <div id="view-maintenance" class="view-section"><h2>Maintenance Console</h2><p>Update manager...</p></div>
    <div id="view-files" class="view-section"><h2>File Manager</h2><p>Asset library and uploads...</p></div>
    <div id="view-billing" class="view-section"><h2>Finance</h2><p>Billing overview and invoices...</p></div>
    <div id="view-reports" class="view-section"><h2>Reports</h2><p>Operational reporting tools...</p></div>
    <div id="view-settings" class="view-section"><h2>Settings</h2><p>Admin preferences...</p></div>
  </div>
</main>

<?php wp_footer(); ?>
</body>
</html>
