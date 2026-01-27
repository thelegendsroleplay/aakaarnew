<?php
/**
 * Admin Tickets Template
 *
 * @package Aakaari_Lead_System
 */

if (!defined('ABSPATH')) {
    exit;
}

$status_filter = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '';
$tickets_data = Aakaari_Ticket_Handler::get_tickets(['status' => $status_filter, 'page' => 1]);
$tickets = $tickets_data['tickets'];
$ticket_stats = Aakaari_Ticket_Handler::get_stats();
?>
<div class="wrap aakaari-admin">
    <h1><?php _e('Tickets', 'aakaari-leads'); ?></h1>

    <style>
        .aakaari-filters { display: flex; gap: 10px; margin: 20px 0; flex-wrap: wrap; }
        .aakaari-filters a { padding: 8px 16px; background: #f1f5f9; border-radius: 20px; text-decoration: none; color: #475569; font-size: 13px; }
        .aakaari-filters a.active { background: #2563eb; color: #fff; }
        .aakaari-table-container { background: #fff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden; }
        .aakaari-table { width: 100%; border-collapse: collapse; }
        .aakaari-table th { text-align: left; padding: 14px 16px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 12px; font-weight: 600; text-transform: uppercase; }
        .aakaari-table td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; }
        .aakaari-table tr:hover { background: #f8fafc; }
        .aakaari-table .ticket-id { font-weight: 600; color: #2563eb; }
        .aakaari-badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 500; }
        .aakaari-badge.new { background: #dbeafe; color: #1e40af; }
        .aakaari-badge.under_review { background: #fef3c7; color: #92400e; }
        .aakaari-badge.proposal_sent { background: #d1fae5; color: #065f46; }
        .aakaari-badge.closed_won { background: #10b981; color: #fff; }
        .aakaari-badge.closed_lost { background: #f1f5f9; color: #64748b; }
        .aakaari-badge.urgent { background: #fef2f2; color: #dc2626; }
        .aakaari-badge.high { background: #ffedd5; color: #c2410c; }
        .aakaari-badge.medium { background: #fef9c3; color: #854d0e; }
        .aakaari-badge.low { background: #f0f9ff; color: #0369a1; }
        .aakaari-badge.hot { background: #fef2f2; color: #dc2626; }
        .aakaari-badge.warm { background: #fffbeb; color: #d97706; }
        .aakaari-badge.cold { background: #f0f9ff; color: #0284c7; }
        .aakaari-actions { display: flex; gap: 8px; }
        .aakaari-actions a { padding: 6px 12px; background: #f1f5f9; border-radius: 6px; text-decoration: none; color: #475569; font-size: 12px; }
        .aakaari-actions a:hover { background: #e2e8f0; }
        .aakaari-stats-row { display: flex; gap: 16px; margin-bottom: 20px; }
        .aakaari-stat-mini { background: #fff; padding: 16px 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .aakaari-stat-mini .value { font-size: 24px; font-weight: 700; color: #1e293b; }
        .aakaari-stat-mini .label { font-size: 12px; color: #64748b; }
    </style>

    <div class="aakaari-stats-row">
        <div class="aakaari-stat-mini">
            <div class="value"><?php echo esc_html($ticket_stats['open']); ?></div>
            <div class="label">Open Tickets</div>
        </div>
        <div class="aakaari-stat-mini">
            <div class="value"><?php echo esc_html($ticket_stats['avg_response_time'] ?? 0); ?>h</div>
            <div class="label">Avg Response Time</div>
        </div>
        <div class="aakaari-stat-mini">
            <div class="value"><?php echo esc_html($ticket_stats['conversion_rate']); ?>%</div>
            <div class="label">Conversion Rate</div>
        </div>
        <div class="aakaari-stat-mini">
            <div class="value">₹<?php echo number_format($ticket_stats['pipeline_value']); ?></div>
            <div class="label">Pipeline Value</div>
        </div>
    </div>

    <div class="aakaari-filters">
        <a href="?page=aakaari-tickets" class="<?php echo !$status_filter ? 'active' : ''; ?>">All</a>
        <a href="?page=aakaari-tickets&status=new" class="<?php echo $status_filter === 'new' ? 'active' : ''; ?>">New</a>
        <a href="?page=aakaari-tickets&status=under_review" class="<?php echo $status_filter === 'under_review' ? 'active' : ''; ?>">Under Review</a>
        <a href="?page=aakaari-tickets&status=proposal_sent" class="<?php echo $status_filter === 'proposal_sent' ? 'active' : ''; ?>">Proposal Sent</a>
        <a href="?page=aakaari-tickets&status=awaiting_response" class="<?php echo $status_filter === 'awaiting_response' ? 'active' : ''; ?>">Awaiting Response</a>
        <a href="?page=aakaari-tickets&status=closed_won" class="<?php echo $status_filter === 'closed_won' ? 'active' : ''; ?>">Won</a>
        <a href="?page=aakaari-tickets&status=closed_lost" class="<?php echo $status_filter === 'closed_lost' ? 'active' : ''; ?>">Lost</a>
    </div>

    <div class="aakaari-table-container">
        <table class="aakaari-table">
            <thead>
                <tr>
                    <th>Ticket</th>
                    <th>Customer</th>
                    <th>Project Type</th>
                    <th>Budget</th>
                    <th>Lead Score</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($tickets)): ?>
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 40px; color: #64748b;">No tickets found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($tickets as $ticket): ?>
                        <?php
                        $temp = 'cold';
                        if ($ticket['lead_score'] >= 80) $temp = 'hot';
                        elseif ($ticket['lead_score'] >= 50) $temp = 'warm';
                        ?>
                        <tr>
                            <td>
                                <span class="ticket-id">#<?php echo esc_html($ticket['ticket_number']); ?></span>
                                <br><small style="color: #64748b;"><?php echo esc_html(mb_substr($ticket['title'], 0, 30)); ?>...</small>
                            </td>
                            <td>
                                <?php echo esc_html($ticket['name']); ?>
                                <br><small style="color: #64748b;"><?php echo esc_html($ticket['email']); ?></small>
                            </td>
                            <td><?php echo esc_html($ticket['project_type']); ?></td>
                            <td><?php echo esc_html($ticket['budget_range']); ?></td>
                            <td><span class="aakaari-badge <?php echo $temp; ?>"><?php echo esc_html($ticket['lead_score']); ?></span></td>
                            <td><span class="aakaari-badge <?php echo esc_attr($ticket['status']); ?>"><?php echo esc_html(ucwords(str_replace('_', ' ', $ticket['status']))); ?></span></td>
                            <td><span class="aakaari-badge <?php echo esc_attr($ticket['priority']); ?>"><?php echo esc_html(ucfirst($ticket['priority'])); ?></span></td>
                            <td><?php echo human_time_diff(strtotime($ticket['created_at'])); ?> ago</td>
                            <td class="aakaari-actions">
                                <a href="?page=aakaari-tickets&id=<?php echo $ticket['id']; ?>">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($tickets_data['total_pages'] > 1): ?>
        <div style="margin-top: 20px; text-align: center;">
            Page <?php echo $tickets_data['page']; ?> of <?php echo $tickets_data['total_pages']; ?>
        </div>
    <?php endif; ?>
</div>
