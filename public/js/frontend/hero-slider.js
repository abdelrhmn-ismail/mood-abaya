/**
 * Hero image slider – auto-cycles through slides with dot navigation
 */
(function () {
    'use strict';

    var SLIDE_INTERVAL_MS = 5000;

    function initHeroSlider() {
        var slider = document.querySelector('[data-hero-slider]');
        if (!slider) return;

        var slides = slider.querySelectorAll('[data-hero-slide]');
        var dots = slider.querySelectorAll('[data-hero-dot]');
        if (slides.length === 0) return;

        var current = 0;

        function goTo(index) {
            current = ((index % slides.length) + slides.length) % slides.length;
            slides.forEach(function (s, i) {
                s.classList.toggle('opacity-0', i !== current);
                s.classList.toggle('opacity-100', i === current);
                s.classList.toggle('pointer-events-none', i !== current);
            });
            dots.forEach(function (d, i) {
                d.setAttribute('aria-current', i === current ? 'true' : 'false');
                d.classList.toggle('bg-white/90', i === current);
                d.classList.toggle('bg-white/40', i !== current);
            });
        }

        function next() {
            goTo(current + 1);
        }

        var interval = setInterval(next, SLIDE_INTERVAL_MS);

        dots.forEach(function (dot, i) {
            dot.addEventListener('click', function () {
                goTo(i);
                clearInterval(interval);
                interval = setInterval(next, SLIDE_INTERVAL_MS);
            });
        });

        slider.addEventListener('mouseenter', function () { clearInterval(interval); });
        slider.addEventListener('mouseleave', function () {
            interval = setInterval(next, SLIDE_INTERVAL_MS);
        });

        goTo(0);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHeroSlider);
    } else {
        initHeroSlider();
    }
})();
