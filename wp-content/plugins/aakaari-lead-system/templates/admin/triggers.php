<?php
/**
 * Admin Triggers Template
 *
 * @package Aakaari_Lead_System
 */

if (!defined('ABSPATH')) {
    exit;
}

$triggers = Aakaari_Triggers::get_all_triggers();
?>
<div class="wrap aakaari-admin">
    <h1><?php _e('Proactive Chat Triggers', 'aakaari-leads'); ?></h1>
    <p class="description">Configure automatic chat popups to engage visitors based on their behavior.</p>

    <style>
        .aakaari-triggers-grid { display: grid; gap: 20px; margin-top: 20px; }
        .aakaari-trigger-card { background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .aakaari-trigger-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
        .aakaari-trigger-card-header h3 { margin: 0; font-size: 16px; }
        .aakaari-trigger-card-header .toggle { }
        .aakaari-trigger-type { display: inline-block; padding: 4px 10px; background: #f1f5f9; border-radius: 12px; font-size: 11px; color: #64748b; margin-bottom: 12px; }
        .aakaari-trigger-message { background: #f8fafc; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-style: italic; color: #475569; }
        .aakaari-trigger-stats { display: flex; gap: 20px; font-size: 13px; color: #64748b; }
        .aakaari-trigger-stats strong { color: #1e293b; }
        .aakaari-toggle { position: relative; display: inline-block; width: 44px; height: 24px; }
        .aakaari-toggle input { opacity: 0; width: 0; height: 0; }
        .aakaari-toggle-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .3s; border-radius: 24px; }
        .aakaari-toggle-slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .3s; border-radius: 50%; }
        .aakaari-toggle input:checked + .aakaari-toggle-slider { background-color: #2563eb; }
        .aakaari-toggle input:checked + .aakaari-toggle-slider:before { transform: translateX(20px); }
    </style>

    <div class="aakaari-triggers-grid">
        <?php foreach ($triggers as $trigger): ?>
            <div class="aakaari-trigger-card">
                <div class="aakaari-trigger-card-header">
                    <h3><?php echo esc_html($trigger['trigger_name']); ?></h3>
                    <label class="aakaari-toggle">
                        <input type="checkbox" <?php checked($trigger['is_active'], 1); ?>
                               onchange="toggleTrigger(<?php echo $trigger['id']; ?>, this.checked)">
                        <span class="aakaari-toggle-slider"></span>
                    </label>
                </div>
                <span class="aakaari-trigger-type"><?php echo esc_html(ucwords(str_replace('_', ' ', $trigger['trigger_type']))); ?></span>
                <div class="aakaari-trigger-message">"<?php echo esc_html($trigger['message']); ?>"</div>
                <div class="aakaari-trigger-stats">
                    <span>Shown: <strong><?php echo esc_html($trigger['times_triggered']); ?></strong></span>
                    <span>Engaged: <strong><?php echo esc_html($trigger['times_engaged']); ?></strong></span>
                    <span>Rate: <strong><?php echo esc_html($trigger['engagement_rate']); ?>%</strong></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
function toggleTrigger(id, active) {
    fetch('<?php echo rest_url('aakaari/v1/admin/triggers/'); ?>' + id, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
        },
        body: JSON.stringify({ is_active: active ? 1 : 0 })
    });
}
</script>
