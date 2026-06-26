/* =====================================================================
   PROGRAM KP — main.js
   ===================================================================== */
(function () {
  "use strict";

  var prefersReduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  /* ---------- Header scroll state ---------- */
  var header = document.querySelector(".site-header");
  var toTop  = document.querySelector(".to-top");

  function onScroll() {
    var y = window.scrollY || window.pageYOffset;
    if (header) header.classList.toggle("is-scrolled", y > 20);
    if (toTop)  toTop.classList.toggle("show", y > 480);
  }
  window.addEventListener("scroll", onScroll, { passive: true });
  onScroll();

  if (toTop) {
    toTop.addEventListener("click", function () {
      window.scrollTo({ top: 0, behavior: prefersReduced ? "auto" : "smooth" });
    });
  }

  /* ---------- Mobile navigation ---------- */
  var toggle = document.querySelector(".nav-toggle");
  var menu   = document.querySelector(".nav-menu");

  function closeMenu() {
    if (!menu || !toggle) return;
    menu.classList.remove("open");
    toggle.setAttribute("aria-expanded", "false");
  }

  if (toggle && menu) {
    toggle.addEventListener("click", function () {
      var open = menu.classList.toggle("open");
      toggle.setAttribute("aria-expanded", String(open));
    });
    menu.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", closeMenu);
    });
    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape") closeMenu();
    });
    window.addEventListener("resize", function () {
      if (window.innerWidth >= 860) closeMenu();
    });
  }

  /* ---------- Mobile dropdown (Profil sub-menu) ---------- */
  document.querySelectorAll(".nav-has-drop").forEach(function (item) {
    var btn = item.querySelector(".drop-toggle");
    if (!btn) return;
    btn.addEventListener("click", function (e) {
      e.stopPropagation();
      var isOpen = item.classList.toggle("open");
      btn.setAttribute("aria-expanded", String(isOpen));
    });
  });

  /* Close dropdown when clicking outside */
  document.addEventListener("click", function (e) {
    document.querySelectorAll(".nav-has-drop.open").forEach(function (item) {
      if (!item.contains(e.target)) {
        item.classList.remove("open");
        var btn = item.querySelector(".drop-toggle");
        if (btn) btn.setAttribute("aria-expanded", "false");
      }
    });
  });

  /* ---------- Reveal on scroll ---------- */
  var reveals = document.querySelectorAll("[data-reveal]");
  if (prefersReduced || !("IntersectionObserver" in window)) {
    reveals.forEach(function (el) { el.classList.add("is-visible"); });
  } else {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: "0px 0px -40px 0px" });
    reveals.forEach(function (el) { el.classList.add("reveal"); io.observe(el); });
  }

  /* ---------- Animated stat counters ---------- */
  var counters = document.querySelectorAll("[data-count]");
  function runCounter(el) {
    var target = parseFloat(el.getAttribute("data-count"));
    if (prefersReduced) { el.textContent = target; return; }
    var start = performance.now(), dur = 1400;
    function tick(now) {
      var p = Math.min((now - start) / dur, 1);
      var eased = 1 - Math.pow(1 - p, 3);
      el.textContent = Math.round(target * eased);
      if (p < 1) requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);
  }
  if (counters.length) {
    if (!("IntersectionObserver" in window)) {
      counters.forEach(runCounter);
    } else {
      var co = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) { runCounter(entry.target); co.unobserve(entry.target); }
        });
      }, { threshold: 0.6 });
      counters.forEach(function (el) { co.observe(el); });
    }
  }

  /* ---------- Profil sub-nav active highlight on scroll ---------- */
  var subLinks = document.querySelectorAll(".profil-subnav a[href^='#']");
  if (subLinks.length) {
    var sections = Array.from(subLinks).map(function (a) {
      return document.querySelector(a.getAttribute("href"));
    });
    function updateSubNav() {
      var scrollY = window.scrollY + 120;
      var active = null;
      sections.forEach(function (sec) {
        if (sec && sec.offsetTop <= scrollY) active = sec;
      });
      subLinks.forEach(function (a) {
        var target = document.querySelector(a.getAttribute("href"));
        a.classList.toggle("is-active", target === active);
      });
    }
    window.addEventListener("scroll", updateSubNav, { passive: true });
    updateSubNav();
  }

  /* ---------- Contact form ---------- */
  var form = document.querySelector("[data-contact-form]");
  if (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      var status = form.querySelector(".form-status");
      if (!form.checkValidity()) { form.reportValidity(); return; }
      if (status) status.textContent = "Terima kasih — pesan Anda telah kami terima.";
      form.reset();
    });
  }
})();
