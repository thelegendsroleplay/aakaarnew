<?php
/**
 * Plugin Name: Aakaari Lead Conversion System
 * Plugin URI: https://aakaari.tech
 * Description: Live chat and ticket system for lead conversion - WordPress services business
 * Version: 1.0.0
 * Author: AAKAARI Tech Solutions
 * Author URI: https://aakaari.tech
 * Text Domain: aakaari-leads
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 8.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Plugin constants
define('AAKAARI_LEADS_VERSION', '1.0.0');
define('AAKAARI_LEADS_PATH', plugin_dir_path(__FILE__));
define('AAKAARI_LEADS_URL', plugin_dir_url(__FILE__));
define('AAKAARI_LEADS_BASENAME', plugin_basename(__FILE__));

/**
 * Main Plugin Class
 */
final class Aakaari_Lead_System {

    private static $instance = null;

    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->load_dependencies();
        $this->init_hooks();
    }

    private function load_dependencies() {
        require_once AAKAARI_LEADS_PATH . 'includes/class-database.php';
        require_once AAKAARI_LEADS_PATH . 'includes/class-security.php';
        require_once AAKAARI_LEADS_PATH . 'includes/class-rest-api.php';
        require_once AAKAARI_LEADS_PATH . 'includes/class-chat-handler.php';
        require_once AAKAARI_LEADS_PATH . 'includes/class-ticket-handler.php';
        require_once AAKAARI_LEADS_PATH . 'includes/class-lead-handler.php';
        require_once AAKAARI_LEADS_PATH . 'includes/class-email-handler.php';
        require_once AAKAARI_LEADS_PATH . 'includes/class-triggers.php';
        require_once AAKAARI_LEADS_PATH . 'includes/class-admin.php';
    }

    private function init_hooks() {
        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deactivate']);

        add_action('init', [$this, 'init']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('wp_footer', [$this, 'render_chat_widget']);
    }

    public function activate() {
        Aakaari_Database::create_tables();
        Aakaari_Database::seed_default_data();
        flush_rewrite_rules();
    }

    public function deactivate() {
        flush_rewrite_rules();
    }

    public function init() {
        // Initialize components
        Aakaari_Security::init();
        Aakaari_REST_API::init();
        Aakaari_Chat_Handler::init();
        Aakaari_Ticket_Handler::init();
        Aakaari_Lead_Handler::init();
        Aakaari_Email_Handler::init();
        Aakaari_Triggers::init();
        Aakaari_Admin::init();

        // Load translations
        load_plugin_textdomain('aakaari-leads', false, dirname(AAKAARI_LEADS_BASENAME) . '/languages');
    }

    public function enqueue_frontend_assets() {
        // Chat widget styles
        wp_enqueue_style(
            'aakaari-chat-widget',
            AAKAARI_LEADS_URL . 'assets/css/chat-widget.css',
            [],
            AAKAARI_LEADS_VERSION
        );

        // Chat widget script
        wp_enqueue_script(
            'aakaari-chat-widget',
            AAKAARI_LEADS_URL . 'assets/js/chat-widget.js',
            [],
            AAKAARI_LEADS_VERSION,
            true
        );

        // Localize script with settings
        wp_localize_script('aakaari-chat-widget', 'aakaariChat', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'restUrl' => rest_url('aakaari/v1/'),
            'nonce' => wp_create_nonce('aakaari_chat_nonce'),
            'restNonce' => wp_create_nonce('wp_rest'),
            'isLoggedIn' => is_user_logged_in(),
            'currentPage' => $this->get_current_page_info(),
            'settings' => $this->get_chat_settings(),
            'triggers' => Aakaari_Triggers::get_active_triggers(),
            'i18n' => $this->get_translations()
        ]);
    }

    public function enqueue_admin_assets($hook) {
        // Only load on our admin pages
        if (strpos($hook, 'aakaari') === false && !$this->is_dashboard_page()) {
            return;
        }

        wp_enqueue_style(
            'aakaari-admin',
            AAKAARI_LEADS_URL . 'assets/css/admin.css',
            [],
            AAKAARI_LEADS_VERSION
        );

        wp_enqueue_script(
            'aakaari-admin-chat',
            AAKAARI_LEADS_URL . 'assets/js/admin-chat.js',
            [],
            AAKAARI_LEADS_VERSION,
            true
        );

        wp_localize_script('aakaari-admin-chat', 'aakaariAdmin', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'restUrl' => rest_url('aakaari/v1/'),
            'nonce' => wp_create_nonce('aakaari_admin_nonce'),
            'restNonce' => wp_create_nonce('wp_rest'),
            'agentId' => get_current_user_id(),
            'pollInterval' => 3000,
            'i18n' => $this->get_admin_translations()
        ]);
    }

    public function render_chat_widget() {
        // Don't show on admin pages or if disabled
        if (is_admin() || $this->is_chat_disabled()) {
            return;
        }

        include AAKAARI_LEADS_PATH . 'templates/chat-widget.php';
    }

    private function get_current_page_info() {
        return [
            'url' => home_url(add_query_arg([], $GLOBALS['wp']->request)),
            'title' => wp_title('', false),
            'type' => $this->get_page_type(),
            'id' => get_queried_object_id()
        ];
    }

    private function get_page_type() {
        if (is_front_page()) return 'homepage';
        if (is_singular('product')) return 'product';
        if (is_page()) return 'page';
        if (is_archive()) return 'archive';
        return 'other';
    }

    private function get_chat_settings() {
        return [
            'enabled' => get_option('aakaari_chat_enabled', true),
            'offlineMode' => !$this->is_agent_online(),
            'businessHours' => $this->get_business_hours(),
            'primaryColor' => get_option('aakaari_primary_color', '#2563EB'),
            'position' => get_option('aakaari_widget_position', 'bottom-right'),
            'greeting' => get_option('aakaari_greeting', 'Hi! How can we help you today?'),
            'offlineMessage' => get_option('aakaari_offline_message', 'We\'re currently offline. Leave a message and we\'ll get back to you within 4 hours.')
        ];
    }

    private function get_business_hours() {
        $hours = get_option('aakaari_business_hours', [
            'timezone' => 'Asia/Kolkata',
            'days' => [
                'monday' => ['start' => '09:00', 'end' => '18:00', 'enabled' => true],
                'tuesday' => ['start' => '09:00', 'end' => '18:00', 'enabled' => true],
                'wednesday' => ['start' => '09:00', 'end' => '18:00', 'enabled' => true],
                'thursday' => ['start' => '09:00', 'end' => '18:00', 'enabled' => true],
                'friday' => ['start' => '09:00', 'end' => '18:00', 'enabled' => true],
                'saturday' => ['start' => '10:00', 'end' => '14:00', 'enabled' => true],
                'sunday' => ['start' => '00:00', 'end' => '00:00', 'enabled' => false]
            ]
        ]);
        return $hours;
    }

    private function is_agent_online() {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_agent_status';

        // Check if table exists
        if ($wpdb->get_var("SHOW TABLES LIKE '$table'") !== $table) {
            return false;
        }

        $online_agents = $wpdb->get_var(
            "SELECT COUNT(*) FROM $table WHERE status = 'available' AND last_seen > DATE_SUB(NOW(), INTERVAL 5 MINUTE)"
        );

        return $online_agents > 0;
    }

    private function is_chat_disabled() {
        return !get_option('aakaari_chat_enabled', true);
    }

    private function is_dashboard_page() {
        global $post;
        return $post && $post->post_name === 'aakaari-dashboard';
    }

    private function get_translations() {
        return [
            'startChat' => __('Start Chat', 'aakaari-leads'),
            'sendMessage' => __('Send', 'aakaari-leads'),
            'typeMessage' => __('Type your message...', 'aakaari-leads'),
            'connecting' => __('Connecting...', 'aakaari-leads'),
            'connected' => __('Connected', 'aakaari-leads'),
            'offline' => __('Leave a message', 'aakaari-leads'),
            'typing' => __('is typing...', 'aakaari-leads'),
            'endChat' => __('End Chat', 'aakaari-leads'),
            'chatEnded' => __('Chat ended', 'aakaari-leads'),
            'requiredField' => __('This field is required', 'aakaari-leads'),
            'invalidEmail' => __('Please enter a valid email', 'aakaari-leads'),
            'formTitle' => __('Before we chat...', 'aakaari-leads'),
            'nameLabel' => __('Your Name', 'aakaari-leads'),
            'emailLabel' => __('Email Address', 'aakaari-leads'),
            'websiteLabel' => __('Website URL (optional)', 'aakaari-leads'),
            'companyLabel' => __('Company Name (optional)', 'aakaari-leads'),
            'sourceLabel' => __('How did you find us?', 'aakaari-leads'),
            'questionLabel' => __('What brings you here today?', 'aakaari-leads'),
            'submitForm' => __('Start Chatting', 'aakaari-leads'),
            'waitTime' => __('Average wait time:', 'aakaari-leads'),
            'queuePosition' => __('Your position in queue:', 'aakaari-leads')
        ];
    }

    private function get_admin_translations() {
        return [
            'newChat' => __('New chat request', 'aakaari-leads'),
            'accept' => __('Accept', 'aakaari-leads'),
            'reject' => __('Reject', 'aakaari-leads'),
            'transfer' => __('Transfer', 'aakaari-leads'),
            'endChat' => __('End Chat', 'aakaari-leads'),
            'createTicket' => __('Create Ticket', 'aakaari-leads'),
            'sendProposal' => __('Send Proposal', 'aakaari-leads'),
            'hotLead' => __('Hot Lead', 'aakaari-leads'),
            'warmLead' => __('Warm Lead', 'aakaari-leads'),
            'coldLead' => __('Cold Lead', 'aakaari-leads')
        ];
    }
}

/**
 * Initialize plugin
 */
function aakaari_lead_system() {
    return Aakaari_Lead_System::instance();
}

// Start the plugin
aakaari_lead_system();
