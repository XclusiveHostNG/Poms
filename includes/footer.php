</main>
<footer class="bg-dark text-light py-5 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="text-uppercase mb-3"><i class="fa-solid fa-landmark-flag me-2"></i>About</h5>
                <p class="small mb-0"><?= htmlspecialchars($siteTagline); ?></p>
            </div>
            <div class="col-md-4">
                <h5 class="text-uppercase mb-3">Quick Links</h5>
                <ul class="list-unstyled small">
                    <li><a class="text-decoration-none text-light" href="<?= $baseUrl; ?>pages/privacy-policy">Privacy Policy</a></li>
                    <li><a class="text-decoration-none text-light" href="<?= $baseUrl; ?>pages/terms-and-conditions">Terms &amp; Conditions</a></li>
                    <li><a class="text-decoration-none text-light" href="<?= $baseUrl; ?>pages/faq">FAQ</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5 class="text-uppercase mb-3">Stay Connected</h5>
                <div class="d-flex gap-3">
                    <?php if (!empty($siteSettings['facebook_url'])): ?>
                        <a class="text-light" href="<?= htmlspecialchars($siteSettings['facebook_url']); ?>" target="_blank" rel="noopener"><i class="fa-brands fa-facebook"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($siteSettings['twitter_url'])): ?>
                        <a class="text-light" href="<?= htmlspecialchars($siteSettings['twitter_url']); ?>" target="_blank" rel="noopener"><i class="fa-brands fa-x-twitter"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($siteSettings['instagram_url'])): ?>
                        <a class="text-light" href="<?= htmlspecialchars($siteSettings['instagram_url']); ?>" target="_blank" rel="noopener"><i class="fa-brands fa-instagram"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($siteSettings['youtube_url'])): ?>
                        <a class="text-light" href="<?= htmlspecialchars($siteSettings['youtube_url']); ?>" target="_blank" rel="noopener"><i class="fa-brands fa-youtube"></i></a>
                    <?php endif; ?>
                </div>
                <p class="small mt-3 mb-0"><i class="fa-solid fa-envelope me-2"></i><?= htmlspecialchars($siteSettings['support_email'] ?? ''); ?></p>
                <p class="small mb-0"><i class="fa-solid fa-phone me-2"></i><?= htmlspecialchars($siteSettings['support_phone'] ?? ''); ?></p>
            </div>
        </div>
        <div class="text-center pt-4 mt-4 border-top border-secondary">
            <p class="small mb-0">&copy; <?= date('Y'); ?> <?= htmlspecialchars($siteName); ?>. All rights reserved.</p>
        </div>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= $baseUrl; ?>assets/js/style.js"></script>
<?php if (!empty($extraScripts ?? [])) : ?>
    <?php foreach ($extraScripts as $script): ?>
        <script src="<?= htmlspecialchars($script); ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>
