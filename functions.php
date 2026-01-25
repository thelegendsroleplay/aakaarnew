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
            'aakaari-maintenance-plans',
            get_template_directory_uri() . '/assets/css/maintenance-plans.css',
            ['aakaari-main'],
            $theme_version
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
