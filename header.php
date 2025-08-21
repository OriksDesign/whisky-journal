<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width,initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class('bg-[#f4f0e8] text-gray-900'); ?>>
<header class="border-b border-gray-200 bg-white">
  <div class="max-w-screen-xl mx-auto px-4 py-4 flex items-center justify-between">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="text-xl font-semibold">
      <?php bloginfo('name'); ?>
    </a>

    <nav aria-label="Primary">
      <?php
      wp_nav_menu([
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => 'flex gap-6',
          'fallback_cb'    => 'whisky_fallback_menu',
          'link_before'    => '<span class="hover:underline">',
          'link_after'     => '</span>',
      ]);
      ?>
    </nav>
  </div>
</header>
<main class="max-w-screen-xl mx-auto px-4 py-10">

