document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.getElementById('navbar');
    const navToggle = document.getElementById('navToggle');
    const navLinks = document.getElementById('navLinks');
    const backToTop = document.querySelector('.back-to-top');

    /* ---- Navbar shrink + back-to-top on scroll ---- */
    window.addEventListener('scroll', function () {
        const scrolled = window.scrollY > 30;
        if (navbar) navbar.classList.toggle('scrolled', scrolled);
        if (backToTop) backToTop.classList.toggle('show', window.scrollY > 400);
    });

    /* ---- Back-to-top: selalu gulung ke atas di SEMUA halaman ----
       Sebelumnya mengandalkan href="#beranda" yang hanya ada di halaman Home,
       sehingga tidak berfungsi di halaman lain. Ditangani via JS agar universal. */
    if (backToTop) {
        backToTop.addEventListener('click', function (e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    /* ---- Animasi tinggi submenu (halus seperti collapse Bootstrap) ---- */
    function expandDropdown(dd) {
        const menu = dd.querySelector('.dropdown-menu');
        dd.classList.add('open');            // padding terbuka aktif sebelum diukur
        if (!menu) return;
        menu.style.height = menu.scrollHeight + 'px';
        menu.addEventListener('transitionend', function onEnd(e) {
            if (e.propertyName !== 'height') return;
            menu.removeEventListener('transitionend', onEnd);
            // Biarkan auto agar tetap pas bila konten/orientasi berubah.
            if (dd.classList.contains('open')) menu.style.height = 'auto';
        });
    }

    function collapseDropdown(dd) {
        const menu = dd.querySelector('.dropdown-menu');
        if (!dd.classList.contains('open')) return;
        if (menu) {
            // Kunci tinggi saat ini (ubah 'auto' -> px), paksa reflow, lalu ke 0.
            menu.style.height = menu.scrollHeight + 'px';
            void menu.offsetHeight;
            dd.classList.remove('open');
            menu.style.height = '0px';
        } else {
            dd.classList.remove('open');
        }
    }

    // Tutup dropdown tanpa animasi (mis. saat panel disembunyikan / pindah ke desktop).
    function resetDropdown(dd) {
        const menu = dd.querySelector('.dropdown-menu');
        dd.classList.remove('open');
        if (menu) menu.style.height = '';
    }

    // Buka/tutup panel menu mobile sekaligus mengunci/melepas scroll latar.
    function setMobileMenu(open) {
        navLinks.classList.toggle('open', open);
        navToggle.classList.toggle('active', open);
        navToggle.setAttribute('aria-expanded', open);
        // Kunci scroll latar agar navbar + tombol tutup tetap di tempatnya.
        document.documentElement.classList.toggle('nav-open', open);
        // Saat dibuka, mulai dari kondisi semua dropdown tertutup.
        if (open) navLinks.querySelectorAll('.dropdown').forEach(resetDropdown);
    }

    /* ---- Mobile menu toggle ---- */
    navToggle.addEventListener('click', function () {
        setMobileMenu(!navLinks.classList.contains('open'));
    });

    /* ---- Tutup menu saat menekan di luar panel ---- */
    document.addEventListener('click', function (e) {
        if (!navLinks.classList.contains('open')) return;
        // Abaikan klik di dalam panel menu atau pada tombol toggle itu sendiri.
        if (navLinks.contains(e.target) || navToggle.contains(e.target)) return;
        setMobileMenu(false);
    });

    /* ---- Tutup menu dengan tombol Escape ---- */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && navLinks.classList.contains('open')) {
            setMobileMenu(false);
        }
    });

    /* ---- Cegah dropdown desktop terpotong tepi kanan layar ----
       Untuk tiap dropdown, jika menunya akan melewati tepi kanan viewport,
       tambahkan .flip agar menu dibuka ke kiri (rata kanan). Dihitung ulang
       saat resize sehingga aman di semua lebar layar. */
    const dropdowns = document.querySelectorAll('.nav-links > .dropdown');

    function adjustDropdowns() {
        // Di mode mobile (<=768px) dropdown memakai posisi statis, jadi reset flip.
        if (window.innerWidth <= 768) {
            dropdowns.forEach(function (dd) {
                dd.querySelector('.dropdown-menu')?.classList.remove('flip');
            });
            return;
        }

        // Pindah ke desktop: tutup panel mobile, lepas kunci scroll, dan
        // bersihkan sisa state accordion agar hover desktop kembali normal.
        setMobileMenu(false);
        dropdowns.forEach(resetDropdown);

        const margin = 8; // sisa jarak aman dari tepi
        dropdowns.forEach(function (dd) {
            const menu = dd.querySelector('.dropdown-menu');
            if (!menu) return;
            menu.classList.remove('flip');
            const liLeft = dd.getBoundingClientRect().left;
            if (liLeft + menu.offsetWidth > window.innerWidth - margin) {
                menu.classList.add('flip');
            }
        });
    }

    adjustDropdowns();
    window.addEventListener('resize', adjustDropdowns);

    /* ---- Mobile dropdown accordion ----
       Klik header dropdown untuk membuka/menutup submenunya. Bergaya accordion:
       membuka satu dropdown otomatis menutup yang lain, dengan animasi tinggi halus. */
    document.querySelectorAll('.dropdown > a').forEach(function (link) {
        link.addEventListener('click', function (e) {
            if (window.innerWidth > 768) return;
            e.preventDefault();
            const parent = link.parentElement;
            const willOpen = !parent.classList.contains('open');

            // Tutup dropdown lain yang sedang terbuka (accordion).
            navLinks.querySelectorAll('.dropdown.open').forEach(function (d) {
                if (d !== parent) collapseDropdown(d);
            });

            if (willOpen) expandDropdown(parent);
            else collapseDropdown(parent);
        });
    });

    /* ---- Close mobile menu after clicking a link ---- */
    navLinks.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            if (!link.parentElement.classList.contains('dropdown')) {
                setMobileMenu(false);
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