<?php
// Реєстрація таксономій
add_action('init', function () {
    register_taxonomy('region', 'whisky', [
        'label' => 'Region',
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
    ]);

    register_taxonomy('classification', 'whisky', [
        'label' => 'Classification',
        'public' => true,
        'hierarchical' => false,
        'show_in_rest' => true,
    ]);
});
