<?php
/**
 * Lead Handler
 *
 * Manages leads, scoring, and pipeline
 *
 * @package Aakaari_Lead_System
 */

if (!defined('ABSPATH')) {
    exit;
}

class Aakaari_Lead_Handler {

    public static function init() {
        // Nothing to initialize for now
    }

    /**
     * Create or update lead
     */
    public static function create_lead($data) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_leads';

        // Check if lead exists by email
        $existing = $wpdb->get_row($wpdb->prepare(
            "SELECT id, lead_score FROM $table WHERE email = %s",
            $data['email']
        ));

        if ($existing) {
            // Update existing lead
            $update_data = [
                'last_contact_at' => current_time('mysql'),
                'updated_at' => current_time('mysql')
            ];

            // Update name if provided and different
            if (!empty($data['name'])) {
                $update_data['name'] = $data['name'];
            }

            // Update other fields if provided
            foreach (['phone', 'company', 'website'] as $field) {
                if (!empty($data[$field])) {
                    $update_data[$field] = $data[$field];
                }
            }

            $wpdb->update($table, $update_data, ['id' => $existing->id]);

            return $existing->id;
        }

        // Create new lead
        $wpdb->insert($table, [
            'visitor_id' => $data['visitor_id'] ?? null,
            'source' => $data['source'] ?? 'chat',
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'company' => $data['company'] ?? null,
            'website' => $data['website'] ?? null,
            'status' => 'new',
            'lead_score' => 0,
            'first_contact_at' => current_time('mysql'),
            'last_contact_at' => current_time('mysql'),
            'how_found_us' => $data['how_found_us'] ?? null,
            'created_at' => current_time('mysql')
        ]);

        $lead_id = $wpdb->insert_id;

        // Start new lead email sequence
        Aakaari_Email_Handler::start_sequence($lead_id, 'new_chat_lead');

        Aakaari_Security::log_audit('lead_created', 'lead', $lead_id);

        return $lead_id;
    }

    /**
     * Update lead status
     */
    public static function update_status($lead_id, $status) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_leads';

        $old_status = $wpdb->get_var($wpdb->prepare(
            "SELECT status FROM $table WHERE id = %d",
            $lead_id
        ));

        $wpdb->update(
            $table,
            [
                'status' => $status,
                'last_contact_at' => current_time('mysql'),
                'updated_at' => current_time('mysql')
            ],
            ['id' => $lead_id]
        );

        Aakaari_Security::log_audit('lead_status_changed', 'lead', $lead_id, $old_status, $status);

        // Trigger actions based on status
        do_action('aakaari_lead_status_changed', $lead_id, $old_status, $status);
    }

    /**
     * Update lead score
     */
    public static function update_lead_score($lead_id, $score) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_leads';

        $wpdb->update(
            $table,
            [
                'lead_score' => min(100, max(0, $score)),
                'updated_at' => current_time('mysql')
            ],
            ['id' => $lead_id]
        );
    }

    /**
     * Get lead by ID
     */
    public static function get_lead($id) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_leads';

        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table WHERE id = %d",
            $id
        ), ARRAY_A);
    }

    /**
     * Get lead by email
     */
    public static function get_lead_by_email($email) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_leads';

        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table WHERE email = %s",
            $email
        ), ARRAY_A);
    }

    /**
     * Get leads list
     */
    public static function get_leads($args = []) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_leads';

        $where = ['1=1'];
        $values = [];

        if (!empty($args['status'])) {
            $where[] = 'status = %s';
            $values[] = $args['status'];
        }

        if (!empty($args['source'])) {
            $where[] = 'source = %s';
            $values[] = $args['source'];
        }

        if (!empty($args['min_score'])) {
            $where[] = 'lead_score >= %d';
            $values[] = $args['min_score'];
        }

        $where_sql = implode(' AND ', $where);

        $page = max(1, $args['page'] ?? 1);
        $per_page = 20;
        $offset = ($page - 1) * $per_page;

        $sql = "SELECT *,
                       CASE
                           WHEN lead_score >= 80 THEN 'hot'
                           WHEN lead_score >= 50 THEN 'warm'
                           ELSE 'cold'
                       END as temperature
                FROM $table
                WHERE $where_sql
                ORDER BY lead_score DESC, last_contact_at DESC
                LIMIT %d OFFSET %d";

        $values[] = $per_page;
        $values[] = $offset;

        if (!empty($values)) {
            $sql = $wpdb->prepare($sql, ...$values);
        }

        $leads = $wpdb->get_results($sql, ARRAY_A);

        // Get total count
        $count_sql = "SELECT COUNT(*) FROM $table WHERE $where_sql";
        if (count($values) > 2) {
            $count_sql = $wpdb->prepare($count_sql, ...array_slice($values, 0, -2));
        }
        $total = $wpdb->get_var($count_sql);

        return [
            'leads' => $leads,
            'total' => (int) $total,
            'page' => $page,
            'per_page' => $per_page
        ];
    }

    /**
     * Get lead with full details
     */
    public static function get_lead_full($id) {
        $lead = self::get_lead($id);

        if (!$lead) {
            return null;
        }

        global $wpdb;

        // Get conversations
        $lead['conversations'] = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}aakaari_conversations WHERE lead_id = %d ORDER BY created_at DESC",
            $id
        ), ARRAY_A);

        // Get tickets
        $lead['tickets'] = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}aakaari_tickets WHERE lead_id = %d ORDER BY created_at DESC",
            $id
        ), ARRAY_A);

        // Get emails sent
        $lead['emails'] = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}aakaari_sent_emails WHERE lead_id = %d ORDER BY sent_at DESC",
            $id
        ), ARRAY_A);

        return $lead;
    }

    /**
     * Add tag to lead
     */
    public static function add_tag($lead_id, $tag) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_leads';

        $lead = self::get_lead($lead_id);
        $tags = json_decode($lead['tags'] ?? '[]', true);

        if (!in_array($tag, $tags)) {
            $tags[] = $tag;
            $wpdb->update(
                $table,
                ['tags' => json_encode($tags), 'updated_at' => current_time('mysql')],
                ['id' => $lead_id]
            );
        }
    }

    /**
     * Remove tag from lead
     */
    public static function remove_tag($lead_id, $tag) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_leads';

        $lead = self::get_lead($lead_id);
        $tags = json_decode($lead['tags'] ?? '[]', true);

        $tags = array_filter($tags, function ($t) use ($tag) {
            return $t !== $tag;
        });

        $wpdb->update(
            $table,
            ['tags' => json_encode(array_values($tags)), 'updated_at' => current_time('mysql')],
            ['id' => $lead_id]
        );
    }

    /**
     * Get dashboard statistics
     */
    public static function get_dashboard_stats() {
        global $wpdb;

        $stats = [];

        // Today's stats
        $today = date('Y-m-d');

        $stats['today'] = [
            'chats' => $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM {$wpdb->prefix}aakaari_conversations WHERE DATE(created_at) = %s",
                $today
            )),
            'tickets' => $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM {$wpdb->prefix}aakaari_tickets WHERE DATE(created_at) = %s",
                $today
            )),
            'leads' => $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM {$wpdb->prefix}aakaari_leads WHERE DATE(created_at) = %s",
                $today
            ))
        ];

        // This week
        $week_start = date('Y-m-d', strtotime('monday this week'));

        $stats['week'] = [
            'chats' => $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM {$wpdb->prefix}aakaari_conversations WHERE created_at >= %s",
                $week_start
            )),
            'tickets' => $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM {$wpdb->prefix}aakaari_tickets WHERE created_at >= %s",
                $week_start
            )),
            'leads' => $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM {$wpdb->prefix}aakaari_leads WHERE created_at >= %s",
                $week_start
            ))
        ];

        // Lead temperature distribution
        $stats['lead_temperatures'] = [
            'hot' => $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}aakaari_leads WHERE lead_score >= 80"),
            'warm' => $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}aakaari_leads WHERE lead_score >= 50 AND lead_score < 80"),
            'cold' => $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}aakaari_leads WHERE lead_score < 50")
        ];

        // Open items
        $stats['open'] = [
            'waiting_chats' => $wpdb->get_var(
                "SELECT COUNT(*) FROM {$wpdb->prefix}aakaari_conversations WHERE status = 'waiting'"
            ),
            'active_chats' => $wpdb->get_var(
                "SELECT COUNT(*) FROM {$wpdb->prefix}aakaari_conversations WHERE status = 'active'"
            ),
            'open_tickets' => $wpdb->get_var(
                "SELECT COUNT(*) FROM {$wpdb->prefix}aakaari_tickets WHERE status NOT IN ('closed_won', 'closed_lost', 'spam')"
            ),
            'overdue_tickets' => $wpdb->get_var(
                "SELECT COUNT(*) FROM {$wpdb->prefix}aakaari_tickets WHERE sla_deadline < NOW() AND status NOT IN ('closed_won', 'closed_lost', 'spam')"
            )
        ];

        // Conversion metrics
        $total_leads = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}aakaari_leads");
        $won_leads = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}aakaari_leads WHERE status = 'won'");

        $stats['conversion'] = [
            'total_leads' => (int) $total_leads,
            'won' => (int) $won_leads,
            'rate' => $total_leads > 0 ? round(($won_leads / $total_leads) * 100, 1) : 0
        ];

        // Revenue (from won tickets)
        $stats['revenue'] = [
            'total' => $wpdb->get_var(
                "SELECT SUM(proposal_amount) FROM {$wpdb->prefix}aakaari_tickets WHERE status = 'closed_won'"
            ) ?: 0,
            'pipeline' => $wpdb->get_var(
                "SELECT SUM(proposal_amount) FROM {$wpdb->prefix}aakaari_tickets WHERE status IN ('proposal_sent', 'awaiting_response', 'negotiation')"
            ) ?: 0
        ];

        // Chat-to-lead conversion
        $total_chats = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}aakaari_conversations");
        $chats_with_lead = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}aakaari_conversations WHERE lead_captured = 1");

        $stats['chat_conversion'] = [
            'total' => (int) $total_chats,
            'captured' => (int) $chats_with_lead,
            'rate' => $total_chats > 0 ? round(($chats_with_lead / $total_chats) * 100, 1) : 0
        ];

        // Top traffic sources
        $stats['sources'] = $wpdb->get_results(
            "SELECT how_found_us, COUNT(*) as count
             FROM {$wpdb->prefix}aakaari_leads
             WHERE how_found_us IS NOT NULL
             GROUP BY how_found_us
             ORDER BY count DESC
             LIMIT 5",
            ARRAY_A
        );

        // Agent performance (if multiple agents)
        $stats['agents'] = $wpdb->get_results(
            "SELECT u.display_name, a.status, a.current_chats,
                    (SELECT COUNT(*) FROM {$wpdb->prefix}aakaari_conversations WHERE agent_id = u.ID AND DATE(created_at) = CURDATE()) as today_chats
             FROM {$wpdb->prefix}aakaari_agent_status a
             JOIN {$wpdb->users} u ON a.user_id = u.ID
             ORDER BY a.status ASC",
            ARRAY_A
        );

        return $stats;
    }

    /**
     * Merge duplicate leads
     */
    public static function merge_leads($primary_id, $secondary_id) {
        global $wpdb;

        // Update all references to secondary lead
        $wpdb->update(
            $wpdb->prefix . 'aakaari_conversations',
            ['lead_id' => $primary_id],
            ['lead_id' => $secondary_id]
        );

        $wpdb->update(
            $wpdb->prefix . 'aakaari_tickets',
            ['lead_id' => $primary_id],
            ['lead_id' => $secondary_id]
        );

        $wpdb->update(
            $wpdb->prefix . 'aakaari_sent_emails',
            ['lead_id' => $primary_id],
            ['lead_id' => $secondary_id]
        );

        // Delete secondary lead
        $wpdb->delete($wpdb->prefix . 'aakaari_leads', ['id' => $secondary_id]);

        Aakaari_Security::log_audit('leads_merged', 'lead', $primary_id, $secondary_id, null);
    }
}
