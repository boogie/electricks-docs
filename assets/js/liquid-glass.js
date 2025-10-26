/**
 * Liquid Glass Icon System - iOS 26 Design
 * Authentic squircle shapes with multi-layer glass effects
 */

// Color presets inspired by iOS
const LIQUID_GLASS_PRESETS = {
  appStore: { color1: '#4A9EF5', color2: '#1565C0' },
  messages: { color1: '#34C759', color2: '#248A3D' },
  music: { color1: '#FF3B30', color2: '#C7221B' },
  photos: { color1: '#FF9500', color2: '#FF6B00' },
  maps: { color1: '#34C759', color2: '#00A82D' },
  purple: { color1: '#AF52DE', color2: '#7C3AAE' },
  blue: { color1: '#007AFF', color2: '#0051D5' },
  indigo: { color1: '#5856D6', color2: '#3634A3' },
  teal: { color1: '#5AC8FA', color2: '#0099CC' },
  pink: { color1: '#FF2D55', color2: '#C7001E' },
  yellow: { color1: '#FFCC00', color2: '#FF9500' },
  orange: { color1: '#FF9500', color2: '#FF6B00' }
};

/**
 * Generate authentic iOS squircle path
 * Uses superellipse formula for true iOS app icon shape
 * @param {number} size - Icon size in pixels
 * @returns {string} SVG path data
 */
function generateSquirclePath(size) {
  const scale = size / 120;
  const cornerRadius = 27 * scale; // iOS standard corner radius proportion

  return `M ${cornerRadius},0
          C ${12*scale},0 0,${12*scale} 0,${cornerRadius}
          L 0,${size - cornerRadius}
          C 0,${size - 12*scale} ${12*scale},${size} ${cornerRadius},${size}
          L ${size - cornerRadius},${size}
          C ${size - 12*scale},${size} ${size},${size - 12*scale} ${size},${size - cornerRadius}
          L ${size},${cornerRadius}
          C ${size},${12*scale} ${size - 12*scale},0 ${size - cornerRadius},0
          Z`;
}

/**
 * Create a Liquid Glass icon with iOS 26 design
 * @param {Object} options - Configuration options
 * @param {string} options.id - Unique identifier for the icon
 * @param {string} options.color1 - Gradient start color (hex)
 * @param {string} options.color2 - Gradient end color (hex)
 * @param {string} options.content - HTML content to display inside (icon SVG or text)
 * @param {number} options.size - Icon size in pixels (default: 80)
 * @param {string} options.preset - Optional color preset name
 * @returns {string} HTML string for the liquid glass icon
 */
function createLiquidGlassIcon({ id, color1, color2, content, size = 80, preset = null }) {
  // Use preset if provided
  if (preset && LIQUID_GLASS_PRESETS[preset]) {
    color1 = LIQUID_GLASS_PRESETS[preset].color1;
    color2 = LIQUID_GLASS_PRESETS[preset].color2;
  }

  const scale = size / 120;
  const path = generateSquirclePath(size);
  const shadowBlur = 30 * scale;
  const shadowY = 15 * scale;

  // Convert hex to rgba for shadow
  const shadowColor = hexToRgba(color2, 0.4);

  return `
    <div class="liquid-glass-icon" data-size="${size}" style="filter: drop-shadow(0 ${shadowY}px ${shadowBlur}px ${shadowColor})">
      <svg class="liquid-glass-shape" viewBox="0 0 ${size} ${size}" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <!-- Main gradient background -->
          <linearGradient id="bg-grad-${id}" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="${color1}" />
            <stop offset="100%" stop-color="${color2}" />
          </linearGradient>

          <!-- Top-left corner glow (specular highlight) -->
          <radialGradient id="glow-tl-${id}" cx="15%" cy="15%" r="50%">
            <stop offset="0%" stop-color="white" stop-opacity="0.4" />
            <stop offset="100%" stop-color="white" stop-opacity="0" />
          </radialGradient>

          <!-- Bottom-right corner glow -->
          <radialGradient id="glow-br-${id}" cx="85%" cy="85%" r="50%">
            <stop offset="0%" stop-color="white" stop-opacity="0.25" />
            <stop offset="100%" stop-color="white" stop-opacity="0" />
          </radialGradient>

          <!-- Glassy dimensional border gradient -->
          <linearGradient id="border-glow-${id}" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="white" stop-opacity="0.4" />
            <stop offset="50%" stop-color="white" stop-opacity="0.15" />
            <stop offset="100%" stop-color="white" stop-opacity="0.3" />
          </linearGradient>

          <!-- Squircle clip path -->
          <clipPath id="clip-${id}">
            <path d="${path}" />
          </clipPath>
        </defs>

        <!-- Layer 1: Base gradient -->
        <path d="${path}" fill="url(#bg-grad-${id})" />

        <!-- Layer 2: Top-left glow (glass refraction) -->
        <path d="${path}" fill="url(#glow-tl-${id})" />

        <!-- Layer 3: Bottom-right glow -->
        <path d="${path}" fill="url(#glow-br-${id})" />

        <!-- Layer 4: Border glow (outer) - iOS 26 stronger border -->
        <path d="${path}"
              fill="none"
              stroke="url(#border-glow-${id})"
              stroke-width="${2.5*scale}"
              opacity="0.9" />

        <!-- Layer 5: Solid white border (inner) - iOS 26 stronger -->
        <path d="${path}"
              fill="none"
              stroke="rgba(255,255,255,0.4)"
              stroke-width="${1.5*scale}" />
      </svg>

      <!-- Icon content layer -->
      <div class="liquid-glass-content">
        ${content}
      </div>
    </div>
  `;
}

/**
 * Convert hex color to rgba
 * @param {string} hex - Hex color code
 * @param {number} alpha - Alpha value (0-1)
 * @returns {string} rgba color string
 */
function hexToRgba(hex, alpha = 1) {
  const r = parseInt(hex.slice(1, 3), 16);
  const g = parseInt(hex.slice(3, 5), 16);
  const b = parseInt(hex.slice(5, 7), 16);
  return `rgba(${r}, ${g}, ${b}, ${alpha})`;
}

/**
 * Initialize all liquid glass icons on the page
 * Looks for elements with data-liquid-glass attribute
 */
function initLiquidGlassIcons() {
  const icons = document.querySelectorAll('[data-liquid-glass]');

  icons.forEach((element, index) => {
    const preset = element.getAttribute('data-liquid-glass');
    const size = parseInt(element.getAttribute('data-size')) || 80;
    const content = element.innerHTML;
    const id = element.getAttribute('data-id') || `icon-${index}`;

    const html = createLiquidGlassIcon({
      id,
      preset,
      content,
      size
    });

    element.outerHTML = html;
  });
}

// Auto-initialize when DOM is ready
if (typeof document !== 'undefined') {
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLiquidGlassIcons);
  } else {
    initLiquidGlassIcons();
  }
}

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
  module.exports = {
    createLiquidGlassIcon,
    LIQUID_GLASS_PRESETS,
    initLiquidGlassIcons
  };
}
