/**
 * Knowledge Canvas Animation - Help Center Version
 * Floating magic-themed PNG icons for help portal
 */

class KnowledgeParticle {
    constructor(canvas, type, image) {
        this.canvas = canvas;
        this.type = type;
        this.image = image;
        this.reset();

        // Start at random position across the entire canvas
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;
    }

    reset() {
        // Static position - no movement
        this.x = Math.random() * this.canvas.width;
        this.y = Math.random() * this.canvas.height;
        this.size = 35 + Math.random() * 45;

        // Static rotation between -15 and 15 degrees
        this.rotation = (Math.random() - 0.5) * (15 * Math.PI / 180) * 2; // -15 to +15 degrees in radians

        // Higher opacity since canvas will be blurred and have opacity applied
        this.baseOpacity = 0.8;

        // Single color - subtle purple only
        this.color = '#c084fc';
    }

    update() {
        // No animations for clean Apple look
    }

    draw(ctx) {
        if (!this.image || !this.image.complete) return;

        ctx.save();
        ctx.translate(this.x, this.y);
        ctx.rotate(this.rotation);

        const imgSize = this.size;

        // Simple, subtle opacity
        ctx.globalAlpha = this.baseOpacity;

        // Minimal glow for depth
        ctx.shadowColor = this.color;
        ctx.shadowBlur = 15;
        ctx.shadowOffsetX = 0;
        ctx.shadowOffsetY = 0;

        // Create tinted canvas once
        if (!this.tintedCanvas) {
            this.tintedCanvas = document.createElement('canvas');
            this.tintedCanvas.width = 100;
            this.tintedCanvas.height = 100;
            const tintCtx = this.tintedCanvas.getContext('2d');
            tintCtx.drawImage(this.image, 0, 0, 100, 100);
            tintCtx.globalCompositeOperation = 'source-in';
            tintCtx.fillStyle = this.color;
            tintCtx.fillRect(0, 0, 100, 100);
        }

        // Draw tinted image
        ctx.drawImage(this.tintedCanvas, -imgSize / 2, -imgSize / 2, imgSize, imgSize);

        ctx.restore();
    }
}

class KnowledgeAnimation {
    constructor() {
        this.canvas = document.getElementById('knowledgeCanvas');
        if (!this.canvas) return;

        this.ctx = this.canvas.getContext('2d');
        this.particles = [];
        this.images = {};
        this.imageTypes = ['teleport', 'magic-hat', 'star'];
        this.imagesLoaded = 0;

        this.loadImages();
    }

    loadImages() {
        this.imageTypes.forEach(type => {
            const img = new Image();
            img.onload = () => {
                this.imagesLoaded++;
                if (this.imagesLoaded === this.imageTypes.length) {
                    // Initial setup
                    this.canvas.width = this.canvas.offsetWidth;
                    this.canvas.height = this.canvas.offsetHeight;
                    this.init();
                    this.setupEventListeners();
                    this.animate();
                }
            };
            img.src = `/assets/images/hero-icons/${type}.png`;
            this.images[type] = img;
        });
    }

    init() {
        // Measure the hero-content-center element
        const contentElement = document.querySelector('.hero-content-center');
        let exclusionZone = null;

        if (contentElement) {
            const rect = contentElement.getBoundingClientRect();
            const canvasRect = this.canvas.getBoundingClientRect();

            exclusionZone = {
                left: rect.left - canvasRect.left,
                top: rect.top - canvasRect.top,
                right: rect.right - canvasRect.left,
                bottom: rect.bottom - canvasRect.top,
                width: rect.width,
                height: rect.height
            };
        }

        // Pick one random icon type for all particles
        const randomType = this.imageTypes[Math.floor(Math.random() * this.imageTypes.length)];
        const selectedImage = this.images[randomType];

        // Distribute across entire background in a clean grid pattern
        const cols = 4;
        const rows = 3;
        const particleCount = 12;

        const marginX = this.canvas.width * 0.1;
        const marginY = this.canvas.height * 0.15;
        const spacingX = (this.canvas.width - marginX * 2) / (cols - 1);
        const spacingY = (this.canvas.height - marginY * 2) / (rows - 1);

        let index = 0;
        for (let row = 0; row < rows; row++) {
            for (let col = 0; col < cols; col++) {
                if (index >= particleCount) break;

                const x = marginX + col * spacingX;
                const y = marginY + row * spacingY;

                const particle = new KnowledgeParticle(this.canvas, randomType, selectedImage);
                particle.x = x;
                particle.y = y;
                this.particles.push(particle);
                index++;
            }
        }
    }

    resize() {
        this.canvas.width = this.canvas.offsetWidth;
        this.canvas.height = this.canvas.offsetHeight;

        // Reinitialize particles with new canvas dimensions
        this.particles = [];
        this.init();
    }

    setupEventListeners() {
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => this.resize(), 250);
        });
    }

    animate() {
        // Clear canvas (transparent background to show waves)
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        // Update and draw stationary particles with rotation and glow
        this.particles.forEach(particle => {
            particle.update();
            particle.draw(this.ctx);
        });

        requestAnimationFrame(() => this.animate());
    }
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new KnowledgeAnimation();
    });
} else {
    new KnowledgeAnimation();
}
