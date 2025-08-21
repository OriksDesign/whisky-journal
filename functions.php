<?php
/**
 * Whisky Journal 2025 – core theme setup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme setup
 */
add_action( 'after_setup_theme', function () {

	// Title tag, thumbnails, HTML5 etc.
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ] );

	// Image size for whisky cards
	add_image_size( 'whisky-card', 600, 600, true );
} );

/**
 * Enqueue styles (theme stylesheet + optional compiled CSS)
 */
add_action( 'wp_enqueue_scripts', function () {
	// theme root style.css
	wp_enqueue_style( 'whisky-journal-style', get_stylesheet_uri(), [], wp_get_theme()->get( 'Version' ) );

	// optional: compiled CSS if exists (assets/css/main.css)
	$built_css = get_stylesheet_directory() . '/assets/css/main.css';
	if ( file_exists( $built_css ) ) {
		wp_enqueue_style(
			'whisky-journal-main',
			get_stylesheet_directory_uri() . '/assets/css/main.css',
			[ 'whisky-journal-style' ],
			filemtime( $built_css )
		);
	}
} );

/**
 * Register Custom Post Type: whisky
 */
add_action( 'init', function () {

	$labels = [
		'name'               => __( 'Whiskies', 'whisky' ),
		'singular_name'      => __( 'Whisky', 'whisky' ),
		'add_new'            => __( 'Add New', 'whisky' ),
		'add_new_item'       => __( 'Add New Whisky', 'whisky' ),
		'edit_item'          => __( 'Edit Whisky', 'whisky' ),
		'new_item'           => __( 'New Whisky', 'whisky' ),
		'view_item'          => __( 'View Whisky', 'whisky' ),
		'search_items'       => __( 'Search Whiskies', 'whisky' ),
		'not_found'          => __( 'No whiskies found', 'whisky' ),
		'not_found_in_trash' => __( 'No whiskies found in Trash', 'whisky' ),
		'all_items'          => __( 'Whiskies', 'whisky' ),
		'menu_name'          => __( 'Whiskies', 'whisky' ),
	];

	$args = [
		'labels'             => $labels,
		'public'             => true,
		'show_in_rest'       => true,
		'has_archive'        => true,
		'rewrite'            => [ 'slug' => 'whisky', 'with_front' => false ],
		'menu_position'      => 20,
		'menu_icon'          => 'dashicons-awards',
		'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
	];

	register_post_type( 'whisky', $args );
} );

/**
 * Register taxonomies: region (hierarchical) & classification (hierarchical)
 */
add_action( 'init', function () {

	// Region
	register_taxonomy(
		'region',
		[ 'whisky' ],
		[
			'labels'       => [
				'name'          => __( 'Regions', 'whisky' ),
				'singular_name' => __( 'Region', 'whisky' ),
			],
			'hierarchical' => true,
			'show_ui'      => true,
			'show_in_rest' => true,
			'public'       => true,
			'rewrite'      => [ 'slug' => 'region', 'with_front' => false ],
		]
	);

	// Classification
	register_taxonomy(
		'classification',
		[ 'whisky' ],
		[
			'labels'       => [
				'name'          => __( 'Classification', 'whisky' ),
				'singular_name' => __( 'Class', 'whisky' ),
			],
			'hierarchical' => true,
			'show_ui'      => true,
			'show_in_rest' => true,
			'public'       => true,
			'rewrite'      => [ 'slug' => 'classification', 'with_front' => false ],
		]
	);
} );

/**
 * Archive: set posts per page (grid) & order
 */
add_action( 'pre_get_posts', function ( WP_Query $q ) {
	if ( is_admin() || ! $q->is_main_query() ) {
		return;
	}
	if ( $q->is_post_type_archive( 'whisky' ) ) {
		$q->set( 'posts_per_page', 9 );
		$q->set( 'orderby', 'title' );
		$q->set( 'order', 'ASC' );
	}
} );

/**
 * Меню: реєстрація локацій
 */
add_action('after_setup_theme', function () {
    register_nav_menus([
        'primary' => __('Primary Menu', 'whisky'),
        'footer'  => __('Footer Menu', 'whisky'),
    ]);
});

/**
 * Спрощений fallback, якщо меню не призначено
 */
function whisky_fallback_menu() {
    echo '<ul class="flex gap-6">';
    wp_list_pages([
        'title_li' => '',
        'depth'    => 1,
    ]);
    echo '</ul>';
}
/**
 * Додаємо Tailwind класи до активного пункту меню
 */
add_filter('nav_menu_css_class', function ($classes, $item) {
    if (in_array('current-menu-item', $classes, true) || in_array('current_page_item', $classes, true)) {
        $classes[] = 'text-amber-600 font-semibold underline';
    } else {
        $classes[] = 'text-gray-700 hover:text-amber-600 transition';
    }
    return $classes;
}, 10, 2);


/**
 * Mini helpers – safely get ACF/meta values
 */
if ( ! function_exists( 'wj_get_number_meta' ) ) {
	function wj_get_number_meta( $post_id, $key ) {
		// Prefer ACF if available
		if ( function_exists( 'get_field' ) ) {
			$val = get_field( $key, $post_id );
			if ( $val !== null && $val !== '' ) {
				return $val;
			}
		}
		$val = get_post_meta( $post_id, $key, true );
		return $val !== '' ? $val : null;
	}
}

/**
 * Template tag: render taxonomy list as comma separated terms
 */
if ( ! function_exists( 'wj_terms_list' ) ) {
	function wj_terms_list( $post_id, $taxonomy ) {
		$terms = get_the_terms( $post_id, $taxonomy );
		if ( ! $terms || is_wp_error( $terms ) ) {
			return '';
		}
		return esc_html( join( ', ', wp_list_pluck( $terms, 'name' ) ) );
	}
}
