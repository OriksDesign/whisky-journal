<?php
/** Footer */
?>
</main>

<footer class="mt-12 border-t border-slate-200 bg-white/70 backdrop-blur">
  <div class="max-w-screen-xl mx-auto px-4 py-8 grid md:grid-cols-3 gap-6 text-sm">
    <div>
      <div class="font-semibold mb-2"><?php bloginfo('name'); ?></div>
      <p class="text-slate-600">Невеликий журнал про віскі: класифікації, регіони, міцність та вік.</p>
    </div>
    <nav>
      <div class="font-semibold mb-2">Навігація</div>
      <?php
      wp_nav_menu([
        'theme_location' => 'footer',
        'container'      => false,
        'menu_class'     => 'space-y-1',
        'fallback_cb'    => '__return_empty_string',
      ]);
      ?>
    </nav>
    <div>
      <div class="font-semibold mb-2">Ми в мережі</div>
      <div class="flex gap-3 text-slate-600">
        <a href="#" class="hover:text-slate-900">Instagram</a>
        <a href="#" class="hover:text-slate-900">YouTube</a>
        <a href="#" class="hover:text-slate-900">X/Twitter</a>
      </div>
    </div>
  </div>
  <div class="border-t border-slate-200 text-xs py-4 text-center text-slate-600">
    © <?php echo date('Y'); ?> <?php bloginfo('name'); ?>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
