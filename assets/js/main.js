// Mobile nav
const toggle = document.querySelector('.nav-toggle');
const nav = document.querySelector('#site-nav');
if (toggle && nav) {
  toggle.addEventListener('click', () => {
    const open = nav.classList.toggle('open');
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
  });
}

// Theme toggle (persists in localStorage)
const root = document.documentElement;
const themeBtn = document.getElementById('theme-toggle');
const saved = localStorage.getItem('theme');
if (saved === 'light') root.classList.add('light');
if (themeBtn) {
  themeBtn.addEventListener('click', () => {
    root.classList.toggle('light');
    localStorage.setItem(
      'theme',
      root.classList.contains('light') ? 'light' : 'dark'
    );
  });
}

// -----------------------------
// Projects search / filter
// -----------------------------
document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.querySelector('[data-project-search]');
  const cards = Array.from(document.querySelectorAll('[data-project-card]'));
  const emptyState = document.querySelector('[data-projects-empty]');

  // If we’re not on the Projects page, do nothing
  if (!searchInput || cards.length === 0) return;

  function applyFilter() {
    const query = (searchInput.value || '').trim().toLowerCase();
    let visibleCount = 0;

    cards.forEach(card => {
      // Prefer explicit data-search text; fallback to card text
      const searchText = (
        card.getAttribute('data-search') ||
        card.textContent ||
        ''
      ).toLowerCase();

      const matches = query === '' || searchText.includes(query);

      // Show/hide via inline style
      card.style.display = matches ? '' : 'none';

      if (matches) visibleCount++;
    });

    if (emptyState) {
      emptyState.hidden = visibleCount !== 0;
    }
  }

  // Initial state (empty query => show all)
  applyFilter();

  // Live filtering as the user types
  searchInput.addEventListener('input', applyFilter);
});
