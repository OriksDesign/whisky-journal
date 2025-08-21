<?php
get_header();

// Hero
?>
<section class="mb-10">
  <div class="rounded-2xl bg-white p-8 shadow-sm">
    <h1 class="text-3xl font-semibold">Whisky Journal</h1>
    <p class="mt-3 text-gray-600">
      Колекція віскі з фільтрами за регіонами, класифікаціями, віком та міцністю.
    </p>
    <div class="mt-5">
      <a href="<?php echo esc_url( get_post_type_archive_link('whisky') ); ?>"
         class="inline-block rounded-xl border border-gray-300 px-4 py-2 hover:bg-gray-50">
        Перейти до каталогу
      </a>
    </div>
  </div>
</section>

<?php
// Останні 6 віскі
$q = new WP_Query([
    'post_type'      => 'whisky',
    'posts_per_page' => 6,
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

if ( $q->have_posts() ) : ?>
  <section>
    <h2 class="text-2xl font-semibold mb-6">Останні додані</h2>
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <?php
      while ( $q->have_posts() ) : $q->the_post();
        get_template_part('template-parts/content', 'whisky-card');
      endwhile;
      wp_reset_postdata();
      ?>
    </div>
  </section>
<?php else : ?>
  <p>Поки немає елементів.</p>
<?php endif;

get_footer();
