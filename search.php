<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$q = get_search_query();
?>
<main class="max-w-screen-xl mx-auto px-4 py-10">
  <h1 class="text-3xl font-bold mb-6">Пошук: “<?php echo esc_html($q); ?>”</h1>

  <?php if (have_posts()): ?>
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
      <?php while(have_posts()): the_post();
        if (get_post_type() === 'whisky') {
          get_template_part('template-parts/content','whisky-card');
        } else { ?>
          <article class="rounded-2xl border p-4 bg-white">
            <h3 class="font-semibold"><a class="hover:underline" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <p class="text-sm text-slate-600 mt-1"><?php echo wp_trim_words( get_the_excerpt(), 24 ); ?></p>
          </article>
        <?php } endwhile; ?>
    </div>
    <div class="mt-8"><?php the_posts_pagination(array('prev_text'=>'«','next_text'=>'»')); ?></div>
  <?php else: ?>
    <p>Нічого не знайдено. Спробуйте інший запит.</p>
  <?php endif; ?>
</main>
<?php get_footer(); ?>
