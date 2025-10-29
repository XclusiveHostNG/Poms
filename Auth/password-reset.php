<?php
require_once __DIR__ . '/../config/config.php';
$settings = getSiteSettings($pdo);

$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if ($email !== '') {
        $stmt = $pdo->prepare('INSERT INTO password_resets (email, token) VALUES (:email, :token)');
        $token = bin2hex(random_bytes(32));
        $stmt->execute([
            'email' => $email,
            'token' => $token,
        ]);
        $success = true;
    }
}

include __DIR__ . '/../Includes/Header.php';
?>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h1 class="h3 mb-4 text-center">Reset Password</h1>
                        <?php if ($success): ?>
                            <div class="alert alert-success">If the email exists in our system, a reset link has been sent.</div>
                        <?php endif; ?>
                        <form method="post" novalidate>
                            <div class="mb-3">
                                <label class="form-label">Email address</label>
                                <input type="email" name="email" class="form-control" required placeholder="Enter your email" value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES); ?>">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                        </form>
                        <p class="text-center mt-3 mb-0"><a href="/Auth/login"><i class="fa-solid fa-arrow-left me-2"></i>Back to login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../Includes/Footer.php'; ?>
