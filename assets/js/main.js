/**
 * Electricks Developer Portal - Main JavaScript
 */

(function() {
    'use strict';

    // ===== Search Modal =====
    const searchTrigger = document.getElementById('searchTrigger');
    const searchModal = document.getElementById('searchModal');
    const searchClose = document.getElementById('searchClose');
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');

    let searchTimeout = null;

    if (searchTrigger) {
        searchTrigger.addEventListener('click', openSearchModal);
    }

    if (searchClose) {
        searchClose.addEventListener('click', closeSearchModal);
    }

    if (searchModal) {
        searchModal.addEventListener('click', function(e) {
            if (e.target === searchModal) {
                closeSearchModal();
            }
        });
    }

    // Keyboard shortcut: Cmd+K or Ctrl+K
    document.addEventListener('keydown', function(e) {
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
            e.preventDefault();
            if (searchModal.classList.contains('active')) {
                closeSearchModal();
            } else {
                openSearchModal();
            }
        }

        // ESC to close search
        if (e.key === 'Escape' && searchModal.classList.contains('active')) {
            closeSearchModal();
        }
    });

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length < 2) {
                searchResults.innerHTML = '';
                return;
            }

            searchTimeout = setTimeout(function() {
                performSearch(query);
            }, 300);
        });
    }

    function openSearchModal() {
        searchModal.classList.add('active');
        searchInput.focus();
    }

    function closeSearchModal() {
        searchModal.classList.remove('active');
        searchInput.value = '';
        searchResults.innerHTML = '';
    }

    async function performSearch(query) {
        try {
            const response = await fetch(`/api/search?q=${encodeURIComponent(query)}`);
            const data = await response.json();

            if (data.results && data.results.length > 0) {
                renderSearchResults(data.results);
            } else {
                searchResults.innerHTML = '<p class="console-empty">No results found</p>';
            }
        } catch (error) {
            console.error('Search error:', error);
            searchResults.innerHTML = '<p class="console-empty">Search failed. Please try again.</p>';
        }
    }

    function renderSearchResults(results) {
        const html = results.map(result => `
            <a href="${result.url}" class="search-result-item">
                <div class="search-result-title">${escapeHtml(result.title)}</div>
                <div class="search-result-excerpt">${result.excerpt}</div>
            </a>
        `).join('');

        searchResults.innerHTML = html;
    }

    // ===== Mobile Menu =====
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mainNav = document.querySelector('.main-nav');

    if (mobileMenuToggle && mainNav) {
        mobileMenuToggle.addEventListener('click', function() {
            mainNav.classList.toggle('active');
            this.classList.toggle('active');
        });
    }

    // ===== Smooth Scroll for Anchor Links =====
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                const headerHeight = document.querySelector('.site-header').offsetHeight;
                const targetPosition = target.offsetTop - headerHeight - 20;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // ===== Syntax Highlighting =====
    if (typeof Prism !== 'undefined') {
        Prism.highlightAll();
    }

    // ===== Copy Code Button =====
    document.querySelectorAll('pre code').forEach(function(codeBlock) {
        const pre = codeBlock.parentElement;
        const button = document.createElement('button');
        button.className = 'copy-code-button';
        button.textContent = 'Copy';
        button.setAttribute('aria-label', 'Copy code to clipboard');

        pre.style.position = 'relative';
        button.style.position = 'absolute';
        button.style.top = '8px';
        button.style.right = '8px';
        button.style.padding = '4px 12px';
        button.style.fontSize = '12px';
        button.style.backgroundColor = 'rgba(255, 255, 255, 0.1)';
        button.style.border = 'none';
        button.style.borderRadius = '4px';
        button.style.color = '#fff';
        button.style.cursor = 'pointer';
        button.style.opacity = '0';
        button.style.transition = 'opacity 0.2s';

        pre.addEventListener('mouseenter', function() {
            button.style.opacity = '1';
        });

        pre.addEventListener('mouseleave', function() {
            button.style.opacity = '0';
        });

        button.addEventListener('click', async function() {
            const code = codeBlock.textContent;
            try {
                await navigator.clipboard.writeText(code);
                button.textContent = 'Copied!';
                setTimeout(function() {
                    button.textContent = 'Copy';
                }, 2000);
            } catch (err) {
                console.error('Failed to copy:', err);
                button.textContent = 'Failed';
                setTimeout(function() {
                    button.textContent = 'Copy';
                }, 2000);
            }
        });

        pre.appendChild(button);
    });

    // ===== Utility Functions =====
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    // ===== Active TOC Highlighting =====
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            const id = entry.target.getAttribute('id');
            if (entry.isIntersecting) {
                document.querySelectorAll('.table-of-contents a').forEach(function(link) {
                    link.classList.remove('active');
                });
                const activeLink = document.querySelector(`.table-of-contents a[href="#${id}"]`);
                if (activeLink) {
                    activeLink.classList.add('active');
                }
            }
        });
    }, {
        rootMargin: '-80px 0px -80% 0px'
    });

    // Observe all headings
    document.querySelectorAll('.article-body h2, .article-body h3').forEach(function(heading) {
        if (heading.id) {
            observer.observe(heading);
        }
    });

})();
