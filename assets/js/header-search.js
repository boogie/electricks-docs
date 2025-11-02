/**
 * Header Search Functionality
 * Handles search modal, keyboard shortcuts, and API integration
 */

(function() {
    // Detect platform for keyboard shortcut
    const isMac = navigator.platform.toUpperCase().indexOf('MAC') >= 0;
    const modifierKey = isMac ? 'metaKey' : 'ctrlKey';
    const shortcutDisplay = isMac ? '⌘K' : 'Ctrl+K';

    // Update shortcut display
    const shortcutEl = document.getElementById('searchShortcut');
    if (shortcutEl) {
        shortcutEl.textContent = shortcutDisplay;
    }

    // Elements
    const searchModal = document.getElementById('searchModal');
    const searchModalInput = document.getElementById('searchModalInput');
    const searchResults = document.getElementById('searchResults');
    const searchBtn = document.getElementById('headerSearchBtn');
    const searchCloseBtn = document.getElementById('searchCloseBtn');
    const modalOverlay = searchModal ? searchModal.querySelector('.search-modal-overlay') : null;

    // Check if we're on homepage
    const isHomePage = document.body.classList.contains('home-page');
    const heroSearchInput = document.getElementById('heroSearchInput');

    let currentResults = [];
    let selectedIndex = -1;
    let searchTimeout = null;

    /**
     * Open search modal or focus hero search
     */
    function openSearch() {
        if (heroSearchInput) {
            // On homepage, focus the hero search field only (don't open modal)
            heroSearchInput.focus();
            heroSearchInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else if (searchModal) {
            // On other pages, show modal
            searchModal.classList.add('active');
            searchModalInput.focus();
            document.body.style.overflow = 'hidden';
        }
    }

    /**
     * Close search modal
     */
    function closeSearch() {
        if (searchModal) {
            searchModal.classList.remove('active');
            searchModalInput.value = '';
            searchResults.innerHTML = `
                <div class="search-empty-state">
                    <i class="ph ph-magnifying-glass"></i>
                    <p>Start typing to search...</p>
                </div>
            `;
            document.body.style.overflow = '';
            currentResults = [];
            selectedIndex = -1;
        }
    }

    /**
     * Perform search via API
     */
    async function performSearch(query) {
        if (!query || query.trim().length < 2) {
            searchResults.innerHTML = `
                <div class="search-empty-state">
                    <i class="ph ph-magnifying-glass"></i>
                    <p>Start typing to search...</p>
                </div>
            `;
            currentResults = [];
            return;
        }

        // Show loading state
        searchResults.innerHTML = `
            <div class="search-empty-state">
                <i class="ph ph-circle-notch" style="animation: spin 1s linear infinite;"></i>
                <p>Searching...</p>
            </div>
        `;

        try {
            const response = await fetch(`/api/search?q=${encodeURIComponent(query)}`);
            const data = await response.json();

            if (data.results && data.results.length > 0) {
                currentResults = data.results;
                displayResults(data.results);
            } else {
                searchResults.innerHTML = `
                    <div class="search-empty-state">
                        <i class="ph ph-magnifying-glass-minus"></i>
                        <p>No results found for "${query}"</p>
                    </div>
                `;
                currentResults = [];
            }
        } catch (error) {
            console.error('Search error:', error);
            searchResults.innerHTML = `
                <div class="search-empty-state">
                    <i class="ph ph-warning-circle"></i>
                    <p>Search unavailable. Please try again.</p>
                </div>
            `;
            currentResults = [];
        }
    }

    /**
     * Display search results
     */
    function displayResults(results) {
        searchResults.innerHTML = results.map((result, index) => `
            <a href="${result.url}" class="search-result-item" data-index="${index}">
                <div class="search-result-icon">
                    <i class="ph-fill ph-file-text"></i>
                </div>
                <div class="search-result-content">
                    <div class="search-result-title">${highlightText(result.title)}</div>
                    ${result.excerpt ? `<div class="search-result-excerpt">${highlightText(result.excerpt)}</div>` : ''}
                    ${result.breadcrumb ? `<div class="search-result-breadcrumb">${result.breadcrumb}</div>` : ''}
                </div>
            </a>
        `).join('');

        selectedIndex = -1;
    }

    /**
     * Highlight search terms in text
     */
    function highlightText(text) {
        const query = searchModalInput.value.trim();
        if (!query) return text;

        const regex = new RegExp(`(${query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
        return text.replace(regex, '<mark>$1</mark>');
    }

    /**
     * Navigate results with keyboard
     */
    function navigateResults(direction) {
        if (currentResults.length === 0) return;

        // Remove previous selection
        const items = searchResults.querySelectorAll('.search-result-item');
        if (items[selectedIndex]) {
            items[selectedIndex].classList.remove('active');
        }

        // Update selection
        if (direction === 'down') {
            selectedIndex = Math.min(selectedIndex + 1, currentResults.length - 1);
        } else if (direction === 'up') {
            selectedIndex = Math.max(selectedIndex - 1, -1);
        }

        // Add new selection
        if (selectedIndex >= 0 && items[selectedIndex]) {
            items[selectedIndex].classList.add('active');
            items[selectedIndex].scrollIntoView({ block: 'nearest', behavior: 'smooth' });
        }
    }

    /**
     * Open selected result
     */
    function openSelectedResult() {
        if (selectedIndex >= 0 && currentResults[selectedIndex]) {
            window.location.href = currentResults[selectedIndex].url;
        }
    }

    // Event Listeners

    // Search button click
    if (searchBtn) {
        searchBtn.addEventListener('click', openSearch);
    }

    // Close button click
    if (searchCloseBtn) {
        searchCloseBtn.addEventListener('click', closeSearch);
    }

    // Overlay click
    if (modalOverlay) {
        modalOverlay.addEventListener('click', closeSearch);
    }

    // Search input
    if (searchModalInput) {
        searchModalInput.addEventListener('input', (e) => {
            const query = e.target.value;

            // Debounce search
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch(query);
            }, 300);
        });
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', (e) => {
        // Cmd/Ctrl + K to open search
        if (e[modifierKey] && e.key === 'k') {
            // If hero search input exists, let home-search.js handle it
            // Check dynamically in case DOM wasn't ready when script loaded
            const heroInput = document.getElementById('heroSearchInput');
            if (heroInput) {
                return;
            }
            e.preventDefault();
            openSearch();
            return;
        }

        // Only handle these keys when modal is open
        if (!searchModal || !searchModal.classList.contains('active')) return;

        switch (e.key) {
            case 'Escape':
                e.preventDefault();
                closeSearch();
                break;
            case 'ArrowDown':
                e.preventDefault();
                navigateResults('down');
                break;
            case 'ArrowUp':
                e.preventDefault();
                navigateResults('up');
                break;
            case 'Enter':
                e.preventDefault();
                openSelectedResult();
                break;
        }
    });

    // Add CSS for spin animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .search-result-title mark,
        .search-result-excerpt mark {
            background: #fef3c7;
            color: inherit;
            padding: 1px 2px;
            border-radius: 2px;
        }
    `;
    document.head.appendChild(style);
})();
