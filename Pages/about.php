<?php
require_once __DIR__ . '/../config/config.php';
$settings = getSiteSettings($pdo);
include __DIR__ . '/../Includes/Header.php';
?>
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <h1 class="section-title">About Us</h1>
                <p class="lead">The Political Organisation Management System (POMS) is designed to empower democratic participation through data-driven mobilisation and inclusive community building.</p>
                <p>We provide a unified platform that helps political organisations onboard supporters, manage aspirants, run campaigns, and coordinate events with ease. Our technology supports transparency, accountability, and timely communication across all levels of political engagement.</p>
                <p>With POMS, members can stay informed about party activities, engage in training, and volunteer their skills where they are most needed. Aspirants can launch their campaigns, manage supporters, and track compliance requirements. Administrators gain full visibility into the organisation&apos;s performance.</p>
            </div>
            <div class="col-lg-4">
                <?php include __DIR__ . '/../Includes/Sidebar.php'; ?>
            </div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../Includes/Footer.php'; ?>
