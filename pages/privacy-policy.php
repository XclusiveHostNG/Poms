<?php
require_once __DIR__ . '/../config/Database.php';

$pageTitle = 'Privacy Policy';
$database = Database::getInstance();
$siteSettings = $database->fetchSiteSettings();

require __DIR__ . '/../includes/header.php';
?>
<section class="py-5">
    <div class="container">
        <h1 class="section-title">Privacy Policy</h1>
        <p class="small text-muted">Your privacy matters to us.</p>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5>Information We Collect</h5>
                <p>We collect personal data required for membership and aspirant onboarding including contact details, demographic information, identification numbers, and uploaded documents for KYC verification.</p>

                <h5>How We Use Information</h5>
                <p>Information is used to manage membership records, process KYC requests, coordinate events, manage campaigns, and facilitate secure communication across regions.</p>

                <h5>Data Security</h5>
                <p>We implement technical and organisational measures to safeguard your data. Access is restricted to authorised administrators.</p>

                <h5>Your Rights</h5>
                <p>You may request updates or removal of your personal data subject to legal and organisational obligations.</p>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
