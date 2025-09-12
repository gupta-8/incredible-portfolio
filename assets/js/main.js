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
    localStorage.setItem('theme', root.classList.contains('light') ? 'light' : 'dark');
  });
}
