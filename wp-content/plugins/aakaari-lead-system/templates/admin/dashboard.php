<?php
/**
 * Admin Dashboard Template
 *
 * @package Aakaari_Lead_System
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap aakaari-admin">
    <h1><?php _e('Lead System Dashboard', 'aakaari-leads'); ?></h1>

    <style>
        .aakaari-admin { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        .aakaari-stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 20px 0; }
        .aakaari-stat-card { background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .aakaari-stat-card h3 { margin: 0 0 8px; font-size: 14px; color: #64748b; font-weight: 500; }
        .aakaari-stat-card .value { font-size: 32px; font-weight: 700; color: #1e293b; }
        .aakaari-stat-card .value.primary { color: #2563eb; }
        .aakaari-stat-card .value.success { color: #10b981; }
        .aakaari-stat-card .value.warning { color: #f59e0b; }
        .aakaari-stat-card .value.danger { color: #ef4444; }
        .aakaari-stat-card .change { font-size: 12px; color: #64748b; margin-top: 4px; }
        .aakaari-section { background: #fff; border-radius: 12px; padding: 24px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .aakaari-section h2 { margin: 0 0 20px; font-size: 18px; color: #1e293b; }
        .aakaari-quick-actions { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 20px; }
        .aakaari-quick-actions a { display: inline-flex; align-items: center; gap: 8px; padding: 12px 20px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 8px; font-weight: 500; transition: background 0.2s; }
        .aakaari-quick-actions a:hover { background: #1d4ed8; }
        .aakaari-quick-actions a.secondary { background: #f1f5f9; color: #475569; }
        .aakaari-quick-actions a.secondary:hover { background: #e2e8f0; }
        .aakaari-table { width: 100%; border-collapse: collapse; }
        .aakaari-table th { text-align: left; padding: 12px; border-bottom: 2px solid #e2e8f0; color: #64748b; font-weight: 500; font-size: 13px; }
        .aakaari-table td { padding: 12px; border-bottom: 1px solid #f1f5f9; }
        .aakaari-badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; }
        .aakaari-badge.hot { background: #fef2f2; color: #dc2626; }
        .aakaari-badge.warm { background: #fffbeb; color: #d97706; }
        .aakaari-badge.cold { background: #f0f9ff; color: #0284c7; }
        .aakaari-badge.waiting { background: #fef3c7; color: #92400e; }
        .aakaari-badge.active { background: #d1fae5; color: #065f46; }
        .aakaari-agent-status { display: flex; align-items: center; gap: 8px; padding: 16px; background: #f8fafc; border-radius: 8px; margin-bottom: 20px; }
        .aakaari-agent-status .dot { width: 10px; height: 10px; border-radius: 50%; }
        .aakaari-agent-status .dot.available { background: #10b981; }
        .aakaari-agent-status .dot.offline { background: #94a3b8; }
        .aakaari-agent-status select { margin-left: auto; padding: 8px 12px; border-radius: 6px; border: 1px solid #e2e8f0; }
    </style>

    <!-- Agent Status -->
    <div class="aakaari-agent-status">
        <span class="dot <?php echo $this->is_agent_online() ? 'available' : 'offline'; ?>"></span>
        <strong>Your Status:</strong>
        <select id="agent-status" onchange="updateAgentStatus(this.value)">
            <option value="available">Available</option>
            <option value="busy">Busy</option>
            <option value="away">Away</option>
            <option value="offline">Offline</option>
        </select>
    </div>

    <!-- Stats Grid -->
    <div class="aakaari-stats-grid">
        <div class="aakaari-stat-card">
            <h3>Waiting Chats</h3>
            <div class="value <?php echo $stats['open']['waiting_chats'] > 0 ? 'warning' : ''; ?>">
                <?php echo esc_html($stats['open']['waiting_chats']); ?>
            </div>
            <div class="change">Needs attention</div>
        </div>

        <div class="aakaari-stat-card">
            <h3>Active Chats</h3>
            <div class="value primary"><?php echo esc_html($stats['open']['active_chats']); ?></div>
            <div class="change">In progress</div>
        </div>

        <div class="aakaari-stat-card">
            <h3>Open Tickets</h3>
            <div class="value"><?php echo esc_html($stats['open']['open_tickets']); ?></div>
            <div class="change">
                <?php if ($stats['open']['overdue_tickets'] > 0): ?>
                    <span style="color: #ef4444;"><?php echo esc_html($stats['open']['overdue_tickets']); ?> overdue</span>
                <?php else: ?>
                    All on track
                <?php endif; ?>
            </div>
        </div>

        <div class="aakaari-stat-card">
            <h3>Today's Leads</h3>
            <div class="value success"><?php echo esc_html($stats['today']['leads']); ?></div>
            <div class="change"><?php echo esc_html($stats['week']['leads']); ?> this week</div>
        </div>

        <div class="aakaari-stat-card">
            <h3>Hot Leads</h3>
            <div class="value danger"><?php echo esc_html($stats['lead_temperatures']['hot']); ?></div>
            <div class="change">Score 80+</div>
        </div>

        <div class="aakaari-stat-card">
            <h3>Conversion Rate</h3>
            <div class="value"><?php echo esc_html($stats['conversion']['rate']); ?>%</div>
            <div class="change"><?php echo esc_html($stats['conversion']['won']); ?> of <?php echo esc_html($stats['conversion']['total_leads']); ?> leads</div>
        </div>

        <div class="aakaari-stat-card">
            <h3>Pipeline Value</h3>
            <div class="value primary">₹<?php echo number_format($stats['revenue']['pipeline']); ?></div>
            <div class="change">Active proposals</div>
        </div>

        <div class="aakaari-stat-card">
            <h3>Total Revenue</h3>
            <div class="value success">₹<?php echo number_format($stats['revenue']['total']); ?></div>
            <div class="change">From won deals</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="aakaari-quick-actions">
        <a href="<?php echo admin_url('admin.php?page=aakaari-chats'); ?>">
            <span class="dashicons dashicons-format-chat"></span>
            View Live Chats
        </a>
        <a href="<?php echo admin_url('admin.php?page=aakaari-tickets'); ?>">
            <span class="dashicons dashicons-tickets-alt"></span>
            Manage Tickets
        </a>
        <a href="<?php echo admin_url('admin.php?page=aakaari-leads-list'); ?>" class="secondary">
            <span class="dashicons dashicons-groups"></span>
            All Leads
        </a>
        <a href="<?php echo admin_url('admin.php?page=aakaari-settings'); ?>" class="secondary">
            <span class="dashicons dashicons-admin-settings"></span>
            Settings
        </a>
    </div>

    <!-- Recent Activity -->
    <div class="aakaari-section" style="margin-top: 30px;">
        <h2>Lead Temperature Distribution</h2>
        <div style="display: flex; gap: 20px; align-items: center;">
            <div style="flex: 1; height: 20px; background: #f1f5f9; border-radius: 10px; overflow: hidden; display: flex;">
                <?php
                $total = $stats['lead_temperatures']['hot'] + $stats['lead_temperatures']['warm'] + $stats['lead_temperatures']['cold'];
                $total = max($total, 1);
                $hot_pct = ($stats['lead_temperatures']['hot'] / $total) * 100;
                $warm_pct = ($stats['lead_temperatures']['warm'] / $total) * 100;
                $cold_pct = ($stats['lead_temperatures']['cold'] / $total) * 100;
                ?>
                <div style="width: <?php echo $hot_pct; ?>%; background: #ef4444;"></div>
                <div style="width: <?php echo $warm_pct; ?>%; background: #f59e0b;"></div>
                <div style="width: <?php echo $cold_pct; ?>%; background: #0ea5e9;"></div>
            </div>
            <div style="display: flex; gap: 20px; font-size: 13px;">
                <span><span class="aakaari-badge hot">Hot</span> <?php echo esc_html($stats['lead_temperatures']['hot']); ?></span>
                <span><span class="aakaari-badge warm">Warm</span> <?php echo esc_html($stats['lead_temperatures']['warm']); ?></span>
                <span><span class="aakaari-badge cold">Cold</span> <?php echo esc_html($stats['lead_temperatures']['cold']); ?></span>
            </div>
        </div>
    </div>

    <!-- Traffic Sources -->
    <?php if (!empty($stats['sources'])): ?>
    <div class="aakaari-section">
        <h2>Top Lead Sources</h2>
        <table class="aakaari-table">
            <thead>
                <tr>
                    <th>Source</th>
                    <th>Leads</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stats['sources'] as $source): ?>
                <tr>
                    <td><?php echo esc_html(ucfirst($source['how_found_us'])); ?></td>
                    <td><?php echo esc_html($source['count']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <!-- Agent Performance -->
    <?php if (!empty($stats['agents'])): ?>
    <div class="aakaari-section">
        <h2>Agent Status</h2>
        <table class="aakaari-table">
            <thead>
                <tr>
                    <th>Agent</th>
                    <th>Status</th>
                    <th>Active Chats</th>
                    <th>Today's Chats</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stats['agents'] as $agent): ?>
                <tr>
                    <td><?php echo esc_html($agent['display_name']); ?></td>
                    <td>
                        <span class="aakaari-badge <?php echo $agent['status'] === 'available' ? 'active' : ''; ?>">
                            <?php echo esc_html(ucfirst($agent['status'])); ?>
                        </span>
                    </td>
                    <td><?php echo esc_html($agent['current_chats']); ?></td>
                    <td><?php echo esc_html($agent['today_chats']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<script>
function updateAgentStatus(status) {
    fetch('<?php echo rest_url('aakaari/v1/admin/status'); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
        },
        body: JSON.stringify({ status: status })
    });

    // Update dot color
    const dot = document.querySelector('.aakaari-agent-status .dot');
    dot.className = 'dot ' + (status === 'available' ? 'available' : 'offline');
}
</script>
