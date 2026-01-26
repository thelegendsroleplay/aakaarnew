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
  <div class="brand"><div class="brand-dot"></div> Aakaari</div>
  <div class="nav-scroll">
    <div class="nav-header">Overview</div>
    <div class="nav-item active" onclick="clientPortal.nav('home', this)">
      <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
      Dashboard
    </div>
    <div class="nav-item" onclick="clientPortal.nav('fixes', this)">
      <svg viewBox="0 0 24 24"><path d="M4 4h10l6 6v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"></path><polyline points="14 4 14 10 20 10"></polyline></svg>
      My Fixes
    </div>
    <div class="nav-item" onclick="clientPortal.nav('projects', this)">
      <svg viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
      Projects
    </div>
    <div class="nav-item" onclick="clientPortal.nav('support', this)">
      <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
      Support Tickets
    </div>

    <div class="nav-header">Management</div>
    <div class="nav-item" onclick="clientPortal.nav('websites', this)">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
      Websites
    </div>
    <div class="nav-item" onclick="clientPortal.nav('files', this)">
      <svg viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
      Files
    </div>
    <div class="nav-item" onclick="clientPortal.nav('security', this)">
      <svg viewBox="0 0 24 24"><path d="M12 2l7 4v6c0 5-3.5 9.5-7 10-3.5-.5-7-5-7-10V6z"></path></svg>
      Security Vault
    </div>
    <div class="nav-header">Account</div>
    <div class="nav-item" onclick="clientPortal.nav('plan', this)">
      <svg viewBox="0 0 24 24"><polygon points="12 2 15 8 22 9 17 14 18 21 12 18 6 21 7 14 2 9 9 8"></polygon></svg>
      My Plan
    </div>
    <div class="nav-item" onclick="clientPortal.nav('billing', this)">
      <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
      Billing
    </div>
    <div class="nav-item" onclick="clientPortal.nav('settings', this)">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.8 1.8 0 0 0 .4 2l.1.1a2 2 0 0 1-1.4 3.4h-1a2 2 0 0 1-2-1.4l-.1-.3a1.8 1.8 0 0 0-1.7-1.2h-1.4a1.8 1.8 0 0 0-1.7 1.2l-.1.3a2 2 0 0 1-2 1.4h-1a2 2 0 0 1-1.4-3.4l.1-.1a1.8 1.8 0 0 0 .4-2l-.5-.9a1.8 1.8 0 0 0-1.5-.9H3a2 2 0 0 1-2-2v-1a2 2 0 0 1 2-2h.3a1.8 1.8 0 0 0 1.5-.9l.5-.9a1.8 1.8 0 0 0-.4-2l-.1-.1A2 2 0 0 1 6.2 2.6h1a2 2 0 0 1 2 1.4l.1.3a1.8 1.8 0 0 0 1.7 1.2h1.4a1.8 1.8 0 0 0 1.7-1.2l.1-.3a2 2 0 0 1 2-1.4h1a2 2 0 0 1 1.4 3.4l-.1.1a1.8 1.8 0 0 0-.4 2l.5.9a1.8 1.8 0 0 0 1.5.9h.3a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2h-.3a1.8 1.8 0 0 0-1.5.9z\"></path></svg>
      Settings
    </div>
  </div>
  <div class="user-panel">
    <div class="avatar">JD</div>
    <div>
      <div style="font-weight:600; font-size:0.9rem;">John Doe</div>
      <div style="font-size:0.75rem; color:#94A3B8;">Business Plan</div>
    </div>
  </div>
</aside>

<main class="main">
  <header class="header">
    <div class="page-title" id="headerTitle">Dashboard</div>
    <div class="header-tools">
      <button class="btn btn-primary" type="button" onclick="clientPortal.openModal()">+ New Ticket</button>
    </div>
  </header>

  <div class="content-scroll">
    <div id="view-home" class="view-section active">
      <div class="stats-grid">
        <div class="card stat-card">
          <div style="color:#64748B; font-weight:600; font-size:0.9rem;">Open Tickets</div>
          <div style="font-size:1.8rem; font-weight:800; margin-top:8px; color:var(--text-head);">2</div>
        </div>
        <div class="card stat-card">
          <div style="color:#64748B; font-weight:600; font-size:0.9rem;">Plan Usage</div>
          <div style="font-size:1.8rem; font-weight:800; margin-top:8px; color:var(--text-head);">1<span style="font-size:1rem; color:#94A3B8;">/2</span></div>
        </div>
        <div class="card stat-card">
          <div style="color:#64748B; font-weight:600; font-size:0.9rem;">Site Health</div>
          <div style="font-size:1.8rem; font-weight:800; margin-top:8px; color:var(--success);">100%</div>
        </div>
        <div class="card stat-card">
          <div style="color:#64748B; font-weight:600; font-size:0.9rem;">Next Invoice</div>
          <div style="font-size:1.8rem; font-weight:800; margin-top:8px; color:var(--text-head);">$179</div>
        </div>
      </div>
    </div>

    <div id="view-fixes" class="view-section">
      <div class="card"><div class="card-body"><h3>My Fixes</h3><p>Ticket history and fix requests appear here...</p></div></div>
    </div>

    <div id="view-support" class="view-section" style="height:100%;">
      <div class="card" style="height:100%; display:flex; flex-direction:column; margin:0; border:none; box-shadow:none; background:transparent;">
        <div class="ticket-grid">
          <div class="card" style="margin:0; overflow:hidden; display:flex; flex-direction:column;">
            <div class="card-head" style="padding:15px 20px;">
              <span>Inbox</span>
              <div style="display:flex; gap:10px; font-size:0.8rem;">
                <span style="cursor:pointer; color:var(--primary); font-weight:700;">Open (2)</span>
                <span style="cursor:pointer; color:#94A3B8;">Closed (12)</span>
              </div>
            </div>
            <div class="ticket-list">
              <div class="ticket-item selected" onclick="clientPortal.loadTicket(1)">
                <div class="ticket-meta">
                  <span>#T-294 • Fix Request</span>
                  <span style="color:var(--warning);">2h ago</span>
                </div>
                <div class="ticket-subject">Checkout Page Styling Issue</div>
                <div class="ticket-preview">Aakaari: We are looking into the CSS conflict...</div>
                <div style="margin-top:8px;">
                  <span class="badge bg-blue">In Progress</span>
                  <span class="badge bg-orange">High Priority</span>
                </div>
              </div>
              <div class="ticket-item" onclick="clientPortal.loadTicket(2)">
                <div class="ticket-meta">
                  <span>#T-291 • Support</span>
                  <span>Yesterday</span>
                </div>
                <div class="ticket-subject">Billing Question</div>
                <div class="ticket-preview">You: Can I download the PDF invoice for...</div>
                <div style="margin-top:8px;">
                  <span class="badge bg-green">Replied</span>
                </div>
              </div>
            </div>
          </div>

          <div class="card" style="margin:0; overflow:hidden; display:flex; flex-direction:column;">
            <div class="chat-area">
              <div class="chat-header">
                <div>
                  <div style="font-weight:700; font-size:1.1rem;">#T-294 Checkout Page Styling Issue</div>
                  <div style="font-size:0.8rem; color:#64748B;">Plan Fix • High Priority • 2 Participants</div>
                </div>
                <button class="btn btn-outline" type="button" style="padding:6px 12px; font-size:0.8rem;">Mark Resolved</button>
              </div>

              <div class="chat-messages" id="chatFeed">
                <div class="msg-bubble bubble-in">
                  <strong>Aakaari Support</strong>
                  <div>Hello John, thanks for the report. Is this happening on mobile or desktop?</div>
                  <span class="msg-time">10:00 AM</span>
                </div>
                <div class="msg-bubble bubble-out">
                  <strong>You</strong>
                  <div>It seems to be only on mobile (iOS Safari). The button is overlapping the text.</div>
                  <span class="msg-time">10:05 AM</span>
                </div>
                <div class="msg-bubble bubble-in">
                  <strong>Aakaari Support</strong>
                  <div>Understood. Our developers are patching the CSS now. We will update you shortly.</div>
                  <span class="msg-time">11:30 AM</span>
                </div>
              </div>

              <div class="chat-input-wrap">
                <button type="button" style="background:none; border:none; font-size:1.2rem; cursor:pointer; color:#64748B;">📎</button>
                <input type="text" class="form-input" style="margin:0;" placeholder="Type your reply...">
                <button class="btn btn-primary" type="button">Send</button>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div id="view-projects" class="view-section">
      <div class="card"><div class="card-body"><h3>Projects View</h3><p>Milestone tracker goes here...</p></div></div>
    </div>
    <div id="view-websites" class="view-section">
      <div class="card"><div class="card-body"><h3>Websites View</h3><p>Manage domains...</p></div></div>
    </div>
    <div id="view-files" class="view-section">
      <div class="card"><div class="card-body"><h3>Files View</h3><p>Download reports...</p></div></div>
    </div>
    <div id="view-security" class="view-section">
      <div class="card"><div class="card-body"><h3>Security Vault</h3><p>Security assets and credentials live here...</p></div></div>
    </div>
    <div id="view-plan" class="view-section">
      <div class="card"><div class="card-body"><h3>My Plan</h3><p>Plan details and usage info go here...</p></div></div>
    </div>
    <div id="view-billing" class="view-section">
      <div class="card"><div class="card-body"><h3>Billing View</h3><p>Invoices list...</p></div></div>
    </div>
    <div id="view-settings" class="view-section">
      <div class="card"><div class="card-body"><h3>Settings</h3><p>Account settings and preferences go here...</p></div></div>
    </div>
  </div>
</main>

<div class="modal" id="ticketModal">
  <div class="modal-box">
    <h2 style="margin-bottom:24px;">Create New Ticket</h2>

    <label class="form-label">Ticket Type</label>
    <select class="form-input" style="margin-bottom:16px;">
      <option>🛠️ Fix Request (Uses Plan Limit)</option>
      <option>💰 Billing Question</option>
      <option>🆘 General Support</option>
    </select>

    <label class="form-label">Subject</label>
    <input type="text" class="form-input" placeholder="e.g. Broken Contact Form">

    <label class="form-label">Priority</label>
    <div style="display:flex; gap:10px; margin-bottom:16px;">
      <label style="background:#F1F5F9; padding:8px 16px; border-radius:6px; cursor:pointer; font-size:0.9rem;"><input type="radio" name="prio"> Low</label>
      <label style="background:#F1F5F9; padding:8px 16px; border-radius:6px; cursor:pointer; font-size:0.9rem;"><input type="radio" name="prio" checked> Normal</label>
      <label style="background:#FEF2F2; color:var(--danger); padding:8px 16px; border-radius:6px; cursor:pointer; font-size:0.9rem;"><input type="radio" name="prio"> High</label>
    </div>

    <label class="form-label">Description</label>
    <textarea class="form-input" rows="4" style="font-family:inherit;"></textarea>

    <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:10px;">
      <button class="btn btn-outline" type="button" onclick="clientPortal.closeModal()">Cancel</button>
      <button class="btn btn-primary" type="button" onclick="clientPortal.closeModal()">Submit Ticket</button>
    </div>
  </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
