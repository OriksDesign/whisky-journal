<?php
/** Header */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <?php wp_head(); ?>
</head>
<body <?php body_class('bg-[#fdeee2] text-slate-900 antialiased'); ?>>

<header class="sticky top-0 z-50 supports-[backdrop-filter]:bg-white/60 bg-white/90 backdrop-blur border-b border-slate-200/60">
  <div class="max-w-screen-xl mx-auto px-4 h-16 flex items-center justify-between">
    <a href="<?php echo esc_url( home_url('/') ); ?>" class="flex items-center gap-3 shrink-0 group">
      <img
        src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/logo-whisky-journal.svg' ); ?>"
        alt="<?php bloginfo('name'); ?>"
        width="140" height="26"
        class="h-6 w-auto"
      />
      <span class="sr-only"><?php bloginfo('name'); ?></span>
    </a>

    <nav id="siteNav" class="hidden md:flex items-center gap-6">
      <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'flex items-center gap-6',
        'fallback_cb'    => '__return_empty_string',
        'link_before'    => '<span class="hover:underline underline-offset-4 decoration-2 decoration-slate-300">',
        'link_after'     => '</span>',
      ]);
      ?>
    </nav>

    <div class="flex items-center gap-3">
      <button id="themeToggle"
              class="inline-flex md:mr-2 items-center justify-center w-9 h-9 rounded-lg border border-slate-300 hover:bg-slate-50 transition"
              aria-label="Toggle theme">🌙</button>

      <button id="navToggle"
              class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg border border-slate-300"
              aria-controls="drawer" aria-expanded="false" aria-label="Toggle menu">
        ☰
      </button>
    </div>
  </div>

  <!-- Mobile drawer -->
  <div id="drawer" class="md:hidden hidden border-t border-slate-200 bg-white/95 backdrop-blur">
    <div class="max-w-screen-xl mx-auto px-4 py-3">
      <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'flex flex-col gap-3',
        'fallback_cb'    => '__return_empty_string',
        'link_before'    => '<span class="py-2 inline-block hover:underline">',
        'link_after'     => '</span>',
      ]);
      ?>
    </div>
  </div>
</header>

<main class="max-w-screen-xl mx-auto px-4 py-10">
