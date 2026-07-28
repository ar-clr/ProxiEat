<?php
$feeders = [
    ['F-001', 'Room 01', 'Bella', '95%', '100%', '3 / 4', 'Available', 'available'],
    ['F-002', 'Room 03', 'Max', '80%', '75%', '2 / 4', 'Assigned', 'assigned'],
    ['F-003', 'Room 05', 'Buddy', '42%', '45%', '4 / 4', 'Assigned', 'assigned'],
    ['F-004', 'Room 06', 'Not Assigned', '15%', '10%', '0 / 4', 'Maintenance', 'maintenance'],
    ['F-005', 'Room 08', 'Coco', '80%', '100%', '3 / 4', 'Assigned', 'assigned'],
    ['F-006', 'Room 10', 'Not Assigned', '95%', '75%', '0 / 4', 'Offline', 'offline'],
];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ProxiEat | Pet Feeders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="assets/css/dashboard.css" rel="stylesheet">
    <link href="assets/css/feeders.css" rel="stylesheet">
</head>
<body>
    <div class="app-shell d-flex">
        <aside class="sidebar d-flex flex-column">
            <div class="brand d-flex align-items-center gap-2 px-4 py-4">
                <span class="brand-mark"><i class="bi bi-heart-pulse-fill"></i></span>
                <span>ProxiEat</span>
            </div>
            <nav class="nav flex-column px-3 gap-1">
                <a class="nav-link" href="index.php"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a>
                <a class="nav-link" href="pet_boarding.php"><i class="bi bi-house-heart"></i> Pet Boarding</a>
                <a class="nav-link" href="pet_management.php"><i class="bi bi-heart"></i> Pets</a>
                <a class="nav-link" href="owner_management.php"><i class="bi bi-people"></i> Pet Owners</a>
                <a class="nav-link active" href="pet_feeders.php"><i class="bi bi-egg-fried"></i> Pet Feeders</a>
                <a class="nav-link" href="#"><i class="bi bi-calendar-check"></i> Feeding Schedule</a>
                <a class="nav-link" href="#"><i class="bi bi-camera-video"></i> Camera Monitoring</a>
                <a class="nav-link" href="#"><i class="bi bi-file-earmark-bar-graph"></i> Reports</a>
                <a class="nav-link" href="#"><i class="bi bi-gear"></i> Settings</a>
            </nav>
        </aside>
        <div class="content-wrap flex-grow-1">
            <nav class="topbar navbar bg-white border-bottom px-3 px-lg-4">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-light d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar"><i class="bi bi-list fs-5"></i></button>
                    <h1 class="h5 mb-0 fw-semibold text-dark">Pet Feeders</h1>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-light position-relative rounded-circle notification-btn"><i class="bi bi-bell fs-5"></i><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span></button>
                    <div class="dropdown">
                        <button class="btn profile-button dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                            <img src="https://i.pravatar.cc/80?img=47" alt="Front Desk Staff" class="profile-photo">
                            <span class="d-none d-sm-inline text-start"><span class="d-block fw-semibold small">Front Desk Staff</span><span class="d-block text-muted role-label">Consult A Vet</span></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <main class="dashboard-content p-3 p-md-4">
                <section class="mb-4">
                    <h2 class="h3 fw-bold mb-1">Pet Feeders</h2>
                    <p class="text-muted mb-0">Monitor and manage all ProxiEat Smart Pet Feeders assigned to boarding pets.</p>
                </section>
                <section class="row g-3 mb-4">
                    <div class="col-6 col-xl-3"><div class="card summary-card h-100"><div class="card-body"><span class="summary-icon blue"><i class="bi bi-egg-fried"></i></span><p class="summary-label">Total Feeders</p><h3>10</h3><p class="summary-note">Registered feeders</p></div></div></div>
                    <div class="col-6 col-xl-3"><div class="card summary-card h-100"><div class="card-body"><span class="summary-icon green"><i class="bi bi-check-circle"></i></span><p class="summary-label">Available Feeders</p><h3>3</h3><p class="summary-note">Ready to assign</p></div></div></div>
                    <div class="col-6 col-xl-3"><div class="card summary-card h-100"><div class="card-body"><span class="summary-icon blue"><i class="bi bi-link-45deg"></i></span><p class="summary-label">Feeders In Use</p><h3>6</h3><p class="summary-note">Assigned to pets</p></div></div></div>
                    <div class="col-6 col-xl-3"><div class="card summary-card h-100"><div class="card-body"><span class="summary-icon orange"><i class="bi bi-tools"></i></span><p class="summary-label">Under Maintenance</p><h3>1</h3><p class="summary-note">Needs attention</p></div></div></div>
                </section>
                <section class="card mb-4"><div class="card-body feeder-toolbar p-3"><div class="row g-2 align-items-center"><div class="col-12 col-lg-4"><div class="input-group"><span class="input-group-text"><i class="bi bi-search"></i></span><input type="search" class="form-control" placeholder="Search feeder ID..."></div></div><div class="col-6 col-md-4 col-lg-2"><select class="form-select"><option selected>Status: All</option><option>Available</option><option>Assigned</option><option>Maintenance</option><option>Offline</option></select></div><div class="col-6 col-md-4 col-lg-2"><select class="form-select"><option selected>Room: All</option><option>Room 01</option><option>Room 03</option><option>Room 05</option></select></div><div class="col-6 col-md-4 col-lg-2"><select class="form-select"><option selected>Newest First</option><option>Oldest First</option><option>Feeder ID (A-Z)</option></select></div><div class="col-6 col-lg-2 d-grid"><button class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Register New Feeder</button></div></div></div></section>
                <div class="d-flex justify-content-between align-items-center mb-3"><p class="record-count mb-0">Showing <strong>10</strong> Registered Feeders</p><button class="btn btn-sm btn-light text-secondary"><i class="bi bi-arrow-clockwise me-1"></i>Refresh</button></div>
                <section class="card feeder-table"><div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead><tr><th>Feeder ID</th><th>Assigned Room</th><th>Assigned Pet</th><th>Food Tank</th><th>Water Tank</th><th>Today's Feedings</th><th>Status</th><th class="text-center">Actions</th></tr></thead><tbody><?php foreach ($feeders as $feeder): ?><tr><td class="boarding-id"><?= $feeder[0] ?></td><td><?= $feeder[1] ?></td><td><?= $feeder[2] ?></td><td><div class="feeder-tank"><small class="fw-semibold"><?= $feeder[3] ?></small><div class="progress mt-1"><div class="progress-bar food" style="width: <?= $feeder[3] ?>"></div></div></div></td><td><div class="feeder-tank"><small class="fw-semibold"><?= $feeder[4] ?></small><div class="progress mt-1"><div class="progress-bar water" style="width: <?= $feeder[4] ?>"></div></div></div></td><td><?= $feeder[5] ?></td><td><span class="badge status-<?= $feeder[7] ?>"><?= $feeder[6] ?></span></td><td class="text-center"><div class="dropdown"><button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">Actions</button><ul class="dropdown-menu dropdown-menu-end"><li><a class="dropdown-item" href="feeder_details.php">View Feeder</a></li><li><a class="dropdown-item" href="#">Assign Pet</a></li><li><a class="dropdown-item" href="#">Unassign Pet</a></li><li><a class="dropdown-item" href="#">Edit</a></li><li><a class="dropdown-item" href="#">Maintenance</a></li></ul></div></td></tr><?php endforeach; ?></tbody></table></div></section>
                <nav class="mt-4" aria-label="Feeder pages"><ul class="pagination pagination-sm justify-content-center mb-0"><li class="page-item disabled"><a class="page-link" href="#">Previous</a></li><li class="page-item active"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="#">2</a></li><li class="page-item"><a class="page-link" href="#">Next</a></li></ul></nav>
            </main>
        </div>
    </div>
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar"><div class="offcanvas-header"><div class="brand text-primary"><span class="brand-mark"><i class="bi bi-heart-pulse-fill"></i></span> ProxiEat</div><button class="btn-close" data-bs-dismiss="offcanvas"></button></div><div class="offcanvas-body p-0"><nav class="nav flex-column px-3 gap-1"><a class="nav-link" href="index.php">Dashboard</a><a class="nav-link" href="pet_boarding.php">Pet Boarding</a><a class="nav-link" href="pet_management.php">Pets</a><a class="nav-link" href="owner_management.php">Pet Owners</a><a class="nav-link active" href="pet_feeders.php">Pet Feeders</a><a class="nav-link" href="#">Feeding Schedule</a><a class="nav-link" href="#">Camera Monitoring</a><a class="nav-link" href="#">Reports</a><a class="nav-link" href="#">Settings</a></nav></div></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
