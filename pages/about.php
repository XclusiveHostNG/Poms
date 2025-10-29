<?php
require_once __DIR__ . '/../config/Database.php';

$pageTitle = 'About Us';
$database = Database::getInstance();
$siteSettings = $database->fetchSiteSettings();

require __DIR__ . '/../includes/header.php';
?>
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="section-title">About <?= htmlspecialchars($siteSettings['site_name'] ?? 'POMS'); ?></h1>
        <p class="lead">Empowering democratic participation through innovative political organization management.</p>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Our Mission</h5>
                        <p class="card-text">To provide a modern digital infrastructure that supports political organisations in coordinating members, aspirants, and administrators with transparency and accountability.</p>
                        <p class="card-text">We enable seamless onboarding, verification, campaign coordination, and community engagement through regional collaboration hubs.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Our Vision</h5>
                        <p class="card-text">To build a stronger, more engaged democratic community where every member has a voice and aspirants can manage grassroots mobilization effectively.</p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Digital-first membership and aspirant management.</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Transparent KYC and identity verification.</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Integrated events and campaign tools.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
