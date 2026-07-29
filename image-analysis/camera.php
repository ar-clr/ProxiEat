<?php
require_once __DIR__ . '/config/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Image Analysis - ProxiEat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="assets/css/camera.css?v=<?= time() ?>" rel="stylesheet">
</head>
<body>
    <div class="camera-page">
        <header class="page-header">
            <h1>Image Analysis</h1>
            <p>Capture and analyze images from the Smart Pet Feeder camera.</p>
        </header>

        <div class="camera-container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <section class="camera-card" aria-labelledby="live-feed-title">
                        <div class="card-header">
                            <h2 id="live-feed-title">Live Camera Feed</h2>
                        </div>
                        <div class="card-body">
                            <div class="feed-preview" id="liveFeedContainer">
                                <img
                                    data-src="http://<?= ESP32_IP ?>:81/stream"
                                    alt="ESP32 Live Camera Feed"
                                    id="liveFeed">
                                <div class="live-pause-overlay" id="livePauseOverlay">
                                    <div class="live-pause-content">
                                        <i class="bi bi-camera live-pause-icon"></i>
                                        <h3 class="live-pause-title">Live View Paused</h3>
                                        <p class="live-pause-subtitle">Start Live View whenever you'd like to monitor your pet.</p>
                                        <button class="btn btn-primary" id="resumeLiveViewBtn" type="button">
                                            <i class="bi bi-play-circle"></i>
                                            Start Live View
                                        </button>
                                    </div>
                                </div>
                            </div>
                             <div class="status-badge status-paused" id="cameraStatus">Paused</div>
                        </div>
                    </section>
                </div>

                <div class="col-lg-4">
                    <section class="camera-card" aria-labelledby="controls-title">
                        <div class="card-header">
                            <h2 id="controls-title">Camera Controls</h2>
                        </div>
                        <div class="card-body">
                            <div class="controls">
                                <button class="btn btn-primary" id="captureBtn" type="button">
                                    <i class="bi bi-camera"></i>
                                    Capture Image
                                </button>
                                <button class="btn btn-outline-primary" id="liveViewBtn" type="button">
                                    <i class="bi bi-play-circle"></i>
                                    Start Live View
                                </button>
                                <button class="btn btn-secondary" type="button" disabled>
                                    <i class="bi bi-magic"></i>
                                    Coming Soon
                                </button>
                                <button class="btn btn-outline-danger" type="button" disabled>
                                    <i class="bi bi-trash"></i>
                                    Clear Preview
                                </button>
                            </div>
                            <p class="text-muted mt-3 mb-0 small">Controls are disabled in Sprint 1.</p>
                        </div>
                    </section>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <section class="camera-card" aria-labelledby="latest-capture-title">
                        <div class="card-header">
                            <h2 id="latest-capture-title">Latest Capture</h2>
                        </div>
                        <div class="card-body">
                            <div class="capture-preview">
                            <img
                                id="latestCapture"
                                src="images/placeholder-capture.png"
                                alt="Latest Capture">                            
                            </div>
                            <p class="capture-placeholder mt-2" id="captureStatus">No image captured yet.</p>
                        </div>
                    </section>
                </div>

                <div class="col-lg-6">
                    <section class="camera-card" aria-labelledby="analysis-results-title">
                        <div class="card-header">
                            <h2 id="analysis-results-title">Analysis Results</h2>
                        </div>
                        <div class="card-body">
                            <div class="analysis-grid">
                                <div class="analysis-item">
                                    <div class="label">Food Level</div>
                                    <div class="value placeholder">--</div>
                                </div>
                                <div class="analysis-item">
                                    <div class="label">Water Level</div>
                                    <div class="value placeholder">--</div>
                                </div>
                                <div class="analysis-item">
                                    <div class="label">Pet Visible</div>
                                    <div class="value placeholder">--</div>
                                </div>
                                <div class="analysis-item">
                                    <div class="label">Cleanliness</div>
                                    <div class="value placeholder">--</div>
                                </div>
                                <div class="analysis-item full-width">
                                    <div class="label">Overall Status</div>
                                    <div class="value placeholder">Waiting for analysis...</div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <!-- <section class="dev-card" aria-labelledby="dev-notes-title">
                <h2 id="dev-notes-title">Sprint 1</h2>
                <p>This module is currently under development.</p>
                <p><strong>Current Sprint:</strong></p>
                <ul>
                    <li>Camera UI</li>
                </ul>
                <p><strong>Upcoming:</strong></p>
                <ul>
                    <li>Image Capture</li>
                    <li>AI Image Analysis</li>
                    <li>History</li>
                    <li>Dashboard Integration</li>
                </ul>
            </section> -->
        </div>
    </div>

    <!-- Capture Modal -->
    <div class="capture-modal-overlay hidden" id="captureModal" aria-hidden="true">
        <div class="capture-modal-card" role="dialog" aria-modal="true" aria-labelledby="captureModalTitle">
            <div class="capture-modal-body">
                <div class="capture-icon-wrapper" id="captureModalIconWrapper">
                    <i class="bi bi-camera capture-icon" id="captureModalIcon"></i>
                </div>
                <h3 class="capture-modal-title" id="captureModalTitle">Capturing Image</h3>
                <p class="capture-modal-subtitle" id="captureModalSubtitle">Please wait while we prepare your latest photo.</p>
                <div class="capture-modal-spinner-wrapper">
                    <div class="spinner-border text-primary" id="captureModalSpinner" role="status"></div>
                    <i class="bi bi-check-circle-fill capture-modal-success-icon hidden-icon" id="captureModalSuccessIcon"></i>
                    <i class="bi bi-x-circle-fill capture-modal-error-icon hidden-icon" id="captureModalErrorIcon"></i>
                </div>
                <p class="capture-modal-status" id="captureModalStatus">Preparing your image...</p>
                <button class="btn btn-outline-danger capture-modal-close hidden" id="captureModalClose" type="button">Close</button>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" id="liveViewToastContainer">
        <div class="toast" id="liveViewToast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bi bi-info-circle me-2 text-primary"></i>
                <strong class="me-auto">Live View</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Live View was paused to improve performance. Click "Start Live View" whenever you're ready.
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/camera.js?v=<?= time() ?>"></script>
</body>
</html>
