/**
 * Hero image slider – cycles through slides, optional dots/arrows
 */
const SLIDE_INTERVAL_MS = 5000;

export function initHeroSlider() {
  const slider = document.querySelector('[data-hero-slider]');
  if (!slider) return;

  const slides = slider.querySelectorAll('[data-hero-slide]');
  const dots = slider.querySelectorAll('[data-hero-dot]');
  if (slides.length === 0) return;

  let current = 0;

  function goTo(index) {
    current = ((index % slides.length) + slides.length) % slides.length;
    slides.forEach((s, i) => {
      s.classList.toggle('opacity-0', i !== current);
      s.classList.toggle('opacity-100', i === current);
      s.classList.toggle('pointer-events-none', i !== current);
    });
    dots.forEach((d, i) => {
      d.setAttribute('aria-current', i === current ? 'true' : 'false');
      d.classList.toggle('bg-white/90', i === current);
      d.classList.toggle('bg-white/40', i !== current);
    });
  }

  function next() {
    goTo(current + 1);
  }

  let interval = setInterval(next, SLIDE_INTERVAL_MS);

  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
      goTo(i);
      clearInterval(interval);
      interval = setInterval(next, SLIDE_INTERVAL_MS);
    });
  });

  slider.addEventListener('mouseenter', () => clearInterval(interval));
  slider.addEventListener('mouseleave', () => {
    interval = setInterval(next, SLIDE_INTERVAL_MS);
  });

  goTo(0);
}
