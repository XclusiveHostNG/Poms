<?php
require_once __DIR__ . '/../config/config.php';
$settings = getSiteSettings($pdo);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $errors[] = 'Username and password are required.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT id, username, password_hash, role FROM users_auth WHERE username = :username LIMIT 1');
        $stmt->execute(['username' => $username]);
        $account = $stmt->fetch();

        if ($account && password_verify($password, $account['password_hash'])) {
            $_SESSION['user_id'] = $account['id'];
            $_SESSION['role'] = $account['role'];

            if ($account['role'] === 'aspirant') {
                header('Location: /Aspirant');
                exit;
            }

            if ($account['role'] === 'admin') {
                header('Location: /Admin');
                exit;
            }

            header('Location: /User');
            exit;
        }

        $errors[] = 'Invalid username or password.';
    }
}

include __DIR__ . '/../Includes/Header.php';
?>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h1 class="h3 mb-4 text-center">Login to Your Account</h1>
                        <?php if ($errors): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= htmlspecialchars($error, ENT_QUOTES); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <form method="post" novalidate>
                            <div class="mb-3">
                                <label class="form-label">Username or Email</label>
                                <input type="text" name="username" class="form-control" required value="<?= htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                </div>
                                <a href="/Auth/password-reset">Forgot password?</a>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                        <p class="text-center mt-3 mb-0">Don&apos;t have an account? <a href="/Auth/register">Create one</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../Includes/Footer.php'; ?>
