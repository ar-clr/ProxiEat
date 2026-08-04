<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paws Up - Pet Feeder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="../assets/css/core/variables.css?v=<?= time() ?>" rel="stylesheet">
    <link href="../assets/css/layout/sidebar.css?v=<?= time() ?>" rel="stylesheet">
    <link href="../assets/css/pages/pet-feeder.css?v=<?= time() ?>" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/components/chatbot/chatbot.css?v=<?= time() ?>">

</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <?php
    $hasPetHotel = isset($_GET['hotel']) && $_GET['hotel'] == '1';
    ?>

    <main class="proxieat-main">
        <header class="proxieat-main__header">
            <h1 class="proxieat-main__title">Pet Feeder</h1>
            <p class="proxieat-main__subtitle">Monitor your pet's feeding while staying at our Pet Hotel.</p>
        </header>

        <div class="proxieat-main__content">
            <?php if ($hasPetHotel): ?>
                <div class="proxieat-dashboard-wrapper is-loading" id="dashboardWrapper">
                    <div class="proxieat-skeleton" aria-hidden="true">
                        <div class="proxieat-skeleton__hero">
                            <div class="proxieat-skeleton__hero-circle proxieat-skeleton__block"></div>
                            <div class="proxieat-skeleton__hero-text">
                                <div class="proxieat-skeleton__hero-title proxieat-skeleton__block"></div>
                                <div class="proxieat-skeleton__hero-subtitle proxieat-skeleton__block"></div>
                            </div>
                            <div class="proxieat-skeleton__hero-chip proxieat-skeleton__block"></div>
                            <div class="proxieat-skeleton__hero-btn proxieat-skeleton__block"></div>
                        </div>

                        <div class="proxieat-skeleton__carousel">
                            <div class="proxieat-skeleton__carousel-arrow proxieat-skeleton__block"></div>
                            <div class="proxieat-skeleton__carousel-pets">
                                <div class="proxieat-skeleton__pet">
                                    <div class="proxieat-skeleton__pet-circle proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__pet-name proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__pet-species proxieat-skeleton__block"></div>
                                </div>
                                <div class="proxieat-skeleton__pet">
                                    <div class="proxieat-skeleton__pet-circle proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__pet-name proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__pet-species proxieat-skeleton__block"></div>
                                </div>
                                <div class="proxieat-skeleton__pet">
                                    <div class="proxieat-skeleton__pet-circle proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__pet-name proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__pet-species proxieat-skeleton__block"></div>
                                </div>
                            </div>
                            <div class="proxieat-skeleton__carousel-arrow proxieat-skeleton__block"></div>
                        </div>

                        <div class="proxieat-skeleton__row">
                            <div class="proxieat-skeleton__info">
                                <div class="proxieat-skeleton__info-header">
                                    <div class="proxieat-skeleton__info-avatar proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__info-text">
                                        <div class="proxieat-skeleton__info-name proxieat-skeleton__block"></div>
                                        <div class="proxieat-skeleton__info-species proxieat-skeleton__block"></div>
                                    </div>
                                </div>
                                <div class="proxieat-skeleton__info-rows">
                                    <div class="proxieat-skeleton__info-row proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__info-row proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__info-row proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__info-row proxieat-skeleton__block"></div>
                                </div>
                            </div>
                            <div class="proxieat-skeleton__status">
                                <div class="proxieat-skeleton__status-card">
                                    <div class="proxieat-skeleton__status-icon proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__status-label proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__status-value proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__status-support proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__status-bar proxieat-skeleton__block"></div>
                                </div>
                                <div class="proxieat-skeleton__status-card">
                                    <div class="proxieat-skeleton__status-icon proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__status-label proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__status-value proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__status-support proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__status-bar proxieat-skeleton__block"></div>
                                </div>
                                <div class="proxieat-skeleton__status-card">
                                    <div class="proxieat-skeleton__status-icon proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__status-label proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__status-value proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__status-support proxieat-skeleton__block"></div>
                                </div>
                                <div class="proxieat-skeleton__status-card">
                                    <div class="proxieat-skeleton__status-icon proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__status-label proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__status-value proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__status-support proxieat-skeleton__block"></div>
                                </div>
                            </div>
                        </div>

                        <div class="proxieat-skeleton__row">
                            <div class="proxieat-skeleton__feeding">
                                <div class="proxieat-skeleton__feeding-title proxieat-skeleton__block"></div>
                                <div class="proxieat-skeleton__feeding-row proxieat-skeleton__block"></div>
                                <div class="proxieat-skeleton__feeding-row proxieat-skeleton__block"></div>
                                <div class="proxieat-skeleton__feeding-row proxieat-skeleton__block"></div>
                            </div>
                            <div class="proxieat-skeleton__activity">
                                <div class="proxieat-skeleton__activity-title proxieat-skeleton__block"></div>
                                <div class="proxieat-skeleton__activity-row">
                                    <div class="proxieat-skeleton__activity-time proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__activity-text proxieat-skeleton__block"></div>
                                </div>
                                <div class="proxieat-skeleton__activity-row">
                                    <div class="proxieat-skeleton__activity-time proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__activity-text proxieat-skeleton__block"></div>
                                </div>
                                <div class="proxieat-skeleton__activity-row">
                                    <div class="proxieat-skeleton__activity-time proxieat-skeleton__block"></div>
                                    <div class="proxieat-skeleton__activity-text proxieat-skeleton__block"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="proxieat-dashboard">

                    <div class="proxieat-hero">
                        <div class="proxieat-hero__deco" aria-hidden="true">
                            <i class="bi bi-paw-fill"></i>
                        </div>
                        <div class="proxieat-hero__left">
                            <div class="proxieat-hero__avatar">
                                <span class="proxieat-hero__avatar-letter">L</span>
                            </div>
                            <div class="proxieat-hero__text">
                                <h2 class="proxieat-hero__title" id="heroGreeting">🐾 Luna is doing great today.</h2>
                                <p class="proxieat-hero__subtitle" id="heroSubtitle">See Luna's latest activities.</p>
                            </div>
                            <span class="proxieat-hero__chip">Online</span>
                        </div>
                        <a href="#" class="proxieat-hero__btn">Open Live Monitoring</a>
                        <i class="bi bi-star-fill proxieat-hero__sparkle" aria-hidden="true"></i>
                    </div>

                    <div class="proxieat-selector">
                        <button class="proxieat-selector__arrow proxieat-selector__arrow--left" type="button" aria-label="Previous pet">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <div class="proxieat-selector__pets">
                            <div class="proxieat-selector__pet is-selected" data-pet="luna" role="button" tabindex="0">
                                <div class="proxieat-selector__avatar">L</div>
                                <span class="proxieat-selector__name">Luna</span>
                                <span class="proxieat-selector__species">Dog</span>
                            </div>
                            <div class="proxieat-selector__pet" data-pet="mochi" role="button" tabindex="0">
                                <div class="proxieat-selector__avatar">M</div>
                                <span class="proxieat-selector__name">Mochi</span>
                                <span class="proxieat-selector__species">Cat</span>
                            </div>
                            <div class="proxieat-selector__pet" data-pet="max" role="button" tabindex="0">
                                <div class="proxieat-selector__avatar">M</div>
                                <span class="proxieat-selector__name">Max</span>
                                <span class="proxieat-selector__species">Dog</span>
                            </div>
                        </div>
                        <button class="proxieat-selector__arrow proxieat-selector__arrow--right" type="button" aria-label="Next pet">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>

                    <div class="proxieat-dashboard__row">
                        <div class="proxieat-info">
                            <div class="proxieat-info__header">
                                <div class="proxieat-info__avatar">L</div>
                                <div>
                                    <h3 class="proxieat-info__name">Luna</h3>
                                    <p class="proxieat-info__species">Dog</p>
                                </div>
                            </div>
                            <div class="proxieat-info__details">
                                <div class="proxieat-info__row">
                                    <span class="proxieat-info__label">Current Stay</span>
                                    <span class="proxieat-info__value">Deluxe Suite</span>
                                </div>
                                <div class="proxieat-info__row">
                                    <span class="proxieat-info__label">Checked-in Date</span>
                                    <span class="proxieat-info__value">Aug 1, 2026</span>
                                </div>
                                <div class="proxieat-info__row">
                                    <span class="proxieat-info__label">Expected Checkout</span>
                                    <span class="proxieat-info__value">Aug 5, 2026</span>
                                </div>
                                <div class="proxieat-info__row">
                                    <span class="proxieat-info__label">Room Number</span>
                                    <span class="proxieat-info__value">12</span>
                                </div>
                            </div>
                        </div>
                        <div class="proxieat-status">
                            <div class="proxieat-status__card">
                                <div class="proxieat-status__header">
                                    <i class="bi bi-basket2"></i>
                                    <span class="proxieat-status__label">Food Supply</span>
                                </div>
                                <span class="proxieat-status__value">82%</span>
                                <span class="proxieat-status__support">Enough for approximately 3 days</span>
                                <div class="proxieat-status__bar">
                                    <div class="proxieat-status__bar-fill" style="width: 82%"></div>
                                </div>
                            </div>
                            <div class="proxieat-status__card">
                                <div class="proxieat-status__header">
                                    <i class="bi bi-droplet"></i>
                                    <span class="proxieat-status__label">Water Supply</span>
                                </div>
                                <span class="proxieat-status__value">87%</span>
                                <span class="proxieat-status__support">Tank is almost full</span>
                                <div class="proxieat-status__bar">
                                    <div class="proxieat-status__bar-fill" style="width: 87%"></div>
                                </div>
                            </div>
                            <div class="proxieat-status__card">
                                <div class="proxieat-status__header">
                                    <i class="bi bi-check-circle"></i>
                                    <span class="proxieat-status__label">Food Bowl</span>
                                </div>
                                <span class="proxieat-status__value">Ready</span>
                                <span class="proxieat-status__support">Meal prepared</span>
                            </div>
                            <div class="proxieat-status__card">
                                <div class="proxieat-status__header">
                                    <i class="bi bi-exclamation-circle"></i>
                                    <span class="proxieat-status__label">Water Bowl</span>
                                </div>
                                <span class="proxieat-status__value">Needs Refill</span>
                                <span class="proxieat-status__support">Recommended soon</span>
                            </div>
                        </div>
                    </div>

                    <div class="proxieat-dashboard__row">
                        <div class="proxieat-feeding">
                            <h3 class="proxieat-feeding__title">Today's Feeding</h3>
                            <div class="proxieat-feeding__list">
                                <div class="proxieat-feeding__item is-completed">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Breakfast</span>
                                </div>
                                <div class="proxieat-feeding__item is-completed">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Lunch</span>
                                </div>
                                <div class="proxieat-feeding__item">
                                    <i class="bi bi-circle"></i>
                                    <span>Dinner</span>
                                </div>
                            </div>
                        </div>
                        <div class="proxieat-activity">
                            <h3 class="proxieat-activity__title">Latest Activity</h3>
                            <div class="proxieat-activity__list">
                                <div class="proxieat-activity__item">
                                    <span class="proxieat-activity__time">9:05 AM</span>
                                    <span class="proxieat-activity__text">Food dispensed</span>
                                </div>
                                <div class="proxieat-activity__item">
                                    <span class="proxieat-activity__time">8:57 AM</span>
                                    <span class="proxieat-activity__text">Pet visited feeder</span>
                                </div>
                                <div class="proxieat-activity__item">
                                    <span class="proxieat-activity__time">8:40 AM</span>
                                    <span class="proxieat-activity__text">Water refilled</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php else: ?>
                <div class="proxieat-empty">
                    <div class="proxieat-empty__icon" aria-hidden="true">
                        <i class="bi bi-paw"></i>
                    </div>
                    <h2 class="proxieat-empty__title">No active Pet Hotel stay</h2>
                    <p class="proxieat-empty__description">ProxiEat becomes available whenever one of your pets is checked into the Pet Hotel.</p>
                    <a href="#" class="proxieat-empty__btn">Book a Pet Hotel Stay</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include __DIR__ . '/../chatbot/chatbot.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/camera/camera.js?v=<?= time() ?>"></script>

    <script src="../assets/vendor/marked/markdown.js?v=<?= time() ?>"></script>
    <!-- <script src="assets/js/vendor/purify.min.js"></script> -->
     
    <script src="../assets/js/chatbot/chatbot-ui.js?v=<?= time() ?>"></script>
    <script src="../assets/js/chatbot/chatbot-renderer.js?v=<?= time() ?>"></script>
    <script src="../assets/js/chatbot/chatbot-typing.js?v=<?= time() ?>"></script>
    <script src="../assets/js/chatbot/chatbot-api.js?v=<?= time() ?>"></script>
    <script src="../assets/js/chatbot/chatbot-controller.js?v=<?= time() ?>"></script>
    <script src="../assets/js/chatbot/chatbot.js?v=<?= time() ?>"></script>

    <script src="../assets/js/proxieat-user/pet-feeder.js?v=<?= time() ?>"></script>
    
</body>
</html>
