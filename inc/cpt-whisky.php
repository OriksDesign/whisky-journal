<?php
// Реєстрація кастомного типу запису Whisky
add_action('init', function () {
    register_post_type('whisky', [
        'labels' => [
            'name' => 'Whisky',
            'singular_name' => 'Whisky',
        ],
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-beer',
        'supports' => ['title', 'editor', 'thumbnail'],
        'rewrite' => ['slug' => 'whisky'],
        'show_in_rest' => true,
    ]);
});
