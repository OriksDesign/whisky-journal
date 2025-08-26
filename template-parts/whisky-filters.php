<?php
// Параметри з GET
$q     = isset($_GET['q'])     ? sanitize_text_field( wp_unslash($_GET['q']) ) : '';
$reg   = isset($_GET['region'])? sanitize_text_field( wp_unslash($_GET['region']) ) : '';
$clas  = isset($_GET['class']) ? sanitize_text_field( wp_unslash($_GET['class']) ) : '';
$age   = isset($_GET['age'])   ? sanitize_text_field( wp_unslash($_GET['age']) ) : '';
$abvmin= isset($_GET['abvmin'])? sanitize_text_field( wp_unslash($_GET['abvmin']) ) : '';
$abvmax= isset($_GET['abvmax'])? sanitize_text_field( wp_unslash($_GET['abvmax']) ) : '';
$sort  = isset($_GET['sort'])  ? sanitize_text_field( wp_unslash($_GET['sort']) ) : '';

$regions = get_terms(['taxonomy'=>'region','hide_empty'=>false]);
$classes = get_terms(['taxonomy'=>'classification','hide_empty'=>false]);
?>
<form class="mb-6 grid gap-3 md:grid-cols-6 items-end" method="get" action="">
  <div class="md:col-span-2">
    <label class="block text-sm mb-1">Пошук</label>
    <input type="text" name="q" value="<?php echo esc_attr($q); ?>"
           class="w-full rounded border-slate-300" placeholder="Назва…">
  </div>

  <div>
    <label class="block text-sm mb-1">Регіон</label>
    <select name="region" class="w-full rounded border-slate-300">
      <option value="">— Всі —</option>
      <?php foreach ( $regions as $t ) : ?>
        <option value="<?php echo esc_attr($t->slug); ?>" <?php selected($reg, $t->slug); ?>>
          <?php echo esc_html($t->name); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div>
    <label class="block text-sm mb-1">Класифікація</label>
    <select name="class" class="w-full rounded border-slate-300">
      <option value="">— Всі —</option>
      <?php foreach ( $classes as $t ) : ?>
        <option value="<?php echo esc_attr($t->slug); ?>" <?php selected($clas, $t->slug); ?>>
          <?php echo esc_html($t->name); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div>
    <label class="block text-sm mb-1">Вік</label>
    <select name="age" class="w-full rounded border-slate-300">
      <option value="">— Будь-який —</option>
      <option value="nas"  <?php selected($age,'nas');  ?>>NAS</option>
      <option value="<=12" <?php selected($age,'<=12');?>>&le; 12</option>
      <option value="13-16" <?php selected($age,'13-16');?>>13–16</option>
      <option value=">=17" <?php selected($age,'>=17');?>>&ge; 17</option>
    </select>
  </div>

  <div class="flex gap-2">
    <div>
      <label class="block text-sm mb-1">ABV від</label>
      <input type="number" step="0.1" min="0" max="100" name="abvmin" value="<?php echo esc_attr($abvmin); ?>"
             class="w-24 rounded border-slate-300">
    </div>
    <div>
      <label class="block text-sm mb-1">до</label>
      <input type="number" step="0.1" min="0" max="100" name="abvmax" value="<?php echo esc_attr($abvmax); ?>"
             class="w-24 rounded border-slate-300">
    </div>
  </div>

  <div>
    <label class="block text-sm mb-1">Сортування</label>
    <select name="sort" class="w-full rounded border-slate-300">
      <option value="">За датою (нові)</option>
      <option value="title" <?php selected($sort,'title'); ?>>За назвою</option>
      <option value="age"   <?php selected($sort,'age');   ?>>За віком</option>
      <option value="abv"   <?php selected($sort,'abv');   ?>>За ABV</option>
    </select>
  </div>

  <div class="md:col-span-6 flex gap-2">
    <button class="px-4 py-2 rounded bg-slate-900 text-white hover:bg-slate-700">Фільтрувати</button>
    <a class="px-4 py-2 rounded border border-slate-300 hover:bg-slate-100" href="<?php echo esc_url( get_post_type_archive_link('whisky') ); ?>">Скинути</a>
  </div>
</form>
