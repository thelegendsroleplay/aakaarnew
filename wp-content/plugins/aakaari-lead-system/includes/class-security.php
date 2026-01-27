<?php
/**
 * Security Handler
 *
 * Handles rate limiting, input sanitization, CSRF protection, and security logging
 *
 * @package Aakaari_Lead_System
 */

if (!defined('ABSPATH')) {
    exit;
}

class Aakaari_Security {

    private static $rate_limits = [
        'chat_init' => ['limit' => 5, 'window' => 3600],      // 5 chat initiations per hour per IP
        'message_send' => ['limit' => 60, 'window' => 60],     // 60 messages per minute
        'ticket_submit' => ['limit' => 3, 'window' => 86400],  // 3 tickets per day per email
        'file_upload' => ['limit' => 10, 'window' => 3600],    // 10 uploads per hour
        'api_request' => ['limit' => 100, 'window' => 60],     // 100 API requests per minute
    ];

    private static $allowed_file_types = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
        'application/pdf' => 'pdf',
        'application/msword' => 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
    ];

    public static function init() {
        add_action('init', [__CLASS__, 'start_session']);
        add_action('wp_ajax_aakaari_verify_nonce', [__CLASS__, 'ajax_verify_nonce']);
        add_action('wp_ajax_nopriv_aakaari_verify_nonce', [__CLASS__, 'ajax_verify_nonce']);
    }

    /**
     * Start session for visitor tracking
     */
    public static function start_session() {
        if (!session_id() && !headers_sent()) {
            session_start([
                'cookie_httponly' => true,
                'cookie_secure' => is_ssl(),
                'cookie_samesite' => 'Strict'
            ]);
        }
    }

    /**
     * Get or create visitor session ID
     */
    public static function get_session_id() {
        if (!isset($_SESSION['aakaari_visitor_id'])) {
            $_SESSION['aakaari_visitor_id'] = self::generate_secure_token(32);
        }
        return $_SESSION['aakaari_visitor_id'];
    }

    /**
     * Generate cryptographically secure token
     */
    public static function generate_secure_token($length = 32) {
        return bin2hex(random_bytes($length / 2));
    }

    /**
     * Verify nonce for AJAX requests
     */
    public static function verify_nonce($nonce, $action = 'aakaari_chat_nonce') {
        return wp_verify_nonce($nonce, $action);
    }

    /**
     * AJAX nonce verification endpoint
     */
    public static function ajax_verify_nonce() {
        $valid = self::verify_nonce($_POST['nonce'] ?? '', $_POST['action_name'] ?? 'aakaari_chat_nonce');
        wp_send_json(['valid' => $valid]);
    }

    /**
     * Check rate limit
     */
    public static function check_rate_limit($action, $identifier = null) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_rate_limits';

        if (!isset(self::$rate_limits[$action])) {
            return true;
        }

        $limit_config = self::$rate_limits[$action];
        $identifier = $identifier ?? self::get_client_ip();
        $key = $action . ':' . $identifier;

        // Clean old entries
        $wpdb->query($wpdb->prepare(
            "DELETE FROM $table WHERE identifier = %s AND action_type = %s AND window_start < DATE_SUB(NOW(), INTERVAL %d SECOND)",
            $key, $action, $limit_config['window']
        ));

        // Check current count
        $current = $wpdb->get_row($wpdb->prepare(
            "SELECT count, window_start FROM $table WHERE identifier = %s AND action_type = %s",
            $key, $action
        ));

        if ($current) {
            if ($current->count >= $limit_config['limit']) {
                self::log_security_event('rate_limit_exceeded', [
                    'action' => $action,
                    'identifier' => $identifier,
                    'count' => $current->count
                ]);
                return false;
            }

            $wpdb->update(
                $table,
                ['count' => $current->count + 1],
                ['identifier' => $key, 'action_type' => $action]
            );
        } else {
            $wpdb->insert($table, [
                'identifier' => $key,
                'action_type' => $action,
                'count' => 1,
                'window_start' => current_time('mysql')
            ]);
        }

        return true;
    }

    /**
     * Get client IP address (handles proxies)
     */
    public static function get_client_ip() {
        $ip_keys = [
            'HTTP_CF_CONNECTING_IP', // Cloudflare
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];

        foreach ($ip_keys as $key) {
            if (!empty($_SERVER[$key])) {
                $ip = $_SERVER[$key];
                // Handle comma-separated IPs (X-Forwarded-For)
                if (strpos($ip, ',') !== false) {
                    $ip = trim(explode(',', $ip)[0]);
                }
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }

        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    /**
     * Sanitize input string
     */
    public static function sanitize_string($input, $max_length = 1000) {
        if (!is_string($input)) {
            return '';
        }

        $input = trim($input);
        $input = wp_kses_post($input); // Allow basic HTML
        $input = mb_substr($input, 0, $max_length);

        return $input;
    }

    /**
     * Sanitize plain text (no HTML)
     */
    public static function sanitize_text($input, $max_length = 1000) {
        if (!is_string($input)) {
            return '';
        }

        $input = trim($input);
        $input = sanitize_text_field($input);
        $input = mb_substr($input, 0, $max_length);

        return $input;
    }

    /**
     * Sanitize email
     */
    public static function sanitize_email($email) {
        $email = sanitize_email($email);
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : '';
    }

    /**
     * Sanitize URL
     */
    public static function sanitize_url($url) {
        $url = esc_url_raw($url);
        return filter_var($url, FILTER_VALIDATE_URL) ? $url : '';
    }

    /**
     * Sanitize phone number
     */
    public static function sanitize_phone($phone) {
        // Remove everything except digits, plus sign, and spaces
        $phone = preg_replace('/[^0-9+\s\-()]/', '', $phone);
        return mb_substr($phone, 0, 30);
    }

    /**
     * Validate and sanitize file upload
     */
    public static function validate_file_upload($file, $max_size = 5242880) { // 5MB default
        $errors = [];

        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return ['error' => 'Invalid upload'];
        }

        // Check file size
        if ($file['size'] > $max_size) {
            return ['error' => 'File too large. Maximum size is ' . ($max_size / 1048576) . 'MB'];
        }

        // Check MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!isset(self::$allowed_file_types[$mime_type])) {
            return ['error' => 'File type not allowed'];
        }

        // Check file extension matches MIME
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $expected_ext = self::$allowed_file_types[$mime_type];

        if ($ext !== $expected_ext && !($mime_type === 'image/jpeg' && $ext === 'jpeg')) {
            return ['error' => 'File extension does not match content'];
        }

        // Sanitize filename
        $safe_name = sanitize_file_name($file['name']);
        $safe_name = preg_replace('/[^a-zA-Z0-9._-]/', '', $safe_name);

        return [
            'valid' => true,
            'mime_type' => $mime_type,
            'extension' => $expected_ext,
            'safe_name' => $safe_name,
            'size' => $file['size']
        ];
    }

    /**
     * Check if visitor is blocked
     */
    public static function is_visitor_blocked($identifier = null) {
        global $wpdb;
        $identifier = $identifier ?? self::get_client_ip();

        // Check IP block
        $visitors_table = $wpdb->prefix . 'aakaari_visitors';
        $blocked = $wpdb->get_var($wpdb->prepare(
            "SELECT is_blocked FROM $visitors_table WHERE ip_address = %s AND is_blocked = 1",
            $identifier
        ));

        return (bool) $blocked;
    }

    /**
     * Block a visitor
     */
    public static function block_visitor($visitor_id, $reason = '') {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_visitors';

        $wpdb->update(
            $table,
            ['is_blocked' => 1],
            ['id' => $visitor_id]
        );

        self::log_audit('block_visitor', 'visitor', $visitor_id, null, $reason);
    }

    /**
     * Detect spam/bot submissions
     */
    public static function is_spam_submission($data) {
        // Honeypot field check
        if (!empty($data['website_url_confirm'])) {
            return true;
        }

        // Time-based check (form submitted too quickly)
        if (isset($data['form_token'])) {
            $token_time = self::decrypt_token_time($data['form_token']);
            if ($token_time && (time() - $token_time) < 3) {
                return true;
            }
        }

        // Suspicious patterns in text
        $text_to_check = ($data['message'] ?? '') . ' ' . ($data['description'] ?? '');
        $spam_patterns = [
            '/\b(viagra|cialis|casino|poker|lottery)\b/i',
            '/(http[s]?:\/\/[^\s]+){3,}/i', // Multiple URLs
            '/(.)\1{10,}/', // Repeated characters
        ];

        foreach ($spam_patterns as $pattern) {
            if (preg_match($pattern, $text_to_check)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Generate form token with timestamp
     */
    public static function generate_form_token() {
        $time = time();
        $random = self::generate_secure_token(16);
        $data = $time . '|' . $random;

        return base64_encode(openssl_encrypt(
            $data,
            'AES-256-CBC',
            wp_salt('auth'),
            0,
            substr(wp_salt('secure_auth'), 0, 16)
        ));
    }

    /**
     * Decrypt form token to get timestamp
     */
    private static function decrypt_token_time($token) {
        try {
            $decrypted = openssl_decrypt(
                base64_decode($token),
                'AES-256-CBC',
                wp_salt('auth'),
                0,
                substr(wp_salt('secure_auth'), 0, 16)
            );

            if ($decrypted) {
                $parts = explode('|', $decrypted);
                return (int) $parts[0];
            }
        } catch (Exception $e) {
            return null;
        }

        return null;
    }

    /**
     * Encrypt sensitive data
     */
    public static function encrypt($data) {
        return openssl_encrypt(
            $data,
            'AES-256-CBC',
            wp_salt('auth'),
            0,
            substr(wp_salt('secure_auth'), 0, 16)
        );
    }

    /**
     * Decrypt sensitive data
     */
    public static function decrypt($encrypted) {
        return openssl_decrypt(
            $encrypted,
            'AES-256-CBC',
            wp_salt('auth'),
            0,
            substr(wp_salt('secure_auth'), 0, 16)
        );
    }

    /**
     * Log security event
     */
    public static function log_security_event($event, $data = []) {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('Aakaari Security: ' . $event . ' - ' . json_encode($data));
        }

        // Also log to audit table
        self::log_audit($event, 'security', null, null, json_encode($data));
    }

    /**
     * Log to audit trail
     */
    public static function log_audit($action, $object_type = null, $object_id = null, $old_value = null, $new_value = null) {
        global $wpdb;
        $table = $wpdb->prefix . 'aakaari_audit_log';

        $wpdb->insert($table, [
            'user_id' => get_current_user_id() ?: null,
            'action' => $action,
            'object_type' => $object_type,
            'object_id' => $object_id,
            'old_value' => is_array($old_value) ? json_encode($old_value) : $old_value,
            'new_value' => is_array($new_value) ? json_encode($new_value) : $new_value,
            'ip_address' => self::get_client_ip(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'created_at' => current_time('mysql')
        ]);
    }

    /**
     * Verify request is from authorized admin
     */
    public static function verify_admin_request() {
        if (!current_user_can('manage_options') && !current_user_can('aakaari_agent')) {
            return false;
        }

        return true;
    }

    /**
     * Get user agent info
     */
    public static function get_user_agent_info() {
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';

        $device = 'desktop';
        if (preg_match('/Mobile|Android|iPhone|iPad/i', $ua)) {
            $device = preg_match('/iPad|Tablet/i', $ua) ? 'tablet' : 'mobile';
        }

        $browser = 'unknown';
        if (preg_match('/Chrome/i', $ua)) $browser = 'Chrome';
        elseif (preg_match('/Firefox/i', $ua)) $browser = 'Firefox';
        elseif (preg_match('/Safari/i', $ua)) $browser = 'Safari';
        elseif (preg_match('/Edge/i', $ua)) $browser = 'Edge';
        elseif (preg_match('/MSIE|Trident/i', $ua)) $browser = 'IE';

        return [
            'device_type' => $device,
            'browser' => $browser,
            'user_agent' => mb_substr($ua, 0, 500)
        ];
    }

    /**
     * Generate magic link token for customer portal
     */
    public static function generate_magic_link($email, $ticket_id = null) {
        $token = self::generate_secure_token(32);
        $expires = time() + (7 * 24 * 60 * 60); // 7 days

        $data = json_encode([
            'email' => $email,
            'ticket_id' => $ticket_id,
            'expires' => $expires,
            'token' => $token
        ]);

        $encrypted = self::encrypt($data);
        $hash = hash_hmac('sha256', $encrypted, wp_salt('auth'));

        set_transient('aakaari_magic_' . $token, $encrypted, 7 * DAY_IN_SECONDS);

        return $token;
    }

    /**
     * Verify magic link token
     */
    public static function verify_magic_link($token) {
        $encrypted = get_transient('aakaari_magic_' . $token);

        if (!$encrypted) {
            return false;
        }

        $decrypted = self::decrypt($encrypted);
        $data = json_decode($decrypted, true);

        if (!$data || $data['expires'] < time()) {
            delete_transient('aakaari_magic_' . $token);
            return false;
        }

        return $data;
    }
}
