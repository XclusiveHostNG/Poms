<?php
require_once __DIR__ . '/../config/Database.php';

$pageTitle = 'Manifestoes';
$database = Database::getInstance();
$siteSettings = $database->fetchSiteSettings();

$statement = $database->getConnection()->prepare('SELECT m.id, m.title, m.body, m.published_at, m.created_by_type FROM manifestoes m ORDER BY (m.published_at IS NULL), m.published_at DESC, m.id DESC');
$statement->execute();
$manifestoes = $statement->fetchAll();

require __DIR__ . '/../includes/header.php';
?>
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
            <h1 class="section-title mb-3 mb-md-0">Manifestoes</h1>
            <a class="btn btn-primary btn-sm" href="<?= $baseUrl; ?>auth/register?type=aspirant"><i class="fa-solid fa-pen-to-square me-2"></i>Submit Manifesto</a>
        </div>
        <?php if (!empty($manifestoes)): ?>
            <div class="row g-4">
                <?php foreach ($manifestoes as $manifesto): ?>
                    <div class="col-md-6">
                        <article class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><?= htmlspecialchars($manifesto['title']); ?></h5>
                                <?php if (!empty($manifesto['published_at'])): ?>
                                    <p class="small text-muted mb-3"><i class="fa-solid fa-calendar-day me-2"></i><?= date('d M Y', strtotime($manifesto['published_at'])); ?> &bull; <?= ucfirst(htmlspecialchars($manifesto['created_by_type'])); ?></p>
                                <?php endif; ?>
                                <p class="card-text small"><?= nl2br(htmlspecialchars(substr($manifesto['body'], 0, 280))); ?><?= strlen($manifesto['body']) > 280 ? '...' : ''; ?></p>
                                <a href="<?= $baseUrl; ?>manifestoes/view?id=<?= urlencode($manifesto['id']); ?>" class="btn btn-outline-primary btn-sm">Read more</a>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info" role="alert">
                <i class="fa-solid fa-circle-info me-2"></i>No manifestoes published yet.
            </div>
        <?php endif; ?>
    </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
