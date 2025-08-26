<?php
/**
 * Template: Archive – Whiskies
 * URL: /whisky/
 */

get_header();
?>

<main class="max-w-screen-xl mx-auto px-4 py-8">

  <!-- Sub-hero над фільтрами -->
  <section class="relative overflow-hidden rounded-2xl bg-[#f4eade] dark:bg-slate-800/40 mb-6">
    <div class="p-6 md:p-8">
      <h1 class="text-2xl md:text-3xl font-bold tracking-tight">Whiskies</h1>
      <p class="mt-2 text-slate-700 dark:text-slate-200">
        Каталог віскі з фільтрами за регіонами, класифікаціями, віком та міцністю.
      </p>
      <div class="mt-4 flex gap-3">
        <a href="<?php echo esc_url( home_url('/') ); ?>"
           class="inline-flex items-center gap-2 rounded-xl border border-slate-300 px-4 py-2 hover:bg-slate-50 dark:border-slate-600 dark:hover:bg-slate-700 transition">
          На головну
        </a>
        <a href="<?php echo esc_url( home_url('/whisky/') ); ?>"
           class="inline-flex items-center gap-2 rounded-xl bg-slate-900 text-white px-4 py-2 hover:bg-slate-700 transition">
          Оновити каталог
        </a>
      </div>
    </div>
  </section>

  <?php
  /**
   * ФІЛЬТРИ
   * Якщо маєш власну форму у цьому файлі — залиш її.
   * Якщо винесено в окремий файл, розкоментуй наступний рядок і створи template-part:
   * /template-parts/whisky-filters.php
   */
  // get_template_part( 'template-parts/whisky', 'filters' );
  ?>

  <!-- Грід карток -->
  <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">

    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
        <?php
        // Картка віскі (наш оновлений файл)
        get_template_part( 'template-parts/content', 'whisky-card' );
        ?>
      <?php endwhile; ?>
    <?php else : ?>
      <p class="text-slate-600">Нічого не знайдено. Змініть фільтри або спробуйте інший запит.</p>
    <?php endif; ?>

  </div>

  <!-- Пагінація -->
  <div class="mt-8">
    <?php
    the_posts_pagination([
      'mid_size'  => 1,
      'prev_text' => '«',
      'next_text' => '»',
      'screen_reader_text' => '',
      'class' => 'flex items-center gap-2',
    ]);
    ?>
  </div>

</main>

<?php
get_footer();
