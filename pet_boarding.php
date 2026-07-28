<?php
$records = [
['BR-1024','Bella','Golden Retriever','Maria Santos','Room A-03','F-01','Jul 23, 2026','Jul 27, 2026','Checked In','checked-in'],
['BR-1023','Max','Beagle','John Reyes','Room B-01','F-04','Jul 22, 2026','Jul 25, 2026','Checking Out Today','checking-out'],
['BR-1022','Luna','Persian Cat','Anne Cruz','Room C-02','Not Assigned','Jul 26, 2026','Jul 29, 2026','Reserved','reserved'],
['BR-1021','Charlie','Poodle','Carlo Mendoza','Room A-07','F-09','Jul 21, 2026','Jul 25, 2026','Checked Out','checked-out'],
['BR-1020','Rocky','Shih Tzu','Daniel Garcia','Room A-06','F-09','Jul 24, 2026','Jul 28, 2026','Checked In','checked-in'],
['BR-1019','Coco','Pomeranian','Ella Villanueva','Room B-04','Not Assigned','Jul 27, 2026','Jul 30, 2026','Cancelled','cancelled'],
];
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ProxiEat | Pet Boarding</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link href="assets/css/dashboard.css" rel="stylesheet">
        <link href="assets/css/boarding.css" rel="stylesheet">
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
                    <a class="nav-link active" href="pet_boarding.php">
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
                        <button class="btn btn-light d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-label="Open menu">
                            <i class="bi bi-list fs-5">
                            </i>
                        </button>
                        <h1 class="h5 mb-0 fw-semibold text-dark">Pet Boarding</h1>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-light position-relative rounded-circle notification-btn">
                            <i class="bi bi-bell fs-5">
                            </i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                        </button>
                        <div class="dropdown">
                            <button class="btn profile-button dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                                <img src="https://i.pravatar.cc/80?img=47" alt="Front Desk Staff" class="profile-photo">
                                <span class="d-none d-sm-inline text-start">
                                    <span class="d-block fw-semibold small">Front Desk Staff</span>
                                    <span class="d-block text-muted role-label">Consult A Vet</span>
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li>
                                    <a class="dropdown-item" href="#">Profile</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Settings</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <main class="dashboard-content p-3 p-md-4">
                    <section class="mb-4">
                        <h2 class="h3 fw-bold mb-1">Pet Boarding</h2>
                        <p class="text-muted mb-0">Manage all pet boarding reservations, check-ins, and check-outs.</p>
                    </section>
                    <section class="card mb-4">
                        <div class="card-body boarding-toolbar p-3">
                            <div class="row g-2 align-items-center">
                                <div class="col-12 col-lg-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-search">
                                            </i>
                                        </span>
                                        <input type="search" class="form-control" placeholder="Search pet name, owner, room, or feeder">
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 col-lg-2">
                                    <select class="form-select">
                                        <option selected>Status: All</option>
                                        <option>Reserved</option>
                                        <option>Checked In</option>
                                        <option>Checking Out Today</option>
                                        <option>Checked Out</option>
                                        <option>Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-6 col-md-4 col-lg-2">
                                    <input type="date" class="form-control" aria-label="Boarding date">
                                </div>
                                <div class="col-6 col-md-4 col-lg-2">
                                    <select class="form-select">
                                        <option selected>Newest First</option>
                                        <option>Oldest First</option>
                                        <option>Pet Name (A-Z)</option>
                                        <option>Pet Name (Z-A)</option>
                                        <option>Check-in Date</option>
                                        <option>Check-out Date</option>
                                    </select>
                                </div>
                                <div class="col-6 col-lg-2 d-grid">
                                    <button class="btn btn-primary">
                                        <i class="bi bi-plus-lg me-1">
                                        </i>New Boarding</button>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="record-count mb-0">Showing <strong>12</strong> Boarding Records</p>
                        <button class="btn btn-sm btn-light text-secondary">
                            <i class="bi bi-arrow-clockwise me-1">
                            </i>Refresh</button>
                    </div>
                    <section class="card boarding-table">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Boarding ID</th>
                                        <th>Pet Name</th>
                                        <th>Owner</th>
                                        <th>Assigned Room</th>
                                        <th>Assigned Feeder</th>
                                        <th>Check-in Date</th>
                                        <th>Check-out Date</th>
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($records as $record): ?>
                                        <tr>
                                            <td class="boarding-id">
                                                <?= $record[0] ?>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <span class="pet-avatar">
                                                        <i class="bi bi-heart-fill">
                                                        </i>
                                                    </span>
                                                    <span>
                                                        <strong>
                                                            <?= $record[1] ?>
                                                        </strong>
                                                        <small class="d-block text-muted">
                                                            <?= $record[2] ?>
                                                        </small>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <?= $record[3] ?>
                                            </td>
                                            <td>
                                                <?= $record[4] ?>
                                            </td>
                                            <td>
                                                <?= $record[5] ?>
                                            </td>
                                            <td>
                                                <?= $record[6] ?>
                                            </td>
                                            <td>
                                                <?= $record[7] ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?= $record[9] ?>">
                                                    <?= $record[8] ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <?php include 'partials/actions.php'; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                    <nav class="mt-4" aria-label="Boarding pages">
                        <ul class="pagination pagination-sm justify-content-center mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#">Previous</a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
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
                    <a class="nav-link" href="index.php">Dashboard</a>
                    <a class="nav-link active" href="pet_boarding.php">Pet Boarding</a>
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