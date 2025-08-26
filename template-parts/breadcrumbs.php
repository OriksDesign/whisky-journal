<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

$items = array(
  array('label' => 'Головна', 'url' => home_url('/')),
);

if (is_post_type_archive('whisky') || is_singular('whisky')) {
  $items[] = array('label' => 'Whiskies', 'url' => get_post_type_archive_link('whisky'));
}

if (is_tax('region') || is_tax('classification')) {
  $term = get_queried_object();
  if ($term && !is_wp_error($term)) {
    $items[] = array('label' => $term->name, 'url' => get_term_link($term));
  }
}

if (is_singular()) {
  $items[] = array('label' => get_the_title(), 'url' => get_permalink());
}
?>
<nav class="text-sm text-slate-600" aria-label="Breadcrumbs">
  <ol class="flex flex-wrap gap-x-2">
    <?php foreach ($items as $i => $it): ?>
      <li>
        <?php if ($i < count($items)-1): ?>
          <a class="hover:underline" href="<?php echo esc_url($it['url']); ?>"><?php echo esc_html($it['label']); ?></a>
          <span aria-hidden="true">/</span>
        <?php else: ?>
          <span class="text-slate-900"><?php echo esc_html($it['label']); ?></span>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ol>
</nav>
