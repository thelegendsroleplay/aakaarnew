<?php
/**
 * Admin Settings Template
 *
 * @package Aakaari_Lead_System
 */

if (!defined('ABSPATH')) {
    exit;
}

// Handle form submission
if (isset($_POST['aakaari_settings_nonce']) && wp_verify_nonce($_POST['aakaari_settings_nonce'], 'aakaari_save_settings')) {
    update_option('aakaari_chat_enabled', isset($_POST['chat_enabled']));
    update_option('aakaari_primary_color', sanitize_hex_color($_POST['primary_color']));
    update_option('aakaari_widget_position', sanitize_text_field($_POST['widget_position']));
    update_option('aakaari_greeting', sanitize_text_field($_POST['greeting']));
    update_option('aakaari_offline_message', sanitize_textarea_field($_POST['offline_message']));
    update_option('aakaari_ticket_prefix', sanitize_text_field($_POST['ticket_prefix']));
    update_option('aakaari_sla_response_hours', absint($_POST['sla_response_hours']));

    echo '<div class="notice notice-success"><p>Settings saved successfully!</p></div>';
}

$chat_enabled = get_option('aakaari_chat_enabled', true);
$primary_color = get_option('aakaari_primary_color', '#2563EB');
$widget_position = get_option('aakaari_widget_position', 'bottom-right');
$greeting = get_option('aakaari_greeting', 'Hi! How can we help you today?');
$offline_message = get_option('aakaari_offline_message', 'We\'re currently offline. Leave a message and we\'ll get back to you within 4 hours.');
$ticket_prefix = get_option('aakaari_ticket_prefix', 'TKT');
$sla_hours = get_option('aakaari_sla_response_hours', 24);
?>
<div class="wrap aakaari-admin">
    <h1><?php _e('Lead System Settings', 'aakaari-leads'); ?></h1>

    <style>
        .aakaari-settings-form { max-width: 700px; }
        .aakaari-settings-section { background: #fff; border-radius: 12px; padding: 24px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .aakaari-settings-section h2 { margin: 0 0 20px; font-size: 18px; padding-bottom: 12px; border-bottom: 1px solid #e2e8f0; }
        .aakaari-form-row { margin-bottom: 20px; }
        .aakaari-form-row label { display: block; margin-bottom: 6px; font-weight: 500; color: #374151; }
        .aakaari-form-row input[type="text"],
        .aakaari-form-row input[type="number"],
        .aakaari-form-row input[type="color"],
        .aakaari-form-row select,
        .aakaari-form-row textarea { width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; }
        .aakaari-form-row input[type="color"] { height: 44px; padding: 4px; }
        .aakaari-form-row textarea { min-height: 100px; resize: vertical; }
        .aakaari-form-row .description { margin-top: 6px; font-size: 13px; color: #6b7280; }
        .aakaari-checkbox-row { display: flex; align-items: center; gap: 10px; }
        .aakaari-checkbox-row input[type="checkbox"] { width: 20px; height: 20px; }
        .aakaari-submit-btn { background: #2563eb; color: #fff; padding: 12px 24px; border: none; border-radius: 8px; font-size: 15px; font-weight: 500; cursor: pointer; }
        .aakaari-submit-btn:hover { background: #1d4ed8; }
    </style>

    <form method="post" class="aakaari-settings-form">
        <?php wp_nonce_field('aakaari_save_settings', 'aakaari_settings_nonce'); ?>

        <div class="aakaari-settings-section">
            <h2>Chat Widget</h2>

            <div class="aakaari-form-row">
                <div class="aakaari-checkbox-row">
                    <input type="checkbox" name="chat_enabled" id="chat_enabled" <?php checked($chat_enabled); ?>>
                    <label for="chat_enabled">Enable Chat Widget</label>
                </div>
                <p class="description">Show the chat widget on your website</p>
            </div>

            <div class="aakaari-form-row">
                <label for="primary_color">Primary Color</label>
                <input type="color" name="primary_color" id="primary_color" value="<?php echo esc_attr($primary_color); ?>">
                <p class="description">Main color for the chat widget (buttons, headers)</p>
            </div>

            <div class="aakaari-form-row">
                <label for="widget_position">Widget Position</label>
                <select name="widget_position" id="widget_position">
                    <option value="bottom-right" <?php selected($widget_position, 'bottom-right'); ?>>Bottom Right</option>
                    <option value="bottom-left" <?php selected($widget_position, 'bottom-left'); ?>>Bottom Left</option>
                </select>
            </div>

            <div class="aakaari-form-row">
                <label for="greeting">Greeting Message</label>
                <input type="text" name="greeting" id="greeting" value="<?php echo esc_attr($greeting); ?>">
                <p class="description">First message shown to visitors</p>
            </div>

            <div class="aakaari-form-row">
                <label for="offline_message">Offline Message</label>
                <textarea name="offline_message" id="offline_message"><?php echo esc_textarea($offline_message); ?></textarea>
                <p class="description">Message shown when no agents are online</p>
            </div>
        </div>

        <div class="aakaari-settings-section">
            <h2>Tickets</h2>

            <div class="aakaari-form-row">
                <label for="ticket_prefix">Ticket Number Prefix</label>
                <input type="text" name="ticket_prefix" id="ticket_prefix" value="<?php echo esc_attr($ticket_prefix); ?>" maxlength="5">
                <p class="description">Prefix for ticket numbers (e.g., TKT-2024-001)</p>
            </div>

            <div class="aakaari-form-row">
                <label for="sla_response_hours">SLA Response Time (hours)</label>
                <input type="number" name="sla_response_hours" id="sla_response_hours" value="<?php echo esc_attr($sla_hours); ?>" min="1" max="168">
                <p class="description">Expected first response time for tickets</p>
            </div>
        </div>

        <button type="submit" class="aakaari-submit-btn">Save Settings</button>
    </form>
</div>
