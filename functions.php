<?php
/**
 * Whisky Journal Theme functions
 */

// Папка для інклюдів
$wj_inc = get_template_directory() . '/inc';

// Підключаємо модулі
require_once $wj_inc . '/setup.php';
require_once $wj_inc . '/enqueue.php';
require_once $wj_inc . '/cpt-whisky.php';
require_once $wj_inc . '/taxonomies.php';
require_once $wj_inc . '/customizer-home.php';