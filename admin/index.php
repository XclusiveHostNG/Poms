<?php
session_start();
require_once __DIR__ . '/../config/Database.php';

$pageTitle = 'Dashboard';
$database = Database::getInstance();
$connection = $database->getConnection();

$stats = [
    'users' => (int)$connection->query('SELECT COUNT(*) FROM users')->fetchColumn(),
    'aspirants' => (int)$connection->query('SELECT COUNT(*) FROM aspirants')->fetchColumn(),
    'events' => (int)$connection->query('SELECT COUNT(*) FROM events')->fetchColumn(),
    'campaigns' => (int)$connection->query('SELECT COUNT(*) FROM campaigns')->fetchColumn(),
];

require __DIR__ . '/includes/header.php';
?>
<div class="row g-4">
    <div class="col-md-3">
        <div class="card dashboard-card border-0">
            <div class="card-body">
                <h6 class="text-muted text-uppercase">Members</h6>
                <h2 class="fw-bold mb-0"><?= number_format($stats['users']); ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card dashboard-card border-0">
            <div class="card-body">
                <h6 class="text-muted text-uppercase">Aspirants</h6>
                <h2 class="fw-bold mb-0"><?= number_format($stats['aspirants']); ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card dashboard-card border-0">
            <div class="card-body">
                <h6 class="text-muted text-uppercase">Events</h6>
                <h2 class="fw-bold mb-0"><?= number_format($stats['events']); ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card dashboard-card border-0">
            <div class="card-body">
                <h6 class="text-muted text-uppercase">Campaigns</h6>
                <h2 class="fw-bold mb-0"><?= number_format($stats['campaigns']); ?></h2>
            </div>
        </div>
    </div>
</div>
<div class="row g-4 mt-1">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-bottom-0">
                <h5 class="mb-0"><i class="fa-solid fa-id-card me-2 text-primary"></i>Pending KYC Requests</h5>
            </div>
            <div class="card-body">
                <?php
                $kycStmt = $connection->query("SELECT owner_type, COUNT(*) as total FROM kyc_documents WHERE status = 'pending' GROUP BY owner_type");
                $kycData = $kycStmt->fetchAll();
                if ($kycData):
                ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($kycData as $row): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="text-capitalize"><?= htmlspecialchars($row['owner_type']); ?></span>
                                <span class="badge bg-warning text-dark rounded-pill"><?= $row['total']; ?> pending</span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted mb-0">No pending KYC submissions.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-bottom-0">
                <h5 class="mb-0"><i class="fa-solid fa-calendar-days me-2 text-success"></i>Upcoming Events</h5>
            </div>
            <div class="card-body">
                <?php
                $eventStmt = $connection->prepare('SELECT title, start_date, state FROM events WHERE start_date >= NOW() ORDER BY start_date ASC LIMIT 5');
                $eventStmt->execute();
                $events = $eventStmt->fetchAll();
                if ($events):
                ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($events as $event): ?>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1 text-primary"><?= htmlspecialchars($event['title']); ?></h6>
                                        <p class="small text-muted mb-0"><i class="fa-solid fa-location-dot me-1"></i><?= htmlspecialchars($event['state'] ?? 'N/A'); ?></p>
                                    </div>
                                    <span class="badge bg-light text-dark border"><i class="fa-solid fa-clock me-1"></i><?= date('d M, g:ia', strtotime($event['start_date'])); ?></span>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted mb-0">No upcoming events scheduled.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
