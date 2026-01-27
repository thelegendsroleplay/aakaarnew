<?php
/**
 * Admin Canned Responses Template
 *
 * @package Aakaari_Lead_System
 */

if (!defined('ABSPATH')) {
    exit;
}

global $wpdb;
$responses = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}aakaari_canned_responses ORDER BY category, title", ARRAY_A);
?>
<div class="wrap aakaari-admin">
    <h1><?php _e('Canned Responses', 'aakaari-leads'); ?></h1>
    <p class="description">Quick reply templates for chat agents. Use shortcuts like /hi to insert responses quickly.</p>

    <style>
        .aakaari-canned-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px; margin-top: 20px; }
        .aakaari-canned-card { background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .aakaari-canned-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .aakaari-canned-card-header h3 { margin: 0; font-size: 15px; }
        .aakaari-canned-shortcut { background: #f1f5f9; padding: 4px 8px; border-radius: 4px; font-family: monospace; font-size: 12px; color: #2563eb; }
        .aakaari-canned-category { display: inline-block; padding: 2px 8px; background: #e0e7ff; border-radius: 10px; font-size: 11px; color: #3730a3; margin-bottom: 8px; }
        .aakaari-canned-text { background: #f8fafc; padding: 12px; border-radius: 8px; font-size: 13px; color: #475569; line-height: 1.5; white-space: pre-wrap; }
        .aakaari-canned-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 12px; font-size: 12px; color: #94a3b8; }
    </style>

    <div class="aakaari-canned-grid">
        <?php foreach ($responses as $response): ?>
            <div class="aakaari-canned-card">
                <div class="aakaari-canned-card-header">
                    <h3><?php echo esc_html($response['title']); ?></h3>
                    <?php if ($response['shortcut']): ?>
                        <span class="aakaari-canned-shortcut"><?php echo esc_html($response['shortcut']); ?></span>
                    <?php endif; ?>
                </div>
                <?php if ($response['category']): ?>
                    <span class="aakaari-canned-category"><?php echo esc_html(ucfirst($response['category'])); ?></span>
                <?php endif; ?>
                <div class="aakaari-canned-text"><?php echo esc_html($response['message_text']); ?></div>
                <div class="aakaari-canned-footer">
                    <span>Used <?php echo esc_html($response['usage_count']); ?> times</span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
