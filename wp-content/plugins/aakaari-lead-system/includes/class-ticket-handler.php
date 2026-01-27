<?php
/**
 * Ticket Handler
 *
 * Manages support tickets and project inquiries
 *
 * @package Aakaari_Lead_System
 */

if (!defined('ABSPATH')) {
    exit;
}

class Aakaari_Ticket_Handler {

    public static function init() {
        // Schedule status auto-transitions
        add_action('aakaari_ticket_status_check', [__CLASS__, 'check_status_transitions']);

        if (!wp_next_scheduled('aakaari_ticket_status_check')) {
            wp_schedule_event(time(), 'hourly', 'aakaari_ticket_status_check');
        }
    }

    /**
     * Create a new ticket
     */
    public static function create_ticket($data) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_tickets';

        $ticket_number = Aakaari_Database::generate_ticket_number();

        // Calculate lead score
        $lead_score = self::calculate_lead_score($data);

        // Determine priority based on budget and timeline
        $priority = self::determine_priority($data);

        // Calculate SLA deadline (24 hours for response)
        $sla_hours = get_option('aakaari_sla_response_hours', 24);
        $sla_deadline = date('Y-m-d H:i:s', strtotime("+$sla_hours hours"));

        $wpdb->insert($table, [
            'ticket_number' => $ticket_number,
            'lead_id' => $data['lead_id'],
            'project_type' => $data['project_type'],
            'title' => $data['title'],
            'description' => $data['description'],
            'problem_statement' => $data['problem_statement'] ?? null,
            'status' => 'new',
            'priority' => $priority,
            'lead_score' => $lead_score,
            'budget_range' => $data['budget_range'],
            'timeline' => $data['timeline'],
            'timeline_date' => $data['timeline_date'] ?? null,
            'has_mockups' => $data['has_mockups'] ? 1 : 0,
            'previous_agency_experience' => $data['previous_agency_experience'] ? 1 : 0,
            'previous_agency_feedback' => $data['previous_agency_feedback'] ?? null,
            'additional_requirements' => $data['additional_requirements'] ?? null,
            'created_from' => $data['created_from'] ?? 'form',
            'files' => isset($data['files']) ? json_encode($data['files']) : null,
            'sla_deadline' => $sla_deadline,
            'created_at' => current_time('mysql')
        ]);

        $ticket_id = $wpdb->insert_id;

        // Update lead score
        if ($data['lead_id']) {
            Aakaari_Lead_Handler::update_lead_score($data['lead_id'], $lead_score);
        }

        // Log audit
        Aakaari_Security::log_audit('ticket_created', 'ticket', $ticket_id);

        return [
            'id' => $ticket_id,
            'ticket_number' => $ticket_number,
            'lead_score' => $lead_score
        ];
    }

    /**
     * Calculate lead score for ticket
     */
    private static function calculate_lead_score($data) {
        $score = 0;

        // Budget scoring
        $budget_scores = [
            'under_10k' => 10,
            '10k_25k' => 25,
            '25k_50k' => 50,
            '50k_100k' => 75,
            'above_100k' => 100,
            'not_sure' => 20
        ];

        $budget_key = self::normalize_budget_key($data['budget_range']);
        $score += $budget_scores[$budget_key] ?? 20;

        // Timeline scoring
        $timeline_scores = [
            'asap' => 100,
            '1_2_weeks' => 75,
            '1_month' => 50,
            '2_3_months' => 30,
            'flexible' => 25
        ];

        $timeline_key = self::normalize_timeline_key($data['timeline']);
        $score += $timeline_scores[$timeline_key] ?? 25;

        // Has website (+20)
        if (!empty($data['website'])) {
            $score += 20;
        }

        // Has mockups (+30)
        if (!empty($data['has_mockups'])) {
            $score += 30;
        }

        // Detailed description (+20)
        if (strlen($data['description'] ?? '') > 200) {
            $score += 20;
        }

        // Phone provided (+10)
        if (!empty($data['phone'])) {
            $score += 10;
        }

        // Previous agency experience (+10)
        if (!empty($data['previous_agency_experience'])) {
            $score += 10;
        }

        // Cap at 100
        return min(100, $score);
    }

    /**
     * Normalize budget key
     */
    private static function normalize_budget_key($budget) {
        $budget = strtolower(str_replace([' ', '₹', ',', '-'], ['', '', '', '_'], $budget));

        if (strpos($budget, 'under') !== false || strpos($budget, '<') !== false) {
            return 'under_10k';
        }
        if (strpos($budget, '10') !== false && strpos($budget, '25') !== false) {
            return '10k_25k';
        }
        if (strpos($budget, '25') !== false && strpos($budget, '50') !== false) {
            return '25k_50k';
        }
        if (strpos($budget, '50') !== false && strpos($budget, '100') !== false) {
            return '50k_100k';
        }
        if (strpos($budget, '100') !== false || strpos($budget, 'above') !== false) {
            return 'above_100k';
        }

        return 'not_sure';
    }

    /**
     * Normalize timeline key
     */
    private static function normalize_timeline_key($timeline) {
        $timeline = strtolower($timeline);

        if (strpos($timeline, 'asap') !== false || strpos($timeline, 'urgent') !== false) {
            return 'asap';
        }
        if (strpos($timeline, '1') !== false && strpos($timeline, '2') !== false && strpos($timeline, 'week') !== false) {
            return '1_2_weeks';
        }
        if (strpos($timeline, '1') !== false && strpos($timeline, 'month') !== false) {
            return '1_month';
        }
        if (strpos($timeline, '2') !== false && strpos($timeline, '3') !== false) {
            return '2_3_months';
        }

        return 'flexible';
    }

    /**
     * Determine priority
     */
    private static function determine_priority($data) {
        $budget_key = self::normalize_budget_key($data['budget_range']);
        $timeline_key = self::normalize_timeline_key($data['timeline']);

        // Urgent if ASAP or high budget
        if ($timeline_key === 'asap' || in_array($budget_key, ['50k_100k', 'above_100k'])) {
            return 'urgent';
        }

        // High if quick timeline or good budget
        if ($timeline_key === '1_2_weeks' || $budget_key === '25k_50k') {
            return 'high';
        }

        // Medium for most cases
        if ($timeline_key === '1_month' || $budget_key === '10k_25k') {
            return 'medium';
        }

        return 'low';
    }

    /**
     * Create ticket from chat conversation
     */
    public static function create_from_conversation($conversation_id, $extra_data = []) {
        global $wpdb;

        $conversation = Aakaari_Chat_Handler::get_conversation_full($conversation_id);

        if (!$conversation) {
            return null;
        }

        // Compile chat messages into description
        $messages = array_filter($conversation['messages'], function ($m) {
            return $m['message_type'] === 'text';
        });

        $chat_summary = "Chat conversation summary:\n\n";
        foreach ($messages as $msg) {
            $sender = $msg['sender_type'] === 'visitor' ? $conversation['visitor_name'] : 'Agent';
            $chat_summary .= "[$sender]: {$msg['message_text']}\n";
        }

        $ticket_data = [
            'lead_id' => $conversation['lead_id'],
            'conversation_id' => $conversation_id,
            'project_type' => $extra_data['project_type'] ?? 'General Inquiry',
            'title' => $extra_data['title'] ?? "Chat inquiry from {$conversation['visitor_name']}",
            'description' => $chat_summary,
            'budget_range' => $extra_data['budget_range'] ?? 'Not specified',
            'timeline' => $extra_data['timeline'] ?? 'Flexible',
            'created_from' => 'chat'
        ];

        $ticket = self::create_ticket($ticket_data);

        // Link ticket to conversation
        $wpdb->update(
            $wpdb->prefix . 'aakaari_conversations',
            ['channel' => 'ticket'],
            ['id' => $conversation_id]
        );

        return $ticket;
    }

    /**
     * Get ticket by ID
     */
    public static function get_ticket($id) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_tickets';

        return $wpdb->get_row($wpdb->prepare(
            "SELECT t.*, l.name, l.email, l.phone, l.company, l.website
             FROM $table t
             LEFT JOIN {$wpdb->prefix}aakaari_leads l ON t.lead_id = l.id
             WHERE t.id = %d",
            $id
        ), ARRAY_A);
    }

    /**
     * Get ticket with full details
     */
    public static function get_ticket_full($id) {
        $ticket = self::get_ticket($id);

        if (!$ticket) {
            return null;
        }

        global $wpdb;

        // Get responses
        $responses = $wpdb->get_results($wpdb->prepare(
            "SELECT r.*,
                    CASE
                        WHEN r.responder_type = 'agent' THEN u.display_name
                        ELSE 'Customer'
                    END as responder_name
             FROM {$wpdb->prefix}aakaari_ticket_responses r
             LEFT JOIN {$wpdb->users} u ON r.responder_id = u.ID
             WHERE r.ticket_id = %d
             ORDER BY r.created_at ASC",
            $id
        ), ARRAY_A);

        $ticket['responses'] = $responses;

        // Get status history from audit log
        $history = $wpdb->get_results($wpdb->prepare(
            "SELECT action, old_value, new_value, created_at
             FROM {$wpdb->prefix}aakaari_audit_log
             WHERE object_type = 'ticket' AND object_id = %d
             ORDER BY created_at ASC",
            $id
        ), ARRAY_A);

        $ticket['history'] = $history;

        return $ticket;
    }

    /**
     * Get tickets list
     */
    public static function get_tickets($args = []) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_tickets';

        $where = ['1=1'];
        $values = [];

        if (!empty($args['status'])) {
            $where[] = 't.status = %s';
            $values[] = $args['status'];
        }

        if (!empty($args['priority'])) {
            $where[] = 't.priority = %s';
            $values[] = $args['priority'];
        }

        if (!empty($args['assigned_to'])) {
            $where[] = 't.assigned_to = %d';
            $values[] = $args['assigned_to'];
        }

        $where_sql = implode(' AND ', $where);

        $page = max(1, $args['page'] ?? 1);
        $per_page = min(100, max(1, $args['per_page'] ?? 20));
        $offset = ($page - 1) * $per_page;

        $sql = "SELECT t.*, l.name, l.email, l.phone,
                       u.display_name as assigned_name
                FROM $table t
                LEFT JOIN {$wpdb->prefix}aakaari_leads l ON t.lead_id = l.id
                LEFT JOIN {$wpdb->users} u ON t.assigned_to = u.ID
                WHERE $where_sql
                ORDER BY
                    CASE t.priority
                        WHEN 'urgent' THEN 1
                        WHEN 'high' THEN 2
                        WHEN 'medium' THEN 3
                        ELSE 4
                    END,
                    t.created_at DESC
                LIMIT %d OFFSET %d";

        $values[] = $per_page;
        $values[] = $offset;

        if (!empty($values)) {
            $sql = $wpdb->prepare($sql, ...$values);
        }

        $tickets = $wpdb->get_results($sql, ARRAY_A);

        // Get total count
        $count_sql = "SELECT COUNT(*) FROM $table t WHERE $where_sql";
        if (count($values) > 2) {
            $count_sql = $wpdb->prepare($count_sql, ...array_slice($values, 0, -2));
        }
        $total = $wpdb->get_var($count_sql);

        return [
            'tickets' => $tickets,
            'total' => (int) $total,
            'page' => $page,
            'per_page' => $per_page,
            'total_pages' => ceil($total / $per_page)
        ];
    }

    /**
     * Update ticket
     */
    public static function update_ticket($id, $data) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_tickets';

        // Get old values for audit
        $old = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $id), ARRAY_A);

        $data['updated_at'] = current_time('mysql');

        // Handle status transitions
        if (isset($data['status']) && $data['status'] !== $old['status']) {
            self::handle_status_transition($id, $old['status'], $data['status']);
        }

        $result = $wpdb->update($table, $data, ['id' => $id]);

        // Log changes
        foreach ($data as $field => $new_value) {
            if ($field !== 'updated_at' && isset($old[$field]) && $old[$field] !== $new_value) {
                Aakaari_Security::log_audit(
                    'ticket_updated',
                    'ticket',
                    $id,
                    [$field => $old[$field]],
                    [$field => $new_value]
                );
            }
        }

        return $result;
    }

    /**
     * Handle status transitions
     */
    private static function handle_status_transition($id, $old_status, $new_status) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_tickets';

        $now = current_time('mysql');

        switch ($new_status) {
            case 'proposal_sent':
                $wpdb->update($table, ['proposal_sent_at' => $now], ['id' => $id]);
                // Start proposal follow-up sequence
                $ticket = self::get_ticket($id);
                if ($ticket['lead_id']) {
                    Aakaari_Email_Handler::start_sequence($ticket['lead_id'], 'proposal_sent');
                }
                break;

            case 'closed_won':
                $wpdb->update($table, ['won_at' => $now], ['id' => $id]);
                // Update lead status
                $ticket = self::get_ticket($id);
                if ($ticket['lead_id']) {
                    Aakaari_Lead_Handler::update_status($ticket['lead_id'], 'won');
                }
                break;

            case 'closed_lost':
                $wpdb->update($table, ['lost_at' => $now], ['id' => $id]);
                $ticket = self::get_ticket($id);
                if ($ticket['lead_id']) {
                    Aakaari_Lead_Handler::update_status($ticket['lead_id'], 'lost');
                }
                break;

            case 'under_review':
                // Set automatically if still 'new' after 1 hour
                if (!$wpdb->get_var($wpdb->prepare(
                    "SELECT first_response_at FROM $table WHERE id = %d",
                    $id
                ))) {
                    $wpdb->update($table, ['first_response_at' => $now], ['id' => $id]);
                }
                break;
        }
    }

    /**
     * Add response to ticket
     */
    public static function add_response($data) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_ticket_responses';

        $wpdb->insert($table, [
            'ticket_id' => $data['ticket_id'],
            'responder_type' => $data['responder_type'],
            'responder_id' => $data['responder_id'] ?? get_current_user_id(),
            'response_text' => $data['response_text'],
            'is_internal_note' => $data['is_internal_note'] ?? 0,
            'files' => isset($data['files']) ? json_encode($data['files']) : null,
            'created_at' => current_time('mysql')
        ]);

        $response_id = $wpdb->insert_id;

        // Update ticket timestamp
        $wpdb->update(
            $wpdb->prefix . 'aakaari_tickets',
            ['updated_at' => current_time('mysql')],
            ['id' => $data['ticket_id']]
        );

        // Set first response time if this is first agent response
        if ($data['responder_type'] === 'agent') {
            $ticket_table = $wpdb->prefix . 'aakaari_tickets';
            $wpdb->query($wpdb->prepare(
                "UPDATE $ticket_table SET first_response_at = COALESCE(first_response_at, NOW()) WHERE id = %d",
                $data['ticket_id']
            ));

            // Send email notification to customer
            if (empty($data['is_internal_note'])) {
                Aakaari_Email_Handler::send_ticket_response($data['ticket_id'], $response_id);
            }
        }

        return $response_id;
    }

    /**
     * Check and perform automatic status transitions
     */
    public static function check_status_transitions() {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_tickets';

        // Auto-transition 'new' to 'under_review' after 1 hour
        $wpdb->query(
            "UPDATE $table SET status = 'under_review', updated_at = NOW()
             WHERE status = 'new' AND created_at < DATE_SUB(NOW(), INTERVAL 1 HOUR)"
        );

        // Auto-transition 'proposal_sent' to 'awaiting_response' after 1 day
        $wpdb->query(
            "UPDATE $table SET status = 'awaiting_response', updated_at = NOW()
             WHERE status = 'proposal_sent' AND proposal_sent_at < DATE_SUB(NOW(), INTERVAL 1 DAY)"
        );

        // Auto-close tickets with no response in 30 days
        $stale_tickets = $wpdb->get_results(
            "SELECT id, lead_id FROM $table
             WHERE status = 'awaiting_response'
             AND updated_at < DATE_SUB(NOW(), INTERVAL 30 DAY)"
        );

        foreach ($stale_tickets as $ticket) {
            self::update_ticket($ticket->id, [
                'status' => 'closed_lost',
                'lost_reason' => 'No response after 30 days'
            ]);
        }
    }

    /**
     * Get ticket stats for dashboard
     */
    public static function get_stats() {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_tickets';

        $stats = [];

        // Count by status
        $status_counts = $wpdb->get_results(
            "SELECT status, COUNT(*) as count FROM $table GROUP BY status",
            ARRAY_A
        );

        $stats['by_status'] = array_column($status_counts, 'count', 'status');

        // Count open tickets
        $stats['open'] = $wpdb->get_var(
            "SELECT COUNT(*) FROM $table WHERE status NOT IN ('closed_won', 'closed_lost', 'spam')"
        );

        // Average response time
        $stats['avg_response_time'] = $wpdb->get_var(
            "SELECT AVG(TIMESTAMPDIFF(HOUR, created_at, first_response_at))
             FROM $table WHERE first_response_at IS NOT NULL"
        );

        // Conversion rate
        $total = $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE status IN ('closed_won', 'closed_lost')");
        $won = $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE status = 'closed_won'");
        $stats['conversion_rate'] = $total > 0 ? round(($won / $total) * 100, 1) : 0;

        // Pipeline value
        $stats['pipeline_value'] = $wpdb->get_var(
            "SELECT SUM(proposal_amount) FROM $table WHERE status IN ('proposal_sent', 'awaiting_response', 'negotiation')"
        ) ?: 0;

        return $stats;
    }
}
