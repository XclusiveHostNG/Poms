<?php
require_once __DIR__ . '/../config/Database.php';

$pageTitle = 'Contact Us';
$database = Database::getInstance();
$siteSettings = $database->fetchSiteSettings();

require __DIR__ . '/../includes/header.php';
?>
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <h1 class="section-title">Get in Touch</h1>
                <p class="lead">Have questions or need support? Fill the form and our team will respond promptly.</p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fa-solid fa-envelope me-2"></i><?= htmlspecialchars($siteSettings['support_email'] ?? 'support@poms.org'); ?></li>
                    <li class="mb-2"><i class="fa-solid fa-phone me-2"></i><?= htmlspecialchars($siteSettings['support_phone'] ?? '+234-000-0000'); ?></li>
                    <?php if (!empty($siteSettings['address'])): ?>
                        <li class="mb-2"><i class="fa-solid fa-location-dot me-2"></i><?= nl2br(htmlspecialchars($siteSettings['address'])); ?></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Send a Message</h5>
                        <form method="post" action="<?= $baseUrl; ?>pages/contact">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="contactName" class="form-label">Full Name</label>
                                    <input type="text" id="contactName" name="full_name" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="contactEmail" class="form-label">Email</label>
                                    <input type="email" id="contactEmail" name="email" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <label for="contactPhone" class="form-label">Phone</label>
                                    <input type="tel" id="contactPhone" name="phone" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label for="contactSubject" class="form-label">Subject</label>
                                    <input type="text" id="contactSubject" name="subject" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label for="contactMessage" class="form-label">Message</label>
                                    <textarea id="contactMessage" name="message" rows="5" class="form-control" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-paper-plane me-2"></i>Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
