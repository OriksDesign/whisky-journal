<?php
// Підключення стилів та скриптів
add_action('wp_enqueue_scripts', function () {
    $ver = filemtime(get_template_directory() . '/style.css');

    // Головний стиль (якщо є Tailwind build)
    wp_enqueue_style(
        'whisky-style',
        get_stylesheet_uri(),
        [],
        $ver
    );

    // Theme overrides (dark mode, картки, тощо)
    wp_enqueue_style(
        'whisky-theme',
        get_template_directory_uri() . '/assets/css/theme.css',
        ['whisky-style'],
        filemtime(get_template_directory() . '/assets/css/theme.css')
    );

    // Головний JS
    wp_enqueue_script(
        'whisky-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        filemtime(get_template_directory() . '/assets/js/main.js'),
        true
    );

    // Передаємо дані в JS
    wp_localize_script('whisky-main', 'WJ', [
        'themeUri' => get_stylesheet_directory_uri(),
    ]);
});
