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
                    <h1 class="h3">Aspirant Dashboard</h1>
                    <p class="text-muted mb-0">Manage your campaign, events, and compliance requirements.</p>
                </div>
                <a href="/Aspirant/profile" class="btn btn-outline-primary"><i class="fa-solid fa-user-tie me-2"></i>View Profile</a>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-xl-4">
                    <div class="card dashboard-card p-4">
                        <h6 class="text-muted text-uppercase">Campaigns</h6>
                        <p class="mb-2">Create and manage your political campaigns.</p>
                        <a class="btn btn-sm btn-primary" href="/Aspirant/campaigns">Manage Campaigns</a>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card dashboard-card p-4">
                        <h6 class="text-muted text-uppercase">Events</h6>
                        <p class="mb-2">Organise town halls, rallies, and meetings.</p>
                        <a class="btn btn-sm btn-outline-primary" href="/Aspirant/events">Manage Events</a>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card dashboard-card p-4">
                        <h6 class="text-muted text-uppercase">Donations</h6>
                        <p class="mb-2">Track contributions and fundraising goals.</p>
                        <a class="btn btn-sm btn-success" href="/Aspirant/donations">View Donations</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?php include __DIR__ . '/Includes/footer.php'; ?>
