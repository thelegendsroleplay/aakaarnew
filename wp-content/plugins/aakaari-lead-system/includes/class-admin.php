<?php
/**
 * Admin Interface
 *
 * Manages admin menu, settings, and dashboard integration
 *
 * @package Aakaari_Lead_System
 */

if (!defined('ABSPATH')) {
    exit;
}

class Aakaari_Admin {

    public static function init() {
        add_action('admin_menu', [__CLASS__, 'add_admin_menu']);
        add_action('admin_init', [__CLASS__, 'register_settings']);

        // Add agent capability
        add_action('admin_init', [__CLASS__, 'add_agent_role']);

        // Dashboard widget
        add_action('wp_dashboard_setup', [__CLASS__, 'add_dashboard_widget']);

        // Admin bar notification
        add_action('admin_bar_menu', [__CLASS__, 'admin_bar_notification'], 100);

        // AJAX handlers for admin
        add_action('wp_ajax_aakaari_dismiss_notification', [__CLASS__, 'ajax_dismiss_notification']);
    }

    /**
     * Add admin menu
     */
    public static function add_admin_menu() {
        $menu_capability = 'aakaari_agent';

        // Main menu
        add_menu_page(
            __('Lead System', 'aakaari-leads'),
            __('Lead System', 'aakaari-leads'),
            $menu_capability,
            'aakaari-leads',
            [__CLASS__, 'render_dashboard_page'],
            'dashicons-format-chat',
            30
        );

        // Submenu pages
        add_submenu_page(
            'aakaari-leads',
            __('Dashboard', 'aakaari-leads'),
            __('Dashboard', 'aakaari-leads'),
            $menu_capability,
            'aakaari-leads',
            [__CLASS__, 'render_dashboard_page']
        );

        add_submenu_page(
            'aakaari-leads',
            __('Live Chats', 'aakaari-leads'),
            __('Live Chats', 'aakaari-leads'),
            $menu_capability,
            'aakaari-chats',
            [__CLASS__, 'render_chats_page']
        );

        add_submenu_page(
            'aakaari-leads',
            __('Tickets', 'aakaari-leads'),
            __('Tickets', 'aakaari-leads'),
            $menu_capability,
            'aakaari-tickets',
            [__CLASS__, 'render_tickets_page']
        );

        add_submenu_page(
            'aakaari-leads',
            __('Leads', 'aakaari-leads'),
            __('Leads', 'aakaari-leads'),
            $menu_capability,
            'aakaari-leads-list',
            [__CLASS__, 'render_leads_page']
        );

        add_submenu_page(
            'aakaari-leads',
            __('Triggers', 'aakaari-leads'),
            __('Triggers', 'aakaari-leads'),
            $menu_capability,
            'aakaari-triggers',
            [__CLASS__, 'render_triggers_page']
        );

        add_submenu_page(
            'aakaari-leads',
            __('Canned Responses', 'aakaari-leads'),
            __('Canned Responses', 'aakaari-leads'),
            $menu_capability,
            'aakaari-canned',
            [__CLASS__, 'render_canned_page']
        );

        add_submenu_page(
            'aakaari-leads',
            __('Settings', 'aakaari-leads'),
            __('Settings', 'aakaari-leads'),
            'manage_options',
            'aakaari-settings',
            [__CLASS__, 'render_settings_page']
        );
    }

    /**
     * Register settings
     */
    public static function register_settings() {
        // General settings
        register_setting('aakaari_settings', 'aakaari_chat_enabled');
        register_setting('aakaari_settings', 'aakaari_primary_color');
        register_setting('aakaari_settings', 'aakaari_widget_position');
        register_setting('aakaari_settings', 'aakaari_greeting');
        register_setting('aakaari_settings', 'aakaari_offline_message');
        register_setting('aakaari_settings', 'aakaari_ticket_prefix');
        register_setting('aakaari_settings', 'aakaari_sla_response_hours');
        register_setting('aakaari_settings', 'aakaari_business_hours');
    }

    /**
     * Add agent role and capability
     */
    public static function add_agent_role() {
        $role = get_role('administrator');
        if ($role && !$role->has_cap('aakaari_agent')) {
            $role->add_cap('aakaari_agent');
        }

        // Create agent role if it doesn't exist
        if (!get_role('aakaari_agent')) {
            add_role('aakaari_agent', 'Chat Agent', [
                'read' => true,
                'aakaari_agent' => true
            ]);
        }
    }

    /**
     * Check if any agent is online.
     */
    public static function is_agent_online() {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_agent_status';

        if ($wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table)) !== $table) {
            return false;
        }

        $online_agents = $wpdb->get_var(
            "SELECT COUNT(*) FROM $table WHERE status = 'available' AND last_seen > DATE_SUB(NOW(), INTERVAL 5 MINUTE)"
        );

        return $online_agents > 0;
    }

    /**
     * Dashboard widget
     */
    public static function add_dashboard_widget() {
        wp_add_dashboard_widget(
            'aakaari_stats_widget',
            __('Lead System Overview', 'aakaari-leads'),
            [__CLASS__, 'render_dashboard_widget']
        );
    }

    /**
     * Render dashboard widget
     */
    public static function render_dashboard_widget() {
        $stats = Aakaari_Lead_Handler::get_dashboard_stats();
        ?>
        <div class="aakaari-widget">
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 15px;">
                <div style="text-align: center; padding: 15px; background: #f0f7ff; border-radius: 8px;">
                    <div style="font-size: 24px; font-weight: bold; color: #2563EB;"><?php echo esc_html($stats['open']['waiting_chats']); ?></div>
                    <div style="color: #666; font-size: 12px;">Waiting Chats</div>
                </div>
                <div style="text-align: center; padding: 15px; background: #fff7ed; border-radius: 8px;">
                    <div style="font-size: 24px; font-weight: bold; color: #ea580c;"><?php echo esc_html($stats['open']['open_tickets']); ?></div>
                    <div style="color: #666; font-size: 12px;">Open Tickets</div>
                </div>
                <div style="text-align: center; padding: 15px; background: #f0fdf4; border-radius: 8px;">
                    <div style="font-size: 24px; font-weight: bold; color: #16a34a;"><?php echo esc_html($stats['today']['leads']); ?></div>
                    <div style="color: #666; font-size: 12px;">Today's Leads</div>
                </div>
            </div>
            <p style="margin: 0;">
                <a href="<?php echo admin_url('admin.php?page=aakaari-leads'); ?>" class="button button-primary">Open Dashboard</a>
                <a href="<?php echo admin_url('admin.php?page=aakaari-chats'); ?>" class="button" style="margin-left: 5px;">View Chats</a>
            </p>
        </div>
        <?php
    }

    /**
     * Admin bar notification for waiting chats
     */
    public static function admin_bar_notification($wp_admin_bar) {
        if (!current_user_can('manage_options') && !current_user_can('aakaari_agent')) {
            return;
        }

        global $wpdb;
        $waiting = $wpdb->get_var(
            "SELECT COUNT(*) FROM {$wpdb->prefix}aakaari_conversations WHERE status = 'waiting'"
        );

        if ($waiting > 0) {
            $wp_admin_bar->add_node([
                'id' => 'aakaari-chats',
                'title' => sprintf(
                    '<span class="ab-icon dashicons dashicons-format-chat"></span> <span class="aakaari-count" style="background: #dc3545; color: #fff; padding: 2px 6px; border-radius: 10px; font-size: 11px;">%d</span>',
                    $waiting
                ),
                'href' => admin_url('admin.php?page=aakaari-chats'),
                'meta' => ['title' => sprintf(__('%d waiting chats', 'aakaari-leads'), $waiting)]
            ]);
        }
    }

    /**
     * Render dashboard page
     */
    public static function render_dashboard_page() {
        $stats = Aakaari_Lead_Handler::get_dashboard_stats();
        include AAKAARI_LEADS_PATH . 'templates/admin/dashboard.php';
    }

    /**
     * Render chats page
     */
    public static function render_chats_page() {
        include AAKAARI_LEADS_PATH . 'templates/admin/chats.php';
    }

    /**
     * Render tickets page
     */
    public static function render_tickets_page() {
        include AAKAARI_LEADS_PATH . 'templates/admin/tickets.php';
    }

    /**
     * Render leads page
     */
    public static function render_leads_page() {
        include AAKAARI_LEADS_PATH . 'templates/admin/leads.php';
    }

    /**
     * Render triggers page
     */
    public static function render_triggers_page() {
        include AAKAARI_LEADS_PATH . 'templates/admin/triggers.php';
    }

    /**
     * Render canned responses page
     */
    public static function render_canned_page() {
        include AAKAARI_LEADS_PATH . 'templates/admin/canned.php';
    }

    /**
     * Render settings page
     */
    public static function render_settings_page() {
        include AAKAARI_LEADS_PATH . 'templates/admin/settings.php';
    }

    /**
     * AJAX dismiss notification
     */
    public static function ajax_dismiss_notification() {
        check_ajax_referer('aakaari_admin_nonce', 'nonce');
        $notification_id = sanitize_text_field($_POST['notification_id']);
        update_user_meta(get_current_user_id(), 'aakaari_dismissed_' . $notification_id, true);
        wp_send_json_success();
    }
}
