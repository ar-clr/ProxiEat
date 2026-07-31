(function () {
    'use strict';

    const MOOD_CLASS_MAP = {
        'Happy': 'mood-happy',
        'Relaxed': 'mood-relaxed',
        'Alert': 'mood-alert',
        'Curious': 'mood-curious',
        'Sleepy': 'mood-sleepy',
        'Eating': 'mood-eating',
        'Unknown': 'mood-unknown'
    };

    const SELECTORS = {
        galleryGrid: '#galleryGrid',
        toolbarSearch: '#toolbarSearch',
        sortSelect: '#sortSelect',
        filterChips: '.filter-chip',
        emptyState: '#emptyState',
        loadingState: '#loadingState',
        detailModal: '#detailModal',
        detailModalBody: '#detailModalBody',
        deleteModal: '#deleteModal',
        // deleteModalId: '#deleteModalId',
        deleteModalCancel: '#deleteModalCancel',
        deleteModalConfirm: '#deleteModalConfirm',
        detailModalClose: '#detailModalClose'
    };

    let currentData = [];
    let filteredData = [];
    let deleteTargetId = null;

    async function loadGallery() {

    showLoadingState();

    try {

        const response = await fetch('gallery-data.php');

        if (!response.ok) {
            throw new Error('Unable to load gallery.');
        }

        currentData = await response.json();

        filteredData = currentData.slice();

        hideLoadingState();

        renderCards(filteredData);

    } catch (error) {

        console.error('Gallery Error:', error);

        currentData = [];
        filteredData = [];

        hideLoadingState();

        renderCards([]);

    }

}

    function cacheRefs() {
        Object.keys(SELECTORS).forEach(function (key) {
            refs[key] = document.querySelector(SELECTORS[key]);
        });
    }

    function getMoodClass(mood) {
        return MOOD_CLASS_MAP[mood] || 'mood-unknown';
    }

    function formatConfidence(value) {
        if (value === null || value === undefined || value === '' || value === 0) {
            return 'Unable to determine';
        }
        return Math.round(value * 100) + '%';
    }

    function createCard(item) {
        const card = document.createElement('div');
        const analysis = item.analysis || {};
        card.className = 'gallery-card';
        card.setAttribute('data-id', item.id);
        card.setAttribute('data-date', item.date);
        card.setAttribute('data-mood', item.mood.toLowerCase());
        card.setAttribute('data-observation', item.observation.toLowerCase());
        card.setAttribute(
            'data-objects',
            (analysis.visible_objects || []).join(' ').toLowerCase()
        );
        const moodClass = getMoodClass(item.mood);

        card.innerHTML = `
            <div class="gallery-card-thumb">
                <img src="${item.image}" alt="Captured image from ${item.date}" loading="lazy">
                <div class="ai-badge-overlay">
                    <i class="bi bi-stars"></i>
                    AI Analyzed
                </div>
            </div>
            <div class="gallery-card-body">
                <div class="gallery-card-meta">
                    <span class="gallery-card-date">📅 ${item.date}</span>
                    <span class="gallery-card-time">🕐 ${item.time}</span>
                </div>
                <div class="gallery-card-observation">${item.observation}</div>
                <div class="gallery-card-footer">
                    <span class="gallery-card-mood ${moodClass}">${item.mood}</span>
                    <div class="gallery-card-actions">
                        <button class="btn btn-outline-primary btn-sm view-details-btn" type="button" data-id="${item.id}">
                            <i class="bi bi-eye"></i> View Details
                        </button>
                        <button class="btn btn-outline-secondary btn-sm download-btn" type="button" data-image="${item.image}" data-filename="${item.id}.jpg">
                            <i class="bi bi-download"></i> Download
                        </button>
                        <button class="btn btn-outline-danger btn-sm delete-btn" type="button" data-id="${item.id}">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        `;

        return card;
    }

    function renderCards(data) {
        const grid = refs.galleryGrid;
        if (!grid) return;
        grid.innerHTML = '';

        if (data.length === 0) {
            showEmptyState();
            return;
        }

        hideEmptyState();
        hideLoadingState();

        data.forEach(function (item) {
            grid.appendChild(createCard(item));
        });

        attachCardListeners();
    }

    function showEmptyState() {
        if (refs.emptyState) {
            refs.emptyState.classList.remove('d-none');
        }
        if (refs.galleryGrid) {
            refs.galleryGrid.classList.add('d-none');
        }
    }

    function hideEmptyState() {
        if (refs.emptyState) {
            refs.emptyState.classList.add('d-none');
        }
        if (refs.galleryGrid) {
            refs.galleryGrid.classList.remove('d-none');
        }
    }

    function showLoadingState() {
        if (refs.loadingState) {
            refs.loadingState.classList.remove('d-none');
        }
        if (refs.galleryGrid) {
            refs.galleryGrid.classList.add('d-none');
        }
        if (refs.emptyState) {
            refs.emptyState.classList.add('d-none');
        }
    }

    function hideLoadingState() {
        if (refs.loadingState) {
            refs.loadingState.classList.add('d-none');
        }
        if (refs.galleryGrid) {
            refs.galleryGrid.classList.remove('d-none');
        }
    }

    function attachCardListeners() {
        document.querySelectorAll('.view-details-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                openDetailModal(id);
            });
        });

        document.querySelectorAll('.download-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const image = this.getAttribute('data-image');
                const filename = this.getAttribute('data-filename');
                downloadImage(image, filename);
            });
        });

        document.querySelectorAll('.delete-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                openDeleteModal(id);
            });
        });
    }

    function downloadImage(imageUrl, filename) {
        const link = document.createElement('a');
        link.href = imageUrl;
        link.download = filename || 'capture.jpg';
        link.target = '_blank';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function openDetailModal(id) {
        const item = currentData.find(function (d) { return d.id === id; });
        if (!item || !refs.detailModalBody || !refs.detailModal) return;

        const analysis = item.analysis || {};
        const behavior = analysis.behavior || {};

        refs.detailModalBody.innerHTML = `
            <div class="modal-body-scroll">
                <div class="modal-image-col">
                    <img src="${item.image}" alt="Captured image from ${item.date}">
                </div>
                <div class="modal-analysis-col">
                    <div class="modal-section">
                        <div class="modal-section-title">✨ Overall Observation</div>
                        <div class="modal-overall">${analysis.summary || 'No summary available.'}</div>
                    </div>

                    <div class="modal-section">
                        <div class="modal-section-title">👀 What We Noticed</div>
                        <div class="modal-observations-list">
                            <div class="modal-observation-row">
                                <span class="modal-observation-label">Estimated Mood</span>
                                <span class="modal-observation-value">${behavior.estimated_mood || 'Unable to determine'}</span>
                            </div>
                            <div class="modal-observation-row">
                                <span class="modal-observation-label">Body Posture</span>
                                <span class="modal-observation-value">${behavior.body_posture || 'Unable to determine'}</span>
                            </div>
                            <div class="modal-observation-row">
                                <span class="modal-observation-label">Head Position</span>
                                <span class="modal-observation-value">${behavior.head_position || 'Unable to determine'}</span>
                            </div>
                            <div class="modal-observation-row">
                                <span class="modal-observation-label">Tail Position</span>
                                <span class="modal-observation-value">${behavior.tail_position || 'Unable to determine'}</span>
                            </div>
                            <div class="modal-observation-row">
                                <span class="modal-observation-label">Ears</span>
                                <span class="modal-observation-value">${behavior.ears || 'Unable to determine'}</span>
                            </div>
                            <div class="modal-observation-row">
                                <span class="modal-observation-label">Mouth</span>
                                <span class="modal-observation-value">${behavior.mouth || 'Unable to determine'}</span>
                            </div>
                            <div class="modal-observation-row">
                                <span class="modal-observation-label">Attention</span>
                                <span class="modal-observation-value">${behavior.attention || 'Unable to determine'}</span>
                            </div>
                            <div class="modal-observation-row">
                                <span class="modal-observation-label">Feeding Readiness</span>
                                <span class="modal-observation-value">${behavior.feeding_readiness || 'Unable to determine'}</span>
                            </div>
                            <div class="modal-observation-row">
                                <span class="modal-observation-label">Confidence</span>
                                <span class="modal-observation-value">${formatConfidence(analysis.confidence)}</span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-section">
                        <div class="modal-section-title">👁 Visible Objects</div>
                        <div class="modal-chips">
                            ${(analysis.visible_objects || []).map(function (obj) {
                                return '<span class="modal-chip">' + obj + '</span>';
                            }).join('') || '<span class="modal-section-value placeholder">No notable objects detected.</span>'}
                        </div>
                    </div>

                    <div class="modal-section">
                        <div class="modal-section-title">🏠 Environment</div>
                        <div class="modal-chips">
                            ${(analysis.environment || []).map(function (env) {
                                return '<span class="modal-chip">' + env + '</span>';
                            }).join('') || '<span class="modal-section-value placeholder">Environment could not be determined.</span>'}
                        </div>
                    </div>

                    <div class="modal-section">
                        <div class="modal-section-title">📝 AI Notes</div>
                        <div class="modal-chips">
                            ${(analysis.ai_notes || []).map(function (note) {
                                return '<span class="modal-chip">' + note + '</span>';
                            }).join('') || '<span class="modal-section-value placeholder">No additional notes.</span>'}
                        </div>
                    </div>

                    <div class="modal-section">
                        <div class="modal-section-title">💡 Recommendations</div>
                        <div class="modal-chips">
                            ${(analysis.recommendations || []).map(function (rec) {
                                return '<span class="modal-chip">' + rec + '</span>';
                            }).join('') || '<span class="modal-section-value placeholder">No recommendations.</span>'}
                        </div>
                    </div>
                </div>
            </div>
        `;

        refs.detailModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDetailModal() {
        if (refs.detailModal) {
            refs.detailModal.classList.add('hidden');
        }
        document.body.style.overflow = '';
    }

    function openDeleteModal(id) {
        deleteTargetId = id;
        if (refs.deleteModal) {
            refs.deleteModal.classList.remove('hidden');
        }
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        deleteTargetId = null;
        if (refs.deleteModal) {
            refs.deleteModal.classList.add('hidden');
        }
        document.body.style.overflow = '';
    }

    function confirmDelete() {
        if (!deleteTargetId) return;

        const idx = currentData.findIndex(function (d) { return d.id === deleteTargetId; });
        if (idx !== -1) {
            currentData.splice(idx, 1);
        }

        closeDeleteModal();
        applyFiltersAndSort();
    }

    function filterByPeriod(data, period) {
        if (!period || period === 'all') return data;

        const now = new Date();
        const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());

        return data.filter(function (item) {
            const itemDate = new Date(item.date + 'T00:00:00');
            const diffTime = now - itemDate;
            const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

            if (period === 'today') {
                return itemDate >= today;
            } else if (period === 'week') {
                const weekAgo = new Date(today);
                weekAgo.setDate(weekAgo.getDate() - 7);
                return itemDate >= weekAgo;
            } else if (period === 'month') {
                const monthAgo = new Date(today);
                monthAgo.setMonth(monthAgo.getMonth() - 1);
                return itemDate >= monthAgo;
            }
            return true;
        });
    }

    function sortData(data, sortBy) {
        const sorted = data.slice().sort(function (a, b) {
            const dateA = new Date(a.date + 'T' + a.time);
            const dateB = new Date(b.date + 'T' + b.time);

            if (sortBy === 'oldest') {
                return dateA - dateB;
            }
            return dateB - dateA;
        });
        return sorted;
    }

    function applyFiltersAndSort() {
        let data = currentData.slice();

        const searchTerm = refs.toolbarSearch ? refs.toolbarSearch.value.toLowerCase().trim() : '';
        if (searchTerm) {
            data = data.filter(function (item) {
                return (
                    item.date.toLowerCase().includes(searchTerm) ||
                    item.mood.toLowerCase().includes(searchTerm) ||
                    item.observation.toLowerCase().includes(searchTerm) ||
                    ((item.analysis || {}).visible_objects || []).some(function (obj) {                        return obj.toLowerCase().includes(searchTerm);
                    })
                );
            });
        }

        const activeChip = document.querySelector('.filter-chip.chip-active');
        const period = activeChip ? activeChip.getAttribute('data-period') : 'all';
        data = filterByPeriod(data, period);

        const sortBy = refs.sortSelect ? refs.sortSelect.value : 'newest';
        data = sortData(data, sortBy);

        filteredData = data;
        renderCards(filteredData);
    }

    function initToolbar() {
        if (refs.toolbarSearch) {
            refs.toolbarSearch.addEventListener('input', function () {
                applyFiltersAndSort();
            });
        }

        if (refs.sortSelect) {
            refs.sortSelect.addEventListener('change', function () {
                applyFiltersAndSort();
            });
        }

        document.querySelectorAll('.filter-chip').forEach(function (chip) {
            chip.addEventListener('click', function () {
                document.querySelectorAll('.filter-chip').forEach(function (c) {
                    c.classList.remove('chip-active');
                });
                this.classList.add('chip-active');
                applyFiltersAndSort();
            });
        });
    }

    function initModals() {
        if (refs.detailModalClose) {
            refs.detailModalClose.addEventListener('click', closeDetailModal);
        }

        if (refs.detailModal) {
            refs.detailModal.addEventListener('click', function (e) {
                if (e.target === refs.detailModal) {
                    closeDetailModal();
                }
            });
        }

        if (refs.deleteModalCancel) {
            refs.deleteModalCancel.addEventListener('click', closeDeleteModal);
        }

        if (refs.deleteModalConfirm) {
            refs.deleteModalConfirm.addEventListener('click', confirmDelete);
        }

        if (refs.deleteModal) {
            refs.deleteModal.addEventListener('click', function (e) {
                if (e.target === refs.deleteModal) {
                    closeDeleteModal();
                }
            });
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeDetailModal();
                closeDeleteModal();
            }
        });
    }

function init() {

    cacheRefs();

    initToolbar();

    initModals();

    loadGallery();

}

    var refs = {};

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
