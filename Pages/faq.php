<?php
require_once __DIR__ . '/../config/config.php';
$settings = getSiteSettings($pdo);
include __DIR__ . '/../Includes/Header.php';

$stmt = $pdo->prepare('SELECT question, answer FROM faqs WHERE status = "published" ORDER BY display_order ASC');
$stmt->execute();
$faqs = $stmt->fetchAll();
?>
<section class="py-5">
    <div class="container">
        <h1 class="section-title text-center">Frequently Asked Questions</h1>
        <div class="accordion" id="faqAccordion">
            <?php foreach ($faqs as $index => $faq): ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading<?= $index; ?>">
                        <button class="accordion-button <?= $index === 0 ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index; ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false'; ?>" aria-controls="collapse<?= $index; ?>">
                            <?= htmlspecialchars($faq['question'], ENT_QUOTES); ?>
                        </button>
                    </h2>
                    <div id="collapse<?= $index; ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : ''; ?>" aria-labelledby="heading<?= $index; ?>" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <?= nl2br(htmlspecialchars($faq['answer'], ENT_QUOTES)); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($faqs)): ?>
                <div class="alert alert-info"><i class="fa-solid fa-circle-info me-2"></i>No FAQs have been added yet.</div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../Includes/Footer.php'; ?>
