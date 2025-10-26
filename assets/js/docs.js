/**
 * Documentation Page JavaScript
 */

(function() {
    'use strict';

    // ===== Smooth Scrolling for TOC Links =====
    const tocLinks = document.querySelectorAll('.table-of-contents a');

    tocLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                const headerOffset = 100; // Offset for fixed header
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });

                // Update active state
                tocLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });

    // ===== Auto-highlight TOC on Scroll =====
    const observerOptions = {
        root: null,
        rootMargin: '-100px 0px -66% 0px',
        threshold: 0
    };

    const observerCallback = (entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.getAttribute('id');
                tocLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${id}`) {
                        link.classList.add('active');
                    }
                });
            }
        });
    };

    const observer = new IntersectionObserver(observerCallback, observerOptions);

    // Observe all h2 headings (main sections)
    document.querySelectorAll('.article-body h2[id]').forEach(heading => {
        observer.observe(heading);
    });

    // ===== Sidebar Collapsing on Mobile =====
    const docSidebar = document.querySelector('.doc-sidebar');

    if (docSidebar && window.innerWidth < 968) {
        const sidebarToggle = document.createElement('button');
        sidebarToggle.className = 'sidebar-toggle';
        sidebarToggle.innerHTML = '☰ Menu';
        sidebarToggle.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 100;
            padding: 12px 20px;
            background: var(--color-primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        `;

        document.body.appendChild(sidebarToggle);

        sidebarToggle.addEventListener('click', function() {
            docSidebar.style.display = docSidebar.style.display === 'block' ? 'none' : 'block';
        });
    }


})();
