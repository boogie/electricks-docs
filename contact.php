<?php
require_once __DIR__ . '/config.php';

$pageTitle = 'Contact Support';
$currentPage = 'contact';

// Handle form submission
$success = false;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';
    $product = $_POST['product'] ?? '';
    $order_number = $_POST['order_number'] ?? '';
    
    // Validate
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
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
                        'body_text' => "Product: $product\nOrder Number: $order_number\n\n$message"
                    ]
                ],
                'subject' => $subject
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
            $email_body .= "Email: $email\n";
            $email_body .= "Product: $product\n";
            $email_body .= "Order Number: $order_number\n\n";
            $email_body .= "Subject: $subject\n\n";
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
                    
                    <form method="POST" class="contact-form" id="contactForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name" class="form-label">
                                    Name <span class="required">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    class="form-input" 
                                    required
                                    value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                                >
                            </div>
                            
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
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="product" class="form-label">
                                    Product
                                </label>
                                <select id="product" name="product" class="form-select">
                                    <option value="">Select a product</option>
                                    <option value="atom2">Atom 2</option>
                                    <option value="peeksmith3">PeekSmith 3</option>
                                    <option value="bond">Bond</option>
                                    <option value="sbwatch2">SB Watch 2</option>
                                    <option value="quantum">Quantum Calculator</option>
                                    <option value="teleport">Teleport</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="order_number" class="form-label">
                                    Order Number
                                </label>
                                <input 
                                    type="text" 
                                    id="order_number" 
                                    name="order_number" 
                                    class="form-input"
                                    placeholder="Optional"
                                    value="<?php echo htmlspecialchars($_POST['order_number'] ?? ''); ?>"
                                >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="subject" class="form-label">
                                Subject <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="subject" 
                                name="subject" 
                                class="form-input" 
                                required
                                value="<?php echo htmlspecialchars($_POST['subject'] ?? ''); ?>"
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="message" class="form-label">
                                Message <span class="required">*</span>
                            </label>
                            <textarea 
                                id="message" 
                                name="message" 
                                class="form-textarea" 
                                rows="8" 
                                required
                            ><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
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
    margin-top: 60px;
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

.contact-form {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-900);
}

.required {
    color: var(--orange-600);
}

.form-input,
.form-select,
.form-textarea {
    padding: 12px 16px;
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    font-size: 1rem;
    font-family: inherit;
    transition: all 0.2s;
    background: white;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: var(--primary-500);
    box-shadow: 0 0 0 4px rgba(0, 122, 255, 0.1);
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
    background: var(--green-50);
    color: var(--green-900);
    border: 1px solid var(--green-200);
}

.alert-success i {
    color: var(--green-600);
}

.alert-error {
    background: var(--red-50);
    color: var(--red-900);
    border: 1px solid var(--red-200);
}

.alert-error i {
    color: var(--red-600);
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
    gap: 24px;
}

.contact-info-card {
    background: var(--gray-50);
    padding: 32px;
    border-radius: 16px;
    border: 1px solid var(--gray-200);
}

.contact-info-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--primary-500) 0%, var(--primary-600) 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
}

.contact-info-icon i {
    font-size: 24px;
    color: white;
}

.contact-info-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 8px;
}

.contact-info-text {
    font-size: 1rem;
    color: var(--gray-700);
    margin-bottom: 8px;
}

.contact-info-text a {
    color: var(--primary-600);
    text-decoration: none;
    font-weight: 600;
}

.contact-info-text a:hover {
    text-decoration: underline;
}

.contact-info-description {
    font-size: 0.875rem;
    color: var(--gray-600);
    margin-top: 8px;
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

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>

<script src="/assets/js/mesh-gradient.js"></script>

<?php include __DIR__ . '/includes/footer.php'; ?>
