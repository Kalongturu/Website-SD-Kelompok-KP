document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.getElementById('navbar');
    const navToggle = document.getElementById('navToggle');
    const navLinks = document.getElementById('navLinks');
    const backToTop = document.querySelector('.back-to-top');

    /* ---- Navbar shrink + back-to-top on scroll ---- */
    window.addEventListener('scroll', function () {
        const scrolled = window.scrollY > 30;
        navbar.classList.toggle('scrolled', scrolled);
        backToTop.classList.toggle('show', window.scrollY > 400);
    });

    /* ---- Mobile menu toggle ---- */
    navToggle.addEventListener('click', function () {
        const open = navLinks.classList.toggle('open');
        navToggle.classList.toggle('active', open);
        navToggle.setAttribute('aria-expanded', open);
    });

    /* ---- Mobile dropdown accordion ---- */
    document.querySelectorAll('.dropdown > a').forEach(function (link) {
        link.addEventListener('click', function (e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                link.parentElement.classList.toggle('open');
            }
        });
    });

    /* ---- Close mobile menu after clicking a link ---- */
    navLinks.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            if (!link.parentElement.classList.contains('dropdown')) {
                navLinks.classList.remove('open');
                navToggle.classList.remove('active');
                navToggle.setAttribute('aria-expanded', false);
            }
        });
    });

    /* ---- Reveal sections on scroll ---- */
    const reveals = document.querySelectorAll('.section, .hero-stats');
    reveals.forEach(function (el) { el.classList.add('reveal'); });

    const revealObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    reveals.forEach(function (el) { revealObserver.observe(el); });

    /* ---- Animated stat counters ---- */
    const stats = document.querySelectorAll('.stat-num');
    const statObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            const target = parseInt(el.dataset.target, 10);
            let current = 0;
            const step = Math.max(1, Math.ceil(target / 60));
            const timer = setInterval(function () {
                current += step;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                el.textContent = current + '+';
            }, 25);
            statObserver.unobserve(el);
        });
    }, { threshold: 0.5 });

    stats.forEach(function (el) { statObserver.observe(el); });
});