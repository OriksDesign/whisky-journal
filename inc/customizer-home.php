<?php
/**
 * Customizer: налаштування головної (Hero + YouTube)
 */

add_action('customize_register', function ($wp_customize) {

  $wp_customize->add_section('wj_home', [
    'title'       => __('Головна сторінка', 'whisky'),
    'priority'    => 30,
    'description' => __('Тексти/кнопки для Hero та YouTube-блок на головній', 'whisky'),
  ]);

  // Hero: заголовок
  $wp_customize->add_setting('wj_hero_title', [
    'default'           => 'Whisky Journal',
    'sanitize_callback' => 'sanitize_text_field',
  ]);
  $wp_customize->add_control('wj_hero_title', [
    'label'   => __('Hero: Заголовок', 'whisky'),
    'section' => 'wj_home',
    'type'    => 'text',
  ]);

  // Hero: підзаголовок
  $wp_customize->add_setting('wj_hero_subtitle', [
    'default'           => 'Колекція віскі з фільтрами за регіонами, класифікаціями, віком та міцністю. Додавайте свої улюблені й відкривайте нові.',
    'sanitize_callback' => 'wp_kses_post',
  ]);
  $wp_customize->add_control('wj_hero_subtitle', [
    'label'   => __('Hero: Підзаголовок', 'whisky'),
    'section' => 'wj_home',
    'type'    => 'textarea',
  ]);

  // Hero: текст кнопки
  $wp_customize->add_setting('wj_hero_cta_text', [
    'default'           => 'Перейти до каталогу',
    'sanitize_callback' => 'sanitize_text_field',
  ]);
  $wp_customize->add_control('wj_hero_cta_text', [
    'label'   => __('Hero: текст кнопки', 'whisky'),
    'section' => 'wj_home',
    'type'    => 'text',
  ]);

  // Hero: URL кнопки
  $wp_customize->add_setting('wj_hero_cta_url', [
    'default'           => home_url('/whisky/'),
    'sanitize_callback' => 'esc_url_raw',
  ]);
  $wp_customize->add_control('wj_hero_cta_url', [
    'label'   => __('Hero: посилання кнопки', 'whisky'),
    'section' => 'wj_home',
    'type'    => 'url',
  ]);

  // Hero: фонове зображення
  $wp_customize->add_setting('wj_hero_image', [
    // ImageControl зберігає ID вкладення — тримаємо sanitize як absint
    'default'           => 0,
    'sanitize_callback' => 'absint',
  ]);
  $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'wj_hero_image', [
    'label'    => __('Hero: фонове зображення', 'whisky'),
    'section'  => 'wj_home',
    'settings' => 'wj_hero_image',
  ]));

  // YouTube URL (будь-який формат)
  $wp_customize->add_setting('wj_home_youtube', [
    'default'           => '',
    'sanitize_callback' => 'esc_url_raw',
  ]);
  $wp_customize->add_control('wj_home_youtube', [
    'label'   => __('YouTube URL (необовʼязково)', 'whisky'),
    'section' => 'wj_home',
    'type'    => 'url',
  ]);
});
