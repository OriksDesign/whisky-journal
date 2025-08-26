<?php
/**
 * Template part: Whisky card
 */
$pid       = get_the_ID();
$permalink = get_permalink($pid);
$title     = get_the_title($pid);

// Таксономії
$region_terms = get_the_terms($pid, 'region');
$class_terms  = get_the_terms($pid, 'classification');
$region_out   = ($region_terms && ! is_wp_error($region_terms)) ? $region_terms[0]->name : '';
$class_out    = ($class_terms  && ! is_wp_error($class_terms )) ? $class_terms[0]->name  : '';

// Мета
$age_raw = get_post_meta($pid, 'age', true);
$abv_raw = get_post_meta($pid, 'abv', true);
$age_out = ($age_raw !== '' && $age_raw !== null) ? (int) $age_raw : '0';
if ($abv_raw !== '' && $abv_raw !== null) {
  $abv_num = (float) $abv_raw;
  $abv_out = rtrim(rtrim(number_format($abv_num, 1, '.', ''), '0'), '.');
} else {
  $abv_out = '0';
}

// Джерело зображення (може бути порожнім — тоді підхопить плейсхолдер у JS)
$thumb_id  = get_post_thumbnail_id($pid);
$thumb_img = $thumb_id
  ? wp_get_attachment_image(
      $thumb_id,
      'large',
      false,
      [
        'class'    => 'whisky-img w-full h-full object-contain',
        'loading'  => 'lazy',
        'decoding' => 'async',
        'data-skeleton' => '1', // увімкнути skeleton у JS
        'alt'      => esc_attr($title),
      ]
    )
  : '<img class="whisky-img w-full h-full object-contain" data-skeleton="1" alt="' . esc_attr($title) . '">';

?>
<article class="whisky-card overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition">
  <a href="<?php echo esc_url($permalink); ?>"
     class="block"
     data-prefetch="1" aria-label="<?php echo esc_attr($title); ?>">
    <div class="media aspect-[4/3] bg-slate-100 p-3 flex items-center justify-center">
      <?php echo $thumb_img; ?>
    </div>
  </a>

  <div class="p-4">
    <div class="absolute top-2 right-2 text-xs rounded-full border px-2 py-0.5 badge-abv">
      ABV: <?php echo esc_html($abv_out); ?>%
    </div>

    <h3 class="font-semibold text-slate-900 leading-tight">
      <a href="<?php echo esc_url($permalink); ?>" class="hover:underline"><?php echo esc_html($title); ?></a>
    </h3>

    <?php if ($region_out || $class_out): ?>
      <p class="mt-1 text-sm text-slate-600">
        <?php
          $meta_line = trim($region_out . ($region_out && $class_out ? ' • ' : '') . $class_out);
          echo esc_html($meta_line);
        ?>
      </p>
    <?php endif; ?>

    <p class="mt-1 text-sm text-slate-600 space-x-4">
      <span>Age: <strong><?php echo esc_html($age_out); ?></strong></span>
      <span>ABV: <strong><?php echo esc_html($abv_out); ?>%</strong></span>
    </p>

    <a href="<?php echo esc_url($permalink); ?>"
       class="mt-3 inline-block rounded-md border border-slate-300 px-3 py-1 text-xs hover:bg-slate-50">
      Details
    </a>
  </div>
</article>
