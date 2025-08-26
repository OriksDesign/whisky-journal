<?php
/**
 * Template: Головна сторінка
 */

get_header();

/**
 * Helper: дістаємо URL для hero-зображення.
 * Customizer Image Control зберігає ID — перетворимо в URL.
 */
$hero_image_id  = (int) get_theme_mod('wj_hero_image', 0);
$hero_image_url = $hero_image_id ? wp_get_attachment_image_url($hero_image_id, 'full') : '';

$hero_title     = get_theme_mod('wj_hero_title', 'Whisky Journal');
$hero_subtitle  = get_theme_mod('wj_hero_subtitle', 'Колекція віскі з фільтрами за регіонами, класифікаціями, віком та міцністю. Додавайте свої улюблені й відкривайте нові.');
$hero_cta_text  = get_theme_mod('wj_hero_cta_text', 'Перейти до каталогу');
$hero_cta_url   = get_theme_mod('wj_hero_cta_url', home_url('/whisky/'));
$yt_url         = trim( (string) get_theme_mod('wj_home_youtube', '') );

/**
 * Парсимо YouTube ID (підтримка різних форматів посилань).
 */
$yt_id = '';
if ( $yt_url ) {
  if ( preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|shorts/))([\w\-]{6,})~i', $yt_url, $m) ) {
    $yt_id = $m[1];
  }
}
?>

<main class="max-w-screen-xl mx-auto px-4">

  <!-- HERO -->
  <section class="relative overflow-hidden rounded-3xl bg-slate-900/5 dark:bg-slate-700/10 mt-6">
    <?php if ( $hero_image_url ) : ?>
      <div class="absolute inset-0">
        <img src="<?php echo esc_url($hero_image_url); ?>"
             alt=""
             class="w-full h-full object-cover opacity-20"
             loading="lazy" decoding="async">
        <div class="absolute inset-0 bg-gradient-to-tr from-black/50 via-transparent to-black/20"></div>
      </div>
    <?php endif; ?>

    <div class="relative p-8 md:p-12 lg:p-16 flex flex-col gap-6">
      <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white">
        <?php echo esc_html($hero_title); ?>
      </h1>

      <?php if ( $hero_subtitle ) : ?>
        <p class="max-w-3xl text-slate-700 dark:text-slate-200 text-base md:text-lg">
          <?php echo wp_kses_post($hero_subtitle); ?>
        </p>
      <?php endif; ?>

      <div class="flex items-center gap-3">
        <a href="<?php echo esc_url($hero_cta_url); ?>"
           class="inline-flex items-center gap-2 rounded-xl bg-slate-900 text-white hover:bg-slate-700 px-5 py-3 transition">
          <?php echo esc_html($hero_cta_text); ?>
          <span aria-hidden="true">→</span>
        </a>

        <a href="<?php echo esc_url( home_url('/whisky/') ); ?>"
           class="inline-flex items-center gap-2 rounded-xl border border-slate-300 hover:bg-slate-50 dark:border-slate-600 dark:hover:bg-slate-800 px-4 py-3 transition">
          Каталог
        </a>
      </div>
    </div>
  </section>

  <?php if ( $yt_id ) : ?>
    <!-- YouTube (responsive 16:9) -->
    <section class="mt-10">
      <div class="aspect-video rounded-2xl overflow-hidden shadow-sm border border-slate-200 dark:border-slate-700 bg-black">
        <iframe
          src="https://www.youtube-nocookie.com/embed/<?php echo esc_attr($yt_id); ?>?rel=0"
          title="YouTube video"
          loading="lazy"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          allowfullscreen
          class="w-full h-full">
        </iframe>
      </div>
    </section>
  <?php endif; ?>

  <!-- Останні додані (Whisky) -->
  <section class="mt-12">
    <h2 class="text-xl font-semibold mb-4">Останні додані</h2>
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
      <?php
      $q = new WP_Query([
        'post_type'      => 'whisky',
        'posts_per_page' => 6,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
      ]);
      if ( $q->have_posts() ) :
        while ( $q->have_posts() ) : $q->the_post();
          get_template_part('template-parts/content', 'whisky-card');
        endwhile;
        wp_reset_postdata();
      else :
        echo '<p class="text-slate-600">Поки що немає записів.</p>';
      endif;
      ?>
    </div>

    <div class="mt-6">
      <a class="inline-block px-4 py-2 rounded-xl border border-slate-300 hover:bg-slate-50 dark:border-slate-600 dark:hover:bg-slate-800 transition"
         href="<?php echo esc_url( home_url('/whisky/') ); ?>">
        Весь каталог
      </a>
    </div>
  </section>

  <!-- Останні новини (блог) -->
  <section class="mt-14">
    <h2 class="text-xl font-semibold mb-4">Останні новини</h2>
    <div class="grid gap-6 md:grid-cols-3">
      <?php
      $news = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => 3,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
      ]);
      if ( $news->have_posts() ) :
        while ( $news->have_posts() ) : $news->the_post();
          ?>
          <article class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm overflow-hidden hover:shadow-md transition">
            <a href="<?php the_permalink(); ?>" class="block">
              <div class="aspect-[16/9] bg-slate-100 dark:bg-slate-800 flex items-center justify-center overflow-hidden">
                <?php if ( has_post_thumbnail() ) : ?>
                  <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover', 'loading' => 'lazy']); ?>
                <?php else : ?>
                  <span class="text-slate-400">No image</span>
                <?php endif; ?>
              </div>
            </a>
            <div class="p-4">
              <h3 class="font-semibold text-slate-900 dark:text-white leading-tight">
                <a href="<?php the_permalink(); ?>" class="hover:underline"><?php the_title(); ?></a>
              </h3>
              <p class="mt-1 text-sm text-slate-600 dark:text-slate-300 line-clamp-3">
                <?php echo esc_html( wp_strip_all_tags( get_the_excerpt(), true ) ); ?>
              </p>
              <a href="<?php the_permalink(); ?>" class="mt-3 inline-block rounded-md border border-slate-300 dark:border-slate-600 px-3 py-1 text-xs hover:bg-slate-50 dark:hover:bg-slate-800">
                Читати
              </a>
            </div>
          </article>
          <?php
        endwhile;
        wp_reset_postdata();
      else :
        echo '<p class="text-slate-600">Немає нових записів.</p>';
      endif;
      ?>
    </div>
  </section>

</main>

<?php get_footer(); ?>
