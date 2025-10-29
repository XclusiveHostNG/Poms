<?php
require_once __DIR__ . '/../config/Database.php';

$pageTitle = 'Frequently Asked Questions';
$database = Database::getInstance();
$siteSettings = $database->fetchSiteSettings();

$statement = $database->getConnection()->prepare('SELECT question, answer FROM faqs WHERE is_active = 1 ORDER BY id ASC');
$statement->execute();
$faqs = $statement->fetchAll();

require __DIR__ . '/../includes/header.php';
?>
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="section-title">Frequently Asked Questions</h1>
        <div class="accordion" id="faqAccordion">
            <?php if (!empty($faqs)): ?>
                <?php foreach ($faqs as $index => $faq): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeading<?= $index; ?>">
                            <button class="accordion-button <?= $index === 0 ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse<?= $index; ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false'; ?>" aria-controls="faqCollapse<?= $index; ?>">
                                <?= htmlspecialchars($faq['question']); ?>
                            </button>
                        </h2>
                        <div id="faqCollapse<?= $index; ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : ''; ?>" aria-labelledby="faqHeading<?= $index; ?>" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <?= nl2br(htmlspecialchars($faq['answer'])); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info" role="alert">
                    <i class="fa-solid fa-circle-info me-2"></i>No frequently asked questions have been published.
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
