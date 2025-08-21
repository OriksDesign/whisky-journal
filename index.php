<?php get_header(); ?>
<h1 class="text-3xl font-semibold mb-6">Блог</h1>
<?php if (have_posts()): ?>
  <div class="grid md:grid-cols-2 gap-6">
    <?php while (have_posts()): the_post(); ?>
      <article class="p-5 bg-white rounded-xl shadow-sm">
        <h2 class="text-xl font-semibold mb-2">
          <a href="<?php the_permalink(); ?>" class="hover:underline"><?php the_title(); ?></a>
        </h2>
        <div class="prose max-w-none"><?php the_excerpt(); ?></div>
      </article>
    <?php endwhile; ?>
  </div>
  <div class="mt-8"><?php the_posts_pagination(); ?></div>
<?php else: ?>
  <p>Поки немає записів.</p>
<?php endif; ?>
<?php get_footer(); ?>
