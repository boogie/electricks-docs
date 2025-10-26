/**
 * Home Page Search Functionality
 */

class HomeSearch {
    constructor() {
        this.searchInput = document.getElementById('heroSearchInput');
        this.searchResults = document.getElementById('heroSearchResults');

        if (!this.searchInput) return;

        this.debounceTimer = null;
        this.minSearchLength = 2;

        this.init();
    }

    init() {
        this.searchInput.addEventListener('input', (e) => this.handleSearch(e));
        this.searchInput.addEventListener('focus', () => this.showResults());

        // Close results when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.hero-search')) {
                this.hideResults();
            }
        });

        // Keyboard shortcut (Cmd/Ctrl + K)
        document.addEventListener('keydown', (e) => {
            if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                e.preventDefault();
                this.searchInput.focus();
            }

            // Escape to close
            if (e.key === 'Escape') {
                this.hideResults();
                this.searchInput.blur();
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
        if (results.length === 0) {
            this.searchResults.innerHTML = `
                <div class="search-no-results">
                    <i class="ph-bold ph-magnifying-glass"></i>
                    <p>No results found</p>
                    <span>Try a different search term</span>
                </div>
            `;
            this.showResults();
            return;
        }

        const resultsHTML = results.map(result => `
            <a href="${result.url}" class="search-result-item">
                <div class="search-result-icon">
                    <i class="ph ph-file-text"></i>
                </div>
                <div class="search-result-content">
                    <div class="search-result-title">${this.highlightQuery(result.title, this.searchInput.value)}</div>
                    <div class="search-result-excerpt">${result.excerpt || ''}</div>
                </div>
                <div class="search-result-arrow">
                    <i class="ph ph-arrow-right"></i>
                </div>
            </a>
        `).join('');

        this.searchResults.innerHTML = resultsHTML;
        this.showResults();
    }

    displayError() {
        this.searchResults.innerHTML = `
            <div class="search-error">
                <i class="ph-bold ph-warning"></i>
                <p>Search temporarily unavailable</p>
                <span>Please try again later</span>
            </div>
        `;
        this.showResults();
    }

    highlightQuery(text, query) {
        if (!query) return text;

        const regex = new RegExp(`(${query})`, 'gi');
        return text.replace(regex, '<mark>$1</mark>');
    }

    showResults() {
        if (this.searchResults.innerHTML.trim()) {
            this.searchResults.classList.add('active');
        }
    }

    hideResults() {
        this.searchResults.classList.remove('active');
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
