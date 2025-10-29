<?php
require_once __DIR__ . '/../config/Database.php';

$pageTitle = 'Blog';
$database = Database::getInstance();
$siteSettings = $database->fetchSiteSettings();

$slug = $_GET['slug'] ?? null;
$connection = $database->getConnection();

if ($slug) {
    $statement = $connection->prepare('SELECT title, body, published_at FROM blog_posts WHERE slug = ? AND status = ? LIMIT 1');
    $statement->execute([$slug, 'published']);
    $activePost = $statement->fetch();
} else {
    $activePost = null;
}

$statement = $connection->prepare('SELECT id, title, slug, excerpt, body, published_at FROM blog_posts WHERE status = ? ORDER BY published_at DESC');
$statement->execute(['published']);
$posts = $statement->fetchAll();

require __DIR__ . '/../includes/header.php';
?>
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-7">
                <?php if ($slug && $activePost): ?>
                    <article class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h1 class="section-title h3 mb-3 text-primary"><?= htmlspecialchars($activePost['title']); ?></h1>
                            <?php if (!empty($activePost['published_at'])): ?>
                                <p class="small text-muted mb-4"><i class="fa-solid fa-calendar-day me-2"></i><?= date('d M Y', strtotime($activePost['published_at'])); ?></p>
                            <?php endif; ?>
                            <div class="small">
                                <?= nl2br(htmlspecialchars($activePost['body'])); ?>
                            </div>
                        </div>
                    </article>
                <?php elseif ($slug): ?>
                    <div class="alert alert-warning" role="alert">
                        <i class="fa-solid fa-circle-info me-2"></i>The requested blog post could not be found.
                    </div>
                <?php else: ?>
                    <div class="alert alert-info" role="alert">
                        <i class="fa-solid fa-circle-info me-2"></i>Select a post from the sidebar to read full details.
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h2 class="section-title h5">All Posts</h2>
                        <?php if (!empty($posts)): ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($posts as $post): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div>
                                            <a class="text-decoration-none" href="<?= $baseUrl; ?>pages/blog?slug=<?= urlencode($post['slug']); ?>">
                                                <strong><?= htmlspecialchars($post['title']); ?></strong>
                                            </a>
                                            <?php if (!empty($post['published_at'])): ?>
                                                <p class="small text-muted mb-0"><?= date('d M Y', strtotime($post['published_at'])); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted mb-0">No blog posts available yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
