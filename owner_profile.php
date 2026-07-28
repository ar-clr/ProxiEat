<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ProxiEat | Owner Profile</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link href="assets/css/dashboard.css" rel="stylesheet">
        <link href="assets/css/owners.css" rel="stylesheet">
    </head>
    <body>
        <div class="app-shell d-flex">
            <aside class="sidebar d-flex flex-column">
                <div class="brand d-flex align-items-center gap-2 px-4 py-4">
                    <span class="brand-mark">
                        <i class="bi bi-heart-pulse-fill">
                        </i>
                    </span>
                    <span>ProxiEat</span>
                </div>
                <nav class="nav flex-column px-3 gap-1">
                    <a class="nav-link" href="index.php">
                        <i class="bi bi-grid-1x2-fill">
                        </i> Dashboard</a>
                    <a class="nav-link" href="pet_boarding.php">
                        <i class="bi bi-house-heart">
                        </i> Pet Boarding</a>
                    <a class="nav-link" href="pet_management.php">
                        <i class="bi bi-heart">
                        </i> Pets</a>
                    <a class="nav-link active" href="owner_management.php">
                        <i class="bi bi-people">
                        </i> Pet Owners</a>
                    <a class="nav-link" href="#">
                        <i class="bi bi-egg-fried">
                        </i> Pet Feeders</a>
                    <a class="nav-link" href="#">
                        <i class="bi bi-calendar-check">
                        </i> Feeding Schedule</a>
                    <a class="nav-link" href="#">
                        <i class="bi bi-camera-video">
                        </i> Camera Monitoring</a>
                    <a class="nav-link" href="#">
                        <i class="bi bi-file-earmark-bar-graph">
                        </i> Reports</a>
                    <a class="nav-link" href="#">
                        <i class="bi bi-gear">
                        </i> Settings</a>
                </nav>
            </aside>
            <div class="content-wrap flex-grow-1">
                <nav class="topbar navbar bg-white border-bottom px-3 px-lg-4">
                    <h1 class="h5 mb-0 fw-semibold text-dark">Owner Profile</h1>
                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-light position-relative rounded-circle notification-btn">
                            <i class="bi bi-bell fs-5">
                            </i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                        </button>
                        <div class="dropdown">
                            <button class="btn profile-button dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                                <img src="https://i.pravatar.cc/80?img=47" alt="Front Desk Staff" class="profile-photo">
                                <span class="d-none d-sm-inline fw-semibold small">Front Desk Staff</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#">Profile</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Settings</a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <main class="dashboard-content p-3 p-md-4">
                    <a href="owner_management.php" class="btn btn-sm btn-link text-decoration-none px-0 mb-3">
                        <i class="bi bi-arrow-left me-1">
                        </i>Back to Pet Owners</a>
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
                        <div class="d-flex gap-3 align-items-center">
                            <img src="https://i.pravatar.cc/120?img=49" class="rounded-circle owner-photo" style="width:72px;height:72px" alt="Maria Santos">
                            <div>
                                <h2 class="h3 fw-bold mb-1">Maria Santos</h2>
                                <span class="badge status-active">Active</span>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary">
                                <i class="bi bi-pencil me-1">
                                </i>Edit Owner</button>
                            <button class="btn btn-primary">
                                <i class="bi bi-plus-lg me-1">
                                </i>Register New Pet</button>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-lg-7">
                            <section class="card mb-4">
                                <div class="card-body p-4">
                                    <h3 class="profile-section-title">Owner Information</h3>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <p class="info-label">Full Name</p>
                                            <p class="info-value">Maria Santos</p>
                                            <p class="info-label">Contact Number</p>
                                            <p class="info-value">0917 555 0142</p>
                                            <p class="info-label">Email Address</p>
                                            <p class="info-value">maria.santos@email.com</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="info-label">Address</p>
                                            <p class="info-value">24 Mabini Street, Quezon City</p>
                                            <p class="info-label">Registered Since</p>
                                            <p class="info-value">January 12, 2025</p>
                                            <p class="info-label">Preferred Contact Method</p>
                                            <p class="info-value">Mobile Phone</p>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section class="card">
                                <div class="card-body p-4">
                                    <h3 class="profile-section-title">Registered Pets</h3>
                                    <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                                        <div class="d-flex gap-2 align-items-center">
                                            <span class="pet-avatar">
                                                <i class="bi bi-heart-fill">
                                                </i>
                                            </span>
                                            <div>
                                                <strong>Bella</strong>
                                                <small class="d-block text-muted">Golden Retriever • Female • 4 years</small>
                                            </div>
                                        </div>
                                        <span class="badge status-active">Active</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between pt-3">
                                        <div class="d-flex gap-2 align-items-center">
                                            <span class="pet-avatar">
                                                <i class="bi bi-heart-fill">
                                                </i>
                                            </span>
                                            <div>
                                                <strong>Milo</strong>
                                                <small class="d-block text-muted">Domestic Shorthair • Male • 2 years</small>
                                            </div>
                                        </div>
                                        <span class="badge status-active">Active</span>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-lg-5">
                            <section class="card mb-4">
                                <div class="card-body p-4">
                                    <h3 class="profile-section-title">Emergency Contact</h3>
                                    <p class="info-label mt-3">Contact Person</p>
                                    <p class="info-value">Roberto Santos</p>
                                    <p class="info-label">Relationship</p>
                                    <p class="info-value">Spouse</p>
                                    <p class="info-label">Contact Number</p>
                                    <p class="info-value mb-0">0918 445 7289</p>
                                </div>
                            </section>
                            <section class="card">
                                <div class="card-body p-4">
                                    <h3 class="profile-section-title">Recent Boarding History</h3>
                                    <div class="history-item mt-3">
                                        <strong class="small">Bella checked in</strong>
                                        <p class="text-muted small mb-0">Jul 23, 2026 • Room A-03</p>
                                    </div>
                                    <div class="history-item">
                                        <strong class="small">Milo checked out</strong>
                                        <p class="text-muted small mb-0">Jun 18, 2026 • Room C-01</p>
                                    </div>
                                    <div class="history-item pb-0">
                                        <strong class="small">Boarding reservation created</strong>
                                        <p class="text-muted small mb-0">May 30, 2026 • Bella</p>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
        </script>
    </body>
</html>