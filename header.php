<?php
$current_page = '';
if (is_front_page()) {
  $current_page = 'home';
} elseif (is_page('fix-an-issue')) {
  $current_page = 'fix-an-issue';
} elseif (is_page('maintenance')) {
  $current_page = 'maintenance';
} elseif (is_page('build-solutions')) {
  $current_page = 'build-solutions';
} elseif (is_page('blog') || is_home()) {
  $current_page = 'blog';
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <header class="aakaari-header fixed top-0 left-0 right-0 z-50 px-4 py-4">
      <div class="container mx-auto">
        <div data-header-shell class="relative bg-white/80 backdrop-blur-xl border border-gray-200 rounded-full transition-all duration-300 shadow-lg">
          <div class="relative flex items-center justify-between px-6 py-3">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center space-x-2 group">
              <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg shadow-blue-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles h-5 w-5 text-white"><path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"></path><path d="M20 3v4"></path><path d="M22 5h-4"></path><path d="M4 17v2"></path><path d="M5 18H3"></path></svg>
              </div>
              <span class="text-xl font-bold text-gray-900">Aakaari</span>
            </a>

            <nav class="hidden lg:flex items-center space-x-1">
              <a href="<?php echo esc_url(home_url('/')); ?>" class="px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-200 <?php echo $current_page === 'home' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50'; ?>">Home</a>
              <a href="<?php echo esc_url(home_url('/fix-an-issue/')); ?>" class="px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-200 <?php echo $current_page === 'fix-an-issue' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50'; ?>">Fix Issue</a>
              <a href="<?php echo esc_url(home_url('/maintenance/')); ?>" class="px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-200 <?php echo $current_page === 'maintenance' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50'; ?>">Maintenance</a>
              <a href="<?php echo esc_url(home_url('/build-solutions/')); ?>" class="px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-200 <?php echo $current_page === 'build-solutions' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50'; ?>">Build</a>
              <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-200 <?php echo $current_page === 'blog' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50'; ?>">Blog</a>
            </nav>

            <div class="hidden lg:flex items-center space-x-3">
              <a href="<?php echo esc_url(home_url('/login/')); ?>" class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-4 shrink-0 [&_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive hover:bg-accent dark:hover:bg-accent/50 h-9 px-4 py-2 has-[>svg]:px-3 rounded-full text-gray-600 hover:text-blue-600">Dashboard</a>
              <a href="<?php echo esc_url(home_url('/fix-an-issue/')); ?>" class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-4 shrink-0 [&_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive hover:bg-primary/90 h-9 px-4 py-2 has-[>svg]:px-3 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white shadow-lg shadow-blue-500/30">Get Started</a>
            </div>

            <button data-mobile-menu-toggle class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-4 shrink-0 [&_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/50 size-9 lg:hidden rounded-full text-gray-600" type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="aakaari-mobile-menu">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu h-5 w-5"><line x1="4" x2="20" y1="12" y2="12"></line><line x1="4" x2="20" y1="6" y2="6"></line><line x1="4" x2="20" y1="18" y2="18"></line></svg>
            </button>
          </div>
        </div>
      </div>
    </header>

    <div data-mobile-menu-overlay class="aakaari-sheet-overlay" aria-hidden="true"></div>
    <aside data-mobile-menu-panel class="aakaari-sheet" id="aakaari-mobile-menu" aria-hidden="true" aria-modal="true" role="dialog">
      <div class="aakaari-sheet-shell">
        <div class="aakaari-sheet-handle" aria-hidden="true"></div>
        <div class="aakaari-sheet-header">
          <div class="aakaari-sheet-brand">
            <span class="aakaari-sheet-logo">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles h-5 w-5 text-white"><path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"></path><path d="M20 3v4"></path><path d="M22 5h-4"></path><path d="M4 17v2"></path><path d="M5 18H3"></path></svg>
            </span>
            <div>
              <p class="aakaari-sheet-title">Menu</p>
              <p class="aakaari-sheet-subtitle">Navigate Aakaari</p>
            </div>
          </div>
          <button data-mobile-menu-close class="aakaari-sheet-close" type="button" aria-label="Close menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x h-5 w-5"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
          </button>
        </div>

        <nav class="aakaari-sheet-nav">
          <a href="<?php echo esc_url(home_url('/')); ?>" data-mobile-menu-close class="aakaari-sheet-link <?php echo $current_page === 'home' ? 'aakaari-sheet-link-active' : ''; ?>">
            <span>Home</span>
            <span class="aakaari-sheet-pill">Main</span>
          </a>
          <a href="<?php echo esc_url(home_url('/fix-an-issue/')); ?>" data-mobile-menu-close class="aakaari-sheet-link <?php echo $current_page === 'fix-an-issue' ? 'aakaari-sheet-link-active' : ''; ?>">
            <span>Fix Issue</span>
            <span class="aakaari-sheet-pill">Priority</span>
          </a>
          <a href="<?php echo esc_url(home_url('/maintenance/')); ?>" data-mobile-menu-close class="aakaari-sheet-link <?php echo $current_page === 'maintenance' ? 'aakaari-sheet-link-active' : ''; ?>">
            <span>Maintenance</span>
            <span class="aakaari-sheet-pill">Plans</span>
          </a>
          <a href="<?php echo esc_url(home_url('/build-solutions/')); ?>" data-mobile-menu-close class="aakaari-sheet-link <?php echo $current_page === 'build-solutions' ? 'aakaari-sheet-link-active' : ''; ?>">
            <span>Build</span>
            <span class="aakaari-sheet-pill">Projects</span>
          </a>
          <a href="<?php echo esc_url(home_url('/blog/')); ?>" data-mobile-menu-close class="aakaari-sheet-link <?php echo $current_page === 'blog' ? 'aakaari-sheet-link-active' : ''; ?>">
            <span>Blog</span>
            <span class="aakaari-sheet-pill">Tips</span>
          </a>
        </nav>

        <div class="aakaari-sheet-cta">
          <a href="<?php echo esc_url(home_url('/login/')); ?>" class="aakaari-sheet-secondary" data-mobile-menu-close>Dashboard</a>
          <a href="<?php echo esc_url(home_url('/fix-an-issue/')); ?>" class="aakaari-sheet-primary" data-mobile-menu-close>Get Started</a>
        </div>

        <div class="aakaari-sheet-footer">
          <p>Need help right now?</p>
          <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="aakaari-sheet-footer-link" data-mobile-menu-close>Contact support</a>
        </div>
      </div>
    </aside>
