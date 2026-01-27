<?php
/**
 * Email Handler
 *
 * Manages email automation, templates, and sending
 *
 * @package Aakaari_Lead_System
 */

if (!defined('ABSPATH')) {
    exit;
}

class Aakaari_Email_Handler {

    private static $from_name = 'AAKAARI Tech Solutions';
    private static $from_email = null;

    public static function init() {
        self::$from_email = get_option('admin_email');

        // Schedule email sequence processor
        add_action('aakaari_process_email_sequences', [__CLASS__, 'process_sequences']);

        if (!wp_next_scheduled('aakaari_process_email_sequences')) {
            wp_schedule_event(time(), 'hourly', 'aakaari_process_email_sequences');
        }

        // Email tracking pixel
        add_action('init', [__CLASS__, 'handle_tracking_pixel']);

        // Chat notifications
        add_action('aakaari_new_chat', [__CLASS__, 'notify_admin_new_chat']);
        add_action('aakaari_new_chat_message', [__CLASS__, 'notify_admin_new_chat_message'], 10, 2);
    }

    /**
     * Send chat transcript
     */
    public static function send_chat_transcript($conversation_id) {
        $conversation = Aakaari_Chat_Handler::get_conversation_full($conversation_id);

        if (!$conversation || empty($conversation['visitor']['email'])) {
            return false;
        }

        $to = $conversation['visitor']['email'];
        $name = $conversation['visitor']['name'];

        // Build transcript HTML
        $transcript = self::build_transcript_html($conversation['messages'], $name);

        $subject = 'Your chat with AAKAARI Tech Solutions';

        $body = self::get_template('chat_transcript', [
            'name' => $name,
            'transcript' => $transcript
        ]);

        return self::send_email($to, $subject, $body, [
            'lead_id' => $conversation['lead_id'],
            'type' => 'transcript'
        ]);
    }

    /**
     * Notify admin of new chat
     */
    public static function notify_admin_new_chat($conversation_id) {
        $conversation = Aakaari_Chat_Handler::get_conversation_full($conversation_id);

        if (!$conversation) {
            return false;
        }

        $admin_email = get_option('admin_email');
        $visitor = $conversation['visitor'] ?? [];
        $name = $visitor['name'] ?? 'Visitor';
        $email = $visitor['email'] ?? 'No email';

        $subject = sprintf('New chat request from %s', $name);
        $body = sprintf(
            '<p>A new chat request is waiting.</p><p><strong>Name:</strong> %s<br><strong>Email:</strong> %s</p><p><a href="%s">Open Live Chats</a></p>',
            esc_html($name),
            esc_html($email),
            esc_url(admin_url('admin.php?page=aakaari-chats'))
        );

        return self::send_email($admin_email, $subject, $body, [
            'lead_id' => $conversation['lead_id'],
            'type' => 'chat_notification'
        ]);
    }

    /**
     * Notify admin of new visitor message
     */
    public static function notify_admin_new_chat_message($conversation_id, $message_id) {
        $conversation = Aakaari_Chat_Handler::get_conversation_full($conversation_id);

        if (!$conversation) {
            return false;
        }

        $admin_email = get_option('admin_email');
        $visitor = $conversation['visitor'] ?? [];
        $name = $visitor['name'] ?? 'Visitor';
        $latest = $conversation['messages'][count($conversation['messages']) - 1] ?? null;

        if (!$latest || (int) $latest['id'] !== (int) $message_id) {
            return false;
        }

        $subject = sprintf('New chat message from %s', $name);
        $body = sprintf(
            '<p>You received a new chat message.</p><p><strong>From:</strong> %s</p><p>%s</p><p><a href="%s">Open Live Chats</a></p>',
            esc_html($name),
            esc_html($latest['message_text']),
            esc_url(admin_url('admin.php?page=aakaari-chats'))
        );

        return self::send_email($admin_email, $subject, $body, [
            'lead_id' => $conversation['lead_id'],
            'type' => 'chat_message'
        ]);
    }

    /**
     * Build transcript HTML from messages
     */
    private static function build_transcript_html($messages, $visitor_name) {
        $html = '';

        foreach ($messages as $msg) {
            if ($msg['message_type'] === 'system_notification') {
                $html .= "<p style='color: #666; font-style: italic; text-align: center;'>{$msg['message_text']}</p>";
                continue;
            }

            $sender = $msg['sender_type'] === 'visitor' ? $visitor_name : ($msg['sender_name'] ?? 'Support');
            $align = $msg['sender_type'] === 'visitor' ? 'left' : 'right';
            $bg = $msg['sender_type'] === 'visitor' ? '#f5f5f5' : '#e3f2fd';

            $time = date('H:i', strtotime($msg['created_at']));

            $html .= "
                <div style='margin-bottom: 12px; text-align: {$align};'>
                    <div style='display: inline-block; max-width: 80%; padding: 10px 15px; border-radius: 12px; background: {$bg};'>
                        <strong style='font-size: 12px; color: #666;'>{$sender}</strong>
                        <p style='margin: 5px 0 0; color: #333;'>{$msg['message_text']}</p>
                        <span style='font-size: 10px; color: #999;'>{$time}</span>
                    </div>
                </div>
            ";
        }

        return $html;
    }

    /**
     * Send ticket confirmation email
     */
    public static function send_ticket_confirmation($ticket_id) {
        $ticket = Aakaari_Ticket_Handler::get_ticket($ticket_id);

        if (!$ticket) {
            return false;
        }

        $subject = "Ticket #{$ticket['ticket_number']} - We received your project inquiry";

        $body = self::get_template('ticket_confirmation', [
            'name' => $ticket['name'],
            'ticket_number' => $ticket['ticket_number'],
            'project_type' => $ticket['project_type'],
            'title' => $ticket['title'],
            'portal_link' => self::generate_portal_link($ticket_id, $ticket['email'])
        ]);

        return self::send_email($ticket['email'], $subject, $body, [
            'ticket_id' => $ticket_id,
            'lead_id' => $ticket['lead_id'],
            'type' => 'auto_response'
        ]);
    }

    /**
     * Notify admin of new ticket
     */
    public static function notify_admin_new_ticket($ticket_id) {
        $ticket = Aakaari_Ticket_Handler::get_ticket($ticket_id);
        $admin_email = get_option('admin_email');

        $lead_temp = $ticket['lead_score'] >= 80 ? '🔥 HOT' : ($ticket['lead_score'] >= 50 ? '🌡️ WARM' : '❄️ COLD');

        $subject = "[{$lead_temp}] New Ticket #{$ticket['ticket_number']} - {$ticket['project_type']}";

        $body = "
            <h2>New Project Inquiry</h2>
            <p><strong>Ticket:</strong> #{$ticket['ticket_number']}</p>
            <p><strong>Lead Score:</strong> {$ticket['lead_score']}/100 ({$lead_temp})</p>
            <hr>
            <p><strong>Customer:</strong> {$ticket['name']}</p>
            <p><strong>Email:</strong> {$ticket['email']}</p>
            <p><strong>Phone:</strong> {$ticket['phone']}</p>
            <p><strong>Company:</strong> {$ticket['company']}</p>
            <hr>
            <p><strong>Project Type:</strong> {$ticket['project_type']}</p>
            <p><strong>Title:</strong> {$ticket['title']}</p>
            <p><strong>Budget:</strong> {$ticket['budget_range']}</p>
            <p><strong>Timeline:</strong> {$ticket['timeline']}</p>
            <hr>
            <p><strong>Description:</strong></p>
            <p>{$ticket['description']}</p>
            <hr>
            <p><a href='" . admin_url("admin.php?page=aakaari-tickets&id={$ticket_id}") . "'>View in Dashboard</a></p>
        ";

        return self::send_email($admin_email, $subject, $body, [
            'ticket_id' => $ticket_id,
            'type' => 'manual'
        ]);
    }

    /**
     * Send ticket response notification
     */
    public static function send_ticket_response($ticket_id, $response_id) {
        global $wpdb;

        $ticket = Aakaari_Ticket_Handler::get_ticket($ticket_id);
        $response = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}aakaari_ticket_responses WHERE id = %d",
            $response_id
        ), ARRAY_A);

        if (!$ticket || !$response || $response['is_internal_note']) {
            return false;
        }

        $subject = "Re: Ticket #{$ticket['ticket_number']} - {$ticket['title']}";

        $body = self::get_template('ticket_response', [
            'name' => $ticket['name'],
            'ticket_number' => $ticket['ticket_number'],
            'response' => nl2br($response['response_text']),
            'portal_link' => self::generate_portal_link($ticket_id, $ticket['email'])
        ]);

        return self::send_email($ticket['email'], $subject, $body, [
            'ticket_id' => $ticket_id,
            'lead_id' => $ticket['lead_id'],
            'type' => 'manual'
        ]);
    }

    /**
     * Start email sequence for lead
     */
    public static function start_sequence($lead_id, $trigger_condition) {
        global $wpdb;

        // Get active sequence for this trigger
        $sequence = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}aakaari_email_sequences WHERE trigger_condition = %s AND is_active = 1",
            $trigger_condition
        ));

        if (!$sequence) {
            return false;
        }

        // Schedule first step
        $first_step = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}aakaari_sequence_steps WHERE sequence_id = %d AND step_number = 1 AND is_active = 1",
            $sequence->id
        ));

        if (!$first_step) {
            return false;
        }

        // Calculate send time
        $send_at = strtotime("+{$first_step->delay_days} days +{$first_step->delay_hours} hours");

        // Store in queue (using transient for simplicity, could use custom table)
        $queue_key = "aakaari_email_queue_{$lead_id}_{$sequence->id}";
        set_transient($queue_key, [
            'lead_id' => $lead_id,
            'sequence_id' => $sequence->id,
            'current_step' => 1,
            'send_at' => $send_at
        ], 30 * DAY_IN_SECONDS);

        return true;
    }

    /**
     * Process email sequences (cron job)
     */
    public static function process_sequences() {
        global $wpdb;

        // Get all leads with active sequences
        $leads = $wpdb->get_results(
            "SELECT DISTINCT lead_id FROM {$wpdb->prefix}aakaari_leads WHERE status NOT IN ('won', 'lost')"
        );

        foreach ($leads as $lead_row) {
            $lead_id = $lead_row->lead_id;

            // Check each sequence
            $sequences = $wpdb->get_results(
                "SELECT * FROM {$wpdb->prefix}aakaari_email_sequences WHERE is_active = 1"
            );

            foreach ($sequences as $sequence) {
                $queue_key = "aakaari_email_queue_{$lead_id}_{$sequence->id}";
                $queue = get_transient($queue_key);

                if (!$queue || $queue['send_at'] > time()) {
                    continue;
                }

                // Time to send
                $step = $wpdb->get_row($wpdb->prepare(
                    "SELECT * FROM {$wpdb->prefix}aakaari_sequence_steps WHERE sequence_id = %d AND step_number = %d AND is_active = 1",
                    $sequence->id,
                    $queue['current_step']
                ));

                if (!$step) {
                    delete_transient($queue_key);
                    continue;
                }

                $lead = Aakaari_Lead_Handler::get_lead($lead_id);

                if (!$lead) {
                    delete_transient($queue_key);
                    continue;
                }

                // Send email
                $body = self::parse_template($step->body, ['name' => $lead['name']]);
                $subject = self::parse_template($step->subject, ['name' => $lead['name']]);

                self::send_email($lead['email'], $subject, $body, [
                    'lead_id' => $lead_id,
                    'sequence_step_id' => $step->id,
                    'type' => 'follow_up'
                ]);

                // Schedule next step
                $next_step = $wpdb->get_row($wpdb->prepare(
                    "SELECT * FROM {$wpdb->prefix}aakaari_sequence_steps WHERE sequence_id = %d AND step_number = %d AND is_active = 1",
                    $sequence->id,
                    $queue['current_step'] + 1
                ));

                if ($next_step) {
                    $next_send = strtotime("+{$next_step->delay_days} days +{$next_step->delay_hours} hours");
                    set_transient($queue_key, [
                        'lead_id' => $lead_id,
                        'sequence_id' => $sequence->id,
                        'current_step' => $queue['current_step'] + 1,
                        'send_at' => $next_send
                    ], 30 * DAY_IN_SECONDS);
                } else {
                    delete_transient($queue_key);
                }
            }
        }
    }

    /**
     * Send email using WordPress mail
     */
    public static function send_email($to, $subject, $body, $meta = []) {
        // Generate tracking ID
        $tracking_id = Aakaari_Security::generate_secure_token(32);

        // Add tracking pixel
        $tracking_pixel = '<img src="' . home_url("/aakaari-email-track/{$tracking_id}") . '" width="1" height="1" style="display:none;" />';

        // Wrap body in template
        $html_body = self::wrap_email_template($body . $tracking_pixel);

        // Set headers
        $headers = [
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . self::$from_name . ' <' . self::$from_email . '>'
        ];

        // Send
        $sent = wp_mail($to, $subject, $html_body, $headers);

        // Log sent email
        global $wpdb;
        $wpdb->insert($wpdb->prefix . 'aakaari_sent_emails', [
            'lead_id' => $meta['lead_id'] ?? null,
            'ticket_id' => $meta['ticket_id'] ?? null,
            'sequence_step_id' => $meta['sequence_step_id'] ?? null,
            'email_type' => $meta['type'] ?? 'manual',
            'to_email' => $to,
            'subject' => $subject,
            'body' => $body,
            'tracking_id' => $tracking_id,
            'sent_at' => current_time('mysql')
        ]);

        return $sent;
    }

    /**
     * Wrap email in HTML template
     */
    private static function wrap_email_template($content) {
        $logo_url = get_option('aakaari_logo_url', '');
        $company_name = get_bloginfo('name');
        $year = date('Y');

        return "
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
</head>
<body style='margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, sans-serif; background-color: #f5f5f5;'>
    <table width='100%' cellpadding='0' cellspacing='0' style='background-color: #f5f5f5; padding: 40px 20px;'>
        <tr>
            <td align='center'>
                <table width='600' cellpadding='0' cellspacing='0' style='background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);'>
                    <!-- Header -->
                    <tr>
                        <td style='background-color: #2563EB; padding: 30px; text-align: center;'>
                            <h1 style='margin: 0; color: #ffffff; font-size: 24px; font-weight: 600;'>AAKAARI Tech Solutions</h1>
                        </td>
                    </tr>
                    <!-- Content -->
                    <tr>
                        <td style='padding: 40px 30px;'>
                            {$content}
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style='background-color: #f8f9fa; padding: 30px; text-align: center; border-top: 1px solid #e9ecef;'>
                            <p style='margin: 0 0 10px; color: #666; font-size: 14px;'>
                                Questions? Reply to this email or visit our website.
                            </p>
                            <p style='margin: 0; color: #999; font-size: 12px;'>
                                &copy; {$year} {$company_name}. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>";
    }

    /**
     * Get email template
     */
    private static function get_template($template_name, $vars = []) {
        $templates = [
            'chat_transcript' => '
                <p>Hi {{name}},</p>
                <p>Thanks for chatting with us! Here\'s a copy of our conversation for your records.</p>
                <div style="background: #f9f9f9; padding: 20px; border-radius: 8px; margin: 20px 0;">
                    {{transcript}}
                </div>
                <p>If you have any more questions, just reply to this email or start another chat on our website.</p>
                <p>Best regards,<br><strong>AAKAARI Tech Solutions Team</strong></p>
            ',

            'ticket_confirmation' => '
                <p>Hi {{name}},</p>
                <p>Thanks for reaching out to AAKAARI Tech Solutions! We\'ve received your project inquiry.</p>
                <div style="background: #e3f2fd; padding: 20px; border-radius: 8px; margin: 20px 0;">
                    <p style="margin: 0;"><strong>Ticket ID:</strong> #{{ticket_number}}</p>
                    <p style="margin: 10px 0 0;"><strong>Project Type:</strong> {{project_type}}</p>
                    <p style="margin: 10px 0 0;"><strong>Estimated Response Time:</strong> Within 24 business hours</p>
                </div>
                <h3>What happens next?</h3>
                <ol>
                    <li>Our team is reviewing your requirements</li>
                    <li>We\'ll prepare a custom proposal with pricing and timeline</li>
                    <li>You\'ll receive a detailed quote via email</li>
                    <li>We can schedule a call to discuss further</li>
                </ol>
                <p>
                    <a href="{{portal_link}}" style="display: inline-block; background: #2563EB; color: #fff; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: 600;">Track Your Ticket</a>
                </p>
                <p>Questions? Reply to this email.</p>
                <p>Best regards,<br><strong>AAKAARI Tech Solutions Team</strong></p>
            ',

            'ticket_response' => '
                <p>Hi {{name}},</p>
                <p>We\'ve responded to your ticket <strong>#{{ticket_number}}</strong>:</p>
                <div style="background: #f5f5f5; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #2563EB;">
                    {{response}}
                </div>
                <p>
                    <a href="{{portal_link}}" style="display: inline-block; background: #2563EB; color: #fff; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: 600;">Reply to Ticket</a>
                </p>
                <p>Or simply reply to this email.</p>
                <p>Best regards,<br><strong>AAKAARI Tech Solutions Team</strong></p>
            '
        ];

        $template = $templates[$template_name] ?? '';

        return self::parse_template($template, $vars);
    }

    /**
     * Parse template variables
     */
    private static function parse_template($template, $vars) {
        foreach ($vars as $key => $value) {
            $template = str_replace('{{' . $key . '}}', $value, $template);
        }
        return $template;
    }

    /**
     * Generate customer portal link with magic token
     */
    private static function generate_portal_link($ticket_id, $email) {
        $token = Aakaari_Security::generate_magic_link($email, $ticket_id);
        return home_url("/ticket-portal/?ticket={$ticket_id}&token={$token}");
    }

    /**
     * Handle email tracking pixel
     */
    public static function handle_tracking_pixel() {
        if (preg_match('/^\/aakaari-email-track\/([a-f0-9]+)$/', $_SERVER['REQUEST_URI'], $matches)) {
            global $wpdb;
            $tracking_id = sanitize_text_field($matches[1]);

            $wpdb->update(
                $wpdb->prefix . 'aakaari_sent_emails',
                ['opened_at' => current_time('mysql')],
                ['tracking_id' => $tracking_id, 'opened_at' => null]
            );

            // Return 1x1 transparent GIF
            header('Content-Type: image/gif');
            echo base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
            exit;
        }
    }
}
