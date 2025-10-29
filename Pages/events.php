<?php
require_once __DIR__ . '/../config/config.php';
$settings = getSiteSettings($pdo);
include __DIR__ . '/../Includes/Header.php';

$stmt = $pdo->prepare('SELECT title, description, event_date, venue, state, lga FROM events WHERE status = "published" ORDER BY event_date ASC');
$stmt->execute();
$events = $stmt->fetchAll();
?>
<section class="py-5">
    <div class="container">
        <h1 class="section-title">Events Calendar</h1>
        <p class="lead">Explore upcoming trainings, campaign rallies, and civic engagements across the country.</p>
        <div class="row g-4">
            <?php foreach ($events as $event): ?>
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><i class="fa-solid fa-calendar-day me-2"></i><?= htmlspecialchars($event['title'], ENT_QUOTES); ?></h5>
                            <p class="text-muted mb-1"><i class="fa-regular fa-clock me-2"></i><?= date('d M Y, h:i A', strtotime($event['event_date'])); ?></p>
                            <p class="text-muted mb-1"><i class="fa-solid fa-location-dot me-2"></i><?= htmlspecialchars($event['venue'] ?? 'Venue to be announced', ENT_QUOTES); ?></p>
                            <p class="text-muted"><i class="fa-solid fa-map me-2"></i><?= htmlspecialchars(trim(($event['state'] ?? '') . ', ' . ($event['lga'] ?? '')), ENT_QUOTES); ?></p>
                            <p><?= nl2br(htmlspecialchars($event['description'] ?? 'Details will be shared soon.', ENT_QUOTES)); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($events)): ?>
                <div class="col-12">
                    <div class="alert alert-info"><i class="fa-solid fa-circle-info me-2"></i>No events scheduled yet. Please check back later.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../Includes/Footer.php'; ?>
