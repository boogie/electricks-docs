/**
 * Static Purple Gradient Background with Rotated Grid
 * Renders once on load and on resize (no animation to prevent video flickering)
 */

class MeshGradient {
    constructor(canvasId) {
        this.canvas = document.getElementById(canvasId);
        if (!this.canvas) return;

        this.ctx = this.canvas.getContext('2d', { alpha: false });
        this.width = 0;
        this.height = 0;

        // Purple gradient colors
        this.colors = [
            { r: 46, g: 16, b: 101 },      // Deep purple #2e1065
            { r: 59, g: 26, b: 111 },      // Medium purple #3b1a6f
            { r: 139, g: 92, b: 246 },     // Light purple #8b5cf6
            { r: 168, g: 85, b: 247 },     // Bright purple #a855f7
        ];

        // Gradient points
        this.points = [];

        this.resize();
        window.addEventListener('resize', () => this.resize());

        this.init();
        this.draw(); // Render once only
    }

    init() {
        this.initGradient();
    }

    initGradient() {
        this.points = [];
        // Create 4 gradient points at fixed positions
        for (let i = 0; i < 4; i++) {
            this.points.push({
                x: Math.random(),
                y: Math.random(),
                radius: 0.4 + Math.random() * 0.4,
                color: this.colors[i]
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
        this.draw(); // Re-render on resize
    }

    draw() {
        // Clear with base purple
        this.ctx.fillStyle = '#2e1065';
        this.ctx.fillRect(0, 0, this.width, this.height);

        // Draw purple gradient clouds (static, no animation)
        this.points.forEach(point => {
            const gradient = this.ctx.createRadialGradient(
                point.x * this.width,
                point.y * this.height,
                0,
                point.x * this.width,
                point.y * this.height,
                point.radius * Math.max(this.width, this.height)
            );

            const color = point.color;
            gradient.addColorStop(0, `rgba(${color.r}, ${color.g}, ${color.b}, 0.5)`);
            gradient.addColorStop(0.3, `rgba(${color.r}, ${color.g}, ${color.b}, 0.3)`);
            gradient.addColorStop(0.7, `rgba(${color.r}, ${color.g}, ${color.b}, 0.15)`);
            gradient.addColorStop(1, `rgba(${color.r}, ${color.g}, ${color.b}, 0)`);

            this.ctx.fillStyle = gradient;
            this.ctx.fillRect(0, 0, this.width, this.height);
        });

        // Draw rotated grid overlay (static)
        this.ctx.save();

        // Rotate grid by 15 degrees around center
        this.ctx.translate(this.width / 2, this.height / 2);
        this.ctx.rotate(15 * Math.PI / 180);
        this.ctx.translate(-this.width / 2, -this.height / 2);

        // Add blur
        this.ctx.filter = 'blur(1.5px)';
        this.ctx.strokeStyle = `rgba(192, 132, 252, 0.15)`;
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
