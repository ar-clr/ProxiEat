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
    <link href="..\assets\css\pages\camera.css?v=<?= time() ?>" rel="stylesheet">
</head>
<body>
    <div class="camera-page">
        <header class="page-header">
            <h1>Image Analysis</h1>
            <p>Capture and analyze images from the Smart Pet Feeder camera.</p>
        </header>

        <div class="camera-container">
            <div class="row g-3">
                <div class="col-lg-8">
                    <section class="camera-card" aria-labelledby="live-feed-title">
                        <div class="card-header">
                            <h2 id="live-feed-title">Live Camera Feed</h2>
                        </div>
                        <div class="card-body">
                            <div class="feed-preview" id="liveFeedContainer">
                                <img
                                    data-src="http://<?= ESP32_IP ?>:81/stream"
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
                    <section class="camera-card camera-workspace" aria-labelledby="controls-title">
                        <div class="card-header">
                            <h2 id="controls-title">Camera Workspace</h2>
                        </div>
                        <div class="card-body">
                            <div class="workspace-section">
                                <div class="workspace-section-title">Camera Status</div>
                                <div class="status-badge status-paused" id="workspaceStatus">Paused</div>
                            </div>

                            <div class="workspace-section">
                                <div class="workspace-section-title">Last Capture</div>
                                <div class="workspace-meta">
                                    <div class="workspace-meta-item">
                                        <span class="workspace-meta-label">Date</span>
                                        <span class="workspace-meta-value">Today</span>
                                    </div>
                                    <div class="workspace-meta-item">
                                        <span class="workspace-meta-label">Time</span>
                                        <span class="workspace-meta-value">10:35 AM</span>
                                    </div>
                                </div>
                            </div>

                            <div class="workspace-section">
                                <div class="workspace-section-title">Quick Actions</div>
                                <div class="controls">
                                    <button class="btn btn-primary" id="captureBtn" type="button">
                                        <i class="bi bi-camera"></i>
                                        Capture Image
                                    </button>
                                    <button class="btn btn-outline-primary" id="liveViewBtn" type="button">
                                        <i class="bi bi-play-circle"></i>
                                        Start Live View
                                    </button>
                                </div>
                            </div>

                            <div class="workspace-section workspace-info-section">
                                <div class="workspace-info">
                                    <div class="workspace-info-item">
                                        <i class="bi bi-info-circle"></i>
                                        <span>Every successful capture is automatically analyzed by AI.</span>
                                    </div>
                                    <div class="workspace-info-item">
                                        <i class="bi bi-info-circle"></i>
                                        <span>Live View pauses automatically after inactivity to improve performance.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <div class="row g-4 align-items-stretch">
                <div class="col-lg-6 d-flex">
                    <section class="camera-card latest-capture-card w-100" aria-labelledby="latest-capture-title">
                        <div class="card-header">
                            <h2 id="latest-capture-title">Latest Capture</h2>
                        </div>
                        <div class="card-body">
                            <div class="capture-preview">
                                <img
                                    id="latestCapture"
                                    src="..\assets\images\camera\placeholder-capture.png"
                                    alt="Latest Capture">
                            </div>
                            <div class="capture-details">
                                <div class="capture-meta-single">
                                    <span class="capture-meta-label">📅 Captured</span>
                                    <span
                                        class="capture-meta-value"
                                        id="captureTimestamp">
                                        No capture yet
                                    </span>
                                </div>
                            </div>
                            <div class="capture-actions">
                                <button class="btn btn-outline-primary btn-sm" type="button">View Full Image</button>
                                <button class="btn btn-outline-secondary btn-sm" type="button">Download Image</button>
                                <a href="gallery.php" class="capture-gallery-link">View Gallery →</a>
                            </div>
                            <div class="recent-captures">
                                <div class="recent-captures-title">Recent Captures</div>
                                <p class="capture-placeholder" id="captureStatus">No previous captures yet.</p>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="col-lg-6 d-flex">
                    <section class="camera-card analysis-card w-100" aria-labelledby="analysis-title">
                        <div class="card-header">
                            <h2 id="analysis-title">🐶 Let's See What Your Pet Is Doing!</h2>
                             <p class="analysis-subtitle">AI observations from your latest capture.</p>
                        </div>
                        <div class="card-body">
                            <div class="analysis-state analysis-empty">
                                <div class="empty-illustration">
                                    <i class="bi bi-paw"></i>
                                </div>
                                <h3 class="empty-title">No analysis yet</h3>
                                <p class="empty-text">Capture an image and I'll share what I notice about your pet's behavior and feeding setup.</p>
                            </div>

                            <div class="analysis-state analysis-loading d-none">
                                <div class="loading-icon">
                                    <i class="bi bi-robot"></i>
                                </div>
                                <div class="spinner-border text-primary loading-spinner" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <h3 class="loading-title">Analyzing your pet...</h3>
                                <p class="loading-subtitle">I'm observing posture, attention, and body language from this capture.</p>
                                <div class="loading-chips">
                                    <span class="chip chip-active">Reading posture...</span>
                                    <span class="chip">Checking attention...</span>
                                    <span class="chip">Writing observations...</span>
                                </div>
                            </div>

                             <div class="analysis-state analysis-results d-none">
                                 <div class="analysis-overall">
                                     <div class="result-section result-section-overall">
                                         <h4 class="result-section-title">✨ Overall Observation <span class="ai-badge">AI</span></h4>
                                         <div class="result-summary overall-container" id="analysisSummary">Loading...</div>
                                     </div>
                                 </div>
                                 <div class="analysis-scroll-area">
                                     <div class="result-section">
                                         <h4 class="result-section-title">👀 What We Noticed</h4>
                                         <div class="observations-list">
                                             <div class="observation-row">
                                                 <div class="observation-label">Estimated Mood</div>
                                                 <div class="result-value placeholder" id="analysisMood">—</div>
                                             </div>
                                             <div class="observation-row">
                                                 <div class="observation-label">Body Posture</div>
                                                 <div class="result-value placeholder" id="analysisPosture">—</div>
                                             </div>
                                             <div class="observation-row">
                                                 <div class="observation-label">Head Position</div>
                                                 <div class="result-value placeholder" id="analysisHead">—</div>
                                             </div>
                                             <div class="observation-row">
                                                 <div class="observation-label">Tail Position</div>
                                                 <div class="result-value placeholder" id="analysisTail">—</div>
                                             </div>
                                             <div class="observation-row">
                                                 <div class="observation-label">Ears</div>
                                                 <div class="result-value placeholder" id="analysisEars">—</div>
                                             </div>
                                             <div class="observation-row">
                                                 <div class="observation-label">Mouth</div>
                                                 <div class="result-value placeholder" id="analysisMouth">—</div>
                                             </div>
                                             <div class="observation-row">
                                                 <div class="observation-label">Attention</div>
                                                 <div class="result-value placeholder" id="analysisAttention">—</div>
                                             </div>
                                             <div class="observation-row">
                                                 <div class="observation-label">Feeding Readiness</div>
                                                 <div class="result-value placeholder" id="analysisFeeding">—</div>
                                             </div>
                                             <div class="observation-row">
                                                 <div class="observation-label">Confidence</div>
                                                 <div class="result-value placeholder" id="analysisConfidence">—</div>
                                             </div>
                                         </div>
                                     </div>

                                     <div class="result-section">
                                         <h4 class="result-section-title">👁 Visible Objects</h4>
                                         <div id="analysisObjects"></div>
                                     </div>

                                     <div class="result-section">
                                         <h4 class="result-section-title">🏠 Environment</h4>
                                         <div id="analysisEnvironment"></div>
                                     </div>

                                     <div class="result-section">
                                         <h4 class="result-section-title">📝 AI Notes</h4>
                                         <div id="analysisNotes"></div>
                                     </div>

                                     <div class="result-section">
                                         <h4 class="result-section-title">💡 Recommendations</h4>
                                         <div id="analysisRecommendations"></div>
                                     </div>
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
    <script src="..\assets\js\camera\camera.js?v=<?= time() ?>"></script>
</body>
</html>
