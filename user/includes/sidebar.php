<?php
$config = require __DIR__ . '/../../config/config.php';
$baseUrl = $config['app']['base_url'];
?>
<nav class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-white border-end min-vh-100 shadow-sm">
    <div class="d-flex flex-column align-items-start px-3 pt-3 gap-2">
        <a href="<?= $baseUrl; ?>user" class="btn btn-link text-start"><i class="fa-solid fa-chart-line me-2"></i>Dashboard</a>
        <a href="<?= $baseUrl; ?>user/profile" class="btn btn-link text-start"><i class="fa-solid fa-user me-2"></i>Profile</a>
        <a href="<?= $baseUrl; ?>user/kyc" class="btn btn-link text-start"><i class="fa-solid fa-id-card me-2"></i>KYC Verification</a>
        <a href="<?= $baseUrl; ?>user/id-card" class="btn btn-link text-start"><i class="fa-solid fa-passport me-2"></i>Membership ID</a>
        <a href="<?= $baseUrl; ?>user/events" class="btn btn-link text-start"><i class="fa-solid fa-calendar-check me-2"></i>Events</a>
        <a href="<?= $baseUrl; ?>user/whatsapp" class="btn btn-link text-start"><i class="fa-brands fa-whatsapp me-2"></i>WhatsApp Groups</a>
        <a href="<?= $baseUrl; ?>user/support" class="btn btn-link text-start"><i class="fa-solid fa-life-ring me-2"></i>Support</a>
    </div>
</nav>
