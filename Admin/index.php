<?php
require_once __DIR__ . '/../config/config.php';
$settings = getSiteSettings($pdo);
include __DIR__ . '/Includes/header.php';
?>
<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/Includes/sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Admin Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="/Admin/User/index" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-users me-2"></i>Manage Users</a>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card dashboard-card p-4">
                        <div class="d-flex align-items-center">
                            <div class="timeline-icon"><i class="fa-solid fa-users"></i></div>
                            <div>
                                <h6 class="text-uppercase text-muted mb-1">Registered Members</h6>
                                <h3 class="mb-0"><?= number_format((int)($settings['stats_members'] ?? 0)); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card dashboard-card p-4">
                        <div class="d-flex align-items-center">
                            <div class="timeline-icon bg-success"><i class="fa-solid fa-user-tie"></i></div>
                            <div>
                                <h6 class="text-uppercase text-muted mb-1">Aspirants</h6>
                                <h3 class="mb-0"><?= number_format((int)($settings['stats_aspirants'] ?? 0)); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card dashboard-card p-4">
                        <div class="d-flex align-items-center">
                            <div class="timeline-icon bg-warning"><i class="fa-solid fa-calendar-check"></i></div>
                            <div>
                                <h6 class="text-uppercase text-muted mb-1">Upcoming Events</h6>
                                <h3 class="mb-0"><?= number_format((int)($settings['stats_events'] ?? 0)); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?php include __DIR__ . '/Includes/footer.php'; ?>
