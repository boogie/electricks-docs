/**
 * MagiScript Playground JavaScript
 */

(function() {
    'use strict';

    // ===== Elements =====
    const codeEditor = document.getElementById('codeEditor');
    const runButton = document.getElementById('runCode');
    const clearButton = document.getElementById('clearCode');
    const loadExampleButton = document.getElementById('loadExample');
    const pausePreviewButton = document.getElementById('pausePreview');
    const resetPreviewButton = document.getElementById('resetPreview');

    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    const consoleOutput = document.getElementById('consoleOutput');
    const errorOutput = document.getElementById('errorOutput');
    const ledStrip = document.querySelector('.led-strip');

    const examplesModal = document.getElementById('examplesModal');
    const closeExamplesButton = document.getElementById('closeExamples');
    const exampleCards = document.querySelectorAll('.example-card');

    // ===== State =====
    let isRunning = false;
    let isPaused = false;
    let frame = 0;
    let animationFrame = null;
    let leds = [];
    const LED_COUNT = 30;

    // ===== Initialize LEDs =====
    function initLEDs() {
        ledStrip.innerHTML = '';
        leds = [];

        for (let i = 0; i < LED_COUNT; i++) {
            const led = document.createElement('div');
            led.className = 'led';
            led.dataset.index = i;
            ledStrip.appendChild(led);
            leds.push(led);
        }
    }

    // ===== Tab Switching =====
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.dataset.tab;

            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));

            this.classList.add('active');
            document.querySelector(`.tab-content[data-tab="${targetTab}"]`).classList.add('active');
        });
    });

    // ===== Run Code =====
    if (runButton) {
        runButton.addEventListener('click', runCode);
    }

    async function runCode() {
        const code = codeEditor.value;

        // Clear previous outputs
        consoleOutput.innerHTML = '';
        errorOutput.innerHTML = '';

        // Show console tab
        switchToTab('console');

        logToConsole('Compiling code...');

        try {
            const response = await fetch('/api/compile', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ code })
            });

            const result = await response.json();

            if (result.success) {
                logToConsole('✓ Compilation successful');
                logToConsole('Starting execution...');

                // Switch to preview tab
                switchToTab('preview');

                // Start animation
                startAnimation(code);
            } else {
                switchToTab('errors');
                if (result.errors && result.errors.length > 0) {
                    result.errors.forEach(error => {
                        showError(error);
                    });
                } else {
                    showError({ message: result.error || 'Unknown error', line: 0 });
                }
            }
        } catch (error) {
            switchToTab('errors');
            showError({ message: 'Failed to connect to compiler API', line: 0 });
            console.error('Compile error:', error);
        }
    }

    // ===== Animation Engine =====
    function startAnimation(code) {
        stopAnimation();
        isRunning = true;
        isPaused = false;
        frame = 0;

        // Update pause button
        pausePreviewButton.innerHTML = `
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                <rect x="5" y="3" width="2" height="10" fill="currentColor"/>
                <rect x="9" y="3" width="2" height="10" fill="currentColor"/>
            </svg>
            Pause
        `;

        animate();
    }

    function animate() {
        if (!isRunning || isPaused) return;

        // Simulate MagiScript execution
        // In a real implementation, this would execute compiled bytecode
        simulateExecution(frame);

        frame++;
        animationFrame = requestAnimationFrame(animate);
    }

    function simulateExecution(frame) {
        // Simple rainbow wave simulation
        for (let i = 0; i < LED_COUNT; i++) {
            const hue = (i * 360 / LED_COUNT + frame * 2) % 360;
            setLEDHSV(i, hue, 100, 100);
        }
    }

    function stopAnimation() {
        isRunning = false;
        if (animationFrame) {
            cancelAnimationFrame(animationFrame);
            animationFrame = null;
        }
    }

    // ===== LED Control Functions =====
    function setLEDHSV(index, h, s, v) {
        if (index < 0 || index >= leds.length) return;

        const rgb = hsvToRgb(h, s, v);
        setLEDRGB(index, rgb.r, rgb.g, rgb.b);
    }

    function setLEDRGB(index, r, g, b) {
        if (index < 0 || index >= leds.length) return;

        const led = leds[index];
        const color = `rgb(${r}, ${g}, ${b})`;
        led.style.backgroundColor = color;
        led.classList.add('active');
    }

    function hsvToRgb(h, s, v) {
        s = s / 100;
        v = v / 100;

        const c = v * s;
        const x = c * (1 - Math.abs(((h / 60) % 2) - 1));
        const m = v - c;

        let r, g, b;

        if (h < 60) { r = c; g = x; b = 0; }
        else if (h < 120) { r = x; g = c; b = 0; }
        else if (h < 180) { r = 0; g = c; b = x; }
        else if (h < 240) { r = 0; g = x; b = c; }
        else if (h < 300) { r = x; g = 0; b = c; }
        else { r = c; g = 0; b = x; }

        return {
            r: Math.round((r + m) * 255),
            g: Math.round((g + m) * 255),
            b: Math.round((b + m) * 255)
        };
    }

    // ===== Console Logging =====
    function logToConsole(message) {
        const entry = document.createElement('div');
        entry.className = 'log-entry';
        entry.textContent = `[${new Date().toLocaleTimeString()}] ${message}`;
        consoleOutput.appendChild(entry);
        consoleOutput.scrollTop = consoleOutput.scrollHeight;
    }

    function showError(error) {
        const entry = document.createElement('div');
        entry.className = 'error-entry';

        const lineInfo = error.line > 0 ? ` (Line ${error.line})` : '';
        entry.innerHTML = `
            <strong>${error.severity || 'error'}${lineInfo}</strong><br>
            ${escapeHtml(error.message)}
        `;

        errorOutput.appendChild(entry);
    }

    // ===== Control Buttons =====
    if (clearButton) {
        clearButton.addEventListener('click', function() {
            if (confirm('Clear all code?')) {
                codeEditor.value = '';
                stopAnimation();
                initLEDs();
            }
        });
    }

    if (pausePreviewButton) {
        pausePreviewButton.addEventListener('click', function() {
            if (!isRunning) return;

            isPaused = !isPaused;

            if (isPaused) {
                this.innerHTML = `
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M4 2L12 8L4 14V2Z" fill="currentColor"/>
                    </svg>
                    Resume
                `;
            } else {
                this.innerHTML = `
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <rect x="5" y="3" width="2" height="10" fill="currentColor"/>
                        <rect x="9" y="3" width="2" height="10" fill="currentColor"/>
                    </svg>
                    Pause
                `;
                animate();
            }
        });
    }

    if (resetPreviewButton) {
        resetPreviewButton.addEventListener('click', function() {
            stopAnimation();
            initLEDs();
            frame = 0;
        });
    }

    // ===== Examples =====
    if (loadExampleButton) {
        loadExampleButton.addEventListener('click', function() {
            examplesModal.classList.add('active');
        });
    }

    if (closeExamplesButton) {
        closeExamplesButton.addEventListener('click', function() {
            examplesModal.classList.remove('active');
        });
    }

    exampleCards.forEach(card => {
        card.addEventListener('click', function() {
            const exampleName = this.dataset.example;
            loadExample(exampleName);
            examplesModal.classList.remove('active');
        });
    });

    function loadExample(name) {
        const examples = {
            rainbow: `// Rainbow wave animation
void rainbow_wave() {
    for (int i = 0; i < LED_COUNT; i++) {
        int hue = (i * 360 / LED_COUNT + frame) % 360;
        set_led_hsv(i, hue, 100, 100);
    }
    show();
}

void loop() {
    rainbow_wave();
    delay(30);
}`,
            pulse: `// Pulse effect
void pulse(int r, int g, int b) {
    int brightness = (sin(frame * 0.1) + 1) * 127;
    fill_solid(r, g, b, brightness);
    show();
}

void loop() {
    pulse(255, 0, 128);
    delay(30);
}`,
            chase: `// Chase animation
void chase() {
    clear();
    int pos = frame % LED_COUNT;
    set_led_rgb(pos, 255, 255, 255);
    set_led_rgb((pos - 1 + LED_COUNT) % LED_COUNT, 128, 128, 128);
    set_led_rgb((pos - 2 + LED_COUNT) % LED_COUNT, 64, 64, 64);
    show();
}

void loop() {
    chase();
    delay(50);
}`,
            sparkle: `// Sparkle effect
void sparkle() {
    for (int i = 0; i < LED_COUNT; i++) {
        if (random(100) < 5) {
            set_led_rgb(i, 255, 255, 255);
        } else {
            fade_led(i, 0.95);
        }
    }
    show();
}

void loop() {
    sparkle();
    delay(30);
}`,
            fire: `// Fire simulation
void fire() {
    for (int i = 0; i < LED_COUNT; i++) {
        int heat = random(160, 255);
        set_led_rgb(i, heat, heat / 2, 0);
    }
    show();
}

void loop() {
    fire();
    delay(50);
}`,
            gradient: `// Color gradient
void gradient() {
    for (int i = 0; i < LED_COUNT; i++) {
        int hue = (i * 360 / LED_COUNT + frame) % 360;
        set_led_hsv(i, hue, 100, 100);
    }
    show();
}

void loop() {
    gradient();
    delay(50);
}`
        };

        if (examples[name]) {
            codeEditor.value = examples[name];
        }
    }

    // ===== Utility Functions =====
    function switchToTab(tabName) {
        tabButtons.forEach(btn => {
            if (btn.dataset.tab === tabName) {
                btn.click();
            }
        });
    }

    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }

    // ===== Initialize =====
    initLEDs();

    // Auto-run on load with default code
    setTimeout(() => {
        if (codeEditor.value.trim()) {
            runCode();
        }
    }, 500);

})();
