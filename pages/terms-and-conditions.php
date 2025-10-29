<?php
require_once __DIR__ . '/../config/Database.php';

$pageTitle = 'Terms and Conditions';
$database = Database::getInstance();
$siteSettings = $database->fetchSiteSettings();

require __DIR__ . '/../includes/header.php';
?>
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="section-title">Terms &amp; Conditions</h1>
        <p class="small text-muted">Last updated: <?= date('d F Y'); ?></p>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5>1. Acceptance of Terms</h5>
                <p>By accessing and using this platform, you agree to comply with these terms and conditions as well as any policies referenced herein.</p>

                <h5>2. Eligibility</h5>
                <p>Members and aspirants must provide accurate information during registration and onboarding. Administrators reserve the right to validate details and revoke access for non-compliance.</p>

                <h5>3. Data Protection</h5>
                <p>Your personal information is used strictly for political organisation management purposes and will be processed in line with our privacy policy and applicable regulations.</p>

                <h5>4. Platform Usage</h5>
                <p>Users shall not misuse dashboards, campaign tools, or communication channels. Any fraudulent activity may result in suspension.</p>

                <h5>5. Updates</h5>
                <p>We may update these terms periodically. Continued use of the platform indicates acceptance of the revised terms.</p>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
