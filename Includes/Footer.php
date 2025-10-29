    </main>
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h5 class="text-uppercase">About</h5>
                    <p><?= htmlspecialchars($siteTagline, ENT_QUOTES); ?></p>
                </div>
                <div class="col-md-4">
                    <h5 class="text-uppercase">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a class="text-white-50" href="/Pages/about">About Us</a></li>
                        <li><a class="text-white-50" href="/Pages/manifestoes">Manifestoes</a></li>
                        <li><a class="text-white-50" href="/Pages/contact">Contact</a></li>
                        <li><a class="text-white-50" href="/Pages/blog">Blog</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="text-uppercase">Stay Connected</h5>
                    <div class="d-flex gap-3">
                        <a class="text-white" href="#"><i class="fab fa-facebook"></i></a>
                        <a class="text-white" href="#"><i class="fab fa-twitter"></i></a>
                        <a class="text-white" href="#"><i class="fab fa-instagram"></i></a>
                        <a class="text-white" href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4 text-white-50">
                <small>&copy; <?= date('Y'); ?> <?= htmlspecialchars($siteTitle, ENT_QUOTES); ?>. All rights reserved.</small>
            </div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/Assets/JS/style.js"></script>
</body>
</html>
