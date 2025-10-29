<?php
require_once __DIR__ . '/../config/config.php';
$settings = getSiteSettings($pdo);
include __DIR__ . '/../Includes/Header.php';

$stmt = $pdo->prepare('SELECT title, slug, excerpt, featured_image, published_at FROM posts WHERE status = "published" ORDER BY published_at DESC');
$stmt->execute();
$posts = $stmt->fetchAll();
?>
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-8">
                <h1 class="section-title">Insights &amp; Updates</h1>
                <p class="lead">Stay updated with our latest news, policy analysis, and community success stories.</p>
            </div>
        </div>
        <div class="row g-4">
            <?php foreach ($posts as $post): ?>
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <?php if (!empty($post['featured_image'])): ?>
                            <img src="<?= htmlspecialchars($post['featured_image'], ENT_QUOTES); ?>" class="card-img-top" alt="<?= htmlspecialchars($post['title'], ENT_QUOTES); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($post['title'], ENT_QUOTES); ?></h5>
                            <p class="card-text text-muted"><?= htmlspecialchars($post['excerpt'], ENT_QUOTES); ?></p>
                            <a class="stretched-link" href="/Pages/blog/<?= htmlspecialchars($post['slug'], ENT_QUOTES); ?>">Read More</a>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-muted small">
                            <i class="fa-regular fa-calendar me-2"></i><?= date('d M Y', strtotime($post['published_at'])); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($posts)): ?>
                <div class="col-12">
                    <div class="alert alert-info"><i class="fa-solid fa-circle-info me-2"></i>No blog posts available yet.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../Includes/Footer.php'; ?>
