/**
 * Purple Gradient Background with Rotated Grid
 * Simplified version for Help Center
 */

class MeshGradient {
    constructor(canvasId) {
        this.canvas = document.getElementById(canvasId);
        if (!this.canvas) return;

        this.ctx = this.canvas.getContext('2d', { alpha: false, desynchronized: true });
        this.width = 0;
        this.height = 0;
        this.isVisible = true;
        this.animationId = null;
        this.lastFrameTime = 0;
        this.targetFPS = 30; // Reduced from ~60fps
        this.frameInterval = 1000 / this.targetFPS;

        // Performance optimization
        this.canvas.style.willChange = 'contents';
        this.canvas.style.transform = 'translateZ(0)';
        this.canvas.style.backfaceVisibility = 'hidden';

        // Purple gradient colors
        this.colors = [
            { r: 46, g: 16, b: 101 },      // Deep purple #2e1065
            { r: 59, g: 26, b: 111 },      // Medium purple #3b1a6f
            { r: 139, g: 92, b: 246 },     // Light purple #8b5cf6
            { r: 168, g: 85, b: 247 },     // Bright purple #a855f7
        ];

        // Gradient points
        this.points = [];

        // Sensor grid
        this.gridPulse = 0;

        this.resize();
        window.addEventListener('resize', () => this.resize());

        // Pause animation when tab is not visible
        document.addEventListener('visibilitychange', () => {
            this.isVisible = !document.hidden;
            if (this.isVisible) {
                this.lastFrameTime = performance.now();
                this.animate();
            } else {
                if (this.animationId) {
                    cancelAnimationFrame(this.animationId);
                    this.animationId = null;
                }
            }
        });

        this.init();
        this.animate();
    }

    init() {
        this.initGradient();
    }

    initGradient() {
        this.points = [];
        // Create 4 gradient points
        for (let i = 0; i < 4; i++) {
            this.points.push({
                x: Math.random(),
                y: Math.random(),
                vx: (Math.random() - 0.5) * 0.0002,
                vy: (Math.random() - 0.5) * 0.0002,
                radius: 0.4 + Math.random() * 0.4,
                color: this.colors[i],
                phase: Math.random() * Math.PI * 2,
                pulseSpeed: 0.3 + Math.random() * 0.5
            });
        }
    }

    resize() {
        const dpr = window.devicePixelRatio || 1;
        const rect = this.canvas.getBoundingClientRect();

        this.width = rect.width;
        this.height = rect.height;

        this.canvas.width = this.width * dpr;
        this.canvas.height = this.height * dpr;

        this.ctx.scale(dpr, dpr);
    }

    animate(currentTime = 0) {
        if (!this.isVisible) return;

        // Throttle to target FPS
        const elapsed = currentTime - this.lastFrameTime;

        if (elapsed >= this.frameInterval) {
            this.lastFrameTime = currentTime - (elapsed % this.frameInterval);
            this.update();
            this.draw();
        }

        this.animationId = requestAnimationFrame((time) => this.animate(time));
    }

    update() {
        const time = Date.now() * 0.001;

        // Update grid pulse
        this.gridPulse = Math.sin(time * 0.5) * 0.5 + 0.5;

        // Update gradient points with smooth wrapping
        this.points.forEach((point, i) => {
            point.x += point.vx + Math.sin(time * 0.5 + point.phase) * 0.0001;
            point.y += point.vy + Math.cos(time * 0.3 + point.phase) * 0.0001;

            // Smooth wrap around edges
            if (point.x < -0.3) point.x += 1.6;
            else if (point.x > 1.3) point.x -= 1.6;
            if (point.y < -0.3) point.y += 1.6;
            else if (point.y > 1.3) point.y -= 1.6;
        });
    }

    draw() {
        const time = Date.now() * 0.001;

        // Clear with base purple
        this.ctx.fillStyle = '#2e1065';
        this.ctx.fillRect(0, 0, this.width, this.height);

        // Draw purple gradient clouds
        this.points.forEach(point => {
            const pulse = 0.3 + Math.sin(time * point.pulseSpeed) * 0.15;
            const gradient = this.ctx.createRadialGradient(
                point.x * this.width,
                point.y * this.height,
                0,
                point.x * this.width,
                point.y * this.height,
                point.radius * Math.max(this.width, this.height)
            );

            const color = point.color;
            gradient.addColorStop(0, `rgba(${color.r}, ${color.g}, ${color.b}, ${pulse * 0.5})`);
            gradient.addColorStop(0.3, `rgba(${color.r}, ${color.g}, ${color.b}, ${pulse * 0.3})`);
            gradient.addColorStop(0.7, `rgba(${color.r}, ${color.g}, ${color.b}, ${pulse * 0.15})`);
            gradient.addColorStop(1, `rgba(${color.r}, ${color.g}, ${color.b}, 0)`);

            this.ctx.fillStyle = gradient;
            this.ctx.fillRect(0, 0, this.width, this.height);
        });

        // Draw rotated grid overlay
        this.ctx.save();

        // Rotate grid by 15 degrees around center
        this.ctx.translate(this.width / 2, this.height / 2);
        this.ctx.rotate(15 * Math.PI / 180);
        this.ctx.translate(-this.width / 2, -this.height / 2);

        // Add blur
        this.ctx.filter = 'blur(1.5px)';
        this.ctx.strokeStyle = `rgba(192, 132, 252, ${0.15 + this.gridPulse * 0.05})`;
        this.ctx.lineWidth = 1;

        // Vertical grid lines
        const gridSpacing = 100;
        const extendedSize = Math.max(this.width, this.height) * 1.5;
        for (let x = -extendedSize; x < extendedSize; x += gridSpacing) {
            this.ctx.beginPath();
            this.ctx.moveTo(x, -extendedSize);
            this.ctx.lineTo(x, extendedSize);
            this.ctx.stroke();
        }

        // Horizontal grid lines
        for (let y = -extendedSize; y < extendedSize; y += gridSpacing) {
            this.ctx.beginPath();
            this.ctx.moveTo(-extendedSize, y);
            this.ctx.lineTo(extendedSize, y);
            this.ctx.stroke();
        }

        // Reset transform and filter
        this.ctx.restore();
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    new MeshGradient('meshGradientCanvas');
});
