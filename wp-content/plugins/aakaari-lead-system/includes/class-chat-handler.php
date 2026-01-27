<?php
/**
 * Chat Handler
 *
 * Manages chat conversations, messages, and real-time communication
 *
 * @package Aakaari_Lead_System
 */

if (!defined('ABSPATH')) {
    exit;
}

class Aakaari_Chat_Handler {

    private static $typing_transient_prefix = 'aakaari_typing_';

    public static function init() {
        // Register AJAX handlers for legacy support
        add_action('wp_ajax_aakaari_heartbeat', [__CLASS__, 'ajax_heartbeat']);
        add_action('wp_ajax_nopriv_aakaari_heartbeat', [__CLASS__, 'ajax_heartbeat']);
    }

    /**
     * Track visitor
     */
    public static function track_visitor($data) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_visitors';

        $session_id = $data['session_id'];

        // Check if visitor exists
        $existing = $wpdb->get_row($wpdb->prepare(
            "SELECT id, total_visits FROM $table WHERE session_id = %s",
            $session_id
        ));

        if ($existing) {
            $wpdb->update(
                $table,
                [
                    'last_visit_at' => current_time('mysql'),
                    'total_visits' => $existing->total_visits + 1,
                    'current_page' => $data['current_page'] ?? null,
                    'is_returning' => 1
                ],
                ['id' => $existing->id]
            );
            return $existing->id;
        }

        // Create new visitor
        $wpdb->insert($table, [
            'session_id' => $session_id,
            'first_visit_at' => current_time('mysql'),
            'last_visit_at' => current_time('mysql'),
            'current_page' => $data['current_page'] ?? null,
            'referral_source' => $data['referral_source'] ?? null,
            'device_type' => $data['device_type'] ?? null,
            'browser' => $data['browser'] ?? null,
            'ip_address' => $data['ip_address'] ?? null,
            'user_agent' => $data['user_agent'] ?? null,
            'is_returning' => 0,
            'created_at' => current_time('mysql')
        ]);

        return $wpdb->insert_id;
    }

    /**
     * Create or update visitor with lead info
     */
    public static function create_or_update_visitor($data) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_visitors';

        $session_id = Aakaari_Security::get_session_id();
        $ua_info = Aakaari_Security::get_user_agent_info();

        // Check if visitor exists by session
        $existing = $wpdb->get_row($wpdb->prepare(
            "SELECT id FROM $table WHERE session_id = %s",
            $session_id
        ));

        $visitor_data = [
            'name' => $data['name'],
            'email' => $data['email'],
            'website' => $data['website'] ?? null,
            'company' => $data['company'] ?? null,
            'how_found_us' => $data['how_found_us'] ?? null,
            'current_page' => $data['current_page'] ?? null,
            'last_visit_at' => current_time('mysql'),
            'device_type' => $ua_info['device_type'],
            'browser' => $ua_info['browser'],
            'ip_address' => Aakaari_Security::get_client_ip(),
            'user_agent' => $ua_info['user_agent']
        ];

        if ($existing) {
            $wpdb->update($table, $visitor_data, ['id' => $existing->id]);
            return $existing->id;
        }

        $visitor_data['session_id'] = $session_id;
        $visitor_data['first_visit_at'] = current_time('mysql');
        $visitor_data['created_at'] = current_time('mysql');

        $wpdb->insert($table, $visitor_data);
        return $wpdb->insert_id;
    }

    /**
     * Check if returning visitor
     */
    public static function is_returning_visitor($session_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_visitors';

        $visits = $wpdb->get_var($wpdb->prepare(
            "SELECT total_visits FROM $table WHERE session_id = %s",
            $session_id
        ));

        return $visits > 1;
    }

    /**
     * Create conversation
     */
    public static function create_conversation($data) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_conversations';

        $wpdb->insert($table, [
            'visitor_id' => $data['visitor_id'],
            'lead_id' => $data['lead_id'] ?? null,
            'status' => 'waiting',
            'channel' => 'chat',
            'started_at' => current_time('mysql'),
            'lead_captured' => 1,
            'trigger_source' => $data['trigger_source'] ?? null,
            'page_url' => $data['page_url'] ?? null,
            'created_at' => current_time('mysql')
        ]);

        $conversation_id = $wpdb->insert_id;

        // Notify agents
        self::notify_agents_new_chat($conversation_id);

        return $conversation_id;
    }

    /**
     * Add message to conversation
     */
    public static function add_message($data) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_messages';

        $wpdb->insert($table, [
            'conversation_id' => $data['conversation_id'],
            'sender_type' => $data['sender_type'],
            'sender_id' => $data['sender_id'] ?? null,
            'message_text' => $data['message_text'],
            'message_type' => $data['message_type'] ?? 'text',
            'file_url' => $data['file_url'] ?? null,
            'file_name' => $data['file_name'] ?? null,
            'file_size' => $data['file_size'] ?? null,
            'created_at' => current_time('mysql')
        ]);

        $message_id = $wpdb->insert_id;

        // Update conversation message count
        $conv_table = $wpdb->prefix . 'aakaari_conversations';
        $wpdb->query($wpdb->prepare(
            "UPDATE $conv_table SET message_count = message_count + 1, updated_at = NOW() WHERE id = %d",
            $data['conversation_id']
        ));

        if ($data['sender_type'] === 'visitor') {
            do_action('aakaari_new_chat_message', $data['conversation_id'], $message_id);
        }

        return $message_id;
    }

    /**
     * Get messages since a specific ID
     */
    public static function get_messages_since($conversation_id, $since_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_messages';

        $messages = $wpdb->get_results($wpdb->prepare(
            "SELECT m.*,
                    CASE
                        WHEN m.sender_type = 'agent' THEN u.display_name
                        ELSE NULL
                    END as sender_name
             FROM $table m
             LEFT JOIN {$wpdb->users} u ON m.sender_id = u.ID AND m.sender_type = 'agent'
             WHERE m.conversation_id = %d AND m.id > %d
             ORDER BY m.created_at ASC",
            $conversation_id,
            $since_id
        ), ARRAY_A);

        // Mark as read
        if (!empty($messages)) {
            $message_ids = array_column($messages, 'id');
            $ids_string = implode(',', array_map('intval', $message_ids));
            $wpdb->query("UPDATE $table SET is_read = 1, read_at = NOW() WHERE id IN ($ids_string) AND sender_type = 'agent'");
        }

        return $messages;
    }

    /**
     * Get conversation details
     */
    public static function get_conversation($id) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_conversations';

        $conversation = $wpdb->get_row($wpdb->prepare(
            "SELECT c.*,
                    v.name as visitor_name, v.email as visitor_email,
                    u.display_name as agent_name
             FROM $table c
             LEFT JOIN {$wpdb->prefix}aakaari_visitors v ON c.visitor_id = v.id
             LEFT JOIN {$wpdb->users} u ON c.agent_id = u.ID
             WHERE c.id = %d",
            $id
        ), ARRAY_A);

        return $conversation;
    }

    /**
     * Get full conversation with messages
     */
    public static function get_conversation_full($id) {
        $conversation = self::get_conversation($id);

        if (!$conversation) {
            return null;
        }

        global $wpdb;
        $msg_table = $wpdb->prefix . 'aakaari_messages';

        $messages = $wpdb->get_results($wpdb->prepare(
            "SELECT m.*,
                    CASE
                        WHEN m.sender_type = 'agent' THEN u.display_name
                        ELSE NULL
                    END as sender_name
             FROM $msg_table m
             LEFT JOIN {$wpdb->users} u ON m.sender_id = u.ID AND m.sender_type = 'agent'
             WHERE m.conversation_id = %d
             ORDER BY m.created_at ASC",
            $id
        ), ARRAY_A);

        $conversation['messages'] = $messages;

        // Get visitor info
        $visitor_table = $wpdb->prefix . 'aakaari_visitors';
        $visitor = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $visitor_table WHERE id = %d",
            $conversation['visitor_id']
        ), ARRAY_A);

        $conversation['visitor'] = $visitor;

        // Get lead info
        if ($conversation['lead_id']) {
            $lead_table = $wpdb->prefix . 'aakaari_leads';
            $lead = $wpdb->get_row($wpdb->prepare(
                "SELECT * FROM $lead_table WHERE id = %d",
                $conversation['lead_id']
            ), ARRAY_A);
            $conversation['lead'] = $lead;
        }

        return $conversation;
    }

    /**
     * Verify conversation access for visitor
     */
    public static function verify_conversation_access($conversation_id, $session_id) {
        global $wpdb;

        $result = $wpdb->get_var($wpdb->prepare(
            "SELECT c.id
             FROM {$wpdb->prefix}aakaari_conversations c
             JOIN {$wpdb->prefix}aakaari_visitors v ON c.visitor_id = v.id
             WHERE c.id = %d AND v.session_id = %s",
            $conversation_id,
            $session_id
        ));

        return (bool) $result;
    }

    /**
     * Get queue info
     */
    public static function get_queue_info($conversation_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_conversations';
        $agent_table = $wpdb->prefix . 'aakaari_agent_status';

        // Count waiting conversations before this one
        $position = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $table WHERE status = 'waiting' AND id < %d",
            $conversation_id
        )) + 1;

        // Count available agents
        $agents = $wpdb->get_var(
            "SELECT COUNT(*) FROM $agent_table WHERE status = 'available' AND last_seen > DATE_SUB(NOW(), INTERVAL 5 MINUTE)"
        );

        // Estimate wait time (2 minutes per position if agents available, 5 if not)
        $wait_per_position = $agents > 0 ? 2 : 5;
        $estimated_wait = $position * $wait_per_position;

        return [
            'position' => $position,
            'estimated_wait' => $estimated_wait,
            'agents_available' => (int) $agents
        ];
    }

    /**
     * Accept conversation by agent
     */
    public static function accept_conversation($id, $agent_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_conversations';

        // Check if already accepted
        $current = $wpdb->get_row($wpdb->prepare(
            "SELECT status, started_at, agent_id FROM $table WHERE id = %d",
            $id
        ));

        if (!$current) {
            return false;
        }

        if ($current->status === 'active' && (int) $current->agent_id === (int) $agent_id) {
            return true;
        }

        if ($current->status !== 'waiting') {
            return false;
        }

        // Calculate wait time
        $wait_time = strtotime(current_time('mysql')) - strtotime($current->started_at);

        $result = $wpdb->update(
            $table,
            [
                'agent_id' => $agent_id,
                'status' => 'active',
                'accepted_at' => current_time('mysql'),
                'wait_time' => $wait_time,
                'updated_at' => current_time('mysql')
            ],
            [
                'id' => $id,
                'status' => 'waiting'
            ]
        );

        if ($result) {
            // Add system message
            self::add_message([
                'conversation_id' => $id,
                'sender_type' => 'system',
                'message_text' => 'An agent has joined the chat.',
                'message_type' => 'system_notification'
            ]);

            // Update agent chat count
            self::increment_agent_chats($agent_id);
        } elseif ($result === 0) {
            $updated = $wpdb->get_row($wpdb->prepare(
                "SELECT status, agent_id FROM $table WHERE id = %d",
                $id
            ));

            if ($updated && $updated->status === 'active' && (int) $updated->agent_id === (int) $agent_id) {
                return true;
            }
        }

        return (bool) $result;
    }

    /**
     * Reject waiting conversation
     */
    public static function reject_conversation($id, $agent_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_conversations';

        $current = $wpdb->get_row($wpdb->prepare(
            "SELECT status FROM $table WHERE id = %d",
            $id
        ));

        if (!$current || $current->status !== 'waiting') {
            return false;
        }

        $result = $wpdb->update(
            $table,
            [
                'agent_id' => $agent_id,
                'status' => 'abandoned',
                'ended_at' => current_time('mysql'),
                'ended_by' => 'agent',
                'updated_at' => current_time('mysql')
            ],
            ['id' => $id]
        );

        if ($result) {
            self::add_message([
                'conversation_id' => $id,
                'sender_type' => 'system',
                'message_text' => 'Chat request was declined by an agent.',
                'message_type' => 'system_notification'
            ]);
        }

        return (bool) $result;
    }
    /**
     * End conversation
     */
    public static function end_conversation($id, $ended_by, $rating = null) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_conversations';

        $conversation = $wpdb->get_row($wpdb->prepare(
            "SELECT started_at, agent_id FROM $table WHERE id = %d",
            $id
        ));

        $duration = strtotime(current_time('mysql')) - strtotime($conversation->started_at);

        $wpdb->update(
            $table,
            [
                'status' => 'ended',
                'ended_at' => current_time('mysql'),
                'ended_by' => $ended_by,
                'duration' => $duration,
                'satisfaction_rating' => $rating,
                'updated_at' => current_time('mysql')
            ],
            ['id' => $id]
        );

        // Add system message
        self::add_message([
            'conversation_id' => $id,
            'sender_type' => 'system',
            'message_text' => 'Chat has ended. Thank you for contacting us!',
            'message_type' => 'system_notification'
        ]);

        // Decrement agent chat count
        if ($conversation->agent_id) {
            self::decrement_agent_chats($conversation->agent_id);
        }
    }

    /**
     * Update conversation
     */
    public static function update_conversation($id, $data) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_conversations';

        $data['updated_at'] = current_time('mysql');

        return $wpdb->update($table, $data, ['id' => $id]);
    }

    /**
     * Set typing indicator
     */
    public static function set_typing($conversation_id, $sender_type, $is_typing) {
        $key = self::$typing_transient_prefix . $conversation_id . '_' . $sender_type;

        if ($is_typing) {
            set_transient($key, true, 10); // Expires in 10 seconds
        } else {
            delete_transient($key);
        }
    }

    /**
     * Get typing status
     */
    public static function get_typing_status($conversation_id, $sender_type) {
        $key = self::$typing_transient_prefix . $conversation_id . '_' . $sender_type;
        return (bool) get_transient($key);
    }

    /**
     * Get admin conversations
     */
    public static function get_admin_conversations($status = 'active') {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_conversations';

        $where = '';
        if ($status === 'waiting') {
            $where = "WHERE c.status = 'waiting'";
        } elseif ($status === 'active') {
            $where = "WHERE c.status IN ('waiting', 'active')";
        } elseif ($status === 'ended') {
            $where = "WHERE c.status = 'ended'";
        }

        $conversations = $wpdb->get_results(
            "SELECT c.*,
                    v.name as visitor_name, v.email as visitor_email,
                    v.current_page, v.device_type, v.location_city, v.location_country,
                    u.display_name as agent_name,
                    l.lead_score,
                    (SELECT COUNT(*) FROM {$wpdb->prefix}aakaari_messages WHERE conversation_id = c.id AND is_read = 0 AND sender_type = 'visitor') as unread_count
             FROM $table c
             LEFT JOIN {$wpdb->prefix}aakaari_visitors v ON c.visitor_id = v.id
             LEFT JOIN {$wpdb->users} u ON c.agent_id = u.ID
             LEFT JOIN {$wpdb->prefix}aakaari_leads l ON c.lead_id = l.id
             $where
             ORDER BY
                CASE c.status
                    WHEN 'waiting' THEN 1
                    WHEN 'active' THEN 2
                    ELSE 3
                END,
                c.started_at DESC",
            ARRAY_A
        );

        return $conversations;
    }

    /**
     * Get updates since timestamp for admin
     */
    public static function get_updates_since($agent_id, $since) {
        global $wpdb;

        // New waiting chats
        $new_chats = $wpdb->get_results($wpdb->prepare(
            "SELECT c.*, v.name as visitor_name, v.email as visitor_email
             FROM {$wpdb->prefix}aakaari_conversations c
             JOIN {$wpdb->prefix}aakaari_visitors v ON c.visitor_id = v.id
             WHERE c.status = 'waiting' AND c.created_at > %s
             ORDER BY c.created_at ASC",
            $since
        ), ARRAY_A);

        // New messages in agent's active chats
        $new_messages = $wpdb->get_results($wpdb->prepare(
            "SELECT m.*, c.id as conversation_id
             FROM {$wpdb->prefix}aakaari_messages m
             JOIN {$wpdb->prefix}aakaari_conversations c ON m.conversation_id = c.id
             WHERE c.agent_id = %d AND m.sender_type = 'visitor' AND m.created_at > %s
             ORDER BY m.created_at ASC",
            $agent_id,
            $since
        ), ARRAY_A);

        return [
            'new_chats' => $new_chats,
            'new_messages' => $new_messages,
            'timestamp' => current_time('mysql')
        ];
    }

    /**
     * Set agent status
     */
    public static function set_agent_status($user_id, $status) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_agent_status';

        $existing = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM $table WHERE user_id = %d",
            $user_id
        ));

        if ($existing) {
            $wpdb->update(
                $table,
                [
                    'status' => $status,
                    'last_seen' => current_time('mysql'),
                    'updated_at' => current_time('mysql')
                ],
                ['user_id' => $user_id]
            );
        } else {
            $wpdb->insert($table, [
                'user_id' => $user_id,
                'status' => $status,
                'last_seen' => current_time('mysql'),
                'created_at' => current_time('mysql')
            ]);
        }
    }

    /**
     * Update agent heartbeat
     */
    public static function update_agent_heartbeat($user_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_agent_status';

        $wpdb->query($wpdb->prepare(
            "UPDATE $table SET last_seen = NOW() WHERE user_id = %d",
            $user_id
        ));
    }

    /**
     * Increment agent chat count
     */
    private static function increment_agent_chats($user_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_agent_status';

        $wpdb->query($wpdb->prepare(
            "UPDATE $table SET current_chats = current_chats + 1 WHERE user_id = %d",
            $user_id
        ));
    }

    /**
     * Decrement agent chat count
     */
    private static function decrement_agent_chats($user_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_agent_status';

        $wpdb->query($wpdb->prepare(
            "UPDATE $table SET current_chats = GREATEST(current_chats - 1, 0) WHERE user_id = %d",
            $user_id
        ));
    }

    /**
     * Notify agents of new chat
     */
    private static function notify_agents_new_chat($conversation_id) {
        // This could trigger browser notifications, email, etc.
        // For now, agents poll for new chats
        do_action('aakaari_new_chat', $conversation_id);
    }

    /**
     * AJAX heartbeat handler
     */
    public static function ajax_heartbeat() {
        check_ajax_referer('aakaari_chat_nonce', 'nonce');

        $conversation_id = absint($_POST['conversation_id'] ?? 0);

        if (!$conversation_id) {
            wp_send_json_error('Invalid conversation');
        }

        // Verify access
        $session_id = Aakaari_Security::get_session_id();
        if (!self::verify_conversation_access($conversation_id, $session_id)) {
            wp_send_json_error('Access denied');
        }

        $last_id = absint($_POST['last_id'] ?? 0);
        $messages = self::get_messages_since($conversation_id, $last_id);
        $conversation = self::get_conversation($conversation_id);
        $typing = self::get_typing_status($conversation_id, 'agent');

        wp_send_json_success([
            'messages' => $messages,
            'status' => $conversation['status'],
            'agent_typing' => $typing,
            'agent_name' => $conversation['agent_name']
        ]);
    }
}
