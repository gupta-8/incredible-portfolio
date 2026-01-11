/* Main UI behaviors: mobile nav, theme (auto/light/dark), project search, scroll reveal */
(function(){
  const $ = (sel, parent=document) => parent.querySelector(sel);
  const $$ = (sel, parent=document) => Array.from(parent.querySelectorAll(sel));

  // ---------------------------
  // Mobile nav
  // ---------------------------
  const toggle = $('.nav-toggle');
  const nav = $('#site-nav');
  if (toggle && nav) {
    const closeNav = () => {
      nav.classList.remove('open');
      toggle.setAttribute('aria-expanded', 'false');
    };

    toggle.addEventListener('click', () => {
      const open = nav.classList.toggle('open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });

    // Close on link click (mobile)
    nav.addEventListener('click', (e) => {
      const target = e.target;
      if (target && target.tagName === 'A') closeNav();
    });

    // Close on Escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeNav();
    });

    // Close when clicking outside
    document.addEventListener('click', (e) => {
      if (!nav.classList.contains('open')) return;
      if (e.target === toggle || nav.contains(e.target)) return;
      closeNav();
    });
  }

  // ---------------------------
  // Theme toggle: cycles auto -> light -> dark
  // ---------------------------
  const root = document.documentElement;
  const themeBtn = document.getElementById('theme-toggle');
  const metaTheme = document.querySelector('meta[name="theme-color"]');

  const THEMES = ['auto','light','dark'];

  function setMetaThemeColor(){
    // Use computed bg color as theme-color for nicer mobile address bar
    if (!metaTheme) return;
    try{
      const bg = getComputedStyle(document.body).backgroundColor || '#0b1220';
      metaTheme.setAttribute('content', bg);
    }catch(_){}
  }

  function applyTheme(mode){
    if (!THEMES.includes(mode)) mode = 'auto';
    if (mode === 'auto') {
      root.removeAttribute('data-theme');
    } else {
      root.setAttribute('data-theme', mode);
    }
    localStorage.setItem('theme', mode);
    updateThemeButton(mode);
    setMetaThemeColor();
  }

  function updateThemeButton(mode){
    if (!themeBtn) return;
    const label = mode === 'auto' ? 'Theme: Auto' : (mode === 'light' ? 'Theme: Light' : 'Theme: Dark');
    themeBtn.setAttribute('aria-label', label);

    // Minimal icon set (works in plain text)
    themeBtn.textContent = mode === 'auto' ? '🌓' : (mode === 'light' ? '🌤️' : '🌙');
  }

  if (themeBtn) {
    const saved = localStorage.getItem('theme') || 'auto';
    applyTheme(saved);

    themeBtn.addEventListener('click', () => {
      const current = localStorage.getItem('theme') || 'auto';
      const next = THEMES[(THEMES.indexOf(current) + 1) % THEMES.length];
      applyTheme(next);
    });

    // If user is in auto mode, respond to system theme changes
    const media = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)');
    if (media && media.addEventListener) {
      media.addEventListener('change', () => {
        const mode = localStorage.getItem('theme') || 'auto';
        if (mode === 'auto') setMetaThemeColor();
      });
    }
  } else {
    // still set theme from storage even if button missing
    const saved = localStorage.getItem('theme') || 'auto';
    applyTheme(saved);
  }

  // ---------------------------
  // Projects: live filtering
  // ---------------------------
  document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('[data-project-search] #projects-search') || document.getElementById('projects-search');
    const cards = $$('[data-project-card]');
    const emptyState = document.querySelector('[data-projects-empty]');

    if (!searchInput || cards.length === 0) return;

    function normalize(s){
      return (s || '').toLowerCase().trim();
    }

    function applyFilter(){
      const q = normalize(searchInput.value);
      let visible = 0;

      cards.forEach(card => {
        const hay = normalize(card.getAttribute('data-search'));
        const match = !q || hay.includes(q);
        card.hidden = !match;
        if (match) visible++;
      });

      if (emptyState) emptyState.hidden = visible !== 0;
    }

    applyFilter();
    searchInput.addEventListener('input', applyFilter);
  });

  // ---------------------------
  // Scroll reveal (adds a premium feel)
  // ---------------------------
  const revealTargets = [
    '.hero',
    '.section-header',
    '.card',
    '.project-card',
    '.alert',
    '.form'
  ];
  const els = new Set();
  revealTargets.forEach(sel => $$(sel).forEach(el => els.add(el)));

  els.forEach(el => el.classList.add('reveal'));

  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12 });

    els.forEach(el => io.observe(el));
  } else {
    els.forEach(el => el.classList.add('is-visible'));
  }

  // ---------------------------
  // Scroll-to-top button
  // ---------------------------
  const topBtn = document.createElement('button');
  topBtn.className = 'btn scroll-top';
  topBtn.type = 'button';
  topBtn.setAttribute('aria-label', 'Scroll to top');
  topBtn.textContent = '↑ Top';
  document.body.appendChild(topBtn);

  topBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  const onScroll = () => {
    if (window.scrollY > 700) topBtn.classList.add('show');
    else topBtn.classList.remove('show');
  };
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
})();
