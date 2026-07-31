<?php
require_once __DIR__ . '/config/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Image Gallery - ProxiEat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="..\assets\css\core\variables.css?v=<?= time() ?>" rel="stylesheet">
    <link href="..\assets\css\pages\gallery.css?v=<?= time() ?>" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/components/chatbot/chatbot.css?v=<?= time() ?>">
</head>
<body>
    <div class="gallery-page">
        <header class="page-header">
            <h1>Image Gallery</h1>
            <p>Browse previously captured images and review their AI analysis history.</p>
        </header>

        <div class="gallery-toolbar">
            <div class="toolbar-row">
                <div class="toolbar-search">
                    <i class="bi bi-search"></i>
                    <input type="text" class="form-control" id="toolbarSearch" placeholder="Search images by date, mood, observation, or objects...">
                </div>

                <div class="toolbar-select">
                    <select class="form-select" id="sortSelect">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                    </select>
                </div>

                <div class="toolbar-chips">
                    <button class="chip-btn chip-active filter-chip" type="button" data-period="all">All</button>
                    <button class="chip-btn filter-chip" type="button" data-period="today">Today</button>
                    <button class="chip-btn filter-chip" type="button" data-period="week">This Week</button>
                    <button class="chip-btn filter-chip" type="button" data-period="month">This Month</button>
                </div>
            </div>
        </div>

        <div id="loadingState" class="d-none">
            <div class="skeleton-grid">
                <div class="skeleton-card">
                    <div class="skeleton-thumb"></div>
                    <div class="skeleton-body">
                        <div class="skeleton-line medium"></div>
                        <div class="skeleton-line short"></div>
                        <div class="skeleton-line"></div>
                    </div>
                </div>
                <div class="skeleton-card">
                    <div class="skeleton-thumb"></div>
                    <div class="skeleton-body">
                        <div class="skeleton-line medium"></div>
                        <div class="skeleton-line short"></div>
                        <div class="skeleton-line"></div>
                    </div>
                </div>
                <div class="skeleton-card">
                    <div class="skeleton-thumb"></div>
                    <div class="skeleton-body">
                        <div class="skeleton-line medium"></div>
                        <div class="skeleton-line short"></div>
                        <div class="skeleton-line"></div>
                    </div>
                </div>
                <div class="skeleton-card">
                    <div class="skeleton-thumb"></div>
                    <div class="skeleton-body">
                        <div class="skeleton-line medium"></div>
                        <div class="skeleton-line short"></div>
                        <div class="skeleton-line"></div>
                    </div>
                </div>
                <div class="skeleton-card">
                    <div class="skeleton-thumb"></div>
                    <div class="skeleton-body">
                        <div class="skeleton-line medium"></div>
                        <div class="skeleton-line short"></div>
                        <div class="skeleton-line"></div>
                    </div>
                </div>
                <div class="skeleton-card">
                    <div class="skeleton-thumb"></div>
                    <div class="skeleton-body">
                        <div class="skeleton-line medium"></div>
                        <div class="skeleton-line short"></div>
                        <div class="skeleton-line"></div>
                    </div>
                </div>
            </div>
        </div>

        <div id="emptyState" class="d-none">
            <div class="camera-card" style="max-width: 480px; margin: 0 auto;">
                <div class="card-body">
                    <div class="empty-state">
                        <div class="empty-illustration">
                            <i class="bi bi-images"></i>
                        </div>
                        <h3 class="empty-title">No captured images yet</h3>
                        <p class="empty-text">Images captured from the camera will appear here together with their AI analysis.</p>
                        <a href="camera.php" class="btn btn-primary">
                            <i class="bi bi-camera"></i>
                            Go to Camera
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="gallery-grid" id="galleryGrid"></div>
    </div>

    <!-- Detail Modal -->
    <div class="modal-overlay hidden" id="detailModal" aria-hidden="true">
        <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="detailModalTitle">
            <div class="modal-header">
                <h3 id="detailModalTitle">Capture Details</h3>
                <button class="modal-close" id="detailModalClose" type="button" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="modal-body" id="detailModalBody">
                <!-- Content injected by JS -->
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal-overlay hidden" id="deleteModal" aria-hidden="true">
        <div class="modal-card delete-modal-card" role="dialog" aria-modal="true" aria-labelledby="deleteModalTitle">
            <div class="delete-icon-wrapper">
                <i class="bi bi-trash"></i>
            </div>
            <h3 class="delete-modal-title" id="deleteModalTitle">Delete Capture?</h3>
            <p class="delete-modal-message">This will permanently remove the image and its AI analysis history.</p>
            <div class="delete-modal-actions">
                <button class="btn btn-outline-secondary" id="deleteModalCancel" type="button">Cancel</button>
                <button class="btn btn-outline-danger" id="deleteModalConfirm" type="button">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../chatbot/chatbot.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="..\assets\js\gallery\gallery.js?v=<?= time() ?>"></script>
    <script src="..\assets\vendor\marked\markdown.js?v=<?= time() ?>"></script>
    <script src="../assets/js/chatbot/chatbot-ui.js?v=<?= time() ?>"></script>
    <script src="../assets/js/chatbot/chatbot-renderer.js?v=<?= time() ?>"></script>
    <script src="../assets/js/chatbot/chatbot-typing.js?v=<?= time() ?>"></script>
    <script src="../assets/js/chatbot/chatbot-api.js?v=<?= time() ?>"></script>
    <script src="../assets/js/chatbot/chatbot-controller.js?v=<?= time() ?>"></script>
    <script src="../assets/js/chatbot/chatbot.js?v=<?= time() ?>"></script>
</body>
</html>
