<?php
session_start();
require_once __DIR__ . '/../config/Database.php';

$pageTitle = 'Password Reset';
$database = Database::getInstance();
$siteSettings = $database->fetchSiteSettings();
$baseUrl = (require __DIR__ . '/../config/config.php')['app']['base_url'];

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please provide a valid email address.';
    } else {
        // In a full implementation, a token email would be sent.
        $message = 'If this email is registered, a reset link will be sent shortly.';
    }
}

require __DIR__ . '/../includes/header.php';
?>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <h1 class="h3 mb-4 text-center">Reset Password</h1>
                        <?php if (!empty($message)): ?>
                            <div class="alert alert-info" role="alert">
                                <i class="fa-solid fa-circle-info me-2"></i><?= htmlspecialchars($message); ?>
                            </div>
                        <?php endif; ?>
                        <form method="post" action="<?= $baseUrl; ?>auth/password-reset">
                            <div class="mb-3">
                                <label for="resetEmail" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="resetEmail" name="email" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-paper-plane me-2"></i>Send Reset Link</button>
                        </form>
                    </div>
                    <div class="card-footer text-center bg-light">
                        <p class="mb-0 small">Remembered your password? <a href="<?= $baseUrl; ?>auth/login">Back to login</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
