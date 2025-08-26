<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>
<main class="max-w-screen-xl mx-auto px-4 py-20 text-center">
  <h1 class="text-5xl font-bold mb-4">404</h1>
  <p class="text-slate-600 mb-8">На жаль, сторінку не знайдено.</p>
  <a class="px-4 py-2 rounded bg-slate-900 text-white hover:bg-slate-700" href="<?php echo esc_url( home_url('/') ); ?>">На головну</a>
</main>
<?php get_footer(); ?>
