<?php
/**
 * Proactive Chat Triggers
 *
 * Manages behavioral triggers for proactive chat engagement
 *
 * @package Aakaari_Lead_System
 */

if (!defined('ABSPATH')) {
    exit;
}

class Aakaari_Triggers {

    public static function init() {
        // Nothing server-side to initialize
        // All trigger logic happens on frontend
    }

    /**
     * Get active triggers for frontend
     */
    public static function get_active_triggers() {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_triggers';

        $triggers = $wpdb->get_results(
            "SELECT id, trigger_name, trigger_type, conditions, message, priority, ab_variant
             FROM $table
             WHERE is_active = 1
             ORDER BY priority ASC",
            ARRAY_A
        );

        // Decode JSON conditions
        foreach ($triggers as &$trigger) {
            $trigger['conditions'] = json_decode($trigger['conditions'], true);
        }

        return $triggers;
    }

    /**
     * Record trigger shown
     */
    public static function record_trigger($trigger_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_triggers';

        $wpdb->query($wpdb->prepare(
            "UPDATE $table SET times_triggered = times_triggered + 1 WHERE id = %d",
            $trigger_id
        ));
    }

    /**
     * Record trigger engagement (visitor clicked to chat)
     */
    public static function record_engagement($trigger_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_triggers';

        $wpdb->query($wpdb->prepare(
            "UPDATE $table SET times_engaged = times_engaged + 1 WHERE id = %d",
            $trigger_id
        ));

        // Also record shown
        self::record_trigger($trigger_id);
    }

    /**
     * Get trigger stats
     */
    public static function get_trigger_stats() {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_triggers';

        $triggers = $wpdb->get_results(
            "SELECT id, trigger_name, trigger_type, times_triggered, times_engaged,
                    CASE
                        WHEN times_triggered > 0 THEN ROUND((times_engaged / times_triggered) * 100, 1)
                        ELSE 0
                    END as engagement_rate
             FROM $table
             ORDER BY engagement_rate DESC",
            ARRAY_A
        );

        return $triggers;
    }

    /**
     * Create new trigger
     */
    public static function create_trigger($data) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_triggers';

        $wpdb->insert($table, [
            'trigger_name' => $data['trigger_name'],
            'trigger_type' => $data['trigger_type'],
            'conditions' => json_encode($data['conditions']),
            'message' => $data['message'],
            'is_active' => $data['is_active'] ?? 1,
            'priority' => $data['priority'] ?? 10,
            'ab_variant' => $data['ab_variant'] ?? null,
            'created_at' => current_time('mysql')
        ]);

        return $wpdb->insert_id;
    }

    /**
     * Update trigger
     */
    public static function update_trigger($id, $data) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_triggers';

        $update_data = [];

        if (isset($data['trigger_name'])) $update_data['trigger_name'] = $data['trigger_name'];
        if (isset($data['trigger_type'])) $update_data['trigger_type'] = $data['trigger_type'];
        if (isset($data['conditions'])) $update_data['conditions'] = json_encode($data['conditions']);
        if (isset($data['message'])) $update_data['message'] = $data['message'];
        if (isset($data['is_active'])) $update_data['is_active'] = $data['is_active'];
        if (isset($data['priority'])) $update_data['priority'] = $data['priority'];

        $update_data['updated_at'] = current_time('mysql');

        return $wpdb->update($table, $update_data, ['id' => $id]);
    }

    /**
     * Delete trigger
     */
    public static function delete_trigger($id) {
        global $wpdb;
        return $wpdb->delete($wpdb->prefix . 'aakaari_triggers', ['id' => $id]);
    }

    /**
     * Get all triggers for admin
     */
    public static function get_all_triggers() {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_triggers';

        $triggers = $wpdb->get_results("SELECT * FROM $table ORDER BY priority ASC", ARRAY_A);

        foreach ($triggers as &$trigger) {
            $trigger['conditions'] = json_decode($trigger['conditions'], true);
            $trigger['engagement_rate'] = $trigger['times_triggered'] > 0
                ? round(($trigger['times_engaged'] / $trigger['times_triggered']) * 100, 1)
                : 0;
        }

        return $triggers;
    }
}
