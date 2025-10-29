<?php
session_start();
require_once __DIR__ . '/../config/Database.php';

$pageTitle = 'Login';
$database = Database::getInstance();
$siteSettings = $database->fetchSiteSettings();
$connection = $database->getConnection();
$baseUrl = (require __DIR__ . '/../config/config.php')['app']['base_url'];

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountType = $_POST['account_type'] ?? 'user';
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($accountType === 'admin') {
        $stmt = $connection->prepare('SELECT id, password_hash FROM admins WHERE username = ? OR email = ? LIMIT 1');
    } elseif ($accountType === 'aspirant') {
        $stmt = $connection->prepare('SELECT id, password_hash FROM aspirants WHERE username = ? OR email = ? LIMIT 1');
    } else {
        $stmt = $connection->prepare('SELECT id, password_hash FROM users WHERE username = ? OR email = ? LIMIT 1');
    }

    $stmt->execute([$username, $username]);
    $record = $stmt->fetch();

    if ($record && password_verify($password, $record['password_hash'])) {
        $_SESSION['account_type'] = $accountType;
        $_SESSION['account_id'] = $record['id'];

        if ($accountType === 'admin') {
            header('Location: ' . $baseUrl . 'admin');
        } elseif ($accountType === 'aspirant') {
            header('Location: ' . $baseUrl . 'aspirant');
        } else {
            header('Location: ' . $baseUrl . 'user');
        }
        exit;
    } else {
        $error = 'Invalid credentials. Please try again.';
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
                        <h1 class="h3 mb-4 text-center">Login</h1>
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger" role="alert">
                                <i class="fa-solid fa-circle-exclamation me-2"></i><?= htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>
                        <form method="post" action="<?= $baseUrl; ?>auth/login">
                            <div class="mb-3">
                                <label class="form-label">Account Type</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="account_type" id="accountTypeUser" value="user" <?= (($_POST['account_type'] ?? 'user') === 'user') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="accountTypeUser">Member</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="account_type" id="accountTypeAspirant" value="aspirant" <?= (($_POST['account_type'] ?? '') === 'aspirant') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="accountTypeAspirant">Aspirant</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="account_type" id="accountTypeAdmin" value="admin" <?= (($_POST['account_type'] ?? '') === 'admin') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="accountTypeAdmin">Admin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="loginUsername" class="form-label">Email or Username</label>
                                <input type="text" class="form-control" id="loginUsername" name="username" required value="<?= htmlspecialchars($_POST['username'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="loginPassword" class="form-label">Password</label>
                                <input type="password" class="form-control" id="loginPassword" name="password" required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="<?= $baseUrl; ?>auth/password-reset" class="small">Forgot password?</a>
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-right-to-bracket me-2"></i>Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center bg-light">
                        <p class="mb-0 small">New here? <a href="<?= $baseUrl; ?>auth/register">Create an account</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
