// assets/js/main.js
(() => {
  // Швидкі хелпери
  const $ = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => [...r.querySelectorAll(s)];
  const root = document.documentElement;

  // ----- Мобільне меню
  const navToggle = $('#navToggle');
  const drawer = $('#drawer');
  if (navToggle && drawer) {
    navToggle.addEventListener('click', () => {
      const opened = !drawer.classList.contains('hidden');
      drawer.classList.toggle('hidden', opened);
      navToggle.setAttribute('aria-expanded', String(!opened));
    });
  }

  // ----- Тема з localStorage та системних налаштувань
  const STORAGE_KEY = 'whisky-theme';
  const themeBtn = $('#themeToggle');

  function initialTheme() {
    const saved = localStorage.getItem(STORAGE_KEY);
    if (saved === 'dark' || saved === 'light') return saved;
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
  }
  function applyTheme(theme) {
    root.setAttribute('data-theme', theme);
    if (theme === 'dark') root.classList.add('dark');
    else root.classList.remove('dark');

    if (themeBtn) {
      themeBtn.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false');
      themeBtn.textContent = theme === 'dark' ? '☀️' : '🌙';
      themeBtn.title = theme === 'dark' ? 'Світла тема' : 'Темна тема';
    }
  }
  function toggleTheme() {
    const next = (root.getAttribute('data-theme') || 'light') === 'dark' ? 'light' : 'dark';
    localStorage.setItem(STORAGE_KEY, next);
    applyTheme(next);
  }
  applyTheme(initialTheme());
  const mm = window.matchMedia('(prefers-color-scheme: dark)');
  mm.addEventListener?.('change', e => {
    const saved = localStorage.getItem(STORAGE_KEY);
    if (!saved) applyTheme(e.matches ? 'dark' : 'light');
  });
  if (themeBtn) themeBtn.addEventListener('click', toggleTheme);

  // ----- Prefetch для лінків на картках
  const prefetched = new Set();
  const prefetch = href => {
    if (!href || prefetched.has(href)) return;
    const link = document.createElement('link');
    link.rel = 'prefetch';
    link.href = href;
    document.head.appendChild(link);
    prefetched.add(href);
  };
  document.addEventListener('mouseover', e => {
    const a = e.target.closest('a[data-prefetch="1"]');
    if (a) prefetch(a.href);
  });
  document.addEventListener('focusin', e => {
    const a = e.target.closest('a[data-prefetch="1"]');
    if (a) prefetch(a.href);
  });

  // ----- Шлях до плейсхолдера
  let themeUri = (window.WJ && window.WJ.themeUri) || '';
  if (!themeUri) {
    const scriptEl =
      document.currentScript ||
      [...document.scripts].reverse().find(s => s.src && s.src.includes('/assets/js/main.js'));
    const m = scriptEl && scriptEl.src.match(/^(.*\/wp-content\/themes\/[^\/]+)/);
    if (m) themeUri = m[1];
  }
  const placeholderPath = `${themeUri || ''}/placeholder-whisky.svg`;

  // ----- Skeleton та fallback для зображень карток
  function attachImageHandlers(img) {
    const card = img.closest('.whisky-card');
    if (!card) return;
    const done = () => card.classList.remove('is-loading');

    const start = () => {
      card.classList.add('is-loading');

      if (img.complete && img.naturalWidth > 0) {
        done();
      } else {
        img.addEventListener('load', done, { once: true });
        img.addEventListener(
          'error',
          () => {
            img.src = placeholderPath;
            done();
          },
          { once: true }
        );
      }
    };

    start();
  }

  const imgs = $$('.whisky-card img[data-skeleton]');
  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver(
      entries => {
        entries.forEach(entry => {
          if (!entry.isIntersecting) return;
          attachImageHandlers(entry.target);
          io.unobserve(entry.target);
        });
      },
      { rootMargin: '200px 0px' }
    );
    imgs.forEach(img => io.observe(img));
  } else {
    imgs.forEach(attachImageHandlers);
  }
})();
