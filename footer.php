</main>
<footer class="mt-10 border-t border-gray-200 bg-white">
  <div class="max-w-screen-xl mx-auto px-4 py-6 flex items-center justify-between text-sm">
    <div>© <?php echo date('Y'); ?> Whisky Journal</div>
    <nav aria-label="Footer">
      <?php
      wp_nav_menu([
          'theme_location' => 'footer',
          'container'      => false,
          'menu_class'     => 'flex gap-4',
          'fallback_cb'    => false,
      ]);
      ?>
    </nav>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
