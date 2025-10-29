<?php
require_once __DIR__ . '/../config/config.php';
$settings = getSiteSettings($pdo);
include __DIR__ . '/../Includes/Header.php';
?>
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <h1 class="section-title">Contact Us</h1>
                <p class="lead">Have questions or need assistance? Reach out to the POMS support team and we&apos;ll respond promptly.</p>
                <ul class="list-unstyled">
                    <li class="mb-3"><i class="fa-solid fa-location-dot me-2 text-primary"></i><?= htmlspecialchars($settings['office_address'] ?? '12 Unity Avenue, Abuja, Nigeria', ENT_QUOTES); ?></li>
                    <li class="mb-3"><i class="fa-solid fa-phone me-2 text-primary"></i><?= htmlspecialchars($settings['support_phone'] ?? '+234 800 000 0000', ENT_QUOTES); ?></li>
                    <li class="mb-3"><i class="fa-solid fa-envelope me-2 text-primary"></i><?= htmlspecialchars($settings['support_email'] ?? 'support@poms.org', ENT_QUOTES); ?></li>
                </ul>
            </div>
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" placeholder="Enter your full name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="Enter your email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Message</label>
                                <textarea class="form-control" rows="4" placeholder="How can we help you?" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../Includes/Footer.php'; ?>
