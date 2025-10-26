/**
 * Electricks Developer Portal - Homepage Interactive Effects
 */

document.addEventListener('DOMContentLoaded', function() {

    // ===== Card Parallax Effects =====
    const featureCards = document.querySelectorAll('.feature-card');
    const pathCards = document.querySelectorAll('.path-card');

    function addParallaxEffect(card) {
        card.addEventListener('mousemove', function(e) {
            const rect = card.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / rect.width - 0.5) * 15;
            const y = ((e.clientY - rect.top) / rect.height - 0.5) * 15;

            // Apply 3D rotation based on mouse position
            card.style.transform = `perspective(1000px) rotateX(${-y}deg) rotateY(${x}deg) translateY(-8px) scale(1.02)`;
        });

        card.addEventListener('mouseleave', function() {
            // Reset to default hover state
            card.style.transform = '';
        });
    }

    // Apply to feature cards
    featureCards.forEach(card => addParallaxEffect(card));

    // Apply to path cards
    pathCards.forEach(card => addParallaxEffect(card));


    // ===== Dynamic Lightning Generation =====
    const generateLightning = () => {
        const svg = document.querySelector('.lightning-svg');
        if (!svg) return;

        const paths = svg.querySelectorAll('.lightning-path');
        const viewportWidth = window.innerWidth;

        paths.forEach((path, index) => {
            const points = [];
            const startX = (index + 1) * (viewportWidth / 4);
            let currentX = startX;
            let currentY = 0;

            // Generate jagged lightning path
            for (let i = 0; i < 4; i++) {
                currentY += Math.random() * 80 + 60;
                currentX += (Math.random() - 0.5) * 80;
                points.push(`L ${currentX} ${currentY}`);
            }

            path.setAttribute('d', `M ${startX} 0 ${points.join(' ')}`);
        });
    };

    // Generate lightning paths on load and periodically
    generateLightning();
    setInterval(generateLightning, 8000);

    // Regenerate on window resize
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(generateLightning, 250);
    });


    // ===== Stat Counter Animation =====
    const animateCounters = () => {
        const statValues = document.querySelectorAll('.stat-value');

        statValues.forEach(stat => {
            const text = stat.textContent;
            const hasPlus = text.includes('+');
            const hasPercent = text.includes('%');
            const hasLessThan = text.includes('<');
            const hasMs = text.includes('ms');

            // Extract number
            let numStr = text.replace(/[^0-9.]/g, '');
            const targetNum = parseFloat(numStr);

            if (isNaN(targetNum)) return;

            let currentNum = 0;
            const increment = targetNum / 50;
            const duration = 1500;
            const stepTime = duration / 50;

            const counter = setInterval(() => {
                currentNum += increment;
                if (currentNum >= targetNum) {
                    currentNum = targetNum;
                    clearInterval(counter);
                }

                let display = Math.floor(currentNum);
                if (targetNum < 100 && targetNum % 1 !== 0) {
                    display = currentNum.toFixed(1);
                }

                if (hasLessThan) {
                    stat.textContent = `<${display}ms`;
                } else if (hasPercent) {
                    stat.textContent = `${display}%`;
                } else if (hasPlus) {
                    stat.textContent = `${display}+`;
                } else if (hasMs) {
                    stat.textContent = `${display}ms`;
                } else {
                    stat.textContent = display;
                }
            }, stepTime);
        });
    };

    // Trigger counter animation when stats section is visible
    const statsSection = document.querySelector('.stats');
    if (statsSection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });

        observer.observe(statsSection);
    }


    // ===== Icon Glow Effect on Hover =====
    const liquidGlassIcons = document.querySelectorAll('.liquid-glass-icon');

    liquidGlassIcons.forEach(icon => {
        icon.addEventListener('mouseenter', function() {
            this.style.filter = 'brightness(1.1) drop-shadow(0 0 20px rgba(0, 122, 255, 0.5))';
        });

        icon.addEventListener('mouseleave', function() {
            this.style.filter = '';
        });
    });


    // ===== Smooth Reveal Animations on Scroll =====
    const revealElements = document.querySelectorAll('.feature-card, .path-card, .stat-card');

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    revealElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        revealObserver.observe(el);
    });


    // ===== Code Syntax Highlighting Enhancement =====
    const codeBlock = document.querySelector('.example-code code');
    if (codeBlock) {
        const code = codeBlock.textContent;
        const highlighted = code
            .replace(/(\/\/.*)/g, '<span class="code-comment">$1</span>')
            .replace(/\b(void|int|for|return|const|new|await|import|from)\b/g, '<span class="code-keyword">$1</span>')
            .replace(/\b([a-z_][a-z0-9_]*)\s*\(/gi, '<span class="code-function">$1</span>(')
            .replace(/(['"])(.*?)\1/g, '<span class="code-string">$1$2$1</span>')
            .replace(/\b(\d+)\b/g, '<span class="code-number">$1</span>');

        codeBlock.innerHTML = highlighted;
    }
});
