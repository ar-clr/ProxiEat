<?php
$pets = [
['Bella','Golden Retriever','Dog','4 years','Female','Maria Santos','Active','active','47'], ['Max','Beagle','Dog','3 years','Male','John Reyes','Currently Boarding','boarding','12'], ['Luna','Persian','Cat','2 years','Female','Anne Cruz','Active','active','32'], ['Charlie','Poodle','Dog','5 years','Male','Carlo Mendoza','Inactive','inactive','15'], ['Coco','Pomeranian','Dog','2 years','Female','Ella Villanueva','Currently Boarding','boarding','44'], ['Kiwi','Lovebird','Bird','1 year','Male','Paolo Flores','Active','active','11'],
];
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ProxiEat | Pets</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link href="assets/css/dashboard.css" rel="stylesheet">
        <link href="assets/css/pets.css" rel="stylesheet">
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
                    <a class="nav-link active" href="pet_management.php">
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
                        <button class="btn btn-light d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                            <i class="bi bi-list fs-5">
                            </i>
                        </button>
                        <h1 class="h5 mb-0 fw-semibold text-dark">Pets</h1>
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
                        <h2 class="h3 fw-bold mb-1">Pets</h2>
                        <p class="text-muted mb-0">Manage all registered pets and their basic information.</p>
                    </section>
                    <section class="card mb-4">
                        <div class="card-body pets-toolbar p-3">
                            <div class="row g-2 align-items-center">
                                <div class="col-12 col-lg-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-search">
                                            </i>
                                        </span>
                                        <input type="search" class="form-control" placeholder="Search pet name, owner, breed, or species">
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 col-lg-2">
                                    <select class="form-select">
                                        <option selected>Species: All</option>
                                        <option>Dog</option>
                                        <option>Cat</option>
                                        <option>Bird</option>
                                        <option>Rabbit</option>
                                        <option>Others</option>
                                    </select>
                                </div>
                                <div class="col-6 col-md-3 col-lg-2">
                                    <select class="form-select">
                                        <option selected>Status: All</option>
                                        <option>Active</option>
                                        <option>Currently Boarding</option>
                                        <option>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-6 col-md-3 col-lg-2">
                                    <select class="form-select">
                                        <option selected>Newest First</option>
                                        <option>Oldest First</option>
                                        <option>Pet Name (A-Z)</option>
                                        <option>Pet Name (Z-A)</option>
                                    </select>
                                </div>
                                <div class="col-6 col-md-3 col-lg-2 d-grid">
                                    <button class="btn btn-primary">
                                        <i class="bi bi-plus-lg me-1">
                                        </i>Add New Pet</button>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="record-count mb-0">Showing <strong>48</strong> Registered Pets</p>
                        <button class="btn btn-sm btn-light text-secondary">
                            <i class="bi bi-arrow-clockwise me-1">
                            </i>Refresh</button>
                    </div>
                    <section class="card pet-table">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Pet Name</th>
                                        <th>Species</th>
                                        <th>Breed</th>
                                        <th>Age</th>
                                        <th>Sex</th>
                                        <th>Owner</th>
                                        <th>Current Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pets as $pet): ?>
                                        <tr>
                                            <td>
                                                <img src="https://i.pravatar.cc/80?img=<?= $pet[8] ?>" class="rounded-circle pet-photo" alt="<?= $pet[0] ?>">
                                            </td>
                                            <td>
                                                <strong>
                                                    <?= $pet[0] ?>
                                                </strong>
                                            </td>
                                            <td>
                                                <?= $pet[2] ?>
                                            </td>
                                            <td>
                                                <?= $pet[1] ?>
                                            </td>
                                            <td>
                                                <?= $pet[3] ?>
                                            </td>
                                            <td>
                                                <?= $pet[4] ?>
                                            </td>
                                            <td>
                                                <?= $pet[5] ?>
                                            </td>
                                            <td>
                                                <span class="badge status-<?= $pet[7] ?>">
                                                    <?= $pet[6] ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">Actions</button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a class="dropdown-item" href="#">View Profile</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#">Edit Pet</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#">View Boarding History</a>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-danger" href="#">Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                    <nav class="mt-4" aria-label="Pet pages">
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
                    <a class="nav-link" href="pet_boarding.php">Pet Boarding</a>
                    <a class="nav-link active" href="pet_management.php">Pets</a>
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