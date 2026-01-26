<?php

if (!defined('ABSPATH')) {
    exit;
}

function aakaari_theme_setup(): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', [
        'height' => 32,
        'width' => 140,
        'flex-height' => true,
        'flex-width' => true,
    ]);

    register_nav_menus([
        'primary' => __('Header Menu', 'aakaari'),
    ]);
}
add_action('after_setup_theme', 'aakaari_theme_setup');

function aakaari_enqueue_assets(): void {
    $theme_version = wp_get_theme()->get('Version');

    wp_enqueue_style(
        'aakaari-main',
        get_template_directory_uri() . '/assets/css/main.css',
        [],
        $theme_version
    );

    if (is_page_template('page-fix-an-issue.php')) {
        wp_enqueue_style(
            'aakaari-fix-an-issue',
            get_template_directory_uri() . '/assets/css/fix-an-issue.css',
            ['aakaari-main'],
            $theme_version
        );
        wp_enqueue_script(
            'aakaari-fix-an-issue',
            get_template_directory_uri() . '/assets/js/fix-an-issue.js',
            [],
            $theme_version,
            true
        );
    }

    if (is_page_template('page-maintenance-plans.php')) {
        wp_enqueue_style(
            'aakaari-maintenance-fonts',
            'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap',
            [],
            null
        );
        wp_enqueue_style(
            'aakaari-maintenance-plans',
            get_template_directory_uri() . '/assets/css/maintenance-plans.css',
            ['aakaari-main', 'aakaari-maintenance-fonts'],
            $theme_version
        );
        wp_enqueue_script(
            'aakaari-maintenance-plans',
            get_template_directory_uri() . '/assets/js/maintenance-plans.js',
            [],
            $theme_version,
            true
        );
    }

    if (is_page_template('page-build-solutions.php')) {
        wp_enqueue_style(
            'aakaari-build-fonts',
            'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap',
            [],
            null
        );
        wp_enqueue_style(
            'aakaari-build-solutions',
            get_template_directory_uri() . '/assets/css/build-solutions.css',
            ['aakaari-main', 'aakaari-build-fonts'],
            $theme_version
        );
        wp_enqueue_script(
            'aakaari-build-solutions',
            get_template_directory_uri() . '/assets/js/build-solutions.js',
            [],
            $theme_version,
            true
        );
    }

    wp_enqueue_script(
        'aakaari-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        $theme_version,
        true
    );
}
add_action('wp_enqueue_scripts', 'aakaari_enqueue_assets');

function aakaari_create_required_pages(): void {
    $pages = [
        'plans' => [
            'title' => __('Maintenance Plans', 'aakaari'),
            'template' => 'page-maintenance-plans.php',
        ],
        'fix-an-issue' => [
            'title' => __('Fix an Issue', 'aakaari'),
            'template' => 'page-fix-an-issue.php',
        ],
        'build' => [
            'title' => __('Build Solutions', 'aakaari'),
            'template' => 'page-build-solutions.php',
        ],
    ];

    foreach ($pages as $slug => $page) {
        $existing = get_page_by_path($slug);
        if ($existing) {
            if ($page['template']) {
                update_post_meta($existing->ID, '_wp_page_template', $page['template']);
            }
            continue;
        }

        $page_id = wp_insert_post([
            'post_title' => $page['title'],
            'post_name' => $slug,
            'post_status' => 'publish',
            'post_type' => 'page',
        ]);

        if (!is_wp_error($page_id) && $page['template']) {
            update_post_meta($page_id, '_wp_page_template', $page['template']);
        }
    }
}
add_action('after_switch_theme', 'aakaari_create_required_pages');

function aakaari_get_issue_products(int $limit = 4): array {
    if (!class_exists('WooCommerce')) {
        return [];
    }

    $products = wc_get_products([
        'limit' => $limit,
        'status' => 'publish',
        'category' => ['issues'],
    ]);

    if (!empty($products)) {
        return $products;
    }

    $featured = wc_get_products([
        'limit' => $limit,
        'status' => 'publish',
        'featured' => true,
    ]);

    return $featured ?: [];
}
