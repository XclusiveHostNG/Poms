<?php
$config = require __DIR__ . '/../../config/config.php';
$baseUrl = $config['app']['base_url'];
?>
<aside class="admin-sidebar p-4">
    <div class="mb-4">
        <h2 class="h6 text-uppercase">Admin Menu</h2>
    </div>
    <nav>
        <a href="<?= $baseUrl; ?>admin" class="mb-2"><i class="fa-solid fa-chart-line me-2"></i>Dashboard</a>
        <a href="<?= $baseUrl; ?>admin/user/index" class="mb-2"><i class="fa-solid fa-users me-2"></i>User Management</a>
        <a href="<?= $baseUrl; ?>admin/aspirants/index" class="mb-2"><i class="fa-solid fa-user-tie me-2"></i>Aspirant Management</a>
        <a href="<?= $baseUrl; ?>admin/admins/index" class="mb-2"><i class="fa-solid fa-user-shield me-2"></i>Admin Management</a>
        <a href="<?= $baseUrl; ?>admin/whatsapp-groups/index" class="mb-2"><i class="fa-brands fa-whatsapp me-2"></i>WhatsApp Groups</a>
        <a href="<?= $baseUrl; ?>admin/events/index" class="mb-2"><i class="fa-solid fa-calendar-check me-2"></i>Event Management</a>
        <a href="<?= $baseUrl; ?>admin/campaigns/index" class="mb-2"><i class="fa-solid fa-bullhorn me-2"></i>Campaign Management</a>
        <a href="<?= $baseUrl; ?>admin/roles/index" class="mb-2"><i class="fa-solid fa-key me-2"></i>Roles &amp; Permissions</a>
        <a href="<?= $baseUrl; ?>admin/site-settings" class="mb-2"><i class="fa-solid fa-gear me-2"></i>Site Settings</a>
        <a href="<?= $baseUrl; ?>admin/gallery/index" class="mb-2"><i class="fa-solid fa-image me-2"></i>Gallery Management</a>
    </nav>
</aside>
