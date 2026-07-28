<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ProxiEat | Front Desk Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link href="assets/css/dashboard.css" rel="stylesheet">
    </head>
    <body>
        <div class="app-shell d-flex">
            <aside class="sidebar d-flex flex-column" id="sidebar">
                <div class="brand d-flex align-items-center gap-2 px-4 py-4">
                    <span class="brand-mark">
                        <i class="bi bi-heart-pulse-fill">
                        </i>
                    </span>
                    <span>ProxiEat</span>
                </div>
                <nav class="nav flex-column px-3 gap-1">
                    <a class="nav-link active" href="#">
                        <i class="bi bi-grid-1x2-fill">
                        </i> Dashboard</a>
                    <a class="nav-link" href="pet_boarding.php">
                        <i class="bi bi-house-heart">
                        </i> Pet Boarding</a>
                    <a class="nav-link" href="pet_management.php">
                        <i class="bi bi-heart">
                        </i> Pets</a>
                    <a class="nav-link" href="owner_management.php">
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
                <div class="sidebar-help m-3 mt-auto p-3 rounded-3">
                    <i class="bi bi-question-circle me-1">
                    </i>
                    <strong>Need help?</strong>
                    <p class="mb-0 mt-1">Contact the system administrator.</p>
                </div>
            </aside>
            <div class="content-wrap flex-grow-1">
                <nav class="topbar navbar bg-white border-bottom px-3 px-lg-4">
                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-light d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-label="Open menu">
                            <i class="bi bi-list fs-5">
                            </i>
                        </button>
                        <h1 class="h5 mb-0 fw-semibold text-dark">Front Desk Dashboard</h1>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-light position-relative rounded-circle notification-btn" aria-label="Notifications">
                            <i class="bi bi-bell fs-5">
                            </i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                        </button>
                        <div class="dropdown">
                            <button class="btn profile-button dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://i.pravatar.cc/80?img=47" alt="Front Desk Staff" class="profile-photo">
                                <span class="d-none d-sm-inline text-start">
                                    <span class="d-block fw-semibold small">Front Desk Staff</span>
                                    <span class="d-block text-muted role-label">Consult A Vet</span>
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-person me-2">
                                        </i>Profile</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-gear me-2">
                                        </i>Settings</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#">
                                        <i class="bi bi-box-arrow-right me-2">
                                        </i>Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <main class="dashboard-content p-3 p-md-4">
                    <section class="mb-4">
                        <h2 class="h3 fw-bold mb-1">Welcome back, Front Desk Staff!</h2>
                        <p class="text-muted mb-0">Manage pet boarding operations and monitor daily activities.</p>
                    </section>
                    <section class="row g-3 mb-4" aria-label="Boarding summary">
                        <div class="col-6 col-xl">
                            <div class="card summary-card h-100">
                                <div class="card-body">
                                    <span class="summary-icon blue">
                                        <i class="bi bi-heart-fill">
                                        </i>
                                    </span>
                                    <p class="summary-label">Total Boarding Pets</p>
                                    <h3>24</h3>
                                    <p class="summary-note">Currently staying</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-xl">
                            <div class="card summary-card h-100">
                                <div class="card-body">
                                    <span class="summary-icon green">
                                        <i class="bi bi-egg-fried">
                                        </i>
                                    </span>
                                    <p class="summary-label">Available Pet Feeders</p>
                                    <h3>8</h3>
                                    <p class="summary-note">Ready to assign</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-xl">
                            <div class="card summary-card h-100">
                                <div class="card-body">
                                    <span class="summary-icon orange">
                                        <i class="bi bi-inbox-fill">
                                        </i>
                                    </span>
                                    <p class="summary-label">Occupied Pet Feeders</p>
                                    <h3>16</h3>
                                    <p class="summary-note">Currently in use</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-xl">
                            <div class="card summary-card h-100">
                                <div class="card-body">
                                    <span class="summary-icon blue">
                                        <i class="bi bi-box-arrow-in-right">
                                        </i>
                                    </span>
                                    <p class="summary-label">Today's Check-ins</p>
                                    <h3>5</h3>
                                    <p class="summary-note">Scheduled arrivals</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-xl">
                            <div class="card summary-card h-100">
                                <div class="card-body">
                                    <span class="summary-icon red">
                                        <i class="bi bi-box-arrow-right">
                                        </i>
                                    </span>
                                    <p class="summary-label">Today's Check-outs</p>
                                    <h3>3</h3>
                                    <p class="summary-note">Scheduled departures</p>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="row g-4">
                        <div class="col-xl-8">
                            <!-- Header -->
                            <div class="mb-3">
                                <h2 class="h4 fw-bold mb-1">Current Pet Boarding</h2>
                                <p class="text-muted mb-3">
                                    Manage all pets currently staying in the Pet Hotel.
                                </p>
                                <div class="d-flex flex-wrap gap-2">
                                    <button class="btn btn-primary">
                                        <i class="bi bi-plus-lg me-2">
                                        </i>
                                        New Boarding
                                    </button>
                                    <button class="btn btn-success">
                                        <i class="bi bi-diagram-3 me-2">
                                        </i>
                                        Assign Pet Feeder
                                    </button>
                                    <button class="btn btn-outline-secondary">
                                        <i class="bi bi-file-earmark-text me-2">
                                        </i>
                                        Generate Report
                                    </button>
                                </div>
                            </div>
                            <!-- Table -->
                            <div class="card border-0 shadow-sm rounded-4 table-card">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Pet Name</th>
                                                <th>Owner</th>
                                                <th>Assigned Room</th>
                                                <th>Assigned Feeder</th>
                                                <th>Check-in</th>
                                                <th>Check-out</th>
                                                <th>Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <strong>Bella</strong>
                                                    <div class="small text-muted">
                                                        Golden Retriever
                                                    </div>
                                                </td>
                                                <td>Maria Santos</td>
                                                <td>Room A-03</td>
                                                <td>F-01</td>
                                                <td>Jul 23, 2026</td>
                                                <td>Jul 27, 2026</td>
                                                <td>
                                                    <span class="badge bg-primary">
                                                        Boarding
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="dropdown">
                                                        <button
                                                        class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                                        data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a class="dropdown-item" href="#">
                                                                View Details
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#">
                                                                Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#">
                                                                Assign Feeder
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Max</strong>
                                                <div class="small text-muted">
                                                    Beagle
                                                </div>
                                            </td>
                                            <td>John Reyes</td>
                                            <td>Room B-01</td>
                                            <td>F-04</td>
                                            <td>Jul 22, 2026</td>
                                            <td>Jul 25, 2026</td>
                                            <td>
                                                <span class="badge bg-warning text-dark">
                                                    Checking Out Today
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <button
                                                    class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                                    data-bs-toggle="dropdown">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="#">View Details</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">Edit</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">Assign Feeder</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Luna</strong>
                                            <div class="small text-muted">
                                                Persian Cat
                                            </div>
                                        </td>
                                        <td>Anne Cruz</td>
                                        <td>Room C-02</td>
                                        <td class="text-muted">
                                            Not Assigned
                                        </td>
                                        <td>Jul 25, 2026</td>
                                        <td>Jul 29, 2026</td>
                                        <td>
                                            <span class="badge bg-success">
                                                Reserved
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button
                                                class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                                data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="#">View Details</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#">Edit</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#">Assign Feeder</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Rocky</strong>
                                        <div class="small text-muted">
                                            Shih Tzu
                                        </div>
                                    </td>
                                    <td>Daniel Garcia</td>
                                    <td>Room A-06</td>
                                    <td>F-09</td>
                                    <td>Jul 24, 2026</td>
                                    <td>Jul 28, 2026</td>
                                    <td>
                                        <span class="badge bg-primary">
                                            Boarding
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button
                                            class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                            data-bs-toggle="dropdown">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="#">View Details</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">Edit</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">Assign Feeder</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card side-card mb-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h2 class="h5 fw-bold mb-0">Today's Schedule</h2>
                </div>
                <div class="card-body px-4 pt-2">
                    <div class="schedule-item">
                        <span class="schedule-icon checkin">
                            <i class="bi bi-box-arrow-in-right">
                            </i>
                        </span>
                        <div>
                            <strong>9:00 AM</strong>
                            <p>Bella <span>• Check In</span>
                            </p>
                        </div>
                    </div>
                    <div class="schedule-item">
                        <span class="schedule-icon feeding">
                            <i class="bi bi-egg-fried">
                            </i>
                        </span>
                        <div>
                            <strong>10:30 AM</strong>
                            <p>Max <span>• Feeding</span>
                            </p>
                        </div>
                    </div>
                    <div class="schedule-item">
                        <span class="schedule-icon checkin">
                            <i class="bi bi-box-arrow-in-right">
                            </i>
                        </span>
                        <div>
                            <strong>2:00 PM</strong>
                            <p>Luna <span>• Check In</span>
                            </p>
                        </div>
                    </div>
                    <div class="schedule-item mb-0">
                        <span class="schedule-icon checkout">
                            <i class="bi bi-box-arrow-right">
                            </i>
                        </span>
                        <div>
                            <strong>5:00 PM</strong>
                            <p>Charlie <span>• Check Out</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card side-card">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h2 class="h5 fw-bold mb-0">Recent Activities</h2>
                </div>
                <div class="card-body px-4 pt-2">
                    <div class="activity-item">
                        <span class="activity-dot bg-success">
                        </span>
                        <div>
                            <p>Pet Bella checked in.</p>
                            <small>10 minutes ago</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <span class="activity-dot bg-primary">
                        </span>
                        <div>
                            <p>Pet Max assigned to Feeder F-01.</p>
                            <small>35 minutes ago</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <span class="activity-dot bg-warning">
                        </span>
                        <div>
                            <p>Boarding record updated.</p>
                            <small>1 hour ago</small>
                        </div>
                    </div>
                    <div class="activity-item mb-0">
                        <span class="activity-dot bg-secondary">
                        </span>
                        <div>
                            <p>Pet Charlie checked out.</p>
                            <small>2 hours ago</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
</div>
</div>
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar">
    <div class="offcanvas-header">
        <div class="brand text-primary">
            <span class="brand-mark">
                <i class="bi bi-heart-pulse-fill">
                </i>
            </span> ProxiEat</div>
        <button class="btn-close" data-bs-dismiss="offcanvas">
        </button>
    </div>
    <div class="offcanvas-body p-0">
        <nav class="nav flex-column px-3 gap-1">
            <a class="nav-link active" href="index.php">Dashboard</a>
            <a class="nav-link" href="pet_boarding.php">Pet Boarding</a>
            <a class="nav-link" href="pet_management.php">Pets</a>
            <a class="nav-link" href="owner_management.php">Pet Owners</a>
            <a class="nav-link" href="#">Pet Feeders</a>
            <a class="nav-link" href="#">Feeding Schedule</a>
            <a class="nav-link" href="#">Camera Monitoring</a>
            <a class="nav-link" href="#">Reports</a>
            <a class="nav-link" href="#">Settings</a>
        </nav>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>
</body>
</html>