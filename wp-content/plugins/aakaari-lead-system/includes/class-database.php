<?php
/**
 * Database Schema and Management
 *
 * @package Aakaari_Lead_System
 */

if (!defined('ABSPATH')) {
    exit;
}

class Aakaari_Database {

    /**
     * Create all required database tables
     */
    public static function create_tables() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        // Visitors table
        $table_visitors = $wpdb->prefix . 'aakaari_visitors';
        $sql_visitors = "CREATE TABLE $table_visitors (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            session_id varchar(64) NOT NULL,
            name varchar(100) DEFAULT NULL,
            email varchar(100) DEFAULT NULL,
            phone varchar(30) DEFAULT NULL,
            company varchar(100) DEFAULT NULL,
            website varchar(255) DEFAULT NULL,
            how_found_us varchar(50) DEFAULT NULL,
            first_visit_at datetime NOT NULL,
            last_visit_at datetime NOT NULL,
            total_visits int(11) DEFAULT 1,
            current_page varchar(500) DEFAULT NULL,
            referral_source varchar(255) DEFAULT NULL,
            device_type varchar(20) DEFAULT NULL,
            browser varchar(50) DEFAULT NULL,
            location_country varchar(100) DEFAULT NULL,
            location_city varchar(100) DEFAULT NULL,
            ip_address varchar(45) DEFAULT NULL,
            user_agent text DEFAULT NULL,
            is_returning tinyint(1) DEFAULT 0,
            is_blocked tinyint(1) DEFAULT 0,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY session_id (session_id),
            KEY email (email),
            KEY ip_address (ip_address),
            KEY last_visit_at (last_visit_at)
        ) $charset_collate;";
        dbDelta($sql_visitors);

        // Leads table
        $table_leads = $wpdb->prefix . 'aakaari_leads';
        $sql_leads = "CREATE TABLE $table_leads (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            visitor_id bigint(20) UNSIGNED DEFAULT NULL,
            source enum('chat','ticket','manual','import') NOT NULL DEFAULT 'chat',
            name varchar(100) NOT NULL,
            email varchar(100) NOT NULL,
            phone varchar(30) DEFAULT NULL,
            company varchar(100) DEFAULT NULL,
            website varchar(255) DEFAULT NULL,
            status enum('new','contacted','qualified','proposal_sent','negotiation','won','lost','nurture') DEFAULT 'new',
            lead_score int(3) DEFAULT 0,
            lifetime_value decimal(12,2) DEFAULT 0.00,
            first_contact_at datetime DEFAULT NULL,
            last_contact_at datetime DEFAULT NULL,
            how_found_us varchar(50) DEFAULT NULL,
            tags json DEFAULT NULL,
            notes text DEFAULT NULL,
            assigned_to bigint(20) UNSIGNED DEFAULT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY email (email),
            KEY visitor_id (visitor_id),
            KEY status (status),
            KEY lead_score (lead_score),
            KEY assigned_to (assigned_to)
        ) $charset_collate;";
        dbDelta($sql_leads);

        // Chat conversations table
        $table_conversations = $wpdb->prefix . 'aakaari_conversations';
        $sql_conversations = "CREATE TABLE $table_conversations (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            visitor_id bigint(20) UNSIGNED NOT NULL,
            agent_id bigint(20) UNSIGNED DEFAULT NULL,
            lead_id bigint(20) UNSIGNED DEFAULT NULL,
            status enum('waiting','active','ended','transferred','abandoned') DEFAULT 'waiting',
            channel enum('chat','ticket') DEFAULT 'chat',
            started_at datetime DEFAULT CURRENT_TIMESTAMP,
            accepted_at datetime DEFAULT NULL,
            ended_at datetime DEFAULT NULL,
            ended_by enum('visitor','agent','system') DEFAULT NULL,
            lead_captured tinyint(1) DEFAULT 0,
            lead_score int(3) DEFAULT 0,
            satisfaction_rating int(1) DEFAULT NULL,
            tags json DEFAULT NULL,
            internal_notes text DEFAULT NULL,
            trigger_source varchar(50) DEFAULT NULL,
            page_url varchar(500) DEFAULT NULL,
            wait_time int(11) DEFAULT NULL,
            duration int(11) DEFAULT NULL,
            message_count int(11) DEFAULT 0,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY visitor_id (visitor_id),
            KEY agent_id (agent_id),
            KEY lead_id (lead_id),
            KEY status (status),
            KEY started_at (started_at)
        ) $charset_collate;";
        dbDelta($sql_conversations);

        // Chat messages table
        $table_messages = $wpdb->prefix . 'aakaari_messages';
        $sql_messages = "CREATE TABLE $table_messages (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            conversation_id bigint(20) UNSIGNED NOT NULL,
            sender_type enum('visitor','agent','system','bot') NOT NULL,
            sender_id bigint(20) UNSIGNED DEFAULT NULL,
            message_text text NOT NULL,
            message_type enum('text','image','file','system_notification','bot_question') DEFAULT 'text',
            file_url varchar(500) DEFAULT NULL,
            file_name varchar(255) DEFAULT NULL,
            file_size int(11) DEFAULT NULL,
            is_read tinyint(1) DEFAULT 0,
            read_at datetime DEFAULT NULL,
            metadata json DEFAULT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY conversation_id (conversation_id),
            KEY sender_type (sender_type),
            KEY created_at (created_at),
            KEY is_read (is_read)
        ) $charset_collate;";
        dbDelta($sql_messages);

        // Tickets table
        $table_tickets = $wpdb->prefix . 'aakaari_tickets';
        $sql_tickets = "CREATE TABLE $table_tickets (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            ticket_number varchar(20) NOT NULL,
            lead_id bigint(20) UNSIGNED DEFAULT NULL,
            conversation_id bigint(20) UNSIGNED DEFAULT NULL,
            project_type varchar(50) NOT NULL,
            title varchar(200) NOT NULL,
            description text NOT NULL,
            problem_statement text DEFAULT NULL,
            status enum('new','under_review','proposal_preparing','proposal_sent','awaiting_response','negotiation','accepted','on_hold','closed_won','closed_lost','spam') DEFAULT 'new',
            priority enum('low','medium','high','urgent') DEFAULT 'medium',
            lead_score int(3) DEFAULT 0,
            budget_range varchar(50) DEFAULT NULL,
            budget_amount decimal(12,2) DEFAULT NULL,
            budget_currency varchar(3) DEFAULT 'INR',
            timeline varchar(50) DEFAULT NULL,
            timeline_date date DEFAULT NULL,
            has_mockups tinyint(1) DEFAULT 0,
            previous_agency_experience tinyint(1) DEFAULT 0,
            previous_agency_feedback text DEFAULT NULL,
            additional_requirements text DEFAULT NULL,
            assigned_to bigint(20) UNSIGNED DEFAULT NULL,
            created_from enum('form','chat','email','manual') DEFAULT 'form',
            files json DEFAULT NULL,
            proposal_sent_at datetime DEFAULT NULL,
            proposal_amount decimal(12,2) DEFAULT NULL,
            proposal_currency varchar(3) DEFAULT 'INR',
            proposal_file varchar(500) DEFAULT NULL,
            won_at datetime DEFAULT NULL,
            lost_at datetime DEFAULT NULL,
            lost_reason text DEFAULT NULL,
            sla_deadline datetime DEFAULT NULL,
            first_response_at datetime DEFAULT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY ticket_number (ticket_number),
            KEY lead_id (lead_id),
            KEY status (status),
            KEY priority (priority),
            KEY assigned_to (assigned_to),
            KEY created_at (created_at)
        ) $charset_collate;";
        dbDelta($sql_tickets);

        // Ticket responses table
        $table_ticket_responses = $wpdb->prefix . 'aakaari_ticket_responses';
        $sql_ticket_responses = "CREATE TABLE $table_ticket_responses (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            ticket_id bigint(20) UNSIGNED NOT NULL,
            responder_type enum('customer','agent','system') NOT NULL,
            responder_id bigint(20) UNSIGNED DEFAULT NULL,
            response_text text NOT NULL,
            is_internal_note tinyint(1) DEFAULT 0,
            files json DEFAULT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY ticket_id (ticket_id),
            KEY created_at (created_at)
        ) $charset_collate;";
        dbDelta($sql_ticket_responses);

        // Agent status table
        $table_agent_status = $wpdb->prefix . 'aakaari_agent_status';
        $sql_agent_status = "CREATE TABLE $table_agent_status (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            user_id bigint(20) UNSIGNED NOT NULL,
            status enum('available','busy','away','offline') DEFAULT 'offline',
            current_chats int(3) DEFAULT 0,
            max_chats int(3) DEFAULT 5,
            last_seen datetime DEFAULT CURRENT_TIMESTAMP,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY user_id (user_id),
            KEY status (status),
            KEY last_seen (last_seen)
        ) $charset_collate;";
        dbDelta($sql_agent_status);

        // Proactive triggers table
        $table_triggers = $wpdb->prefix . 'aakaari_triggers';
        $sql_triggers = "CREATE TABLE $table_triggers (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            trigger_name varchar(100) NOT NULL,
            trigger_type enum('time','scroll','exit_intent','page_specific','action_based','return_visitor') NOT NULL,
            conditions json NOT NULL,
            message text NOT NULL,
            is_active tinyint(1) DEFAULT 1,
            priority int(3) DEFAULT 10,
            times_triggered int(11) DEFAULT 0,
            times_engaged int(11) DEFAULT 0,
            ab_variant varchar(1) DEFAULT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY is_active (is_active),
            KEY trigger_type (trigger_type)
        ) $charset_collate;";
        dbDelta($sql_triggers);

        // Canned responses table
        $table_canned = $wpdb->prefix . 'aakaari_canned_responses';
        $sql_canned = "CREATE TABLE $table_canned (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            title varchar(100) NOT NULL,
            shortcut varchar(20) DEFAULT NULL,
            message_text text NOT NULL,
            category varchar(50) DEFAULT NULL,
            usage_count int(11) DEFAULT 0,
            created_by bigint(20) UNSIGNED DEFAULT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY shortcut (shortcut),
            KEY category (category)
        ) $charset_collate;";
        dbDelta($sql_canned);

        // Email sequences table
        $table_sequences = $wpdb->prefix . 'aakaari_email_sequences';
        $sql_sequences = "CREATE TABLE $table_sequences (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            sequence_name varchar(100) NOT NULL,
            trigger_condition varchar(50) NOT NULL,
            is_active tinyint(1) DEFAULT 1,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY trigger_condition (trigger_condition)
        ) $charset_collate;";
        dbDelta($sql_sequences);

        // Email sequence steps table
        $table_sequence_steps = $wpdb->prefix . 'aakaari_sequence_steps';
        $sql_sequence_steps = "CREATE TABLE $table_sequence_steps (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            sequence_id bigint(20) UNSIGNED NOT NULL,
            step_number int(3) NOT NULL,
            delay_days int(3) NOT NULL DEFAULT 0,
            delay_hours int(3) NOT NULL DEFAULT 0,
            subject varchar(200) NOT NULL,
            body text NOT NULL,
            is_active tinyint(1) DEFAULT 1,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY sequence_id (sequence_id),
            KEY step_number (step_number)
        ) $charset_collate;";
        dbDelta($sql_sequence_steps);

        // Sent emails tracking table
        $table_sent_emails = $wpdb->prefix . 'aakaari_sent_emails';
        $sql_sent_emails = "CREATE TABLE $table_sent_emails (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            lead_id bigint(20) UNSIGNED DEFAULT NULL,
            ticket_id bigint(20) UNSIGNED DEFAULT NULL,
            sequence_step_id bigint(20) UNSIGNED DEFAULT NULL,
            email_type enum('auto_response','follow_up','proposal','nurture','manual','transcript') NOT NULL,
            to_email varchar(100) NOT NULL,
            subject varchar(200) NOT NULL,
            body text NOT NULL,
            tracking_id varchar(64) DEFAULT NULL,
            sent_at datetime DEFAULT CURRENT_TIMESTAMP,
            opened_at datetime DEFAULT NULL,
            clicked_at datetime DEFAULT NULL,
            bounced tinyint(1) DEFAULT 0,
            PRIMARY KEY (id),
            KEY lead_id (lead_id),
            KEY ticket_id (ticket_id),
            KEY tracking_id (tracking_id),
            KEY sent_at (sent_at)
        ) $charset_collate;";
        dbDelta($sql_sent_emails);

        // Rate limiting table
        $table_rate_limits = $wpdb->prefix . 'aakaari_rate_limits';
        $sql_rate_limits = "CREATE TABLE $table_rate_limits (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            identifier varchar(100) NOT NULL,
            action_type varchar(50) NOT NULL,
            count int(11) DEFAULT 1,
            window_start datetime NOT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY identifier_action (identifier, action_type),
            KEY window_start (window_start)
        ) $charset_collate;";
        dbDelta($sql_rate_limits);

        // Audit log table
        $table_audit = $wpdb->prefix . 'aakaari_audit_log';
        $sql_audit = "CREATE TABLE $table_audit (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            user_id bigint(20) UNSIGNED DEFAULT NULL,
            action varchar(50) NOT NULL,
            object_type varchar(50) DEFAULT NULL,
            object_id bigint(20) UNSIGNED DEFAULT NULL,
            old_value text DEFAULT NULL,
            new_value text DEFAULT NULL,
            ip_address varchar(45) DEFAULT NULL,
            user_agent text DEFAULT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY user_id (user_id),
            KEY action (action),
            KEY created_at (created_at)
        ) $charset_collate;";
        dbDelta($sql_audit);

        // Store database version
        update_option('aakaari_leads_db_version', AAKAARI_LEADS_VERSION);
    }

    /**
     * Seed default data
     */
    public static function seed_default_data() {
        global $wpdb;

        // Seed default triggers
        $triggers_table = $wpdb->prefix . 'aakaari_triggers';
        $existing = $wpdb->get_var("SELECT COUNT(*) FROM $triggers_table");

        if ($existing == 0) {
            $default_triggers = [
                [
                    'trigger_name' => 'Homepage Welcome',
                    'trigger_type' => 'time',
                    'conditions' => json_encode(['page' => 'homepage', 'delay' => 20]),
                    'message' => '👋 Welcome! Looking for WordPress help? I\'m here to assist.',
                    'priority' => 10
                ],
                [
                    'trigger_name' => 'Pricing Page Interest',
                    'trigger_type' => 'time',
                    'conditions' => json_encode(['page_contains' => 'pricing', 'delay' => 30]),
                    'message' => 'Questions about our packages? Let\'s chat and find the right fit for you!',
                    'priority' => 20
                ],
                [
                    'trigger_name' => 'Service Page Scroll',
                    'trigger_type' => 'scroll',
                    'conditions' => json_encode(['page_contains' => 'service', 'scroll_percent' => 50]),
                    'message' => 'Interested in this service? I can explain more and answer your questions.',
                    'priority' => 15
                ],
                [
                    'trigger_name' => 'Exit Intent',
                    'trigger_type' => 'exit_intent',
                    'conditions' => json_encode(['all_pages' => true]),
                    'message' => 'Wait! Quick question before you go - is there anything I can help you with?',
                    'priority' => 30
                ],
                [
                    'trigger_name' => 'Return Visitor',
                    'trigger_type' => 'return_visitor',
                    'conditions' => json_encode(['min_visits' => 2, 'delay' => 10]),
                    'message' => 'Welcome back! Ready to start your project? Let\'s discuss.',
                    'priority' => 25
                ],
                [
                    'trigger_name' => 'Multiple Pages Visited',
                    'trigger_type' => 'action_based',
                    'conditions' => json_encode(['pages_visited' => 3, 'delay' => 5]),
                    'message' => 'I notice you\'re exploring our services. What are you working on?',
                    'priority' => 18
                ]
            ];

            foreach ($default_triggers as $trigger) {
                $wpdb->insert($triggers_table, array_merge($trigger, [
                    'is_active' => 1,
                    'created_at' => current_time('mysql')
                ]));
            }
        }

        // Seed default canned responses
        $canned_table = $wpdb->prefix . 'aakaari_canned_responses';
        $existing_canned = $wpdb->get_var("SELECT COUNT(*) FROM $canned_table");

        if ($existing_canned == 0) {
            $default_canned = [
                [
                    'title' => 'Greeting',
                    'shortcut' => '/hi',
                    'message_text' => 'Hello! Thanks for reaching out to AAKAARI Tech Solutions. How can I help you today?',
                    'category' => 'general'
                ],
                [
                    'title' => 'Ask for Details',
                    'shortcut' => '/details',
                    'message_text' => 'Could you please share more details about your project? Specifically:\n- What\'s the main goal?\n- Do you have a timeline in mind?\n- What\'s your approximate budget range?',
                    'category' => 'qualification'
                ],
                [
                    'title' => 'Request Website URL',
                    'shortcut' => '/url',
                    'message_text' => 'Could you share your website URL so I can take a look at what you\'re working with?',
                    'category' => 'qualification'
                ],
                [
                    'title' => 'Pricing Information',
                    'shortcut' => '/pricing',
                    'message_text' => 'Our pricing depends on the project scope. To give you an accurate quote, I\'d need to understand your requirements better. Can you tell me more about what you need?',
                    'category' => 'sales'
                ],
                [
                    'title' => 'Schedule Call',
                    'shortcut' => '/call',
                    'message_text' => 'I\'d be happy to discuss this in more detail. Would you like to schedule a quick call? You can book a time that works for you.',
                    'category' => 'sales'
                ],
                [
                    'title' => 'Timeline Response',
                    'shortcut' => '/timeline',
                    'message_text' => 'Typical project timelines:\n- Bug fixes: 1-3 days\n- Small updates: 3-7 days\n- Full websites: 2-4 weeks\n\nWe can discuss your specific timeline after understanding your needs.',
                    'category' => 'sales'
                ],
                [
                    'title' => 'Closing - Send Proposal',
                    'shortcut' => '/proposal',
                    'message_text' => 'Based on our conversation, I\'ll prepare a detailed proposal with pricing and timeline. You\'ll receive it via email within 24 hours. Is there anything specific you\'d like me to include?',
                    'category' => 'closing'
                ],
                [
                    'title' => 'Away Response',
                    'shortcut' => '/away',
                    'message_text' => 'Thanks for your patience! I\'m currently helping another customer. I\'ll be with you in just a moment.',
                    'category' => 'general'
                ]
            ];

            foreach ($default_canned as $response) {
                $wpdb->insert($canned_table, array_merge($response, [
                    'usage_count' => 0,
                    'created_at' => current_time('mysql')
                ]));
            }
        }

        // Seed default email sequences
        $sequences_table = $wpdb->prefix . 'aakaari_email_sequences';
        $steps_table = $wpdb->prefix . 'aakaari_sequence_steps';
        $existing_sequences = $wpdb->get_var("SELECT COUNT(*) FROM $sequences_table");

        if ($existing_sequences == 0) {
            // New Chat Lead sequence
            $wpdb->insert($sequences_table, [
                'sequence_name' => 'New Chat Lead Follow-up',
                'trigger_condition' => 'new_chat_lead',
                'is_active' => 1,
                'created_at' => current_time('mysql')
            ]);
            $chat_sequence_id = $wpdb->insert_id;

            $chat_steps = [
                ['step' => 1, 'days' => 0, 'hours' => 0, 'subject' => 'Your chat with AAKAARI Tech Solutions', 'body' => self::get_email_template('chat_transcript')],
                ['step' => 2, 'days' => 2, 'hours' => 0, 'subject' => 'How we helped a client like you', 'body' => self::get_email_template('case_study')],
                ['step' => 3, 'days' => 5, 'hours' => 0, 'subject' => 'Quick question about your WordPress needs', 'body' => self::get_email_template('follow_up_1')],
                ['step' => 4, 'days' => 10, 'hours' => 0, 'subject' => 'Limited slots available this month', 'body' => self::get_email_template('urgency')],
            ];

            foreach ($chat_steps as $step) {
                $wpdb->insert($steps_table, [
                    'sequence_id' => $chat_sequence_id,
                    'step_number' => $step['step'],
                    'delay_days' => $step['days'],
                    'delay_hours' => $step['hours'],
                    'subject' => $step['subject'],
                    'body' => $step['body'],
                    'is_active' => 1,
                    'created_at' => current_time('mysql')
                ]);
            }

            // Proposal Sent sequence
            $wpdb->insert($sequences_table, [
                'sequence_name' => 'Proposal Follow-up',
                'trigger_condition' => 'proposal_sent',
                'is_active' => 1,
                'created_at' => current_time('mysql')
            ]);
            $proposal_sequence_id = $wpdb->insert_id;

            $proposal_steps = [
                ['step' => 1, 'days' => 3, 'hours' => 0, 'subject' => 'Did you have a chance to review the proposal?', 'body' => self::get_email_template('proposal_follow_1')],
                ['step' => 2, 'days' => 7, 'hours' => 0, 'subject' => 'Happy to answer any questions', 'body' => self::get_email_template('proposal_follow_2')],
                ['step' => 3, 'days' => 14, 'hours' => 0, 'subject' => 'We can adjust the scope to fit your budget', 'body' => self::get_email_template('proposal_follow_3')],
            ];

            foreach ($proposal_steps as $step) {
                $wpdb->insert($steps_table, [
                    'sequence_id' => $proposal_sequence_id,
                    'step_number' => $step['step'],
                    'delay_days' => $step['days'],
                    'delay_hours' => $step['hours'],
                    'subject' => $step['subject'],
                    'body' => $step['body'],
                    'is_active' => 1,
                    'created_at' => current_time('mysql')
                ]);
            }
        }

        // Set default options
        $defaults = [
            'aakaari_chat_enabled' => true,
            'aakaari_primary_color' => '#2563EB',
            'aakaari_widget_position' => 'bottom-right',
            'aakaari_greeting' => 'Hi! How can we help you today?',
            'aakaari_offline_message' => 'We\'re currently offline. Leave a message and we\'ll get back to you within 4 hours.',
            'aakaari_ticket_prefix' => 'TKT',
            'aakaari_auto_response_delay' => 1,
            'aakaari_sla_response_hours' => 24,
        ];

        foreach ($defaults as $key => $value) {
            if (get_option($key) === false) {
                update_option($key, $value);
            }
        }
    }

    /**
     * Get email template content
     */
    private static function get_email_template($template) {
        $templates = [
            'chat_transcript' => '<p>Hi {{name}},</p>
<p>Thanks for chatting with us! Here\'s a copy of our conversation for your records.</p>
<div style="background: #f5f5f5; padding: 20px; border-radius: 8px; margin: 20px 0;">
{{transcript}}
</div>
<p>If you have any more questions, just reply to this email or start another chat.</p>
<p>Best regards,<br>AAKAARI Tech Solutions Team</p>',

            'case_study' => '<p>Hi {{name}},</p>
<p>We thought you might be interested in seeing how we helped a client with similar needs.</p>
<p><strong>The Challenge:</strong> A WordPress site experiencing slow load times and security vulnerabilities.</p>
<p><strong>Our Solution:</strong> Complete speed optimization and security hardening.</p>
<p><strong>The Result:</strong> 3x faster page loads and zero security incidents since.</p>
<p>Ready to achieve similar results? Reply to this email or book a call with us.</p>
<p>Best regards,<br>AAKAARI Tech Solutions Team</p>',

            'follow_up_1' => '<p>Hi {{name}},</p>
<p>I wanted to follow up on our recent chat. Is there anything holding you back from moving forward?</p>
<p>We\'re here to help answer any questions you might have about:</p>
<ul>
<li>Our process and timeline</li>
<li>Pricing and payment options</li>
<li>Technical requirements</li>
</ul>
<p>Just reply to this email - I\'d love to help.</p>
<p>Best regards,<br>AAKAARI Tech Solutions Team</p>',

            'urgency' => '<p>Hi {{name}},</p>
<p>Quick update: We only have a few project slots available for this month.</p>
<p>If you\'re still thinking about your WordPress project, now might be a good time to get started. We can ensure you get our full attention and quick turnaround.</p>
<p>Reply to this email if you\'d like to discuss your project.</p>
<p>Best regards,<br>AAKAARI Tech Solutions Team</p>',

            'proposal_follow_1' => '<p>Hi {{name}},</p>
<p>I wanted to check in - did you have a chance to review the proposal we sent?</p>
<p>If you have any questions about the pricing, timeline, or scope, I\'m happy to clarify.</p>
<p>Just reply to this email.</p>
<p>Best regards,<br>AAKAARI Tech Solutions Team</p>',

            'proposal_follow_2' => '<p>Hi {{name}},</p>
<p>I know you\'re busy, so I\'ll keep this short.</p>
<p>If you have any questions about our proposal, I\'m happy to jump on a quick 15-minute call to discuss.</p>
<p>No pressure - just want to make sure you have all the information you need to make a decision.</p>
<p>Best regards,<br>AAKAARI Tech Solutions Team</p>',

            'proposal_follow_3' => '<p>Hi {{name}},</p>
<p>I understand that budget and scope are important considerations.</p>
<p>If our initial proposal doesn\'t quite fit your needs, we can definitely work together to find a solution. Perhaps we could:</p>
<ul>
<li>Phase the project into smaller milestones</li>
<li>Adjust the scope to fit your budget</li>
<li>Offer flexible payment terms</li>
</ul>
<p>Let me know what works best for you.</p>
<p>Best regards,<br>AAKAARI Tech Solutions Team</p>',
        ];

        return $templates[$template] ?? '';
    }

    /**
     * Generate unique ticket number
     */
    public static function generate_ticket_number() {
        global $wpdb;
        $prefix = get_option('aakaari_ticket_prefix', 'TKT');
        $year = date('Y');

        $table = $wpdb->prefix . 'aakaari_tickets';
        $last_number = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT ticket_number FROM $table WHERE ticket_number LIKE %s ORDER BY id DESC LIMIT 1",
                $prefix . '-' . $year . '-%'
            )
        );

        if ($last_number) {
            $parts = explode('-', $last_number);
            $sequence = (int) end($parts) + 1;
        } else {
            $sequence = 1;
        }

        return sprintf('%s-%s-%03d', $prefix, $year, $sequence);
    }

    /**
     * Clean up old data (for cron job)
     */
    public static function cleanup_old_data() {
        global $wpdb;

        // Clean rate limits older than 1 day
        $rate_table = $wpdb->prefix . 'aakaari_rate_limits';
        $wpdb->query("DELETE FROM $rate_table WHERE window_start < DATE_SUB(NOW(), INTERVAL 1 DAY)");

        // Clean abandoned conversations older than 30 days
        $conv_table = $wpdb->prefix . 'aakaari_conversations';
        $wpdb->query("UPDATE $conv_table SET status = 'abandoned' WHERE status = 'waiting' AND started_at < DATE_SUB(NOW(), INTERVAL 1 HOUR)");

        // Archive audit logs older than 90 days (optional - keep for compliance)
        // $audit_table = $wpdb->prefix . 'aakaari_audit_log';
        // $wpdb->query("DELETE FROM $audit_table WHERE created_at < DATE_SUB(NOW(), INTERVAL 90 DAY)");
    }
}
