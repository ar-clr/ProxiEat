<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ProxiEat - Smarter Feeding. Healthier Pets.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="..\assets\css\core\variables.css?v=<?= time() ?>" rel="stylesheet">
    <link href="..\assets\css\pages\landing.css?v=<?= time() ?>" rel="stylesheet">
    <style>
        /* Ripple animation keyframes */
        @keyframes ripple-anim {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <div class="landing-page">

        <!-- =====================================================
             NAVIGATION
             ===================================================== -->
        <nav class="landing-nav" aria-label="Main navigation">
            <div class="landing-nav__inner">
                <a href="#" class="landing-nav__logo" aria-label="ProxiEat Home">
                    <span class="landing-nav__logo-icon">
                        <i class="bi bi-heart-pulse"></i>
                    </span>
                    ProxiEat
                </a>

                <ul class="landing-nav__links">
                    <li><a href="#features" class="landing-nav__link">Features</a></li>
                    <li><a href="#why" class="landing-nav__link">About</a></li>
                    <li><a href="#contact" class="landing-nav__link">Contact</a></li>
                </ul>

                <div class="landing-nav__actions">
                    <a href="image-analysis/camera.php" class="landing-btn landing-btn--secondary landing-btn--sm">
                        Login
                    </a>
                    <a href="image-analysis/camera.php" class="landing-btn landing-btn--primary landing-btn--sm">
                        Register
                    </a>
                </div>

                <button class="landing-nav__toggle" id="navToggle" type="button" aria-label="Toggle navigation" aria-expanded="false">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </nav>

        <!-- =====================================================
             MOBILE NAVIGATION
             ===================================================== -->
        <div class="landing-mobile-nav" id="mobileNav" aria-hidden="true">
            <button class="landing-nav__toggle landing-mobile-nav__close" id="mobileNavClose" type="button" aria-label="Close navigation">
                <i class="bi bi-x-lg"></i>
            </button>
            <a href="#features" class="landing-mobile-nav__link">Features</a>
            <a href="#why" class="landing-mobile-nav__link">About</a>
            <a href="#contact" class="landing-mobile-nav__link">Contact</a>
            <div class="landing-mobile-nav__actions">
                <a href="image-analysis/camera.php" class="landing-btn landing-btn--secondary">Login</a>
                <a href="image-analysis/camera.php" class="landing-btn landing-btn--primary">Register</a>
            </div>
        </div>

        <!-- =====================================================
             HERO SECTION
             ===================================================== -->
        <section class="landing-hero" aria-labelledby="heroTitle">
            <div class="landing-hero__bg" aria-hidden="true"></div>
            <div class="landing-hero__inner">
                <div class="landing-hero__content">
                    <div class="landing-hero__badge">
                        <span class="landing-hero__badge-dot" aria-hidden="true"></span>
                        Smart IoT Pet Feeding System
                    </div>

                    <h1 class="landing-hero__title" id="heroTitle">
                        Smarter Feeding.<br>
                        <span class="landing-hero__title-accent">Healthier Pets.</span>
                    </h1>

                    <p class="landing-hero__description">
                        ProxiEat combines AI image analysis, smart feeding, and remote monitoring
                        to keep your pet happy, healthy, and well-fed — even when you're away.
                    </p>

                    <div class="landing-hero__actions">
                        <a href="image-analysis/camera.php" class="landing-btn landing-btn--primary landing-btn--lg">
                            Get Started
                        </a>
                        <a href="#features" class="landing-btn landing-btn--secondary landing-btn--lg">
                            Learn More
                        </a>
                    </div>

                    <div class="landing-hero__chips">
                        <span class="landing-hero__chip"><i class="bi bi-cpu"></i> AI Image Analysis</span>
                        <span class="landing-hero__chip"><i class="bi bi-wifi"></i> Remote Feeding</span>
                        <span class="landing-hero__chip"><i class="bi bi-camera-video"></i> Real-time Monitoring</span>
                        <span class="landing-hero__chip"><i class="bi bi-calendar-check"></i> Smart Scheduling</span>
                    </div>
                </div>

                <div class="landing-hero__visual" aria-hidden="true">
                    <div class="landing-dashboard">
                        <div class="landing-dashboard__header">
                            <h2 class="landing-dashboard__title">Pet Dashboard</h2>
                            <span class="landing-dashboard__status">Online</span>
                        </div>
                        <div class="landing-dashboard__body">
                            <div class="landing-dashboard__preview">
                                <div class="landing-dashboard__preview-placeholder">
                                    <i class="bi bi-image"></i>
                                    <span>Cat Image Placeholder</span>
                                </div>
                                <div class="landing-dashboard__ai-badge">
                                    <i class="bi bi-stars"></i> AI Analyzed
                                </div>
                            </div>

                            <div class="landing-dashboard__grid">
                                <div class="landing-dashboard__stat">
                                    <div class="landing-dashboard__stat-value">Relaxed</div>
                                    <div class="landing-dashboard__stat-label">Mood</div>
                                </div>
                                <div class="landing-dashboard__stat">
                                    <div class="landing-dashboard__stat-value">2 / 3</div>
                                    <div class="landing-dashboard__stat-label">Today's Meals</div>
                                </div>
                                <div class="landing-dashboard__stat">
                                    <div class="landing-dashboard__stat-value">85%</div>
                                    <div class="landing-dashboard__stat-label">Feeding Progress</div>
                                </div>
                            </div>

                            <div class="landing-dashboard__footer">
                                <div class="landing-dashboard__footer-item">
                                    <i class="bi bi-battery-half"></i> Battery 68%
                                </div>
                                <div class="landing-dashboard__footer-item">
                                    <i class="bi bi-wifi"></i> Connected
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating cards -->
                    <div class="landing-float-card landing-float-card--mood">
                        <div class="landing-float-card__icon landing-float-card__icon--mood">
                            <i class="bi bi-emoji-smile"></i>
                        </div>
                        <div class="landing-float-card__text">
                            <span class="landing-float-card__title">Mood</span>
                            <span class="landing-float-card__value">Happy & Relaxed</span>
                        </div>
                    </div>

                    <div class="landing-float-card landing-float-card--battery">
                        <div class="landing-float-card__icon landing-float-card__icon--battery">
                            <i class="bi bi-battery-charging"></i>
                        </div>
                        <div class="landing-float-card__text">
                            <span class="landing-float-card__title">Battery</span>
                            <span class="landing-float-card__value">Charging</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- =====================================================
             FEATURES SECTION
             ===================================================== -->
        <section class="landing-section landing-features" id="features" aria-labelledby="featuresTitle">
            <div class="landing-section__inner">
                <div class="landing-section__header landing-reveal">
                    <span class="landing-section__label">Features</span>
                    <h2 class="landing-section__title" id="featuresTitle">Everything your pet needs</h2>
                    <p class="landing-section__subtitle">
                        ProxiEat brings together smart hardware and intelligent software
                        to create the ultimate pet care experience.
                    </p>
                </div>

                <div class="landing-features__grid">
                    <article class="landing-feature landing-reveal">
                        <div class="landing-feature__icon landing-feature__icon--ai" aria-hidden="true">
                            <i class="bi bi-cpu"></i>
                        </div>
                        <h3 class="landing-feature__title">AI Pet Analysis</h3>
                        <p class="landing-feature__text">
                            Advanced image analysis understands your pet's mood, posture, and behavior.
                            Get insights that help you care better.
                        </p>
                    </article>

                    <article class="landing-feature landing-reveal">
                        <div class="landing-feature__icon landing-feature__icon--feed" aria-hidden="true">
                            <i class="bi bi-basket"></i>
                        </div>
                        <h3 class="landing-feature__title">Smart Feeding</h3>
                        <p class="landing-feature__text">
                            Schedule meals, control portions, and dispense food remotely.
                            Your pet gets fed on time, every time.
                        </p>
                    </article>

                    <article class="landing-feature landing-reveal">
                        <div class="landing-feature__icon landing-feature__icon--activity" aria-hidden="true">
                            <i class="bi bi-activity"></i>
                        </div>
                        <h3 class="landing-feature__title">Activity Monitoring</h3>
                        <p class="landing-feature__text">
                            Track eating patterns, movement, and daily activity.
                            Stay connected to your pet's health from anywhere.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <!-- =====================================================
             WHY PROXIEAT SECTION
             ===================================================== -->
        <section class="landing-section landing-why" id="why" aria-labelledby="whyTitle">
            <div class="landing-section__inner">
                <!-- Row 1: Image Left, Content Right -->
                <div class="landing-why__row landing-reveal">
                    <div class="landing-why__visual">
                        <div class="landing-why__image">
                            <div class="landing-why__image-placeholder">
                                <i class="bi bi-shield-check"></i>
                                <span>Trusted & Secure</span>
                            </div>
                        </div>
                    </div>
                    <div class="landing-why__content">
                        <h2 class="landing-why__title" id="whyTitle">Why pet parents choose ProxiEat</h2>
                        <p class="landing-why__text">
                            We built ProxiEat to give you peace of mind. Our platform combines
                            reliable IoT hardware with gentle, intelligent software that respects
                            your pet's routine.
                        </p>
                        <ul class="landing-why__list">
                            <li class="landing-why__item">
                                <span class="landing-why__item-icon" aria-hidden="true"><i class="bi bi-check"></i></span>
                                <span class="landing-why__item-text">Real-time camera feed with AI-powered behavior insights</span>
                            </li>
                            <li class="landing-why__item">
                                <span class="landing-why__item-icon" aria-hidden="true"><i class="bi bi-check"></i></span>
                                <span class="landing-why__item-text">Remote meal scheduling and portion control</span>
                            </li>
                            <li class="landing-why__item">
                                <span class="landing-why__item-icon" aria-hidden="true"><i class="bi bi-check"></i></span>
                                <span class="landing-why__item-text">Activity logs and health trend tracking</span>
                            </li>
                            <li class="landing-why__item">
                                <span class="landing-why__item-icon" aria-hidden="true"><i class="bi bi-check"></i></span>
                                <span class="landing-why__item-text">Works with your existing smart home setup</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- =====================================================
             CTA SECTION
             ===================================================== -->
        <section class="landing-section landing-cta" id="contact" aria-labelledby="ctaTitle">
            <div class="landing-section__inner landing-cta__inner landing-reveal">
                <h2 class="landing-cta__title" id="ctaTitle">Ready to upgrade your pet's routine?</h2>
                <p class="landing-cta__text">
                    Join pet parents who trust ProxiEat to keep their companions
                    happy, healthy, and well-fed.
                </p>
                <div class="landing-cta__actions">
                    <a href="image-analysis/camera.php" class="landing-btn landing-btn--primary landing-btn--lg">
                        Get Started
                    </a>
                    <a href="#features" class="landing-btn landing-btn--secondary landing-btn--lg">
                        Explore Features
                    </a>
                </div>
            </div>
        </section>

        <!-- =====================================================
             FOOTER
             ===================================================== -->
        <footer class="landing-footer">
            <div class="landing-footer__inner">
                <div class="landing-footer__brand">
                    <span class="landing-footer__brand-icon" aria-hidden="true">
                        <i class="bi bi-heart-pulse"></i>
                    </span>
                    ProxiEat
                </div>

                <ul class="landing-footer__links">
                    <li><a href="#features" class="landing-footer__link">Features</a></li>
                    <li><a href="#why" class="landing-footer__link">About</a></li>
                    <li><a href="#contact" class="landing-footer__link">Contact</a></li>
                    <li><a href="image-analysis/camera.php" class="landing-footer__link">Login</a></li>
                </ul>

                <div class="landing-footer__social">
                    <a href="#" class="landing-footer__social-link" aria-label="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="landing-footer__social-link" aria-label="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="landing-footer__social-link" aria-label="Twitter">
                        <i class="bi bi-twitter-x"></i>
                    </a>
                </div>
            </div>
            <div class="landing-footer__bottom">
                &copy; <span id="currentYear"></span> ProxiEat. All rights reserved.
            </div>
        </footer>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="..\assets\js\landing\landing.js?v=<?= time() ?>"></script>

    <script>
        // Set dynamic copyright year
        document.getElementById('currentYear').textContent = new Date().getFullYear();
    </script>
</body>
</html>
