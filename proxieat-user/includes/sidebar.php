<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<aside class="proxieat-sidebar" aria-label="ProxiEat navigation">
    <div class="proxieat-sidebar__brand">
        <div class="proxieat-sidebar__logo">
            <i class="bi bi-heart-pulse"></i>
        </div>
        <div class="proxieat-sidebar__brand-text">
            <span class="proxieat-sidebar__title">Paws Up</span>
            <span class="proxieat-sidebar__subtitle">ProxiEat Module</span>
        </div>
    </div>

    <nav class="proxieat-sidebar__nav">
        <a href="#" class="proxieat-sidebar__link">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>

        <div class="proxieat-sidebar__divider" role="separator"></div>

        <div class="proxieat-sidebar__section">
            <i class="bi bi-heart-pulse"></i>
            <span>ProxiEat</span>
        </div>

        <div class="proxieat-sidebar__divider" role="separator"></div>

        <a href="pet-feeder.php"
            class="proxieat-sidebar__link <?= $currentPage == 'pet-feeder.php' ? 'is-active' : '' ?>">
            <i class="bi bi-basket2"></i>
            <span>Pet Feeder</span>
        </a>

        <a href="live-monitoring.php"
            class="proxieat-sidebar__link <?= $currentPage == 'live-monitoring.php' ? 'is-active' : '' ?>">
            <i class="bi bi-camera-video"></i>
            <span>Live Monitoring</span>
        </a>

        <a href="#" class="proxieat-sidebar__link">
            <i class="bi bi-clock-history"></i>
            <span>Feeding History</span>
        </a>

        <a href="#" class="proxieat-sidebar__link">
            <i class="bi bi-bell"></i>
            <span>Alerts</span>
        </a>

        <a href="#" class="proxieat-sidebar__link">
            <i class="bi bi-calendar-check"></i>
            <span>Smart Feeding</span>
        </a>

        <div class="proxieat-sidebar__divider" role="separator"></div>

        <div class="proxieat-sidebar__footer">
            <a href="#" class="proxieat-sidebar__link proxieat-sidebar__link--logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
        </div>
    </nav>
</aside>
