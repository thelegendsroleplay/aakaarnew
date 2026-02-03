<?php
get_header();
?>
<main class="pt-32 pb-20 px-4">
  <div class="container mx-auto max-w-4xl">
    <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
        <h1 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900"><?php the_title(); ?></h1>
        <div class="space-y-6 text-gray-700">
          <?php the_content(); ?>
        </div>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</main>
<?php
get_footer();
?>
