// Future:
// Analyze Image
// Clear Preview

(function () {
    'use strict';

    const SELECTORS = {
        captureBtn: '#captureBtn',
        liveFeed: '#liveFeed',
        latestCapture: '#latestCapture',
        cameraStatus: '#cameraStatus',
        captureStatus: '#captureStatus',
        workspaceStatus: '#workspaceStatus',
        latestCaptureCard: '#latest-capture-title',
        captureModal: '#captureModal',
        captureModalIconWrapper: '#captureModalIconWrapper',
        captureModalIcon: '#captureModalIcon',
        captureModalTitle: '#captureModalTitle',
        captureModalSubtitle: '#captureModalSubtitle',
        captureModalSpinner: '#captureModalSpinner',
        captureModalSuccessIcon: '#captureModalSuccessIcon',
        captureModalErrorIcon: '#captureModalErrorIcon',
        captureModalStatus: '#captureModalStatus',
        captureModalClose: '#captureModalClose',
        captureTimestamp: '#captureTimestamp',
        liveViewBtn: '#liveViewBtn',
        liveFeedContainer: '#liveFeedContainer',
        livePauseOverlay: '#livePauseOverlay',
        resumeLiveViewBtn: '#resumeLiveViewBtn',
        liveViewToast: '#liveViewToast',
        analysisEmpty: '.analysis-empty',
        analysisLoading: '.analysis-loading',
        analysisResults: '.analysis-results',
        resultSummary: '.result-summary',
        resultCardValue: '.result-value',
        analysisMood: '#analysisMood',
        analysisPosture: '#analysisPosture',
        analysisHead: '#analysisHead',
        analysisTail: '#analysisTail',
        analysisAttention: '#analysisAttention',
        analysisConfidence: '#analysisConfidence',
        analysisSummary: '#analysisSummary',
        analysisNotes: '#analysisNotes',
        analysisRecommendations: '#analysisRecommendations',
        analysisObjects: '#analysisObjects',
        analysisEnvironment: '#analysisEnvironment',
        analysisEars: '#analysisEars',
        analysisMouth: '#analysisMouth',
        analysisFeeding: '#analysisFeeding'
    };

    const STATUS_TEXT = {
        connected: '🟢 Connected',
        capturing: '🟡 Capturing...',
        error: '🔴 Error',
        paused: '⚪ Paused'
    };

    const PROGRESS_MESSAGES = [
        'Preparing your image...',
        'Almost there...',
        'Finalizing your photo...',
        'Please wait...'
    ];

    const SESSION_TIMEOUT = 50000;
    const INACTIVITY_TIMEOUT = 150000;

    let progressInterval = null;
    let progressIndex = 0;
    let sessionTimer = null;
    let inactivityTimer = null;
    let isLiveViewActive = false;
    let originalStreamUrl = '';
    let isAnalyzing = false;

    const refs = {};
    let currentStatus = '';
    let currentButtonMode = '';

    function cacheRefs() {
        Object.keys(SELECTORS).forEach(function (key) {
            refs[key] = document.querySelector(SELECTORS[key]);
        });
    }

function setStatus(status) {
    if (currentStatus === status) return;
    currentStatus = status;
    const badges = [
        refs.cameraStatus,
        refs.workspaceStatus
    ];
    badges.forEach(function (el) {
        if (!el) return;
        el.textContent = status;
        el.classList.remove(
            'status-capturing',
            'status-error',
            'status-paused'
        );
        if (status === STATUS_TEXT.capturing) {
            el.classList.add('status-capturing');
        }
        if (status === STATUS_TEXT.error) {
            el.classList.add('status-error');
        }
        if (status === STATUS_TEXT.paused) {
            el.classList.add('status-paused');
        }
    });
}

    function restoreButton() {
        const btn = refs.captureBtn;
        if (!btn) return;
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-camera"></i> Capture Image';
    }

    function disableButton() {
        const btn = refs.captureBtn;
        if (!btn) return;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Capturing...';
    }

    function showAlert(message, type) {
        type = type || 'success';
        const title = refs.latestCaptureCard;
        if (!title) return;
        const body = title.closest('.camera-card') && title.closest('.camera-card').querySelector('.card-body');
        if (!body) return;
        body.querySelectorAll('.camera-alert').forEach(function (el) { el.remove(); });
        const alert = document.createElement('div');
        alert.className = 'alert alert-' + type + ' camera-alert mb-3';
        alert.innerHTML = message;
        body.insertBefore(alert, body.firstChild);
        setTimeout(function () { alert.remove(); }, 3000);
    }

function handleCaptureSuccess(data) {

    const latestCapture = refs.latestCapture;
    const captureStatus = refs.captureStatus;
    const captureTimestamp = refs.captureTimestamp;

    if (latestCapture) {
        latestCapture.src = data.image + '?t=' + Date.now();
    }

    if (captureTimestamp) {
        captureTimestamp.textContent = data.timestamp;
    }

    // Update the "Last Capture" card
    updateWorkspaceCaptureTime(
        data.capture_date,
        data.capture_time
    );

    if (captureStatus) {
        captureStatus.textContent = 'Latest capture saved.';
    }

    showAlert(data.message, 'success');
    restoreButton();
    startAnalysis();

}

    function fadeOutElement(el) {
        if (!el) return;
        el.style.opacity = '0';
        el.style.transition = 'opacity 0.4s ease';
        setTimeout(function () {
            el.classList.add('d-none');
            el.style.opacity = '';
            el.style.transition = '';
        }, 400);
    }

    function fadeInElement(el) {
        if (!el) return;
        el.classList.remove('d-none');
        void el.offsetHeight;
        el.style.opacity = '0';
        el.style.transition = 'opacity 0.4s ease';
        requestAnimationFrame(function () {
            el.style.opacity = '1';
            setTimeout(function () {
                el.style.transition = '';
            }, 400);
        });
    }

    function showAnalysisLoading() {
        var empty = refs.analysisEmpty;
        var loading = refs.analysisLoading;
        var results = refs.analysisResults;
        var chips = loading ? loading.querySelectorAll('.chip') : [];
        var subtitle = loading ? loading.querySelector('.loading-subtitle') : null;

        if (empty) fadeOutElement(empty);
        if (results) fadeOutElement(results);

        if (chips.length >= 3) {
            chips[0].textContent = '\u2713 Looking at posture...';
            chips[1].textContent = '\u2713 Checking visible body language...';
            chips[2].textContent = '\u2713 Summarizing observations...';
        }

        if (subtitle) {
            subtitle.textContent = "We're looking for visible posture, attention, and body language.";
        }

        if (loading) fadeInElement(loading);
    }

    function formatConfidence(value) {
        if (value === null || value === undefined || value === '' || value === 0) {
            return 'Unable to determine';
        }
        return Math.round(value * 100) + '%';
    }

    function renderList(container, items, emptyText) {
        if (!container) return;
        container.innerHTML = '';
        if (!Array.isArray(items) || items.length === 0) {
            container.innerHTML =
                '<div class="text-muted">' + emptyText + '</div>';
            return;
        }
        items.forEach(function(item){
            const div = document.createElement('div');
            div.className = 'analysis-chip';
            div.textContent = item;
            container.appendChild(div);
        });
    }

function showAnalysisResults(analysis) {

    const loading = refs.analysisLoading;
    const results = refs.analysisResults;

    if (loading) {
        fadeOutElement(loading);
    }

    const behavior = analysis.behavior || {};

    function setValue(ref, value) {

        if (!ref) return;

        ref.textContent = value || 'Unable to determine';

        ref.classList.remove('placeholder');

    }

    // Overall Summary
    if (refs.analysisSummary) {
        refs.analysisSummary.textContent =
            analysis.summary || 'No summary available.';
    }

    // Behavior
    setValue(refs.analysisMood, behavior.estimated_mood);
    setValue(refs.analysisPosture, behavior.body_posture);
    setValue(refs.analysisHead, behavior.head_position);
    setValue(refs.analysisTail, behavior.tail_position);
    setValue(refs.analysisEars, behavior.ears);
    setValue(refs.analysisMouth, behavior.mouth);
    setValue(refs.analysisAttention, behavior.attention);
    setValue(refs.analysisFeeding, behavior.feeding_readiness);

    // Confidence
    if (refs.analysisConfidence) {

        refs.analysisConfidence.textContent =
            formatConfidence(analysis.confidence);

        refs.analysisConfidence.classList.remove('placeholder');

    }

    // Visible Objects
    renderList(
        refs.analysisObjects,
        analysis.visible_objects,
        'No notable objects detected.'
    );

    // Environment
    renderList(
        refs.analysisEnvironment,
        analysis.environment,
        'Environment could not be determined.'
    );

    // AI Notes
    renderList(
        refs.analysisNotes,
        analysis.ai_notes,
        'No additional notes.'
    );

    // Recommendations
    renderList(
        refs.analysisRecommendations,
        analysis.recommendations,
        'No recommendations.'
    );

    setTimeout(function () {
        fadeInElement(results);
    }, 400);

}

    function showAnalysisError() {
        var loading = refs.analysisLoading;
        var empty = refs.analysisEmpty;

        if (loading) fadeOutElement(loading);

        if (empty) {
            var iconWrapper = empty.querySelector('.empty-illustration');
            var title = empty.querySelector('.empty-title');
            var text = empty.querySelector('.empty-text');

            if (iconWrapper) {
                iconWrapper.innerHTML = '<i class="bi bi-exclamation-triangle-fill" style="color:#c93345;"></i>';
            }
            if (title) {
                title.textContent = 'The AI service is temporarily busy. Please try again in a few moments.';
                title.style.color = '#c93345';
            }
            if (text) {
                text.textContent = "We couldn't analyze your pet this time. Please try capturing another image.";
            }

            setTimeout(function () {
                fadeInElement(empty);
            }, 400);
        }
    }

    function startAnalysis() {
        if (isAnalyzing) return;
        isAnalyzing = true;

        showAnalysisLoading();

        fetch('analyze.php')
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('HTTP ' + response.status);
                }
                return response.json();
            })
            .then(function (data) {
                try {
                    console.log(data);
                    showAnalysisResults(data.analysis);
                } catch (e) {
                    console.error(e);
                    alert(e.stack);
                    throw e;
                }
                isAnalyzing = false;
            })
            .catch(function (error) {
                console.error('Analysis error:', error);
                showAnalysisError();
                isAnalyzing = false;
            });
    }

    function showCaptureModal() {
        const modal = refs.captureModal;
        if (!modal) return;
        modal.classList.remove('hidden');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function hideCaptureModal() {
        const modal = refs.captureModal;
        if (!modal) return;
        modal.classList.add('hidden');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        resetModalContent();
    }

    function resetModalContent() {
        const iconWrapper = refs.captureModalIconWrapper;
        const icon = refs.captureModalIcon;
        const title = refs.captureModalTitle;
        const subtitle = refs.captureModalSubtitle;
        const spinner = refs.captureModalSpinner;
        const successIcon = refs.captureModalSuccessIcon;
        const errorIcon = refs.captureModalErrorIcon;
        const status = refs.captureModalStatus;
        const closeBtn = refs.captureModalClose;

        if (iconWrapper) iconWrapper.classList.remove('pulsing');
        if (icon) icon.classList.remove('hidden-icon');
        if (title) title.textContent = 'Capturing Image';
        if (subtitle) subtitle.textContent = 'Please wait while we prepare your latest photo.';
        if (spinner) spinner.classList.remove('hidden-icon');
        if (successIcon) successIcon.classList.add('hidden-icon');
        if (errorIcon) {
            errorIcon.classList.add('hidden-icon');
            closeBtn.classList.add('hidden');
        }
        if (status) status.textContent = PROGRESS_MESSAGES[0];
        if (closeBtn) {
            closeBtn.classList.add('hidden');
            closeBtn.onclick = null;
        }
    }

    function setModalState(state) {
        const icon = refs.captureModalIcon;
        const spinner = refs.captureModalSpinner;
        const successIcon = refs.captureModalSuccessIcon;
        const errorIcon = refs.captureModalErrorIcon;
        const closeBtn = refs.captureModalClose;
        const iconWrapper = refs.captureModalIconWrapper;
        const title = refs.captureModalTitle;
        const subtitle = refs.captureModalSubtitle;
        const status = refs.captureModalStatus;

        if (state === 'loading') {
            if (icon) icon.classList.remove('hidden-icon');
            if (spinner) spinner.classList.remove('hidden-icon');
            if (successIcon) successIcon.classList.add('hidden-icon');
            if (errorIcon) errorIcon.classList.add('hidden-icon');
            if (closeBtn) closeBtn.classList.add('hidden');
            if (iconWrapper) iconWrapper.classList.add('pulsing');
            if (title) title.textContent = 'Capturing Image';
            if (subtitle) subtitle.textContent = 'Please wait while we prepare your latest photo.';
        } else if (state === 'success') {
            if (icon) icon.classList.add('hidden-icon');
            if (spinner) spinner.classList.add('hidden-icon');
            if (successIcon) successIcon.classList.remove('hidden-icon');
            if (errorIcon) errorIcon.classList.add('hidden-icon');
            if (closeBtn) closeBtn.classList.add('hidden');
            if (iconWrapper) iconWrapper.classList.remove('pulsing');
            if (title) title.textContent = 'Image captured successfully!';
            if (subtitle) subtitle.textContent = '';
            if (status) status.textContent = '';
        } else if (state === 'error') {
            if (icon) icon.classList.add('hidden-icon');
            if (spinner) spinner.classList.add('hidden-icon');
            if (successIcon) successIcon.classList.add('hidden-icon');
            if (errorIcon) errorIcon.classList.remove('hidden-icon');
            if (iconWrapper) iconWrapper.classList.remove('pulsing');
            if (title) title.textContent = 'Unable to capture the image.';
            if (subtitle) subtitle.textContent = 'Please try again.';
            if (status) status.textContent = '';
            if (closeBtn) {
                closeBtn.classList.remove('hidden');
                closeBtn.onclick = function () {
                    hideCaptureModal();
                    setStatus(STATUS_TEXT.error);
                    restoreButton();
                };
            }
        }
    }

    function startProgressRotation() {
        stopProgressRotation();
        progressIndex = 0;
        const statusEl = refs.captureModalStatus;
        if (statusEl) {
            statusEl.textContent = PROGRESS_MESSAGES[0];
        }
        progressInterval = setInterval(function () {
            progressIndex = (progressIndex + 1) % PROGRESS_MESSAGES.length;
            const el = refs.captureModalStatus;
            if (el) {
                el.textContent = PROGRESS_MESSAGES[progressIndex];
            }
        }, 1500);
    }

    function stopProgressRotation() {
        if (progressInterval) {
            clearInterval(progressInterval);
            progressInterval = null;
        }
    }

    function updateLiveViewButton() {
        const btn = refs.liveViewBtn;
        if (!btn) return;
        const mode = isLiveViewActive ? 'active' : 'paused';
        if (currentButtonMode === mode) return;
        currentButtonMode = mode;

        if (isLiveViewActive) {
            btn.innerHTML = '<i class="bi bi-pause-circle"></i> Pause Live View';
            btn.classList.remove('btn-outline-primary');
            btn.classList.add('btn-outline-secondary');
        } else {
            btn.innerHTML = '<i class="bi bi-play-circle"></i> Start Live View';
            btn.classList.remove('btn-outline-secondary');
            btn.classList.add('btn-outline-primary');
        }
    }

    function stopStream() {
        const feed = refs.liveFeed;
        if (feed) {
            feed.src = '';
        }
    }

    function startStream() {
        const feed = refs.liveFeed;
        if (feed && originalStreamUrl) {
            feed.src = originalStreamUrl + '?t=' + Date.now();
        }
    }

    function pauseLiveView(showToast, message) {
        if (!isLiveViewActive) return;
        isLiveViewActive = false;

        stopStream();

        const overlay = refs.livePauseOverlay;
        const container = refs.liveFeedContainer;
        if (overlay) overlay.classList.remove('hidden');
        if (container) container.classList.add('live-view-paused');

        setStatus(STATUS_TEXT.paused);
        updateLiveViewButton();
        resetTimers();

        if (showToast && message) {
            showLiveViewToast(message);
        }
    }

    function resumeLiveView() {
        if (isLiveViewActive) return;
        isLiveViewActive = true;

        startStream();

        const overlay = refs.livePauseOverlay;
        const container = refs.liveFeedContainer;
        if (overlay) overlay.classList.add('hidden');
        if (container) container.classList.remove('live-view-paused');

        setStatus(STATUS_TEXT.connected);
        updateLiveViewButton();
        resetTimers();
    }

    function showLiveViewToast(message) {
        const toastEl = refs.liveViewToast;
        if (!toastEl) return;
        const body = toastEl.querySelector('.toast-body');
        if (body && message) {
            body.textContent = message;
        }
        const toast = bootstrap.Toast.getOrCreateInstance(toastEl);
        toast.show();
    }

    function clearTimer(timer) {
        if (timer) {
            clearTimeout(timer);
            return null;
        }
        return timer;
    }

    function resetTimers() {
        sessionTimer = clearTimer(sessionTimer);
        inactivityTimer = clearTimer(inactivityTimer);

        if (isLiveViewActive) {
            sessionTimer = setTimeout(function () {
                pauseLiveView(true, 'Live View has been paused to improve performance. Click "Start Live View" to continue monitoring.');
            }, SESSION_TIMEOUT);

            inactivityTimer = setTimeout(function () {
                pauseLiveView(true, 'Live View was paused to improve performance. Click "Start Live View" whenever you\'re ready.');
            }, INACTIVITY_TIMEOUT);
        }
    }

    function resetInactivityTimerOnly() {
        inactivityTimer = clearTimer(inactivityTimer);
        if (isLiveViewActive) {
            inactivityTimer = setTimeout(function () {
                pauseLiveView(true, 'Live View was paused to improve performance. Click "Start Live View" whenever you\'re ready.');
            }, INACTIVITY_TIMEOUT);
        }
    }

    function handleUserActivity() {
        resetInactivityTimerOnly();
    }

    async function startCapture() {
        try {
            disableButton();
            if (isLiveViewActive) {
                pauseLiveView(false);
            }
            setStatus(STATUS_TEXT.capturing);
            showCaptureModal();
            setModalState('loading');
            startProgressRotation();

            const response = await fetch('snapshot.php', {
                method: 'POST'
            });

            if (!response.ok) {
                throw new Error('HTTP ' + response.status);
            }

            const data = await response.json();

            if (!data.success) {
                throw new Error(data.message);
            }

            stopProgressRotation();
            setModalState('success');

            setTimeout(function () {
                hideCaptureModal();
                handleCaptureSuccess(data);
                setStatus(STATUS_TEXT.paused);
            }, 900);

        } catch (error) {
            console.error(error);
            stopProgressRotation();
            setModalState('error');
            setStatus(STATUS_TEXT.error);
        }
    }

    function initLiveViewControls() {
        const liveViewBtn = refs.liveViewBtn;
        const resumeBtn = refs.resumeLiveViewBtn;

        if (liveViewBtn) {
            liveViewBtn.addEventListener('click', function () {
                if (isLiveViewActive) {
                    pauseLiveView(false);
                } else {
                    resumeLiveView();
                }
            });
        }

        if (resumeBtn) {
            resumeBtn.addEventListener('click', resumeLiveView);
        }

        document.addEventListener('mousemove', handleUserActivity);
        document.addEventListener('click', handleUserActivity);
        document.addEventListener('keydown', handleUserActivity);
        document.addEventListener('scroll', handleUserActivity, true);
    }

    function init() {
        cacheRefs();

        const feed = refs.liveFeed;
        if (feed && feed.dataset.src) {
            originalStreamUrl = feed.dataset.src;
        }

        isLiveViewActive = false;
        stopStream();

        const overlay = refs.livePauseOverlay;
        const container = refs.liveFeedContainer;
        if (overlay) overlay.classList.remove('hidden');
        if (container) container.classList.add('live-view-paused');

        setStatus(STATUS_TEXT.paused);
        updateLiveViewButton();

        const button = refs.captureBtn;
        if (button) {
            button.addEventListener('click', startCapture);
        }
        initLiveViewControls();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

function updateWorkspaceCaptureTime(captureDate, captureTime) {

    const dateEl = document.getElementById("workspaceCaptureDate");
    const timeEl = document.getElementById("workspaceCaptureTime");

    if (dateEl) {
        dateEl.textContent = captureDate;
    }

    if (timeEl) {
        timeEl.textContent = captureTime;
    }

}
