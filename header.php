<?php
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
    <div class="container header-inner">
        <div class="site-brand">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a class="site-title" href="<?php echo esc_url(home_url('/')); ?>">aakaari</a>
            <?php endif; ?>
        </div>
        <button class="nav-toggle" type="button" aria-controls="header-collapse" aria-expanded="false">
            <span class="nav-toggle-bars" aria-hidden="true">
                <span></span>
                <span></span>
                <span></span>
            </span>
            <span class="sr-only">Menu</span>
        </button>
        <div class="header-collapse" id="header-collapse">
            <nav class="site-nav">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'nav-list',
                    'fallback_cb' => function () {
                        echo '<ul class="nav-list">';
                        echo '<li><a href="' . esc_url(home_url('/fix-an-issue/')) . '">Fix an Issue</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/plans/')) . '">Maintenance Plans</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/build/')) . '">Build Solutions</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/knowledge-base/')) . '">Knowledge Base</a></li>';
                        echo '</ul>';
                    },
                ]);
                ?>
            </nav>
            <div class="header-actions">
                <a class="text-link" href="<?php echo esc_url(home_url('/account/')); ?>">Sign in</a>
                <a class="btn btn-primary" href="<?php echo esc_url(home_url('/fix-an-issue/')); ?>">Fix an Issue</a>
            </div>
        </div>
    </div>
</header>
<main class="site-main">
