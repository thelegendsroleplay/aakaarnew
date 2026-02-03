<?php
get_header();
?>
<main class="pt-32 pb-20 px-4">
  <div class="container mx-auto max-w-4xl">
    <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
        <article class="mb-12">
          <h2 class="text-3xl font-bold mb-4 text-gray-900">
            <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors"><?php the_title(); ?></a>
          </h2>
          <div class="text-gray-700 space-y-4">
            <?php the_excerpt(); ?>
          </div>
        </article>
      <?php endwhile; ?>
      <div class="mt-10">
        <?php the_posts_pagination(); ?>
      </div>
    <?php else : ?>
      <p class="text-gray-600">No content found.</p>
    <?php endif; ?>
  </div>
</main>
<?php
get_footer();
?>
