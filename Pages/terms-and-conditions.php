<?php
require_once __DIR__ . '/../config/config.php';
$settings = getSiteSettings($pdo);
include __DIR__ . '/../Includes/Header.php';
?>
<section class="py-5">
    <div class="container">
        <h1 class="section-title">Terms and Conditions</h1>
        <p>By accessing and using the Political Organisation Management System (POMS), you agree to comply with the terms below. These terms ensure that the platform remains secure, reliable, and respectful for all members, aspirants, and administrators.</p>
        <h5 class="mt-4">Use of the Platform</h5>
        <p>POMS is provided for the management of political organisation activities. Users must provide accurate information during registration and agree not to misuse the platform for fraudulent or malicious activities.</p>
        <h5 class="mt-4">Data Protection</h5>
        <p>We value your privacy and process personal data according to applicable laws. Sensitive information such as BVN, NIN, and identification numbers are encrypted and protected.</p>
        <h5 class="mt-4">Compliance</h5>
        <p>Members and aspirants must comply with party regulations, electoral guidelines, and national laws. POMS reserves the right to suspend or terminate accounts that violate these rules.</p>
        <p class="mt-4">For full details or inquiries, please contact our legal team via <?= htmlspecialchars($settings['support_email'] ?? 'support@poms.org', ENT_QUOTES); ?>.</p>
    </div>
</section>
<?php include __DIR__ . '/../Includes/Footer.php'; ?>
