<?php
// Базові налаштування теми
add_action('after_setup_theme', function () {
    // Тайтл у <head>
    add_theme_support('title-tag');

    // Мініатюри
    add_theme_support('post-thumbnails');
    // Розміри для картки та героя (без кропу)
    add_image_size('wj_hero', 1600, 1200, false); // single
    add_image_size('wj_card', 800, 800, false);   // картка у списках (якщо захочеш)


    // Меню
    register_nav_menus([
        'primary' => __('Primary Menu', 'whisky'),
        'footer'  => __('Footer Menu', 'whisky'),
    ]);

    // HTML5 розмітка
    add_theme_support('html5', ['search-form', 'gallery', 'caption']);
});
