<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();

$term = get_queried_object();
$paged = max(1, get_query_var('paged'));

$q = new WP_Query(array(
  'post_type' => 'whisky',
  'paged'     => $paged,
  'tax_query' => array(array(
    'taxonomy' => 'region',
    'field'    => 'term_id',
    'terms'    => $term->term_id,
  )),
  'posts_per_page' => 12,
));
?>
<main class="max-w-screen-xl mx-auto px-4 py-10">
  <?php get_template_part('template-parts/breadcrumbs'); ?>

  <header class="mb-6">
    <h1 class="text-3xl font-bold"><?php echo esc_html($term->name); ?></h1>
    <?php if (!empty($term->description)): ?>
      <p class="mt-2 text-slate-700"><?php echo esc_html($term->description); ?></p>
    <?php endif; ?>
  </header>

  <?php if ($q->have_posts()): ?>
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
      <?php while($q->have_posts()): $q->the_post();
        get_template_part('template-parts/content','whisky-card');
      endwhile; ?>
    </div>
    <div class="mt-8">
      <?php echo paginate_links(array(
        'total' => $q->max_num_pages,
        'current' => $paged,
        'prev_text' => '«',
        'next_text' => '»',
      )); ?>
    </div>
  <?php else: ?>
    <p>У цьому регіоні записів ще немає.</p>
  <?php endif; wp_reset_postdata(); ?>
</main>
<?php get_footer(); ?>
