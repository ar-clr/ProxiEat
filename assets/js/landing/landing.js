/**
 * ProxiEat Landing Page - UI Interactions
 * No backend logic. No fetch(). No AJAX.
 */

(function () {
    'use strict';

    /* =====================================================
       DOM REFERENCES
       ===================================================== */

    const nav = document.querySelector('.landing-nav');
    const navToggle = document.querySelector('.landing-nav__toggle');
    const mobileNav = document.querySelector('.landing-mobile-nav');
    const mobileNavClose = document.querySelector('.landing-mobile-nav__close');
    const revealElements = document.querySelectorAll('.landing-reveal');
    const smoothLinks = document.querySelectorAll('a[href^="#"]');

    /* =====================================================
       STICKY NAVBAR
       ===================================================== */

    function updateNavbar() {
        if (!nav) return;
        const scrollY = window.scrollY || window.pageYOffset;
        if (scrollY > 20) {
            nav.classList.add('landing-nav--scrolled');
        } else {
            nav.classList.remove('landing-nav--scrolled');
        }
    }

    let navTicking = false;
    window.addEventListener('scroll', function () {
        if (!navTicking) {
            window.requestAnimationFrame(function () {
                updateNavbar();
                navTicking = false;
            });
            navTicking = true;
        }
    }, { passive: true });

    /* =====================================================
       MOBILE NAVIGATION
       ===================================================== */

    function openMobileNav() {
        if (!mobileNav) return;
        mobileNav.classList.add('landing-mobile-nav--open');
        mobileNav.setAttribute('aria-hidden', 'false');
        if (navToggle) {
            navToggle.setAttribute('aria-expanded', 'true');
        }
        document.body.style.overflow = 'hidden';
    }

    function closeMobileNav() {
        if (!mobileNav) return;
        mobileNav.classList.remove('landing-mobile-nav--open');
        mobileNav.setAttribute('aria-hidden', 'true');
        if (navToggle) {
            navToggle.setAttribute('aria-expanded', 'false');
        }
        document.body.style.overflow = '';
    }

    if (navToggle) {
        navToggle.addEventListener('click', openMobileNav);
    }

    if (mobileNavClose) {
        mobileNavClose.addEventListener('click', closeMobileNav);
    }

    // Close mobile nav when a link is clicked
    if (mobileNav) {
        mobileNav.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', closeMobileNav);
        });
    }

    /* =====================================================
       SMOOTH SCROLLING
       ===================================================== */

    smoothLinks.forEach(function (link) {
        link.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (!targetId || targetId === '#') return;

            const target = document.querySelector(targetId);
            if (!target) return;

            e.preventDefault();
            const offsetTop = target.getBoundingClientRect().top + window.pageYOffset - 80;
            window.scrollTo({
                top: offsetTop,
                behavior: 'smooth'
            });
        });
    });

    /* =====================================================
       REVEAL ON SCROLL
       ===================================================== */

    if ('IntersectionObserver' in window) {
        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -60px 0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('landing-reveal--visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        revealElements.forEach(function (el) {
            observer.observe(el);
        });
    } else {
        // Fallback: show all immediately
        revealElements.forEach(function (el) {
            el.classList.add('landing-reveal--visible');
        });
    }

    /* =====================================================
       BUTTON RIPPLE (OPTIONAL MICRO-INTERACTION)
       ===================================================== */

    document.querySelectorAll('.landing-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            const rect = btn.getBoundingClientRect();
            const ripple = document.createElement('span');
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.cssText = [
                'position:absolute',
                'width:' + size + 'px',
                'height:' + size + 'px',
                'left:' + x + 'px',
                'top:' + y + 'px',
                'background:rgba(255,255,255,.25)',
                'border-radius:50%',
                'transform:scale(0)',
                'animation:ripple-anim .6s ease-out forwards',
                'pointer-events:none'
            ].join(';');

            btn.appendChild(ripple);
            ripple.addEventListener('animationend', function () {
                ripple.remove();
            });
        });
    });

    /* =====================================================
       INIT
       ===================================================== */

    updateNavbar();

})();
