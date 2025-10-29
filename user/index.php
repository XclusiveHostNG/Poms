<?php
session_start();
require_once __DIR__ . '/../config/Database.php';

$pageTitle = 'Member Dashboard';
$database = Database::getInstance();
$connection = $database->getConnection();

$userId = $_SESSION['account_id'] ?? 0;
$user = [];
if ($userId) {
    $stmt = $connection->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$userId]);
    $user = $stmt->fetch();
}

$eventsStmt = $connection->prepare('SELECT title, start_date, venue FROM events WHERE is_active = 1 ORDER BY start_date ASC LIMIT 5');
$eventsStmt->execute();
$events = $eventsStmt->fetchAll();

require __DIR__ . '/includes/header.php';
?>
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Welcome back<?= $user ? ', ' . htmlspecialchars($user['first_name']) : ''; ?>!</h5>
                <p class="small text-muted">Keep your onboarding progress up to date to access exclusive resources.</p>
                <div class="progress mb-3" style="height: 8px;">
                    <?php
                    $completion = 0;
                    if ($user) {
                        $completion = $user['onboarding_completed'] ? 100 : 60;
                        if ($user['kyc_status'] === 'approved') {
                            $completion = max($completion, 80);
                        }
                    }
                    ?>
                    <div class="progress-bar" role="progressbar" style="width: <?= $completion; ?>%;" aria-valuenow="<?= $completion; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="d-flex gap-2">
                    <a class="btn btn-primary btn-sm" href="<?= $baseUrl; ?>user/profile"><i class="fa-solid fa-pen-to-square me-1"></i>Update Profile</a>
                    <a class="btn btn-outline-success btn-sm" href="<?= $baseUrl; ?>user/kyc"><i class="fa-solid fa-shield-halved me-1"></i>Complete KYC</a>
                </div>
            </div>
        </div>
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-transparent border-bottom-0">
                <h5 class="mb-0"><i class="fa-solid fa-calendar-days me-2 text-primary"></i>Your Events</h5>
            </div>
            <div class="card-body">
                <?php if ($events): ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($events as $event): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 text-primary"><?= htmlspecialchars($event['title']); ?></h6>
                                    <p class="small text-muted mb-0"><i class="fa-solid fa-location-dot me-1"></i><?= htmlspecialchars($event['venue'] ?? 'Venue TBA'); ?></p>
                                </div>
                                <span class="badge bg-light text-dark border"><i class="fa-solid fa-clock me-1"></i><?= date('d M, g:ia', strtotime($event['start_date'])); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted mb-0">No events available for your region yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">WhatsApp Group</h5>
                <?php
                $whatsappStmt = $connection->prepare('SELECT link, description FROM whatsapp_groups WHERE state = ? LIMIT 1');
                $whatsappStmt->execute([$user['state'] ?? '']);
                $group = $whatsappStmt->fetch();
                if ($group):
                ?>
                    <p class="small mb-3"><?= htmlspecialchars($group['description'] ?? 'Join your regional community.'); ?></p>
                    <a class="btn btn-success w-100" href="<?= htmlspecialchars($group['link']); ?>" target="_blank"><i class="fa-brands fa-whatsapp me-2"></i>Join Group</a>
                <?php else: ?>
                    <p class="small text-muted mb-0">WhatsApp link for your region will be available after onboarding.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body">
                <h5 class="card-title">Membership ID</h5>
                <?php if (!empty($user['unique_identification_number'])): ?>
                    <p class="display-6 fw-bold text-primary"><?= htmlspecialchars($user['unique_identification_number']); ?></p>
                    <p class="small text-muted">Keep this ID safe. You can download your card from the ID section.</p>
                <?php else: ?>
                    <p class="small text-muted">Complete your onboarding to receive a unique identification number.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
