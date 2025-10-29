<?php
require_once __DIR__ . '/../config/config.php';
$settings = getSiteSettings($pdo);
include __DIR__ . '/../Includes/Header.php';

$stmt = $pdo->prepare('SELECT title, summary, published_at FROM manifestoes ORDER BY published_at DESC LIMIT 6');
$stmt->execute();
$manifestoes = $stmt->fetchAll();
?>
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-8">
                <h1 class="section-title">Manifestoes</h1>
                <p class="lead">Discover our policy commitments for national development, civic engagement, and inclusive governance.</p>
            </div>
        </div>
        <div class="row g-4">
            <?php foreach ($manifestoes as $manifesto): ?>
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><i class="fa-solid fa-scroll me-2"></i><?= htmlspecialchars($manifesto['title'], ENT_QUOTES); ?></h5>
                            <p class="card-text text-muted"><?= htmlspecialchars($manifesto['summary'], ENT_QUOTES); ?></p>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-muted small">
                            <i class="fa-regular fa-calendar me-2"></i><?= date('d M Y', strtotime($manifesto['published_at'])); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($manifestoes)): ?>
                <div class="col-12">
                    <div class="alert alert-info"><i class="fa-solid fa-circle-info me-2"></i>No manifestoes published yet. Please check back soon.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../Includes/Footer.php'; ?>
