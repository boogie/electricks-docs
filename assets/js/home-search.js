/**
 * Home Page Search Functionality
 */

class HomeSearch {
    constructor() {
        this.searchInput = document.getElementById('heroSearchInput');
        this.searchResults = document.getElementById('heroSearchResults');
        this.searchContainer = document.getElementById('heroSearchResultsContainer');

        if (!this.searchInput) return;

        this.debounceTimer = null;
        this.minSearchLength = 2;
        this.currentResults = [];
        this.selectedIndex = -1;

        this.init();
    }

    init() {
        this.searchInput.addEventListener('input', (e) => this.handleSearch(e));
        this.searchInput.addEventListener('focus', () => this.showResults());

        // Close results when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.hero-search')) {
                this.hideResults();
                this.selectedIndex = -1;
            }
        });

        // Keyboard shortcut (Cmd/Ctrl + K)
        document.addEventListener('keydown', (e) => {
            if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                e.preventDefault();
                this.searchInput.focus();
            }

            // Escape to close (keep focus and selection)
            if (e.key === 'Escape') {
                this.hideResults();
            }

            // Arrow navigation
            if (this.searchContainer && this.searchContainer.classList.contains('active')) {
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    this.navigateResults('down');
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    this.navigateResults('up');
                } else if (e.key === 'Enter' && this.selectedIndex >= 0) {
                    e.preventDefault();
                    this.openSelectedResult();
                }
            }
        });

        // Add hover listeners dynamically
        this.searchResults.addEventListener('mouseover', (e) => {
            const item = e.target.closest('.search-result-item');
            if (item) {
                this.clearSelection();
                item.classList.add('active');
                this.selectedIndex = parseInt(item.dataset.index);
            }
        });
    }

    handleSearch(e) {
        const query = e.target.value.trim();

        clearTimeout(this.debounceTimer);

        if (query.length < this.minSearchLength) {
            this.hideResults();
            return;
        }

        // Debounce search
        this.debounceTimer = setTimeout(() => {
            this.performSearch(query);
        }, 300);
    }

    async performSearch(query) {
        try {
            const response = await fetch(`/api/search?q=${encodeURIComponent(query)}`);
            const data = await response.json();

            this.displayResults(data.results || []);
        } catch (error) {
            console.error('Search error:', error);
            this.displayError();
        }
    }

    displayResults(results) {
        this.currentResults = results;
        this.selectedIndex = -1;

        if (results.length === 0) {
            this.searchResults.innerHTML = `
                <div class="search-empty-state">
                    <i class="ph ph-magnifying-glass-minus"></i>
                    <p>No results found</p>
                </div>
            `;
            this.showResults();
            return;
        }

        const resultsHTML = results.map((result, index) => `
            <a href="${result.url}" class="search-result-item" data-index="${index}">
                <div class="search-result-icon">
                    <i class="ph-fill ph-file-text"></i>
                </div>
                <div class="search-result-content">
                    <div class="search-result-title">${this.highlightQuery(result.title, this.searchInput.value)}</div>
                    ${result.excerpt ? `<div class="search-result-excerpt">${this.highlightQuery(result.excerpt, this.searchInput.value)}</div>` : ''}
                    ${result.breadcrumb ? `<div class="search-result-breadcrumb">${result.breadcrumb}</div>` : ''}
                </div>
            </a>
        `).join('');

        this.searchResults.innerHTML = resultsHTML;
        this.showResults();
    }

    displayError() {
        this.searchResults.innerHTML = `
            <div class="search-empty-state">
                <i class="ph ph-warning-circle"></i>
                <p>Search unavailable. Please try again.</p>
            </div>
        `;
        this.showResults();
    }

    highlightQuery(text, query) {
        if (!query) return text;

        const regex = new RegExp(`(${query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
        return text.replace(regex, '<mark>$1</mark>');
    }

    navigateResults(direction) {
        if (this.currentResults.length === 0) return;

        this.clearSelection();

        if (direction === 'down') {
            this.selectedIndex = Math.min(this.selectedIndex + 1, this.currentResults.length - 1);
        } else if (direction === 'up') {
            this.selectedIndex = Math.max(this.selectedIndex - 1, -1);
        }

        if (this.selectedIndex >= 0) {
            const items = this.searchResults.querySelectorAll('.search-result-item');
            if (items[this.selectedIndex]) {
                items[this.selectedIndex].classList.add('active');
                items[this.selectedIndex].scrollIntoView({ block: 'nearest', behavior: 'smooth' });
            }
        }
    }

    clearSelection() {
        const items = this.searchResults.querySelectorAll('.search-result-item');
        items.forEach(item => item.classList.remove('active'));
    }

    openSelectedResult() {
        if (this.selectedIndex >= 0 && this.currentResults[this.selectedIndex]) {
            window.location.href = this.currentResults[this.selectedIndex].url;
        }
    }

    showResults() {
        if (this.searchResults.innerHTML.trim() && this.searchContainer) {
            this.searchContainer.classList.add('active');
        }
    }

    hideResults() {
        if (this.searchContainer) {
            this.searchContainer.classList.remove('active');
        }
    }
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new HomeSearch();
    });
} else {
    new HomeSearch();
}
