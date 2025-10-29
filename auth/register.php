<?php
session_start();
require_once __DIR__ . '/../config/Database.php';

$pageTitle = 'Register';
$database = Database::getInstance();
$connection = $database->getConnection();
$config = require __DIR__ . '/../config/config.php';
$baseUrl = $config['app']['base_url'];
$siteSettings = $database->fetchSiteSettings();

$errors = [];
$success = '';
$allowInternational = (int)($siteSettings['allow_international_registration'] ?? 1) === 1;
$nationality = $_POST['nationality'] ?? 'nigeria';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountType = $_POST['account_type'] === 'aspirant' ? 'aspirant' : 'user';
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $otherName = trim($_POST['other_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mobileNumber = trim($_POST['mobile_number'] ?? '');
    $country = $nationality === 'nigeria' ? 'Nigeria' : trim($_POST['country'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $securityPin = trim($_POST['security_pin'] ?? '');
    $acceptTerms = isset($_POST['accept_terms']) ? 1 : 0;

    if (!$allowInternational && $nationality !== 'nigeria') {
        $errors[] = 'International registration is currently disabled.';
    }

    if (empty($firstName) || empty($lastName)) {
        $errors[] = 'First name and last name are required.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email address is required.';
    }

    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters.';
    }

    if ($password !== $confirmPassword) {
        $errors[] = 'Password confirmation does not match.';
    }

    if (!preg_match('/^\d{6}$/', $securityPin)) {
        $errors[] = 'Security PIN must be a 6-digit number.';
    }

    if (!$acceptTerms) {
        $errors[] = 'You must accept the terms and conditions.';
    }

    if ($nationality === 'nigeria') {
        $country = 'Nigeria';
        if (empty($state)) {
            $errors[] = 'State is required for Nigerian members.';
        }
    } elseif (empty($country)) {
        $errors[] = 'Please specify your country.';
    }

    if (empty($errors)) {
        $table = $accountType === 'aspirant' ? 'aspirants' : 'users';

        $checkStmt = $connection->prepare("SELECT COUNT(*) FROM {$table} WHERE email = ? OR username = ?");
        $username = trim($_POST['username'] ?? '');
        if (empty($username)) {
            $errors[] = 'Username is required.';
        } else {
            $checkStmt->execute([$email, $username]);
            if ($checkStmt->fetchColumn() > 0) {
                $errors[] = 'Email or username already exists.';
            }
        }
    }

    if (empty($errors)) {
        $year = date('Y');
        $stateShort = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $state ?: $country), 0, 2)) ?: 'NG';
        $prefix = $accountType === 'aspirant' ? 'ASP' : 'MEM';
        $counterStmt = $connection->prepare("SELECT COUNT(*) FROM {$table}");
        $counterStmt->execute();
        $counter = (int)$counterStmt->fetchColumn() + 1;
        $uniqueId = sprintf('%s/%s/%s%04d', $stateShort, $year, $prefix, $counter);

        $fields = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'other_name' => $otherName,
            'email' => $email,
            'mobile_number' => $mobileNumber,
            'address' => $address,
            'city' => $city,
            'state' => $state,
            'local_government_area' => trim($_POST['local_government_area'] ?? ''),
            'ward' => trim($_POST['ward'] ?? ''),
            'polling_unit' => trim($_POST['polling_unit'] ?? ''),
            'senatorial_district' => trim($_POST['senatorial_district'] ?? ''),
            'house_of_representative' => trim($_POST['house_of_representative'] ?? ''),
            'country' => $country,
            'occupation' => trim($_POST['occupation'] ?? ''),
            'education_level' => trim($_POST['education_level'] ?? ''),
            'annual_monthly_income' => !empty($_POST['annual_monthly_income']) ? (float)$_POST['annual_monthly_income'] : null,
            'date_of_birth' => !empty($_POST['date_of_birth']) ? $_POST['date_of_birth'] : null,
            'bvn' => trim($_POST['bvn'] ?? ''),
            'nin' => trim($_POST['nin'] ?? ''),
            'security_pin' => $securityPin,
            'drivers_license_number' => trim($_POST['drivers_license_number'] ?? ''),
            'voters_card_number' => trim($_POST['voters_card_number'] ?? ''),
            'ready_for_whatsapp' => $_POST['ready_for_whatsapp'] ?? 'no',
            'apc_member' => $_POST['apc_member'] ?? 'no',
            'unique_identification_number' => $uniqueId,
            'accept_terms' => $acceptTerms,
            'username' => $username,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        ];

        if ($accountType === 'aspirant') {
            $fields['manifesto'] = trim($_POST['manifesto'] ?? '');
        }

        $columns = array_keys($fields);
        $placeholders = array_map(fn($column) => ':' . $column, $columns);
        $sql = 'INSERT INTO ' . $table . ' (' . implode(', ', $columns) . ') VALUES (' . implode(', ', $placeholders) . ')';
        $insertStmt = $connection->prepare($sql);
        foreach ($fields as $column => $value) {
            $insertStmt->bindValue(':' . $column, $value);
        }
        $insertStmt->execute();

        $success = 'Registration successful. You can now log in.';
    }
}

require __DIR__ . '/../includes/header.php';
?>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <h1 class="h3 mb-4 text-center">Create an Account</h1>
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= htmlspecialchars($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php elseif (!empty($success)): ?>
                            <div class="alert alert-success" role="alert">
                                <i class="fa-solid fa-circle-check me-2"></i><?= htmlspecialchars($success); ?>
                            </div>
                        <?php endif; ?>
                        <form method="post" action="<?= $baseUrl; ?>auth/register">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Registering As</label>
                                    <select name="account_type" class="form-select">
                                        <option value="user" <?= (($_POST['account_type'] ?? 'user') === 'user') ? 'selected' : ''; ?>>Member</option>
                                        <option value="aspirant" <?= (($_POST['account_type'] ?? '') === 'aspirant') ? 'selected' : ''; ?>>Aspirant</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Are you Nigerian?</label>
                                    <select name="nationality" class="form-select" id="nationalitySelect">
                                        <option value="nigeria" <?= (($_POST['nationality'] ?? 'nigeria') === 'nigeria') ? 'selected' : ''; ?>>Yes, I am Nigerian</option>
                                        <option value="international" <?= (($_POST['nationality'] ?? '') === 'international') ? 'selected' : ''; ?> <?= !$allowInternational ? 'disabled' : ''; ?>>No, I live abroad</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" name="first_name" required value="<?= htmlspecialchars($_POST['first_name'] ?? ''); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" required value="<?= htmlspecialchars($_POST['last_name'] ?? ''); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Other Name</label>
                                    <input type="text" class="form-control" name="other_name" value="<?= htmlspecialchars($_POST['other_name'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Mobile Number</label>
                                    <input type="tel" class="form-control" name="mobile_number" value="<?= htmlspecialchars($_POST['mobile_number'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username" required value="<?= htmlspecialchars($_POST['username'] ?? ''); ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="confirm_password" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Security PIN (6 digits)</label>
                                    <input type="text" class="form-control" name="security_pin" maxlength="6" required value="<?= htmlspecialchars($_POST['security_pin'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Country</label>
                                    <input type="text" class="form-control" name="country" id="countryInput" value="<?= htmlspecialchars($nationality === 'nigeria' ? 'Nigeria' : ($_POST['country'] ?? '')); ?>" <?= $nationality === 'nigeria' ? 'readonly' : ''; ?>>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">State</label>
                                    <input type="text" class="form-control" name="state" value="<?= htmlspecialchars($_POST['state'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control" name="city" value="<?= htmlspecialchars($_POST['city'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address" value="<?= htmlspecialchars($_POST['address'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">LGA</label>
                                    <input type="text" class="form-control" name="local_government_area" value="<?= htmlspecialchars($_POST['local_government_area'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Ward</label>
                                    <input type="text" class="form-control" name="ward" value="<?= htmlspecialchars($_POST['ward'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Polling Unit</label>
                                    <input type="text" class="form-control" name="polling_unit" value="<?= htmlspecialchars($_POST['polling_unit'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Senatorial District</label>
                                    <input type="text" class="form-control" name="senatorial_district" value="<?= htmlspecialchars($_POST['senatorial_district'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">House of Representative</label>
                                    <input type="text" class="form-control" name="house_of_representative" value="<?= htmlspecialchars($_POST['house_of_representative'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Occupation</label>
                                    <input type="text" class="form-control" name="occupation" value="<?= htmlspecialchars($_POST['occupation'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Education Level</label>
                                    <select class="form-select" name="education_level">
                                        <option value="">Select level</option>
                                        <?php
                                        $levels = ['O Level', 'NCE', 'OND', 'HND', 'BSc', 'Masters', 'PhD'];
                                        foreach ($levels as $level) {
                                            $selected = (($_POST['education_level'] ?? '') === $level) ? 'selected' : '';
                                            echo '<option value="' . htmlspecialchars($level) . '" ' . $selected . '>' . htmlspecialchars($level) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Monthly Income (₦)</label>
                                    <input type="number" step="0.01" class="form-control" name="annual_monthly_income" value="<?= htmlspecialchars($_POST['annual_monthly_income'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" name="date_of_birth" value="<?= htmlspecialchars($_POST['date_of_birth'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">BVN</label>
                                    <input type="text" class="form-control" name="bvn" value="<?= htmlspecialchars($_POST['bvn'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIN</label>
                                    <input type="text" class="form-control" name="nin" value="<?= htmlspecialchars($_POST['nin'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Driver License Number</label>
                                    <input type="text" class="form-control" name="drivers_license_number" value="<?= htmlspecialchars($_POST['drivers_license_number'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Voter Card Number</label>
                                    <input type="text" class="form-control" name="voters_card_number" value="<?= htmlspecialchars($_POST['voters_card_number'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Join WhatsApp Group?</label>
                                    <select class="form-select" name="ready_for_whatsapp">
                                        <option value="yes" <?= (($_POST['ready_for_whatsapp'] ?? '') === 'yes') ? 'selected' : ''; ?>>Yes</option>
                                        <option value="no" <?= (($_POST['ready_for_whatsapp'] ?? 'no') === 'no') ? 'selected' : ''; ?>>No</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">APC Member?</label>
                                    <select class="form-select" name="apc_member">
                                        <option value="yes" <?= (($_POST['apc_member'] ?? '') === 'yes') ? 'selected' : ''; ?>>Yes</option>
                                        <option value="no" <?= (($_POST['apc_member'] ?? 'no') === 'no') ? 'selected' : ''; ?>>No</option>
                                    </select>
                                </div>
                                <div class="col-12" id="aspirantManifesto" style="display: <?= (($_POST['account_type'] ?? 'user') === 'aspirant') ? 'block' : 'none'; ?>;">
                                    <label class="form-label">Manifesto (for Aspirants)</label>
                                    <textarea class="form-control" name="manifesto" rows="4"><?= htmlspecialchars($_POST['manifesto'] ?? ''); ?></textarea>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="acceptTerms" name="accept_terms" <?= isset($_POST['accept_terms']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="acceptTerms">
                                            I accept the <a href="<?= $baseUrl; ?>pages/terms-and-conditions" target="_blank">terms and conditions</a>.
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg w-100"><i class="fa-solid fa-user-plus me-2"></i>Register</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center bg-light">
                        <p class="mb-0 small">Already have an account? <a href="<?= $baseUrl; ?>auth/login">Login here</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nationalitySelect = document.getElementById('nationalitySelect');
        const countryInput = document.getElementById('countryInput');
        const aspirantManifesto = document.getElementById('aspirantManifesto');
        const accountTypeSelect = document.querySelector('select[name="account_type"]');

        function toggleCountry() {
            if (nationalitySelect.value === 'nigeria') {
                countryInput.value = 'Nigeria';
                countryInput.setAttribute('readonly', 'readonly');
            } else {
                countryInput.removeAttribute('readonly');
                countryInput.focus();
            }
        }

        function toggleManifesto() {
            aspirantManifesto.style.display = accountTypeSelect.value === 'aspirant' ? 'block' : 'none';
        }

        nationalitySelect.addEventListener('change', toggleCountry);
        accountTypeSelect.addEventListener('change', toggleManifesto);
        toggleCountry();
        toggleManifesto();
    });
</script>
<?php require __DIR__ . '/../includes/footer.php'; ?>
