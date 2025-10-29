        </main>
        <footer class="bg-white border-top p-3 text-center small text-muted">
            &copy; <?= date('Y'); ?> <?= htmlspecialchars($siteSettings['site_name'] ?? 'POMS'); ?> Administration.
        </footer>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= $baseUrl; ?>assets/js/style.js"></script>
</body>
</html>
