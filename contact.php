<?php
require_once __DIR__ . '/config.php';

$pageTitle = 'Contact Support';
$currentPage = 'contact';

// Handle form submission
$success = false;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $stage_name = $_POST['stage_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject_category = $_POST['subject_category'] ?? '';
    $message = $_POST['message'] ?? '';
    $order_number = $_POST['order_number'] ?? '';
    $device_info = $_POST['device_info'] ?? '';
    $firmware_version = $_POST['firmware_version'] ?? '';
    $app_version = $_POST['app_version'] ?? '';
    
    // Validate
    if (empty($name) || empty($email) || empty($subject_category) || empty($message)) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (in_array($subject_category, ['order', 'shipping']) && empty($order_number)) {
        $error = 'Order ID is required for order and shipping related questions.';
    } else {
        // Send to Gorgias via their API
        $gorgias_domain = 'electricks'; // Your Gorgias subdomain
        $gorgias_api_key = 'info@electricks.info:4e4a6b385cb62a484893d43ca1e93befb2d2a039c30a4d5f08fd6d15766b1c0c';
        
        if (!empty($gorgias_api_key)) {
            $ticket_data = [
                'via' => 'web-form',
                'channel' => 'email',
                'customer' => [
                    'email' => $email,
                    'name' => $name
                ],
                'messages' => [
                    [
                        'source' => [
                            'type' => 'email',
                            'from' => [
                                'address' => $email,
                                'name' => $name
                            ],
                            'to' => [
                                [
                                    'address' => 'support@electricks.info'
                                ]
                            ]
                        ],
                        'body_text' => "Name: $name\nStage Name: $stage_name\nOrder Number: $order_number\nDevice Info: $device_info\nFirmware Version: $firmware_version\nApp Version: $app_version\n\n$message"
                    ]
                ],
                'subject' => $subject_category . ($order_number ? " - Order #$order_number" : '')
            ];
            
            $ch = curl_init("https://{$gorgias_domain}.gorgias.com/api/tickets");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($ticket_data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($gorgias_api_key)
            ]);
            
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($http_code >= 200 && $http_code < 300) {
                $success = true;
            } else {
                $error = 'Unable to submit your request. Please try again or email us directly at support@electricks.info';
            }
        } else {
            // Fallback: Send via email
            $to = 'support@electricks.info';
            $headers = "From: $name <$email>\r\n";
            $headers .= "Reply-To: $email\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
            
            $email_body = "New Support Request\n\n";
            $email_body .= "Name: $name\n";
            $email_body .= "Stage Name: $stage_name\n";
            $email_body .= "Email: $email\n";
            $email_body .= "Subject: $subject_category\n";
            $email_body .= "Order Number: $order_number\n";
            $email_body .= "Device Info: $device_info\n";
            $email_body .= "Firmware Version: $firmware_version\n";
            $email_body .= "App Version: $app_version\n\n";
            $email_body .= "Message:\n$message\n";
            
            if (mail($to, "Support Request: $subject", $email_body, $headers)) {
                $success = true;
            } else {
                $error = 'Unable to send your message. Please email us directly at support@electricks.info';
            }
        }
    }
}

include __DIR__ . '/includes/header.php';
?>

<div class="hero-compact">
    <canvas id="meshGradientCanvas"></canvas>
    <div class="container">
        <div class="hero-content-center">
            <h1 class="hero-title-compact">
                We're here to <span class="gradient-text">help!</span>
            </h1>
            <p class="hero-subtitle-compact">
                We typically respond within one business day, Central European Time.
            </p>
        </div>
    </div>
</div>

<section class="contact-section">
    <div class="container">
        <div class="contact-layout">
            <!-- Contact Form -->
            <div class="contact-form-container">
                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <i class="ph-fill ph-check-circle"></i>
                        <div>
                            <strong>Thank you for contacting us!</strong>
                            <p>We've received your message and will get back to you within 24 hours.</p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php if ($error): ?>
                        <div class="alert alert-error">
                            <i class="ph-fill ph-warning-circle"></i>
                            <div>
                                <strong>Oops!</strong>
                                <p><?php echo htmlspecialchars($error); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" class="contact-form glass-form" id="contactForm">
                        <div class="form-field">
                            <div class="form-group">
                                <label for="subject_category" class="form-label">
                                    Subject <span class="required">*</span>
                                </label>
                                <select id="subject_category" name="subject_category" class="form-select" required onchange="toggleOrderField()">
                                    <option value="">Select a subject</option>
                                    <option value="technical">Technical Support</option>
                                    <option value="app">App Issue</option>
                                    <option value="firmware">Firmware Issue</option>
                                    <option value="bluetooth">Bluetooth Connection</option>
                                    <option value="order">Order Question</option>
                                    <option value="shipping">Shipping Question</option>
                                    <option value="warranty">Warranty</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-tip">
                                <i class="ph-fill ph-info"></i>
                                Select the category that best describes your issue
                            </div>
                        </div>

                        <div class="form-field" id="orderField" style="display: none;">
                            <div class="form-group">
                                <label for="order_number" class="form-label">
                                    Order ID <span class="required" id="orderRequired">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="order_number" 
                                    name="order_number" 
                                    class="form-input"
                                    placeholder="e.g., #12345"
                                    value="<?php echo htmlspecialchars($_POST['order_number'] ?? ''); ?>"
                                >
                            </div>
                            <div class="form-tip">
                                <i class="ph-fill ph-lightbulb"></i>
                                <strong>Why do we need your Order ID?</strong> It helps us check your order status, warranty period, and what exactly you ordered. You can find your Order ID in your order confirmation email.
                            </div>
                        </div>
                        
                        <div class="form-field">
                            <div class="form-group">
                                <label for="name" class="form-label">
                                    Name (used for ordering) <span class="required">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    class="form-input" 
                                    required
                                    placeholder="Full name"
                                    value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                                >
                            </div>
                            <div class="form-tip">
                                <i class="ph-fill ph-user"></i>
                                Use the name you used when ordering. We cannot search based on stage names alone.
                            </div>
                        </div>

                        <div class="form-field">
                            <div class="form-group">
                                <label for="stage_name" class="form-label">
                                    Stage Name / Artist Name
                                </label>
                                <input 
                                    type="text" 
                                    id="stage_name" 
                                    name="stage_name" 
                                    class="form-input"
                                    placeholder="Optional"
                                    value="<?php echo htmlspecialchars($_POST['stage_name'] ?? ''); ?>"
                                >
                            </div>
                            <div class="form-tip">
                                <i class="ph-fill ph-star"></i>
                                If you perform under a stage name, add it here
                            </div>
                        </div>
                        
                        <div class="form-field">
                            <div class="form-group">
                                <label for="email" class="form-label">
                                    Email <span class="required">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    class="form-input" 
                                    required
                                    value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                                >
                            </div>
                            <div class="form-tip">
                                <i class="ph-fill ph-warning"></i>
                                <strong>Please double-check your email address!</strong> Mistyped emails mean we cannot reply to you.
                            </div>
                        </div>

                        <div class="form-field">
                            <div class="form-group">
                                <label for="device_info" class="form-label">
                                    Device & Phone Info
                                </label>
                                <input 
                                    type="text" 
                                    id="device_info" 
                                    name="device_info" 
                                    class="form-input"
                                    placeholder="e.g., PeekSmith 3 + iPhone 13 Pro, iOS 17.4"
                                    value="<?php echo htmlspecialchars($_POST['device_info'] ?? ''); ?>"
                                >
                            </div>
                            <div class="form-tip">
                                <i class="ph-fill ph-devices"></i>
                                Include your device model and phone model with OS version
                            </div>
                        </div>

                        <div class="form-field">
                            <div class="form-group">
                                <label for="firmware_version" class="form-label">
                                    Firmware Version
                                </label>
                                <input 
                                    type="text" 
                                    id="firmware_version" 
                                    name="firmware_version" 
                                    class="form-input"
                                    placeholder="e.g., 1.4.2 - NOT 'latest'"
                                    value="<?php echo htmlspecialchars($_POST['firmware_version'] ?? ''); ?>"
                                >
                            </div>
                            <div class="form-tip">
                                <i class="ph-fill ph-chip"></i>
                                <strong>Important:</strong> Write the exact version number, not "latest". Saying "latest" doesn't help us - you might think you have the latest but don't.
                            </div>
                        </div>

                        <div class="form-field">
                            <div class="form-group">
                                <label for="app_version" class="form-label">
                                    App Version
                                </label>
                                <input 
                                    type="text" 
                                    id="app_version" 
                                    name="app_version" 
                                    class="form-input"
                                    placeholder="e.g., 2.1.5 - NOT 'latest'"
                                    value="<?php echo htmlspecialchars($_POST['app_version'] ?? ''); ?>"
                                >
                            </div>
                            <div class="form-tip">
                                <i class="ph-fill ph-app-window"></i>
                                <strong>Important:</strong> Check your app's "About" or "Settings" for the exact version number
                            </div>
                        </div>
                        
                        <div class="form-field">
                            <div class="form-group">
                                <label for="message" class="form-label">
                                    Describe Your Issue <span class="required">*</span>
                                </label>
                                <textarea 
                                    id="message" 
                                    name="message" 
                                    class="form-textarea" 
                                    rows="10" 
                                    required
                                    placeholder="Please be as detailed as possible..."
                                ><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                            </div>
                            <div class="form-tip form-tip-detailed">
                                <i class="ph-fill ph-check-circle"></i>
                                <div>
                                    <strong>To help us solve your problem quickly, include:</strong>
                                    <ul>
                                        <li>A clear description of what happens vs. what you expected</li>
                                        <li>Steps to reproduce the issue</li>
                                        <li>What you've already tried (rebooting, updating, etc.)</li>
                                        <li>Screenshots or error messages</li>
                                        <li>For video issues: Upload a video to YouTube/Dropbox and share the link</li>
                                    </ul>
                                    <p style="margin-top: 8px; font-style: italic;">
                                        ❌ Bad: "It's not working"<br>
                                        ✅ Good: "PeekSmith 3 won't connect to my iPhone 13. Bluetooth is on, device shows in app but connection fails. Tried restarting both devices."
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-large">
                            <i class="ph-fill ph-paper-plane-tilt"></i>
                            Send Message
                        </button>
                    </form>
                <?php endif; ?>
            </div>
            
            <!-- Contact Info Sidebar -->
            <div class="contact-sidebar">
                <div class="contact-info-card">
                    <div class="contact-info-icon">
                        <i class="ph-fill ph-envelope"></i>
                    </div>
                    <h3 class="contact-info-title">Email Support</h3>
                    <p class="contact-info-text">
                        <a href="mailto:support@electricks.info">support@electricks.info</a>
                    </p>
                    <p class="contact-info-description">Hardware, firmware, or order-related issues</p>
                </div>
                
                <div class="contact-info-card">
                    <div class="contact-info-icon">
                        <i class="ph-fill ph-messenger-logo"></i>
                    </div>
                    <h3 class="contact-info-title">Facebook Messenger</h3>
                    <p class="contact-info-text">
                        <a href="https://m.me/electricks.magic" target="_blank">m.me/electricks.magic</a>
                    </p>
                    <p class="contact-info-description">Quick responses via Messenger</p>
                </div>
                
                <div class="contact-info-card">
                    <div class="contact-info-icon">
                        <i class="ph-fill ph-device-mobile"></i>
                    </div>
                    <h3 class="contact-info-title">App Support</h3>
                    <p class="contact-info-text">
                        For app-related issues, contact <strong>Benke Smith</strong>
                    </p>
                    <p class="contact-info-description">
                        <a href="mailto:benke.smith@gmail.com">benke.smith@gmail.com</a><br>
                        <a href="https://m.me/benke.smith" target="_blank">m.me/benke.smith</a>
                    </p>
                </div>
                
                <div class="contact-info-card">
                    <div class="contact-info-icon">
                        <i class="ph-fill ph-users-three"></i>
                    </div>
                    <h3 class="contact-info-title">Join Our Communities</h3>
                    <p class="contact-info-text">
                        Connect with thousands of like-minded magicians
                    </p>
                    <div style="margin-top: 12px;">
                        <p style="font-size: 0.875rem; color: var(--gray-700); margin-bottom: 8px;"><strong>Generic Groups:</strong></p>
                        <p style="font-size: 0.875rem; margin-bottom: 4px;">
                            <a href="https://www.facebook.com/groups/electricks" target="_blank" style="color: var(--primary-600);">Electricks</a> • 
                            <a href="https://www.facebook.com/groups/740424130239118" target="_blank" style="color: var(--primary-600);">Magic Apps by Benke</a>
                        </p>
                        
                        <p style="font-size: 0.875rem; color: var(--gray-700); margin: 12px 0 8px;"><strong>Product Groups:</strong></p>
                        <p style="font-size: 0.875rem; line-height: 1.6;">
                            <a href="https://www.facebook.com/groups/peeksmith/" target="_blank" style="color: var(--primary-600);">PeekSmith</a> • 
                            <a href="https://www.facebook.com/groups/timesmith" target="_blank" style="color: var(--primary-600);">SBWatch & TimeSmith</a> • 
                            <a href="https://www.facebook.com/groups/atomremote/" target="_blank" style="color: var(--primary-600);">Atom</a> • 
                            <a href="https://www.facebook.com/groups/magiscript/" target="_blank" style="color: var(--primary-600);">MagiScript</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Compact Hero for Subpages */
.hero-compact {
    position: relative;
    padding: 60px 0 50px;
    margin-top: 0;
    overflow: hidden;
}

.hero-compact canvas {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
}

.hero-compact .container {
    position: relative;
    z-index: 1;
}

.hero-title-compact {
    font-size: 2.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 12px;
    line-height: 1.1;
    text-align: center;
}

.hero-subtitle-compact {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.75);
    max-width: 600px;
    text-align: center;
    margin: 0 auto;
}

@media (max-width: 768px) {
    .hero-compact {
        padding: 50px 0 40px;
    }
    
    .hero-title-compact {
        font-size: 2rem;
    }
    
    .hero-subtitle-compact {
        font-size: 0.9rem;
    }
}

.contact-section {
    padding: 80px 0;
    background: white;
}

.contact-layout {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 80px;
    max-width: 1200px;
    margin: 0 auto;
}

.contact-form-container {
    background: white;
}

.glass-form {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(192, 132, 252, 0.2);
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
}

.contact-form {
    display: flex;
    flex-direction: column;
    gap: 32px;
}

.form-field {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
    flex: 1;
}

.form-tip {
    display: flex;
    gap: 10px;
    padding: 10px 14px;
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.8125rem;
    color: #6b7280;
    line-height: 1.5;
}

.form-tip i {
    color: #9ca3af;
    font-size: 16px;
    flex-shrink: 0;
    margin-top: 2px;
}

.form-tip strong {
    color: #111827;
}

.form-tip a {
    color: #9333ea;
    text-decoration: none;
}

.form-tip a:hover {
    text-decoration: underline;
}

.form-tip-detailed {
    background: #f9fafb;
    border-color: #e5e7eb;
    flex-direction: column;
}

.form-tip-detailed i {
    color: #9ca3af;
}

.form-tip-detailed ul {
    margin: 8px 0 0 20px;
    padding: 0;
}

.form-tip-detailed li {
    margin-bottom: 4px;
}

.form-label {
    font-size: 0.875rem;
    font-weight: 700;
    color: #111827;
}

.required {
    color: #ea580c;
}

.form-input,
.form-select,
.form-textarea {
    padding: 12px 16px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 1rem;
    font-family: inherit;
    transition: all 0.2s;
    background: white;
    color: #111827;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
}

.form-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23374151' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 20px;
    padding-right: 40px;
}

.form-input:hover,
.form-select:hover,
.form-textarea:hover {
    border-color: #9ca3af;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: #a855f7;
    box-shadow: 0 0 0 3px rgba(192, 132, 252, 0.15);
}

.form-textarea {
    resize: vertical;
    min-height: 150px;
}

.alert {
    padding: 20px;
    border-radius: 12px;
    display: flex;
    gap: 16px;
    margin-bottom: 24px;
}

.alert i {
    font-size: 24px;
    flex-shrink: 0;
}

.alert-success {
    background: #d1fae5;
    color: #14532d;
    border: 1px solid #86efac;
}

.alert-success i {
    color: #16a34a;
}

.alert-error {
    background: #fee2e2;
    color: #7f1d1d;
    border: 1px solid #fca5a5;
}

.alert-error i {
    color: #dc2626;
}

.alert strong {
    display: block;
    margin-bottom: 4px;
}

.alert p {
    margin: 0;
    font-size: 0.875rem;
}

.contact-sidebar {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.contact-info-card {
    background: #f9fafb;
    padding: 24px;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
}

.contact-info-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #c084fc 0%, #a855f7 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
}

.contact-info-icon i {
    font-size: 24px;
    color: white;
}

.contact-info-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 8px;
}

.contact-info-text {
    font-size: 0.9375rem;
    color: #374151;
    margin-bottom: 8px;
}

.contact-info-text a {
    color: #9333ea;
    text-decoration: none;
    font-weight: 600;
}

.contact-info-text a:hover {
    text-decoration: underline;
}

.contact-info-description {
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: 4px;
}

@media (max-width: 1024px) {
    .contact-layout {
        grid-template-columns: 1fr;
        gap: 48px;
    }
    
    .contact-sidebar {
        order: -1;
    }
}


</style>

<script>
// Static mesh gradient (no animation)
(function() {
    const canvas = document.getElementById('meshGradientCanvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d', { alpha: false });

    function resize() {
        const dpr = window.devicePixelRatio || 1;
        const rect = canvas.getBoundingClientRect();
        const width = rect.width;
        const height = rect.height;

        canvas.width = width * dpr;
        canvas.height = height * dpr;
        ctx.scale(dpr, dpr);

        // Draw static background
        ctx.fillStyle = '#2e1065';
        ctx.fillRect(0, 0, width, height);

        // Purple gradient colors (static positions)
        const colors = [
            { r: 46, g: 16, b: 101, x: 0.2, y: 0.3, radius: 0.6 },
            { r: 59, g: 26, b: 111, x: 0.8, y: 0.2, radius: 0.5 },
            { r: 139, g: 92, b: 246, x: 0.3, y: 0.7, radius: 0.7 },
            { r: 168, g: 85, b: 247, x: 0.7, y: 0.8, radius: 0.6 }
        ];

        // Draw gradient clouds
        colors.forEach(color => {
            const gradient = ctx.createRadialGradient(
                color.x * width, color.y * height, 0,
                color.x * width, color.y * height,
                color.radius * Math.max(width, height)
            );
            gradient.addColorStop(0, `rgba(${color.r}, ${color.g}, ${color.b}, 0.4)`);
            gradient.addColorStop(0.3, `rgba(${color.r}, ${color.g}, ${color.b}, 0.25)`);
            gradient.addColorStop(0.7, `rgba(${color.r}, ${color.g}, ${color.b}, 0.12)`);
            gradient.addColorStop(1, `rgba(${color.r}, ${color.g}, ${color.b}, 0)`);
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, width, height);
        });

        // Draw rotated grid
        ctx.save();
        ctx.translate(width / 2, height / 2);
        ctx.rotate(15 * Math.PI / 180);
        ctx.translate(-width / 2, -height / 2);

        ctx.strokeStyle = 'rgba(192, 132, 252, 0.18)';
        ctx.lineWidth = 1;

        const gridSpacing = 100;
        const extendedSize = Math.max(width, height) * 1.5;

        for (let x = -extendedSize; x < extendedSize; x += gridSpacing) {
            ctx.beginPath();
            ctx.moveTo(x, -extendedSize);
            ctx.lineTo(x, extendedSize);
            ctx.stroke();
        }

        for (let y = -extendedSize; y < extendedSize; y += gridSpacing) {
            ctx.beginPath();
            ctx.moveTo(-extendedSize, y);
            ctx.lineTo(extendedSize, y);
            ctx.stroke();
        }

        ctx.restore();
    }

    resize();
    window.addEventListener('resize', resize);
})();

function toggleOrderField() {
    const subjectSelect = document.getElementById('subject_category');
    const orderField = document.getElementById('orderField');
    const orderInput = document.getElementById('order_number');
    
    if (subjectSelect.value === 'order' || subjectSelect.value === 'shipping') {
        orderField.style.display = 'flex';
        orderInput.required = true;
    } else {
        orderField.style.display = 'none';
        orderInput.required = false;
    }
}

// Check on page load if form was submitted with errors
document.addEventListener('DOMContentLoaded', function() {
    toggleOrderField();
});
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
