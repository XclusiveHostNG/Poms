<?php
require_once __DIR__ . '/../config/config.php';
include __DIR__ . '/Includes/header.php';
?>
<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/Includes/sidebar.php'; ?>
        <main class="col-lg-9 ms-auto px-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3">Member Dashboard</h1>
                    <p class="text-muted mb-0">Complete your onboarding and stay updated with events and announcements.</p>
                </div>
                <a href="/User/profile" class="btn btn-outline-primary"><i class="fa-solid fa-id-badge me-2"></i>View Profile</a>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-xl-4">
                    <div class="card dashboard-card p-4">
                        <h6 class="text-muted text-uppercase">Onboarding Status</h6>
                        <p class="mb-2">Track your onboarding steps and document submissions.</p>
                        <a class="btn btn-sm btn-primary" href="/User/onboarding">Continue Onboarding</a>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card dashboard-card p-4">
                        <h6 class="text-muted text-uppercase">WhatsApp Group</h6>
                        <p class="mb-2">Join the community WhatsApp group for your region.</p>
                        <a class="btn btn-sm btn-success" href="/User/whatsapp">View Group Link</a>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card dashboard-card p-4">
                        <h6 class="text-muted text-uppercase">Events</h6>
                        <p class="mb-2">Discover upcoming events and mobilisations near you.</p>
                        <a class="btn btn-sm btn-outline-primary" href="/User/events">View Events</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?php include __DIR__ . '/Includes/footer.php'; ?>
