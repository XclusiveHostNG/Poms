<?php
require_once __DIR__ . '/../config/Database.php';

$pageTitle = 'Events';
$database = Database::getInstance();
$siteSettings = $database->fetchSiteSettings();

$statement = $database->getConnection()->prepare('SELECT title, description, venue, state, start_date, end_date FROM events WHERE is_active = 1 ORDER BY start_date ASC');
$statement->execute();
$events = $statement->fetchAll();

require __DIR__ . '/../includes/header.php';
?>
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="section-title">Events &amp; Mobilisations</h1>
        <div class="row g-4">
            <?php if (!empty($events)): ?>
                <?php foreach ($events as $event): ?>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><?= htmlspecialchars($event['title']); ?></h5>
                                <p class="small text-muted"><i class="fa-solid fa-location-dot me-2"></i><?= htmlspecialchars($event['venue'] ?? 'Venue TBA'); ?><?= !empty($event['state']) ? ', ' . htmlspecialchars($event['state']) : ''; ?></p>
                                <p class="small"><i class="fa-solid fa-calendar me-2"></i><?= date('d M Y, g:ia', strtotime($event['start_date'])); ?><?php if (!empty($event['end_date'])): ?> - <?= date('d M Y, g:ia', strtotime($event['end_date'])); ?><?php endif; ?></p>
                                <p class="card-text small"><?= nl2br(htmlspecialchars(substr($event['description'] ?? '', 0, 200))); ?><?= !empty($event['description']) && strlen($event['description']) > 200 ? '...' : ''; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info" role="alert">
                        <i class="fa-solid fa-circle-info me-2"></i>No events are scheduled at this time.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
