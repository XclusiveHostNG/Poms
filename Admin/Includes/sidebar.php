<nav class="col-md-3 col-lg-2 d-md-block admin-sidebar sidebar collapse">
    <div class="position-sticky pt-3">
        <div class="px-3 mb-4">
            <h5 class="mb-0 text-uppercase">Admin Panel</h5>
            <small><?= htmlspecialchars($settings['site_title'] ?? 'POMS', ENT_QUOTES); ?></small>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="/Admin"><i class="fa-solid fa-gauge me-2"></i>Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="/Admin/Kyc/index"><i class="fa-solid fa-id-card me-2"></i>KYC Management</a></li>
            <li class="nav-item"><a class="nav-link" href="/Admin/User/index"><i class="fa-solid fa-users me-2"></i>User Management</a></li>
            <li class="nav-item"><a class="nav-link" href="/Admin/Aspirants/index"><i class="fa-solid fa-user-tie me-2"></i>Aspirant Management</a></li>
            <li class="nav-item"><a class="nav-link" href="/Admin/Event/index"><i class="fa-solid fa-calendar-days me-2"></i>Event Management</a></li>
            <li class="nav-item"><a class="nav-link" href="/Admin/Campaign/index"><i class="fa-solid fa-bullhorn me-2"></i>Campaigns</a></li>
            <li class="nav-item"><a class="nav-link" href="/Admin/Role/index"><i class="fa-solid fa-user-shield me-2"></i>Roles &amp; Permissions</a></li>
            <li class="nav-item"><a class="nav-link" href="/Admin/Whatsapp%20Groups/index"><i class="fa-brands fa-whatsapp me-2"></i>WhatsApp Groups</a></li>
            <li class="nav-item"><a class="nav-link" href="/Admin/Gallery/index"><i class="fa-solid fa-image me-2"></i>Gallery Management</a></li>
            <li class="nav-item"><a class="nav-link" href="/Admin/Settings/index"><i class="fa-solid fa-gear me-2"></i>Site Settings</a></li>
        </ul>
    </div>
</nav>
