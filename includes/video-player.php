<?php
/**
 * Standalone Video Player Component for Help Site
 *
 * This is a self-contained video player that doesn't depend on the main videos site.
 * It connects to the main site's API for video data.
 *
 * Usage:
 * <?php
 * require_once __DIR__ . '/includes/video-player.php';
 * render_help_video('dQw4w9WgXcQ', ['autoplay' => false]);
 * ?>
 */

function render_help_video($video_id, $options = []) {
    // Default options
    $defaults = [
        'autoplay' => false,
        'show_cover' => true,
        'width' => '100%',
        'max_width' => '900px',
    ];

    $opts = array_merge($defaults, $options);

    if (empty($video_id)) {
        echo '<div class="error">Error: No video ID provided</div>';
        return;
    }

    // Fetch video data from main site API
    $main_site_url = 'https://electricks.info'; // Change to actual domain
    $api_url = $main_site_url . '/videos/api/video-title.php?v=' . urlencode($video_id);

    // Try to fetch video data
    $video_data = @file_get_contents($api_url);
    $video_info = $video_data ? json_decode($video_data, true) : null;

    $thumbnail = "https://i.ytimg.com/vi/{$video_id}/maxresdefault.jpg";
    $autoplay_param = $opts['autoplay'] ? 1 : 0;
    $unique_id = 'help-video-' . substr(md5($video_id . time()), 0, 8);

    ?>
    <!-- Electricks Help Video Player -->
    <style>
    .help-video-player * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    .help-video-controls {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
    }

    .help-progress-container::before {
        content: "";
        position: absolute;
        top: -15px;
        bottom: -15px;
        left: 0;
        right: 0;
        z-index: 1;
    }

    .help-progress-container:hover {
        height: 8px !important;
    }

    .help-progress-bar::after {
        content: "";
        position: absolute;
        right: -6px;
        top: 50%;
        transform: translateY(-50%);
        width: 12px;
        height: 12px;
        background: white;
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.2s;
    }

    .help-progress-container:hover .help-progress-bar::after {
        opacity: 1;
    }

    .help-control-btn {
        width: auto !important;
        height: auto !important;
        line-height: 1 !important;
        min-width: auto !important;
    }

    .help-control-btn:hover {
        background: rgba(255,255,255,0.2) !important;
        transform: scale(1.1) !important;
    }

    .help-video-player button {
        font-family: inherit !important;
    }
    </style>
    <div class="help-video-player"
         style="max-width: <?php echo htmlspecialchars($opts['max_width']); ?>; width: <?php echo htmlspecialchars($opts['width']); ?>; margin: 2rem auto;">

        <div class="help-video-container" style="position: relative; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
            <div class="help-video-wrapper" style="position: relative; padding-top: 56.25%; background: #000; overflow: hidden;">

                <?php if ($opts['show_cover'] && !$opts['autoplay']): ?>
                <div class="help-video-cover" id="<?php echo $unique_id; ?>-cover"
                     style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;
                            background-image: url('<?php echo htmlspecialchars($thumbnail); ?>');
                            background-size: cover; background-position: center; z-index: 8; cursor: pointer; transition: opacity 0.3s ease;">
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
                                width: 80px; height: 80px; background: rgba(255, 255, 255, 0.95);
                                border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <div style="font-size: 32px; color: #000; margin-left: 5px;">▶</div>
                    </div>
                </div>
                <?php endif; ?>

                <iframe
                    id="<?php echo $unique_id; ?>"
                    style="position: absolute; top: -40%; left: 0; width: 100%; height: 180%;"
                    src="https://www.youtube.com/embed/<?php echo htmlspecialchars($video_id); ?>?autoplay=<?php echo $autoplay_param; ?>&rel=0&enablejsapi=1&modestbranding=1&playsinline=1&iv_load_policy=3&cc_load_policy=0&controls=0"
                    title="<?php echo $video_info['title'] ?? 'Video Tutorial'; ?>"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share; fullscreen"
                    allowfullscreen
                    loading="eager">
                </iframe>
            </div>

            <!-- Custom Controls -->
            <div class="help-video-controls" id="<?php echo $unique_id; ?>-controls"
                 style="position: absolute; bottom: -10px; left: 0; right: 0;
                        background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.7) 50%, transparent 100%);
                        padding: 40px 20px 20px; opacity: 1; transition: opacity 0.3s ease; z-index: 10; pointer-events: auto;">

                <!-- Progress Bar -->
                <div style="width: 100%; height: 6px; background: rgba(255,255,255,0.3); border-radius: 3px;
                            cursor: pointer; margin-bottom: 12px; position: relative;"
                     id="<?php echo $unique_id; ?>-progress-container"
                     class="help-progress-container">
                    <div id="<?php echo $unique_id; ?>-progress-bar"
                         style="height: 100%; background: #9333ea; border-radius: 3px; width: 0%; transition: width 0.1s linear; position: relative;"
                         class="help-progress-bar"></div>
                    <div id="<?php echo $unique_id; ?>-progress-tooltip"
                         style="position: absolute; bottom: 20px; background: rgba(0, 0, 0, 0.95);
                                backdrop-filter: blur(10px); color: white; padding: 8px 14px; border-radius: 10px;
                                font-size: 0.85rem; font-weight: 600; pointer-events: none; opacity: 0;
                                transform: translateX(-50%); transition: opacity 0.2s;
                                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.6); max-width: 300px; text-align: center;"></div>
                </div>

                <!-- Control Buttons -->
                <div style="display: flex; align-items: center; gap: 12px;">
                    <button id="<?php echo $unique_id; ?>-play-pause"
                            style="background: none; border: none; color: white; cursor: pointer; padding: 8px;
                                   display: flex; align-items: center; justify-content: center; border-radius: 50%;
                                   transition: all 0.2s; font-size: 32px;"
                            class="help-control-btn play-pause"
                            title="Play/Pause">
                        <i class="ph-fill ph-play"></i>
                    </button>

                    <span id="<?php echo $unique_id; ?>-time"
                          style="color: white; font-size: 14px; font-weight: 500; min-width: 100px;">0:00 / 0:00</span>

                    <div style="flex: 1;"></div>

                    <button id="<?php echo $unique_id; ?>-fullscreen"
                            style="background: none; border: none; color: white; cursor: pointer; padding: 8px;
                                   display: flex; align-items: center; justify-content: center; border-radius: 50%;
                                   transition: all 0.2s; font-size: 24px;"
                            class="help-control-btn"
                            title="Fullscreen">
                        <i class="ph ph-corners-out"></i>
                    </button>
                </div>
            </div>
        </div>

        <?php if ($video_info && !empty($video_info['title'])): ?>
        <div style="margin-top: 1rem; padding: 1rem; background: #f9fafb; border-radius: 8px;">
            <h4 style="margin: 0 0 0.5rem 0; color: #1f2937;"><?php echo htmlspecialchars($video_info['title']); ?></h4>
            <?php if (!empty($video_info['description'])): ?>
            <p style="margin: 0; color: #6b7280; font-size: 0.9rem; line-height: 1.5;">
                <?php echo nl2br(htmlspecialchars(substr($video_info['description'], 0, 200))); ?>
                <?php if (strlen($video_info['description']) > 200) echo '...'; ?>
            </p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <script>
    (function() {
        const playerId = '<?php echo $unique_id; ?>';
        let player = null;
        let isReady = false;
        let progressInterval = null;

        // Load YouTube IFrame API
        if (!window.YT) {
            const tag = document.createElement('script');
            tag.src = 'https://www.youtube.com/iframe_api';
            const firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
        }

        // Initialize player when API is ready
        function initPlayer() {
            player = new YT.Player(playerId, {
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
        }

        if (window.YT && window.YT.Player) {
            initPlayer();
        } else {
            const oldCallback = window.onYouTubeIframeAPIReady;
            window.onYouTubeIframeAPIReady = function() {
                if (oldCallback) oldCallback();
                initPlayer();
            };
        }

        function onPlayerReady(event) {
            isReady = true;
            player.setVolume(100);
            startProgressTracking();

            // Handle cover click
            const cover = document.getElementById(playerId + '-cover');
            if (cover) {
                cover.addEventListener('click', function() {
                    player.playVideo();
                    cover.style.opacity = '0';
                    setTimeout(() => cover.style.display = 'none', 300);
                });
            }

            // Play/Pause button
            const playPauseBtn = document.getElementById(playerId + '-play-pause');
            if (playPauseBtn) {
                playPauseBtn.addEventListener('click', () => {
                    if (player.getPlayerState() === YT.PlayerState.PLAYING) {
                        player.pauseVideo();
                    } else {
                        player.playVideo();
                    }
                });
            }

            // Fullscreen button
            const fullscreenBtn = document.getElementById(playerId + '-fullscreen');
            const container = document.querySelector('.help-video-container');
            if (fullscreenBtn && container) {
                fullscreenBtn.addEventListener('click', () => {
                    if (container.requestFullscreen) {
                        container.requestFullscreen();
                    } else if (container.webkitRequestFullscreen) {
                        container.webkitRequestFullscreen();
                    }
                });
            }

            // Progress bar click and hover
            const progressContainer = document.getElementById(playerId + '-progress-container');
            const progressTooltip = document.getElementById(playerId + '-progress-tooltip');

            if (progressContainer) {
                progressContainer.addEventListener('click', (e) => {
                    const rect = progressContainer.getBoundingClientRect();
                    const pos = (e.clientX - rect.left) / rect.width;
                    player.seekTo(player.getDuration() * pos);
                });

                // Show tooltip on hover
                progressContainer.addEventListener('mousemove', (e) => {
                    if (!player || !isReady) return;

                    const rect = progressContainer.getBoundingClientRect();
                    const pos = (e.clientX - rect.left) / rect.width;
                    const time = player.getDuration() * pos;

                    if (progressTooltip) {
                        progressTooltip.textContent = formatTime(time);
                        progressTooltip.style.left = (pos * 100) + '%';
                        progressTooltip.style.opacity = '1';
                    }
                });

                progressContainer.addEventListener('mouseleave', () => {
                    if (progressTooltip) {
                        progressTooltip.style.opacity = '0';
                    }
                });
            }
        }

        function onPlayerStateChange(event) {
            const playPauseBtn = document.getElementById(playerId + '-play-pause');
            const cover = document.getElementById(playerId + '-cover');

            if (event.data === YT.PlayerState.PLAYING) {
                if (playPauseBtn) playPauseBtn.innerHTML = '<i class="ph-fill ph-pause"></i>';
                if (cover) {
                    cover.style.opacity = '0';
                    setTimeout(() => cover.style.display = 'none', 300);
                }
                // Reset restart flag when playing
                hasRestarted = false;
                startProgressTracking();
            } else if (event.data === YT.PlayerState.PAUSED) {
                if (playPauseBtn) playPauseBtn.innerHTML = '<i class="ph-fill ph-play"></i>';
            }
        }

        let hasRestarted = false;

        function startProgressTracking() {
            if (progressInterval) clearInterval(progressInterval);

            progressInterval = setInterval(() => {
                if (!player || !isReady) return;

                try {
                    const currentTime = player.getCurrentTime();
                    const duration = player.getDuration();

                    if (duration > 0) {
                        const progress = (currentTime / duration) * 100;
                        const progressBar = document.getElementById(playerId + '-progress-bar');
                        if (progressBar) progressBar.style.width = progress + '%';

                        const timeDisplay = document.getElementById(playerId + '-time');
                        if (timeDisplay) {
                            timeDisplay.textContent = formatTime(currentTime) + ' / ' + formatTime(duration);
                        }

                        // Auto-restart 1 second before end
                        const timeLeft = duration - currentTime;
                        if (timeLeft <= 1.0 && timeLeft > 0 && !hasRestarted) {
                            hasRestarted = true;
                            player.seekTo(0);
                            player.pauseVideo();

                            // Show cover again
                            const cover = document.getElementById(playerId + '-cover');
                            if (cover) {
                                cover.style.display = 'block';
                                setTimeout(() => cover.style.opacity = '1', 10);
                            }
                        }
                    }
                } catch (e) {
                    console.error('Error updating progress:', e);
                }
            }, 250);
        }

        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return mins + ':' + (secs < 10 ? '0' : '') + secs;
        }
    })();
    </script>
    <?php
}
