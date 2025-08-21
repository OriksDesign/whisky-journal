<?php
/**
 * Single Whisky
 * Path: wp-content/themes/whisky-journal-2025/single-whisky.php
 */

get_header();

while ( have_posts() ) : the_post();

$id = get_the_ID();

/** ACF (працює і без ACF — просто порожні значення) */
$acf = function_exists('get_field');
$abv        = $acf ? get_field('abv') : '';
$age        = $acf ? get_field('age') : '';
$cask       = $acf ? get_field('cask') : '';
$volume     = $acf ? get_field('volume') : '';
$tasting    = $acf ? get_field('tasting_notes') : '';
$gallery    = $acf ? (array) get_field('gallery') : []; // масив зображень (id/url)

/** Таксономії */
$regions         = wp_get_post_terms( $id, 'region', ['fields' => 'all'] );
$classifications = wp_get_post_terms( $id, 'classification', ['fields' => 'all'] );
?>

<main id="primary" class="site-main">
  <article <?php post_class('max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-10'); ?>>

    <!-- Header -->
    <header class="mb-8">
      <nav class="text-sm mb-3">
        <a href="<?php echo esc_url( get_post_type_archive_link('whisky') ); ?>" class="hover:underline">Каталог</a>
        <span class="mx-1 opacity-60">/</span>
        <span class="opacity-80"><?php the_title(); ?></span>
      </nav>

      <h1 class="text-3xl sm:text-4xl font-semibold"><?php the_title(); ?></h1>

      <?php if ( $regions || $classifications ) : ?>
        <div class="mt-3 flex flex-wrap gap-2 text-sm">
          <?php foreach ($regions as $t) : ?>
            <a class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-900"
               href="<?php echo esc_url( get_term_link($t) ); ?>"><?php echo esc_html($t->name); ?></a>
          <?php endforeach; ?>
          <?php foreach ($classifications as $t) : ?>
            <a class="px-2.5 py-1 rounded-full bg-stone-100 text-stone-900"
               href="<?php echo esc_url( get_term_link($t) ); ?>"><?php echo esc_html($t->name); ?></a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </header>

    <!-- Content grid -->
    <div class="grid md:grid-cols-2 gap-8 items-start">

      <!-- Images -->
      <section>
        <?php if ( has_post_thumbnail() ) : ?>
          <figure class="mb-4 overflow-hidden rounded-xl bg-white shadow">
            <?php the_post_thumbnail( 'large', [
              'class' => 'w-full h-auto object-contain',
              'alt'   => esc_attr( get_the_title() ),
            ] ); ?>
          </figure>
        <?php endif; ?>

        <?php if ( !empty($gallery) ) : ?>
          <div class="grid grid-cols-4 gap-3">
            <?php foreach ( $gallery as $img ) :
              $src = is_array($img) ? ($img['sizes']['medium'] ?? $img['url']) : wp_get_attachment_image_url($img, 'medium');
              $full = is_array($img) ? $img['url'] : wp_get_attachment_image_url($img, 'full');
            ?>
              <a href="<?php echo esc_url($full); ?>"
                 class="block aspect-square overflow-hidden rounded-lg bg-white shadow"
                 data-lightbox="whisky">
                <img src="<?php echo esc_url($src); ?>" alt="" class="w-full h-full object-cover">
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </section>

      <!-- Specs & content -->
      <section>
        <div class="grid grid-cols-2 gap-4 mb-6">
          <?php if ($abv !== '') : ?>
            <div class="rounded-lg bg-stone-100 p-4">
              <div class="text-stone-500 text-xs uppercase">Міцність</div>
              <div class="text-xl font-semibold"><?php echo esc_html( rtrim($abv, '%') ); ?>%</div>
            </div>
          <?php endif; ?>

          <?php if ($age !== '') : ?>
            <div class="rounded-lg bg-stone-100 p-4">
              <div class="text-stone-500 text-xs uppercase">Вік</div>
              <div class="text-xl font-semibold"><?php echo esc_html( $age ); ?></div>
            </div>
          <?php endif; ?>

          <?php if ($cask !== '') : ?>
            <div class="rounded-lg bg-stone-100 p-4">
              <div class="text-stone-500 text-xs uppercase">Бочка</div>
              <div class="font-medium"><?php echo esc_html( $cask ); ?></div>
            </div>
          <?php endif; ?>

          <?php if ($volume !== '') : ?>
            <div class="rounded-lg bg-stone-100 p-4">
              <div class="text-stone-500 text-xs uppercase">Об’єм</div>
              <div class="font-medium"><?php echo esc_html( $volume ); ?></div>
            </div>
          <?php endif; ?>
        </div>

        <div class="prose max-w-none">
          <?php the_content(); ?>
        </div>

        <?php if ($tasting !== '') : ?>
          <div class="mt-6 p-5 rounded-xl border border-amber-200 bg-amber-50">
            <div class="text-amber-900 font-medium mb-1">Ноти дегустації</div>
            <p class="text-amber-900/90"><?php echo esc_html( $tasting ); ?></p>
          </div>
        <?php endif; ?>
      </section>
    </div>

    <!-- Related -->
    <?php
    $related_ids = [];
    if ( $regions )         $related_ids = array_merge( $related_ids, wp_list_pluck($regions, 'term_id') );
    if ( $classifications ) $related_ids = array_merge( $related_ids, wp_list_pluck($classifications, 'term_id') );

    if ( $related_ids ) :
      $rel = new WP_Query([
        'post_type'      => 'whisky',
        'posts_per_page' => 3,
        'post__not_in'   => [$id],
        'tax_query'      => [
          'relation' => 'OR',
          [
            'taxonomy' => 'region',
            'field'    => 'term_id',
            'terms'    => wp_list_pluck($regions, 'term_id'),
          ],
          [
            'taxonomy' => 'classification',
            'field'    => 'term_id',
            'terms'    => wp_list_pluck($classifications, 'term_id'),
          ],
        ],
      ]);
      if ( $rel->have_posts() ) : ?>
        <section class="mt-12">
          <h2 class="text-xl font-semibold mb-4">Схожі віскі</h2>
          <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            while ( $rel->have_posts() ) : $rel->the_post();
              get_template_part('template-parts/content', 'whisky-card');
            endwhile;
            wp_reset_postdata();
            ?>
          </div>
        </section>
      <?php endif; wp_reset_postdata();
    endif; ?>

    <!-- Prev/Next -->
    <nav class="mt-10 flex justify-between text-sm">
      <div><?php previous_post_link('%link','← %title', true, '', 'whisky'); ?></div>
      <div><?php next_post_link('%link','%title →', true, '', 'whisky'); ?></div>
    </nav>
  </article>
</main>

<?php endwhile; get_footer();
