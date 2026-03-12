const THEME_KEY = 'theme';
const COOKIE_DAYS = 365;

function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(';').shift();
  return null;
}

function setCookie(name, value, days = COOKIE_DAYS) {
  const expires = new Date(Date.now() + days * 864e5).toUTCString();
  document.cookie = `${name}=${value}; path=/; expires=${expires}; SameSite=Lax`;
}

function applyTheme(theme) {
  const html = document.documentElement;
  if (theme === 'dark') {
    html.classList.add('dark');
  } else {
    html.classList.remove('dark');
  }
}

function initTheme() {
  const stored = getCookie(THEME_KEY);
  applyTheme(stored === 'dark' ? 'dark' : 'light');
}

function toggleTheme() {
  const html = document.documentElement;
  const isDark = html.classList.toggle('dark');
  const theme = isDark ? 'dark' : 'light';
  setCookie(THEME_KEY, theme);
}

export function initThemeToggle() {
  initTheme();
  document.querySelectorAll('[data-theme-toggle]').forEach((el) => {
    el.addEventListener('click', toggleTheme);
  });
}
