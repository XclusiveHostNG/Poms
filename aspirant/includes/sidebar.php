<?php
$config = require __DIR__ . '/../../config/config.php';
$baseUrl = $config['app']['base_url'];
?>
<nav class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-white border-end min-vh-100 shadow-sm">
    <div class="d-flex flex-column align-items-start px-3 pt-3 gap-2">
        <a href="<?= $baseUrl; ?>aspirant" class="btn btn-link text-start"><i class="fa-solid fa-chart-pie me-2"></i>Dashboard</a>
        <a href="<?= $baseUrl; ?>aspirant/profile" class="btn btn-link text-start"><i class="fa-solid fa-user me-2"></i>Profile</a>
        <a href="<?= $baseUrl; ?>aspirant/kyc" class="btn btn-link text-start"><i class="fa-solid fa-id-card me-2"></i>KYC Verification</a>
        <a href="<?= $baseUrl; ?>aspirant/id-card" class="btn btn-link text-start"><i class="fa-solid fa-passport me-2"></i>View ID Card</a>
        <a href="<?= $baseUrl; ?>aspirant/events" class="btn btn-link text-start"><i class="fa-solid fa-calendar-plus me-2"></i>Manage Events</a>
        <a href="<?= $baseUrl; ?>aspirant/campaigns" class="btn btn-link text-start"><i class="fa-solid fa-bullhorn me-2"></i>Campaigns</a>
        <a href="<?= $baseUrl; ?>aspirant/donations" class="btn btn-link text-start"><i class="fa-solid fa-hand-holding-dollar me-2"></i>Donations</a>
    </div>
</nav>
