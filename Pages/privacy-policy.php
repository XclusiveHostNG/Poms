<?php
require_once __DIR__ . '/../config/config.php';
$settings = getSiteSettings($pdo);
include __DIR__ . '/../Includes/Header.php';
?>
<section class="py-5">
    <div class="container">
        <h1 class="section-title">Privacy Policy</h1>
        <p>This privacy policy explains how the Political Organisation Management System (POMS) collects, uses, and safeguards personal data.</p>
        <h5 class="mt-4">Information We Collect</h5>
        <p>We collect personal data such as contact details, demographic information, identification numbers, and participation preferences to fulfil our organisational responsibilities.</p>
        <h5 class="mt-4">How We Use Information</h5>
        <p>Information is used to manage membership, verify eligibility, process KYC requests, facilitate event participation, and maintain a secure platform.</p>
        <h5 class="mt-4">Data Security</h5>
        <p>We implement strict access controls, encryption, and monitoring to protect your data. Only authorised personnel can view sensitive records.</p>
        <p class="mt-4">If you have any privacy questions, contact <?= htmlspecialchars($settings['support_email'] ?? 'support@poms.org', ENT_QUOTES); ?>.</p>
    </div>
</section>
<?php include __DIR__ . '/../Includes/Footer.php'; ?>
