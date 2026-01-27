<?php
/**
 * Admin Leads Template
 *
 * @package Aakaari_Lead_System
 */

if (!defined('ABSPATH')) {
    exit;
}

$status_filter = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '';
$leads_data = Aakaari_Lead_Handler::get_leads(['status' => $status_filter]);
$leads = $leads_data['leads'];
?>
<div class="wrap aakaari-admin">
    <h1><?php _e('Leads', 'aakaari-leads'); ?></h1>

    <style>
        .aakaari-filters { display: flex; gap: 10px; margin: 20px 0; flex-wrap: wrap; }
        .aakaari-filters a { padding: 8px 16px; background: #f1f5f9; border-radius: 20px; text-decoration: none; color: #475569; font-size: 13px; }
        .aakaari-filters a.active { background: #2563eb; color: #fff; }
        .aakaari-table-container { background: #fff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden; }
        .aakaari-table { width: 100%; border-collapse: collapse; }
        .aakaari-table th { text-align: left; padding: 14px 16px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 12px; font-weight: 600; text-transform: uppercase; }
        .aakaari-table td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; }
        .aakaari-table tr:hover { background: #f8fafc; }
        .aakaari-badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 500; }
        .aakaari-badge.hot { background: #fef2f2; color: #dc2626; }
        .aakaari-badge.warm { background: #fffbeb; color: #d97706; }
        .aakaari-badge.cold { background: #f0f9ff; color: #0284c7; }
        .aakaari-badge.new { background: #dbeafe; color: #1e40af; }
        .aakaari-badge.contacted { background: #fef3c7; color: #92400e; }
        .aakaari-badge.qualified { background: #d1fae5; color: #065f46; }
        .aakaari-badge.proposal_sent { background: #e0e7ff; color: #3730a3; }
        .aakaari-badge.won { background: #10b981; color: #fff; }
        .aakaari-badge.lost { background: #f1f5f9; color: #64748b; }
        .aakaari-badge.nurture { background: #fce7f3; color: #9d174d; }
    </style>

    <div class="aakaari-filters">
        <a href="?page=aakaari-leads-list" class="<?php echo !$status_filter ? 'active' : ''; ?>">All</a>
        <a href="?page=aakaari-leads-list&status=new" class="<?php echo $status_filter === 'new' ? 'active' : ''; ?>">New</a>
        <a href="?page=aakaari-leads-list&status=contacted" class="<?php echo $status_filter === 'contacted' ? 'active' : ''; ?>">Contacted</a>
        <a href="?page=aakaari-leads-list&status=qualified" class="<?php echo $status_filter === 'qualified' ? 'active' : ''; ?>">Qualified</a>
        <a href="?page=aakaari-leads-list&status=proposal_sent" class="<?php echo $status_filter === 'proposal_sent' ? 'active' : ''; ?>">Proposal Sent</a>
        <a href="?page=aakaari-leads-list&status=won" class="<?php echo $status_filter === 'won' ? 'active' : ''; ?>">Won</a>
        <a href="?page=aakaari-leads-list&status=nurture" class="<?php echo $status_filter === 'nurture' ? 'active' : ''; ?>">Nurture</a>
    </div>

    <div class="aakaari-table-container">
        <table class="aakaari-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>Source</th>
                    <th>Lead Score</th>
                    <th>Status</th>
                    <th>First Contact</th>
                    <th>Last Contact</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($leads)): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px; color: #64748b;">No leads found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($leads as $lead): ?>
                        <tr>
                            <td><strong><?php echo esc_html($lead['name']); ?></strong></td>
                            <td><?php echo esc_html($lead['email']); ?></td>
                            <td><?php echo esc_html($lead['company'] ?: '-'); ?></td>
                            <td><?php echo esc_html(ucfirst($lead['source'])); ?></td>
                            <td><span class="aakaari-badge <?php echo $lead['temperature']; ?>"><?php echo esc_html($lead['lead_score']); ?></span></td>
                            <td><span class="aakaari-badge <?php echo esc_attr($lead['status']); ?>"><?php echo esc_html(ucfirst(str_replace('_', ' ', $lead['status']))); ?></span></td>
                            <td><?php echo $lead['first_contact_at'] ? human_time_diff(strtotime($lead['first_contact_at'])) . ' ago' : '-'; ?></td>
                            <td><?php echo $lead['last_contact_at'] ? human_time_diff(strtotime($lead['last_contact_at'])) . ' ago' : '-'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
