<?php
/**
 * REST API Endpoints
 *
 * @package Aakaari_Lead_System
 */

if (!defined('ABSPATH')) {
    exit;
}

class Aakaari_REST_API {

    private static $namespace = 'aakaari/v1';

    public static function init() {
        add_action('rest_api_init', [__CLASS__, 'register_routes']);
    }

    public static function register_routes() {
        // Chat routes
        register_rest_route(self::$namespace, '/chat/init', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'init_chat'],
            'permission_callback' => [__CLASS__, 'public_permission'],
        ]);

        register_rest_route(self::$namespace, '/chat/message', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'send_message'],
            'permission_callback' => [__CLASS__, 'public_permission'],
        ]);

        register_rest_route(self::$namespace, '/chat/poll', [
            'methods' => 'GET',
            'callback' => [__CLASS__, 'poll_messages'],
            'permission_callback' => [__CLASS__, 'public_permission'],
        ]);

        register_rest_route(self::$namespace, '/chat/typing', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'set_typing'],
            'permission_callback' => [__CLASS__, 'public_permission'],
        ]);

        register_rest_route(self::$namespace, '/chat/end', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'end_chat'],
            'permission_callback' => [__CLASS__, 'public_permission'],
        ]);

        register_rest_route(self::$namespace, '/chat/upload', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'upload_file'],
            'permission_callback' => [__CLASS__, 'public_permission'],
        ]);

        // Visitor routes
        register_rest_route(self::$namespace, '/visitor/track', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'track_visitor'],
            'permission_callback' => [__CLASS__, 'public_permission'],
        ]);

        register_rest_route(self::$namespace, '/visitor/capture', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'capture_lead'],
            'permission_callback' => [__CLASS__, 'public_permission'],
        ]);

        // Ticket routes
        register_rest_route(self::$namespace, '/ticket/submit', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'submit_ticket'],
            'permission_callback' => [__CLASS__, 'public_permission'],
        ]);

        register_rest_route(self::$namespace, '/ticket/(?P<id>\d+)', [
            'methods' => 'GET',
            'callback' => [__CLASS__, 'get_ticket'],
            'permission_callback' => [__CLASS__, 'public_permission'],
        ]);

        register_rest_route(self::$namespace, '/ticket/(?P<id>\d+)/reply', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'reply_ticket'],
            'permission_callback' => [__CLASS__, 'public_permission'],
        ]);

        // Trigger routes
        register_rest_route(self::$namespace, '/trigger/engaged', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'trigger_engaged'],
            'permission_callback' => [__CLASS__, 'public_permission'],
        ]);

        // Admin routes
        register_rest_route(self::$namespace, '/admin/conversations', [
            'methods' => 'GET',
            'callback' => [__CLASS__, 'admin_get_conversations'],
            'permission_callback' => [__CLASS__, 'admin_permission'],
        ]);

        register_rest_route(self::$namespace, '/admin/conversation/(?P<id>\d+)', [
            'methods' => 'GET',
            'callback' => [__CLASS__, 'admin_get_conversation'],
            'permission_callback' => [__CLASS__, 'admin_permission'],
        ]);

        register_rest_route(self::$namespace, '/admin/conversation/(?P<id>\d+)/accept', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'admin_accept_chat'],
            'permission_callback' => [__CLASS__, 'admin_permission'],
        ]);

        register_rest_route(self::$namespace, '/admin/conversation/(?P<id>\d+)/message', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'admin_send_message'],
            'permission_callback' => [__CLASS__, 'admin_permission'],
        ]);

        register_rest_route(self::$namespace, '/admin/conversation/(?P<id>\d+)/end', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'admin_end_chat'],
            'permission_callback' => [__CLASS__, 'admin_permission'],
        ]);

        register_rest_route(self::$namespace, '/admin/conversation/(?P<id>\d+)/notes', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'admin_update_notes'],
            'permission_callback' => [__CLASS__, 'admin_permission'],
        ]);

        register_rest_route(self::$namespace, '/admin/conversation/(?P<id>\d+)/tags', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'admin_update_tags'],
            'permission_callback' => [__CLASS__, 'admin_permission'],
        ]);

        register_rest_route(self::$namespace, '/admin/conversation/(?P<id>\d+)/ticket', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'admin_convert_to_ticket'],
            'permission_callback' => [__CLASS__, 'admin_permission'],
        ]);

        register_rest_route(self::$namespace, '/admin/poll', [
            'methods' => 'GET',
            'callback' => [__CLASS__, 'admin_poll'],
            'permission_callback' => [__CLASS__, 'admin_permission'],
        ]);

        register_rest_route(self::$namespace, '/admin/status', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'admin_set_status'],
            'permission_callback' => [__CLASS__, 'admin_permission'],
        ]);

        register_rest_route(self::$namespace, '/admin/canned', [
            'methods' => 'GET',
            'callback' => [__CLASS__, 'admin_get_canned'],
            'permission_callback' => [__CLASS__, 'admin_permission'],
        ]);

        register_rest_route(self::$namespace, '/admin/tickets', [
            'methods' => 'GET',
            'callback' => [__CLASS__, 'admin_get_tickets'],
            'permission_callback' => [__CLASS__, 'admin_permission'],
        ]);

        register_rest_route(self::$namespace, '/admin/ticket/(?P<id>\d+)', [
            'methods' => ['GET', 'PUT'],
            'callback' => [__CLASS__, 'admin_ticket'],
            'permission_callback' => [__CLASS__, 'admin_permission'],
        ]);

        register_rest_route(self::$namespace, '/admin/leads', [
            'methods' => 'GET',
            'callback' => [__CLASS__, 'admin_get_leads'],
            'permission_callback' => [__CLASS__, 'admin_permission'],
        ]);

        register_rest_route(self::$namespace, '/admin/stats', [
            'methods' => 'GET',
            'callback' => [__CLASS__, 'admin_get_stats'],
            'permission_callback' => [__CLASS__, 'admin_permission'],
        ]);
    }

    /**
     * Permission callbacks
     */
    public static function public_permission() {
        return true; // Rate limiting handled per-endpoint
    }

    public static function admin_permission() {
        return current_user_can('manage_options') || current_user_can('aakaari_agent');
    }

    /**
     * Initialize chat session
     */
    public static function init_chat(WP_REST_Request $request) {
        if (!Aakaari_Security::check_rate_limit('chat_init')) {
            return new WP_Error('rate_limited', 'Too many requests. Please try again later.', ['status' => 429]);
        }

        $params = $request->get_json_params();

        // Validate pre-chat form data
        $name = Aakaari_Security::sanitize_text($params['name'] ?? '', 100);
        $email = Aakaari_Security::sanitize_email($params['email'] ?? '');
        $website = Aakaari_Security::sanitize_url($params['website'] ?? '');
        $company = Aakaari_Security::sanitize_text($params['company'] ?? '', 100);
        $how_found = Aakaari_Security::sanitize_text($params['how_found_us'] ?? '', 50);
        $question = Aakaari_Security::sanitize_string($params['question'] ?? '', 200);
        $page_url = Aakaari_Security::sanitize_url($params['page_url'] ?? '');

        if (strlen($name) < 3) {
            return new WP_Error('invalid_name', 'Please enter your full name', ['status' => 400]);
        }

        if (!$email) {
            return new WP_Error('invalid_email', 'Please enter a valid email', ['status' => 400]);
        }

        if (strlen($question) < 5) {
            return new WP_Error('invalid_question', 'Please tell us what brings you here', ['status' => 400]);
        }

        // Check spam
        if (Aakaari_Security::is_spam_submission(['message' => $question])) {
            return new WP_Error('spam_detected', 'Unable to process request', ['status' => 400]);
        }

        // Check if visitor is blocked
        if (Aakaari_Security::is_visitor_blocked()) {
            return new WP_Error('blocked', 'Unable to start chat', ['status' => 403]);
        }

        // Create or update visitor
        $visitor_id = Aakaari_Chat_Handler::create_or_update_visitor([
            'name' => $name,
            'email' => $email,
            'website' => $website,
            'company' => $company,
            'how_found_us' => $how_found,
            'current_page' => $page_url
        ]);

        // Create lead
        $lead_id = Aakaari_Lead_Handler::create_lead([
            'visitor_id' => $visitor_id,
            'source' => 'chat',
            'name' => $name,
            'email' => $email,
            'company' => $company,
            'website' => $website,
            'how_found_us' => $how_found
        ]);

        // Create conversation
        $conversation_id = Aakaari_Chat_Handler::create_conversation([
            'visitor_id' => $visitor_id,
            'lead_id' => $lead_id,
            'page_url' => $page_url,
            'trigger_source' => $params['trigger_source'] ?? 'manual'
        ]);

        // Add initial question as first message
        Aakaari_Chat_Handler::add_message([
            'conversation_id' => $conversation_id,
            'sender_type' => 'visitor',
            'message_text' => $question,
            'message_type' => 'text'
        ]);

        // Get queue position
        $queue_info = Aakaari_Chat_Handler::get_queue_info($conversation_id);

        return rest_ensure_response([
            'success' => true,
            'conversation_id' => $conversation_id,
            'visitor_id' => $visitor_id,
            'queue_position' => $queue_info['position'],
            'estimated_wait' => $queue_info['estimated_wait'],
            'agent_online' => $queue_info['agents_available'] > 0
        ]);
    }

    /**
     * Send message from visitor
     */
    public static function send_message(WP_REST_Request $request) {
        if (!Aakaari_Security::check_rate_limit('message_send')) {
            return new WP_Error('rate_limited', 'Please slow down', ['status' => 429]);
        }

        $params = $request->get_json_params();
        $conversation_id = absint($params['conversation_id'] ?? 0);
        $message = Aakaari_Security::sanitize_string($params['message'] ?? '', 1000);

        if (!$conversation_id || !$message) {
            return new WP_Error('invalid_params', 'Invalid parameters', ['status' => 400]);
        }

        // Verify conversation belongs to this session
        $session_id = Aakaari_Security::get_session_id();
        if (!Aakaari_Chat_Handler::verify_conversation_access($conversation_id, $session_id)) {
            return new WP_Error('access_denied', 'Invalid conversation', ['status' => 403]);
        }

        $message_id = Aakaari_Chat_Handler::add_message([
            'conversation_id' => $conversation_id,
            'sender_type' => 'visitor',
            'message_text' => $message,
            'message_type' => 'text'
        ]);

        return rest_ensure_response([
            'success' => true,
            'message_id' => $message_id,
            'timestamp' => current_time('mysql')
        ]);
    }

    /**
     * Poll for new messages (long-polling)
     */
    public static function poll_messages(WP_REST_Request $request) {
        $conversation_id = absint($request->get_param('conversation_id'));
        $last_message_id = absint($request->get_param('last_id') ?? 0);

        if (!$conversation_id) {
            return new WP_Error('invalid_params', 'Invalid parameters', ['status' => 400]);
        }

        // Verify conversation access
        $session_id = Aakaari_Security::get_session_id();
        if (!Aakaari_Chat_Handler::verify_conversation_access($conversation_id, $session_id)) {
            return new WP_Error('access_denied', 'Invalid conversation', ['status' => 403]);
        }

        // Long-polling: wait up to 25 seconds for new messages
        $timeout = 25;
        $start = time();
        $messages = [];

        while (time() - $start < $timeout) {
            $messages = Aakaari_Chat_Handler::get_messages_since($conversation_id, $last_message_id);

            if (!empty($messages)) {
                break;
            }

            // Wait 1 second before checking again
            sleep(1);
        }

        // Get conversation status
        $conversation = Aakaari_Chat_Handler::get_conversation($conversation_id);
        $typing = Aakaari_Chat_Handler::get_typing_status($conversation_id, 'agent');

        return rest_ensure_response([
            'messages' => $messages,
            'status' => $conversation['status'],
            'agent_typing' => $typing,
            'agent_name' => $conversation['agent_name'] ?? null
        ]);
    }

    /**
     * Set typing indicator
     */
    public static function set_typing(WP_REST_Request $request) {
        $params = $request->get_json_params();
        $conversation_id = absint($params['conversation_id'] ?? 0);
        $is_typing = (bool) ($params['is_typing'] ?? false);

        if (!$conversation_id) {
            return new WP_Error('invalid_params', 'Invalid parameters', ['status' => 400]);
        }

        Aakaari_Chat_Handler::set_typing($conversation_id, 'visitor', $is_typing);

        return rest_ensure_response(['success' => true]);
    }

    /**
     * End chat from visitor side
     */
    public static function end_chat(WP_REST_Request $request) {
        $params = $request->get_json_params();
        $conversation_id = absint($params['conversation_id'] ?? 0);
        $rating = absint($params['rating'] ?? 0);

        if (!$conversation_id) {
            return new WP_Error('invalid_params', 'Invalid parameters', ['status' => 400]);
        }

        // Verify access
        $session_id = Aakaari_Security::get_session_id();
        if (!Aakaari_Chat_Handler::verify_conversation_access($conversation_id, $session_id)) {
            return new WP_Error('access_denied', 'Invalid conversation', ['status' => 403]);
        }

        Aakaari_Chat_Handler::end_conversation($conversation_id, 'visitor', $rating);

        // Send transcript email
        Aakaari_Email_Handler::send_chat_transcript($conversation_id);

        return rest_ensure_response(['success' => true]);
    }

    /**
     * Upload file
     */
    public static function upload_file(WP_REST_Request $request) {
        if (!Aakaari_Security::check_rate_limit('file_upload')) {
            return new WP_Error('rate_limited', 'Too many uploads', ['status' => 429]);
        }

        $files = $request->get_file_params();
        $conversation_id = absint($request->get_param('conversation_id'));

        if (empty($files['file']) || !$conversation_id) {
            return new WP_Error('invalid_params', 'Missing file or conversation', ['status' => 400]);
        }

        $validation = Aakaari_Security::validate_file_upload($files['file'], 5242880);

        if (isset($validation['error'])) {
            return new WP_Error('upload_failed', $validation['error'], ['status' => 400]);
        }

        // Upload file
        require_once ABSPATH . 'wp-admin/includes/file.php';

        $upload_dir = wp_upload_dir();
        $aakaari_dir = $upload_dir['basedir'] . '/aakaari-uploads/' . date('Y/m');

        if (!file_exists($aakaari_dir)) {
            wp_mkdir_p($aakaari_dir);
        }

        $unique_name = wp_unique_filename($aakaari_dir, $validation['safe_name']);
        $dest_path = $aakaari_dir . '/' . $unique_name;

        if (!move_uploaded_file($files['file']['tmp_name'], $dest_path)) {
            return new WP_Error('upload_failed', 'Failed to save file', ['status' => 500]);
        }

        $file_url = $upload_dir['baseurl'] . '/aakaari-uploads/' . date('Y/m') . '/' . $unique_name;

        // Create message with file
        $message_id = Aakaari_Chat_Handler::add_message([
            'conversation_id' => $conversation_id,
            'sender_type' => 'visitor',
            'message_text' => 'Shared a file: ' . $validation['safe_name'],
            'message_type' => 'image',
            'file_url' => $file_url,
            'file_name' => $validation['safe_name'],
            'file_size' => $validation['size']
        ]);

        return rest_ensure_response([
            'success' => true,
            'message_id' => $message_id,
            'file_url' => $file_url
        ]);
    }

    /**
     * Track visitor behavior
     */
    public static function track_visitor(WP_REST_Request $request) {
        $params = $request->get_json_params();

        $session_id = Aakaari_Security::get_session_id();
        $page_url = Aakaari_Security::sanitize_url($params['page_url'] ?? '');
        $referrer = Aakaari_Security::sanitize_url($params['referrer'] ?? '');

        $visitor_data = Aakaari_Security::get_user_agent_info();
        $visitor_data['session_id'] = $session_id;
        $visitor_data['current_page'] = $page_url;
        $visitor_data['referral_source'] = $referrer;
        $visitor_data['ip_address'] = Aakaari_Security::get_client_ip();

        $visitor_id = Aakaari_Chat_Handler::track_visitor($visitor_data);

        return rest_ensure_response([
            'session_id' => $session_id,
            'visitor_id' => $visitor_id,
            'is_returning' => Aakaari_Chat_Handler::is_returning_visitor($session_id)
        ]);
    }

    /**
     * Submit ticket
     */
    public static function submit_ticket(WP_REST_Request $request) {
        if (!Aakaari_Security::check_rate_limit('ticket_submit', $request->get_param('email'))) {
            return new WP_Error('rate_limited', 'Too many submissions. Please try again later.', ['status' => 429]);
        }

        $params = $request->get_json_params();

        // Validate required fields
        $required = ['project_type', 'name', 'email', 'phone', 'title', 'description', 'problem_statement', 'timeline', 'budget_range'];
        foreach ($required as $field) {
            if (empty($params[$field])) {
                return new WP_Error('missing_field', "Please fill in the $field field", ['status' => 400]);
            }
        }

        // Sanitize inputs
        $data = [
            'project_type' => Aakaari_Security::sanitize_text($params['project_type'], 50),
            'name' => Aakaari_Security::sanitize_text($params['name'], 100),
            'email' => Aakaari_Security::sanitize_email($params['email']),
            'phone' => Aakaari_Security::sanitize_phone($params['phone']),
            'company' => Aakaari_Security::sanitize_text($params['company'] ?? '', 100),
            'website' => Aakaari_Security::sanitize_url($params['website'] ?? ''),
            'title' => Aakaari_Security::sanitize_text($params['title'], 200),
            'description' => Aakaari_Security::sanitize_string($params['description'], 2000),
            'problem_statement' => Aakaari_Security::sanitize_string($params['problem_statement'], 1000),
            'has_mockups' => (bool) ($params['has_mockups'] ?? false),
            'timeline' => Aakaari_Security::sanitize_text($params['timeline'], 50),
            'timeline_date' => $params['timeline_date'] ?? null,
            'budget_range' => Aakaari_Security::sanitize_text($params['budget_range'], 50),
            'previous_agency_experience' => (bool) ($params['previous_agency_experience'] ?? false),
            'previous_agency_feedback' => Aakaari_Security::sanitize_string($params['previous_agency_feedback'] ?? '', 500),
            'additional_requirements' => Aakaari_Security::sanitize_string($params['additional_requirements'] ?? '', 1000),
            'how_found_us' => Aakaari_Security::sanitize_text($params['how_found_us'] ?? '', 50),
        ];

        if (!$data['email']) {
            return new WP_Error('invalid_email', 'Please enter a valid email', ['status' => 400]);
        }

        if (strlen($data['description']) < 100) {
            return new WP_Error('description_short', 'Please provide more details (at least 100 characters)', ['status' => 400]);
        }

        // Check spam
        if (Aakaari_Security::is_spam_submission($data)) {
            return new WP_Error('spam_detected', 'Unable to process request', ['status' => 400]);
        }

        // Create or get lead
        $lead_id = Aakaari_Lead_Handler::create_lead([
            'source' => 'ticket',
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'company' => $data['company'],
            'website' => $data['website'],
            'how_found_us' => $data['how_found_us']
        ]);

        // Create ticket
        $ticket = Aakaari_Ticket_Handler::create_ticket(array_merge($data, [
            'lead_id' => $lead_id
        ]));

        // Send auto-response email
        Aakaari_Email_Handler::send_ticket_confirmation($ticket['id']);

        // Notify admin
        Aakaari_Email_Handler::notify_admin_new_ticket($ticket['id']);

        return rest_ensure_response([
            'success' => true,
            'ticket_number' => $ticket['ticket_number'],
            'ticket_id' => $ticket['id'],
            'message' => 'Thank you! We\'ll send you a proposal within 24 hours.'
        ]);
    }

    /**
     * Get ticket details (for customer portal)
     */
    public static function get_ticket(WP_REST_Request $request) {
        $ticket_id = $request->get_param('id');
        $token = $request->get_param('token');

        // Verify magic link token
        if ($token) {
            $auth = Aakaari_Security::verify_magic_link($token);
            if (!$auth || $auth['ticket_id'] != $ticket_id) {
                return new WP_Error('access_denied', 'Invalid or expired link', ['status' => 403]);
            }
        } else {
            return new WP_Error('access_denied', 'Authentication required', ['status' => 403]);
        }

        $ticket = Aakaari_Ticket_Handler::get_ticket($ticket_id);

        if (!$ticket) {
            return new WP_Error('not_found', 'Ticket not found', ['status' => 404]);
        }

        return rest_ensure_response($ticket);
    }

    /**
     * Reply to ticket (customer)
     */
    public static function reply_ticket(WP_REST_Request $request) {
        $ticket_id = $request->get_param('id');
        $params = $request->get_json_params();
        $token = $params['token'] ?? '';

        // Verify access
        $auth = Aakaari_Security::verify_magic_link($token);
        if (!$auth || $auth['ticket_id'] != $ticket_id) {
            return new WP_Error('access_denied', 'Invalid or expired link', ['status' => 403]);
        }

        $message = Aakaari_Security::sanitize_string($params['message'] ?? '', 2000);

        if (strlen($message) < 3) {
            return new WP_Error('invalid_message', 'Message too short', ['status' => 400]);
        }

        $response_id = Aakaari_Ticket_Handler::add_response([
            'ticket_id' => $ticket_id,
            'responder_type' => 'customer',
            'response_text' => $message
        ]);

        return rest_ensure_response([
            'success' => true,
            'response_id' => $response_id
        ]);
    }

    /**
     * Track trigger engagement
     */
    public static function trigger_engaged(WP_REST_Request $request) {
        $params = $request->get_json_params();
        $trigger_id = absint($params['trigger_id'] ?? 0);

        if ($trigger_id) {
            Aakaari_Triggers::record_engagement($trigger_id);
        }

        return rest_ensure_response(['success' => true]);
    }

    /**
     * Capture lead from pre-chat form
     */
    public static function capture_lead(WP_REST_Request $request) {
        $params = $request->get_json_params();

        $name = Aakaari_Security::sanitize_text($params['name'] ?? '', 100);
        $email = Aakaari_Security::sanitize_email($params['email'] ?? '');

        if (!$email) {
            return new WP_Error('invalid_email', 'Invalid email', ['status' => 400]);
        }

        $lead_id = Aakaari_Lead_Handler::create_lead([
            'source' => 'chat',
            'name' => $name,
            'email' => $email,
            'company' => Aakaari_Security::sanitize_text($params['company'] ?? '', 100),
            'website' => Aakaari_Security::sanitize_url($params['website'] ?? ''),
            'how_found_us' => Aakaari_Security::sanitize_text($params['how_found_us'] ?? '', 50)
        ]);

        return rest_ensure_response([
            'success' => true,
            'lead_id' => $lead_id
        ]);
    }

    // =====================
    // ADMIN ENDPOINTS
    // =====================

    /**
     * Get all active conversations for admin
     */
    public static function admin_get_conversations(WP_REST_Request $request) {
        $status = $request->get_param('status') ?? 'active';

        $conversations = Aakaari_Chat_Handler::get_admin_conversations($status);

        return rest_ensure_response($conversations);
    }

    /**
     * Get single conversation with messages
     */
    public static function admin_get_conversation(WP_REST_Request $request) {
        $id = $request->get_param('id');

        $conversation = Aakaari_Chat_Handler::get_conversation_full($id);

        if (!$conversation) {
            return new WP_Error('not_found', 'Conversation not found', ['status' => 404]);
        }

        return rest_ensure_response($conversation);
    }

    /**
     * Accept chat
     */
    public static function admin_accept_chat(WP_REST_Request $request) {
        $id = $request->get_param('id');
        $agent_id = get_current_user_id();

        $result = Aakaari_Chat_Handler::accept_conversation($id, $agent_id);

        if (!$result) {
            return new WP_Error('accept_failed', 'Failed to accept chat', ['status' => 400]);
        }

        return rest_ensure_response(['success' => true]);
    }

    /**
     * Send message from admin
     */
    public static function admin_send_message(WP_REST_Request $request) {
        $id = $request->get_param('id');
        $params = $request->get_json_params();
        $message = Aakaari_Security::sanitize_string($params['message'] ?? '', 2000);

        if (!$message) {
            return new WP_Error('empty_message', 'Message cannot be empty', ['status' => 400]);
        }

        $message_id = Aakaari_Chat_Handler::add_message([
            'conversation_id' => $id,
            'sender_type' => 'agent',
            'sender_id' => get_current_user_id(),
            'message_text' => $message,
            'message_type' => 'text'
        ]);

        return rest_ensure_response([
            'success' => true,
            'message_id' => $message_id
        ]);
    }

    /**
     * End chat from admin
     */
    public static function admin_end_chat(WP_REST_Request $request) {
        $id = $request->get_param('id');
        $params = $request->get_json_params();
        $outcome = Aakaari_Security::sanitize_text($params['outcome'] ?? 'closed', 50);

        Aakaari_Chat_Handler::end_conversation($id, 'agent');

        // Update lead status based on outcome
        $conversation = Aakaari_Chat_Handler::get_conversation($id);
        if ($conversation['lead_id']) {
            $lead_status = match ($outcome) {
                'won' => 'won',
                'proposal' => 'proposal_sent',
                'nurture' => 'nurture',
                default => 'contacted'
            };
            Aakaari_Lead_Handler::update_status($conversation['lead_id'], $lead_status);
        }

        // Send transcript
        Aakaari_Email_Handler::send_chat_transcript($id);

        return rest_ensure_response(['success' => true]);
    }

    /**
     * Update internal notes
     */
    public static function admin_update_notes(WP_REST_Request $request) {
        $id = $request->get_param('id');
        $params = $request->get_json_params();
        $notes = Aakaari_Security::sanitize_string($params['notes'] ?? '', 5000);

        Aakaari_Chat_Handler::update_conversation($id, ['internal_notes' => $notes]);

        return rest_ensure_response(['success' => true]);
    }

    /**
     * Update conversation tags
     */
    public static function admin_update_tags(WP_REST_Request $request) {
        $id = $request->get_param('id');
        $params = $request->get_json_params();
        $tags = array_map([Aakaari_Security::class, 'sanitize_text'], $params['tags'] ?? []);

        Aakaari_Chat_Handler::update_conversation($id, ['tags' => json_encode($tags)]);

        return rest_ensure_response(['success' => true]);
    }

    /**
     * Convert chat to ticket
     */
    public static function admin_convert_to_ticket(WP_REST_Request $request) {
        $id = $request->get_param('id');
        $params = $request->get_json_params();

        $ticket = Aakaari_Ticket_Handler::create_from_conversation($id, $params);

        return rest_ensure_response([
            'success' => true,
            'ticket_id' => $ticket['id'],
            'ticket_number' => $ticket['ticket_number']
        ]);
    }

    /**
     * Admin long-poll for updates
     */
    public static function admin_poll(WP_REST_Request $request) {
        $agent_id = get_current_user_id();
        $last_check = $request->get_param('since') ?? date('Y-m-d H:i:s', strtotime('-30 seconds'));

        // Update agent heartbeat
        Aakaari_Chat_Handler::update_agent_heartbeat($agent_id);

        // Long poll for 20 seconds
        $timeout = 20;
        $start = time();
        $updates = [];

        while (time() - $start < $timeout) {
            $updates = Aakaari_Chat_Handler::get_updates_since($agent_id, $last_check);

            if (!empty($updates['new_chats']) || !empty($updates['new_messages'])) {
                break;
            }

            sleep(1);
        }

        return rest_ensure_response($updates);
    }

    /**
     * Set agent status
     */
    public static function admin_set_status(WP_REST_Request $request) {
        $params = $request->get_json_params();
        $status = Aakaari_Security::sanitize_text($params['status'] ?? '', 20);

        if (!in_array($status, ['available', 'busy', 'away', 'offline'])) {
            return new WP_Error('invalid_status', 'Invalid status', ['status' => 400]);
        }

        Aakaari_Chat_Handler::set_agent_status(get_current_user_id(), $status);

        return rest_ensure_response(['success' => true]);
    }

    /**
     * Get canned responses
     */
    public static function admin_get_canned(WP_REST_Request $request) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_canned_responses';

        $responses = $wpdb->get_results("SELECT * FROM $table ORDER BY category, title", ARRAY_A);

        return rest_ensure_response($responses);
    }

    /**
     * Get tickets list
     */
    public static function admin_get_tickets(WP_REST_Request $request) {
        $status = $request->get_param('status');
        $page = absint($request->get_param('page') ?? 1);
        $per_page = absint($request->get_param('per_page') ?? 20);

        $tickets = Aakaari_Ticket_Handler::get_tickets([
            'status' => $status,
            'page' => $page,
            'per_page' => $per_page
        ]);

        return rest_ensure_response($tickets);
    }

    /**
     * Get/Update single ticket
     */
    public static function admin_ticket(WP_REST_Request $request) {
        $id = $request->get_param('id');

        if ($request->get_method() === 'GET') {
            $ticket = Aakaari_Ticket_Handler::get_ticket_full($id);
            return rest_ensure_response($ticket);
        }

        // PUT - Update ticket
        $params = $request->get_json_params();
        $update_data = [];

        $allowed_fields = ['status', 'priority', 'assigned_to', 'internal_notes'];
        foreach ($allowed_fields as $field) {
            if (isset($params[$field])) {
                $update_data[$field] = Aakaari_Security::sanitize_text($params[$field], 500);
            }
        }

        Aakaari_Ticket_Handler::update_ticket($id, $update_data);

        return rest_ensure_response(['success' => true]);
    }

    /**
     * Get leads list
     */
    public static function admin_get_leads(WP_REST_Request $request) {
        $status = $request->get_param('status');
        $page = absint($request->get_param('page') ?? 1);

        $leads = Aakaari_Lead_Handler::get_leads([
            'status' => $status,
            'page' => $page
        ]);

        return rest_ensure_response($leads);
    }

    /**
     * Get dashboard stats
     */
    public static function admin_get_stats(WP_REST_Request $request) {
        $stats = Aakaari_Lead_Handler::get_dashboard_stats();

        return rest_ensure_response($stats);
    }
}
