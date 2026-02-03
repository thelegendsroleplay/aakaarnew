<?php

function aakaari_theme_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('woocommerce');
  add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));

  register_nav_menus(
    array(
      'primary' => __('Primary Menu', 'aakaari'),
    )
  );
}
add_action('after_setup_theme', 'aakaari_theme_setup');

function aakaari_enqueue_assets() {
  $theme_dir = get_template_directory();
  $theme_uri = get_template_directory_uri();

  $css_path = $theme_dir . '/assets/css/aakaari.css';
  $css_ver = file_exists($css_path) ? filemtime($css_path) : null;
  wp_enqueue_style('aakaari-base', $theme_uri . '/assets/css/aakaari.css', array(), $css_ver);

  $style_path = get_stylesheet_directory() . '/style.css';
  $style_ver = file_exists($style_path) ? filemtime($style_path) : null;
  wp_enqueue_style('aakaari-theme', get_stylesheet_uri(), array('aakaari-base'), $style_ver);

  $js_path = $theme_dir . '/assets/js/theme.js';
  $js_ver = file_exists($js_path) ? filemtime($js_path) : null;
  wp_enqueue_script('aakaari-theme', $theme_uri . '/assets/js/theme.js', array(), $js_ver, true);
}
add_action('wp_enqueue_scripts', 'aakaari_enqueue_assets');

function aakaari_get_required_pages() {
  return array(
    'home' => array(
      'title' => 'Home',
      'slug' => 'home',
    ),
    'fix-an-issue' => array(
      'title' => 'Fix an Issue',
      'slug' => 'fix-an-issue',
    ),
    'maintenance' => array(
      'title' => 'Maintenance',
      'slug' => 'maintenance',
    ),
    'build-solutions' => array(
      'title' => 'Build Solutions',
      'slug' => 'build-solutions',
    ),
    'blog' => array(
      'title' => 'Blog',
      'slug' => 'blog',
    ),
    'contact' => array(
      'title' => 'Contact',
      'slug' => 'contact',
    ),
    'login' => array(
      'title' => 'Login',
      'slug' => 'login',
    ),
    'checkout' => array(
      'title' => 'Checkout',
      'slug' => 'checkout',
    ),
    'client-dashboard' => array(
      'title' => 'Client Dashboard',
      'slug' => 'client-dashboard',
    ),
    'admin-dashboard' => array(
      'title' => 'Admin Dashboard',
      'slug' => 'admin-dashboard',
    ),
  );
}

function aakaari_find_page_by_slug($slug) {
  $pages = get_posts(
    array(
      'post_type' => 'page',
      'name' => $slug,
      'post_status' => array('publish', 'draft', 'private'),
      'numberposts' => 1,
    )
  );

  if (empty($pages)) {
    return null;
  }

  return $pages[0];
}

function aakaari_create_required_pages() {
  $pages = aakaari_get_required_pages();
  $created = array();

  foreach ($pages as $key => $page) {
    $existing = aakaari_find_page_by_slug($page['slug']);
    if ($existing) {
      $created[$key] = $existing->ID;
      continue;
    }

    $page_id = wp_insert_post(
      array(
        'post_title' => $page['title'],
        'post_name' => $page['slug'],
        'post_status' => 'publish',
        'post_type' => 'page',
        'post_content' => '',
      )
    );

    if (!is_wp_error($page_id)) {
      update_post_meta($page_id, '_aakaari_auto_created', '1');
      $created[$key] = $page_id;
    }
  }

  return $created;
}

function aakaari_set_front_and_posts_pages($page_ids) {
  if (!empty($page_ids['home'])) {
    $front_id = (int) get_option('page_on_front');
    $show_front = get_option('show_on_front');
    if ($show_front !== 'page' || $front_id === 0 || !get_post($front_id)) {
      update_option('show_on_front', 'page');
      update_option('page_on_front', (int) $page_ids['home']);
    }
  }

  if (!empty($page_ids['blog'])) {
    $posts_id = (int) get_option('page_for_posts');
    if ($posts_id === 0 || !get_post($posts_id)) {
      update_option('page_for_posts', (int) $page_ids['blog']);
    }
  }
}

function aakaari_on_theme_activation() {
  $page_ids = aakaari_create_required_pages();
  aakaari_set_front_and_posts_pages($page_ids);
  flush_rewrite_rules();
}
add_action('after_switch_theme', 'aakaari_on_theme_activation');

function aakaari_get_required_plugins() {
  return array(
    array(
      'name' => 'WooCommerce',
      'slug' => 'woocommerce',
      'file' => 'woocommerce/woocommerce.php',
      'required' => true,
    ),
  );
}

function aakaari_get_plugin_status($plugin) {
  $plugin_path = WP_PLUGIN_DIR . '/' . $plugin['file'];
  $is_installed = file_exists($plugin_path);

  if (!function_exists('is_plugin_active')) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
  }

  $is_active = $is_installed && is_plugin_active($plugin['file']);

  if ($is_active) {
    return 'active';
  }

  if ($is_installed) {
    return 'inactive';
  }

  return 'not_installed';
}

function aakaari_required_plugins_notice() {
  if (!current_user_can('install_plugins') && !current_user_can('activate_plugins')) {
    return;
  }

  $plugins = aakaari_get_required_plugins();
  $missing = array();

  foreach ($plugins as $plugin) {
    if (!empty($plugin['required']) && aakaari_get_plugin_status($plugin) !== 'active') {
      $missing[] = $plugin;
    }
  }

  if (empty($missing)) {
    return;
  }

  $message = 'Aakaari requires the following plugin' . (count($missing) > 1 ? 's' : '') . ' to be installed and active:';
  echo '<div class="notice notice-warning"><p><strong>' . esc_html($message) . '</strong></p><ul style="margin-left: 18px; list-style: disc;">';

  foreach ($missing as $plugin) {
    $status = aakaari_get_plugin_status($plugin);
    $action = '';

    if ($status === 'not_installed' && current_user_can('install_plugins')) {
      $install_url = wp_nonce_url(
        admin_url('update.php?action=install-plugin&plugin=' . $plugin['slug']),
        'install-plugin_' . $plugin['slug']
      );
      $action = '<a class="button button-primary" href="' . esc_url($install_url) . '">Install</a>';
    } elseif ($status === 'inactive' && current_user_can('activate_plugins')) {
      $activate_url = wp_nonce_url(
        admin_url('plugins.php?action=activate&plugin=' . $plugin['file']),
        'activate-plugin_' . $plugin['file']
      );
      $action = '<a class="button button-primary" href="' . esc_url($activate_url) . '">Activate</a>';
    } else {
      $action = '<span class="button disabled">Required</span>';
    }

    echo '<li><strong>' . esc_html($plugin['name']) . '</strong> ' . $action . '</li>';
  }

  echo '</ul></div>';
}
add_action('admin_notices', 'aakaari_required_plugins_notice');

