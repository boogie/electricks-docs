    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Products</h3>
                    <ul>
                        <li><a href="/docs/devices/peeking/peeksmith-3">Peeking Devices</a></li>
                        <li><a href="/docs/devices/watches/sb-watch-2">Prediction Watches</a></li>
                        <li><a href="/docs/devices/remotes/atom-smart-remote">Remote Controls</a></li>
                        <li><a href="/docs/devices/specialty/quantum">Specialty Devices</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Support</h3>
                    <ul>
                        <li><a href="/docs/getting-started/index">Getting Started</a></li>
                        <li><a href="/docs/guides/troubleshooting-common-issues">Troubleshooting</a></li>
                        <li><a href="/docs/support/contact">Contact Us</a></li>
                        <li><a href="/docs/support/warranty">Warranty</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Resources</h3>
                    <ul>
                        <li><a href="https://developers.electricks.info" target="_blank">Developer Portal</a></li>
                        <li><a href="https://electricks.info" target="_blank">Shop</a></li>
                        <li><a href="https://www.facebook.com/groups/electricks" target="_blank">Facebook Groups</a></li>
                        <li><a href="mailto:support@electricks.info">Email Support</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Company</h3>
                    <ul>
                        <li><a href="https://electricks.info/about">About Us</a></li>
                        <li><a href="/docs/support/shipping">Shipping Info</a></li>
                        <li><a href="/docs/support/returns">Returns</a></li>
                        <li><a href="https://electricks.info/privacy">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Electricks Kft. All rights reserved.</p>
                <p class="footer-tagline">Creating Magic Through Technology</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="/assets/js/main.js?v=<?php echo ASSET_VERSION; ?>"></script>
    <?php if (isset($additionalScripts)): ?>
        <?php foreach ($additionalScripts as $script): ?>
            <script src="<?php echo htmlspecialchars($script); ?>?v=<?php echo ASSET_VERSION; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Syntax Highlighting with Highlight.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script>
        // Initialize Highlight.js
        document.addEventListener('DOMContentLoaded', function() {
            hljs.highlightAll();
        });
    </script>
</body>
</html>
