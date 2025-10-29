<?php
session_start();
require_once __DIR__ . '/../config/Database.php';

$pageTitle = 'Aspirant Dashboard';
$database = Database::getInstance();
$connection = $database->getConnection();

$aspirantId = $_SESSION['account_id'] ?? 0;
$aspirant = [];
if ($aspirantId) {
    $stmt = $connection->prepare('SELECT * FROM aspirants WHERE id = ?');
    $stmt->execute([$aspirantId]);
    $aspirant = $stmt->fetch();
}

$eventsStmt = $connection->prepare('SELECT id, title, start_date FROM events WHERE created_by_type = "aspirant" AND created_by_id = ? ORDER BY start_date DESC LIMIT 5');
$eventsStmt->execute([$aspirantId]);
$events = $eventsStmt->fetchAll();

$campaignsStmt = $connection->prepare('SELECT id, title, status, amount_raised, target_amount FROM campaigns WHERE aspirant_id = ? ORDER BY created_at DESC LIMIT 5');
$campaignsStmt->execute([$aspirantId]);
$campaigns = $campaignsStmt->fetchAll();

require __DIR__ . '/includes/header.php';
?>
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Welcome<?= $aspirant ? ' ' . htmlspecialchars($aspirant['first_name']) : ''; ?>!</h5>
                <p class="small text-muted">Manage your campaigns, events, and community outreach from one unified workspace.</p>
                <div class="d-flex gap-2">
                    <a class="btn btn-primary btn-sm" href="<?= $baseUrl; ?>aspirant/events/create"><i class="fa-solid fa-calendar-plus me-1"></i>Create Event</a>
                    <a class="btn btn-outline-success btn-sm" href="<?= $baseUrl; ?>aspirant/campaigns/create"><i class="fa-solid fa-bullhorn me-1"></i>Launch Campaign</a>
                </div>
            </div>
        </div>
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-transparent border-bottom-0">
                <h5 class="mb-0"><i class="fa-solid fa-calendar-days me-2 text-primary"></i>Your Recent Events</h5>
            </div>
            <div class="card-body">
                <?php if ($events): ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($events as $event): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><?= htmlspecialchars($event['title']); ?></span>
                                <span class="badge bg-light text-dark border"><i class="fa-solid fa-clock me-1"></i><?= date('d M, g:ia', strtotime($event['start_date'])); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted mb-0">No events created yet. Start by creating your first event.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom-0">
                <h5 class="mb-0"><i class="fa-solid fa-bullhorn me-2 text-success"></i>Campaign Overview</h5>
            </div>
            <div class="card-body">
                <?php if ($campaigns): ?>
                    <?php foreach ($campaigns as $campaign): ?>
                        <div class="mb-3">
                            <h6 class="mb-1 text-primary"><?= htmlspecialchars($campaign['title']); ?></h6>
                            <p class="small text-muted mb-1">Status: <span class="badge bg-secondary status-badge text-uppercase"><?= htmlspecialchars($campaign['status']); ?></span></p>
                            <div class="progress" style="height: 6px;">
                                <?php
                                $progress = 0;
                                if (!empty($campaign['target_amount'])) {
                                    $progress = min(100, ($campaign['amount_raised'] / $campaign['target_amount']) * 100);
                                }
                                ?>
                                <div class="progress-bar" role="progressbar" style="width: <?= number_format($progress, 2); ?>%;"></div>
                            </div>
                            <p class="small text-muted mt-1">Raised ₦<?= number_format((float)$campaign['amount_raised'], 2); ?> of ₦<?= number_format((float)($campaign['target_amount'] ?? 0), 2); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted mb-0">You have not launched any campaigns yet.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body">
                <h5 class="card-title">WhatsApp Group</h5>
                <?php
                $whatsappStmt = $connection->prepare('SELECT link, description FROM whatsapp_groups WHERE state = ? LIMIT 1');
                $whatsappStmt->execute([$aspirant['state'] ?? '']);
                $group = $whatsappStmt->fetch();
                if ($group):
                ?>
                    <p class="small mb-3"><?= htmlspecialchars($group['description'] ?? 'Coordinate with campaign volunteers.'); ?></p>
                    <a class="btn btn-success w-100" href="<?= htmlspecialchars($group['link']); ?>" target="_blank"><i class="fa-brands fa-whatsapp me-2"></i>Join Group</a>
                <?php else: ?>
                    <p class="small text-muted mb-0">WhatsApp link for your region will appear once assigned.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
