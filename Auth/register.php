<?php
require_once __DIR__ . '/../config/config.php';
$settings = getSiteSettings($pdo);

$allowInternational = ($settings['allow_international_registration'] ?? '1') === '1';
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountType = $_POST['account_type'] ?? 'member';
    $nationality = $_POST['nationality'] ?? 'nigerian';

    if (!$allowInternational && $nationality !== 'nigerian') {
        $errors[] = 'International registration is currently disabled.';
    }

    if (!in_array($accountType, ['member', 'aspirant'], true)) {
        $errors[] = 'Invalid account type selected.';
    }

    $requiredFields = ['first_name', 'last_name', 'email', 'mobile_number', 'username'];
    foreach ($requiredFields as $field) {
        if (empty(trim($_POST[$field] ?? ''))) {
            $errors[] = ucfirst(str_replace('_', ' ', $field)) . ' is required.';
        }
    }

    if (empty($_POST['password']) || strlen($_POST['password']) < 8) {
        $errors[] = 'Password must be at least 8 characters.';
    }

    if (($_POST['password'] ?? '') !== ($_POST['confirm_password'] ?? '')) {
        $errors[] = 'Passwords do not match.';
    }

    if (empty($errors)) {
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare('INSERT INTO users_auth (username, email, password_hash, role) VALUES (:username, :email, :password_hash, :role)');
            $stmt->execute([
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password_hash' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'role' => $accountType === 'aspirant' ? 'aspirant' : 'member',
            ]);

            $authId = (int) $pdo->lastInsertId();

            $profileTable = $accountType === 'aspirant' ? 'aspirants' : 'users';
            $profileStmt = $pdo->prepare("INSERT INTO {$profileTable} (
                auth_id, first_name, last_name, other_name, email, mobile_number, address, city, state,
                local_government_area, ward, polling_unit, senatorial_district, house_of_representative,
                country, occupation, level_of_education, annual_income, date_of_birth, bvn, nin, six_digit_pin,
                driver_license_number, voters_card_number, whatsapp_group_opt_in, apc_member, unique_identification_number,
                accepted_terms
            ) VALUES (
                :auth_id, :first_name, :last_name, :other_name, :email, :mobile_number, :address, :city, :state,
                :local_government_area, :ward, :polling_unit, :senatorial_district, :house_of_representative,
                :country, :occupation, :level_of_education, :annual_income, :date_of_birth, :bvn, :nin, :six_digit_pin,
                :driver_license_number, :voters_card_number, :whatsapp_group_opt_in, :apc_member, :unique_identification_number,
                :accepted_terms
            )");

            $profileStmt->execute([
                'auth_id' => $authId,
                'first_name' => trim($_POST['first_name'] ?? ''),
                'last_name' => trim($_POST['last_name'] ?? ''),
                'other_name' => trim($_POST['other_name'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'mobile_number' => trim($_POST['mobile_number'] ?? ''),
                'address' => trim($_POST['address'] ?? ''),
                'city' => trim($_POST['city'] ?? ''),
                'state' => trim($_POST['state'] ?? ''),
                'local_government_area' => trim($_POST['local_government_area'] ?? ''),
                'ward' => trim($_POST['ward'] ?? ''),
                'polling_unit' => trim($_POST['polling_unit'] ?? ''),
                'senatorial_district' => trim($_POST['senatorial_district'] ?? ''),
                'house_of_representative' => trim($_POST['house_of_representative'] ?? ''),
                'country' => $nationality === 'nigerian' ? 'Nigeria' : trim($_POST['country'] ?? ''),
                'occupation' => trim($_POST['occupation'] ?? ''),
                'level_of_education' => trim($_POST['level_of_education'] ?? ''),
                'annual_income' => trim($_POST['annual_income'] ?? ''),
                'date_of_birth' => trim($_POST['date_of_birth'] ?? ''),
                'bvn' => trim($_POST['bvn'] ?? ''),
                'nin' => trim($_POST['nin'] ?? ''),
                'six_digit_pin' => trim($_POST['six_digit_pin'] ?? ''),
                'driver_license_number' => trim($_POST['driver_license_number'] ?? ''),
                'voters_card_number' => trim($_POST['voters_card_number'] ?? ''),
                'whatsapp_group_opt_in' => ($_POST['whatsapp_group_opt_in'] ?? 'no') === 'yes' ? 'yes' : 'no',
                'apc_member' => ($_POST['apc_member'] ?? 'no') === 'yes' ? 'yes' : 'no',
                'unique_identification_number' => trim($_POST['unique_identification_number'] ?? ''),
                'accepted_terms' => isset($_POST['accepted_terms']) ? 1 : 0,
            ]);

            $pdo->commit();
            $success = true;
        } catch (Throwable $exception) {
            $pdo->rollBack();
            $errors[] = 'Registration failed. Please try again.';
        }
    }
}

include __DIR__ . '/../Includes/Header.php';
?>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h1 class="h3 mb-4 text-center">Create Your Account</h1>
                        <?php if ($success): ?>
                            <div class="alert alert-success"><i class="fa-solid fa-circle-check me-2"></i>Your account has been created successfully. Please login.</div>
                        <?php endif; ?>
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
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Registering as</label>
                                    <select name="account_type" class="form-select" required>
                                        <option value="member" <?= (($_POST['account_type'] ?? '') === 'member') ? 'selected' : ''; ?>>Member</option>
                                        <option value="aspirant" <?= (($_POST['account_type'] ?? '') === 'aspirant') ? 'selected' : ''; ?>>Aspirant</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Nationality</label>
                                    <select name="nationality" id="nationality" class="form-select" required>
                                        <option value="nigerian" <?= (($_POST['nationality'] ?? '') !== 'non-nigerian') ? 'selected' : ''; ?>>Nigerian</option>
                                        <option value="non-nigerian" <?= (($_POST['nationality'] ?? '') === 'non-nigerian') ? 'selected' : ''; ?> <?= $allowInternational ? '' : 'disabled'; ?>>International</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Country</label>
                                    <input type="text" name="country" id="countryField" class="form-control" value="<?= htmlspecialchars($_POST['country'] ?? 'Nigeria', ENT_QUOTES); ?>" <?= (($_POST['nationality'] ?? '') !== 'non-nigerian') ? 'readonly' : ''; ?>>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">First Name</label>
                                    <input type="text" name="first_name" class="form-control" required value="<?= htmlspecialchars($_POST['first_name'] ?? '', ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" required value="<?= htmlspecialchars($_POST['last_name'] ?? '', ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Other Name</label>
                                    <input type="text" name="other_name" class="form-control" value="<?= htmlspecialchars($_POST['other_name'] ?? '', ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Mobile Number</label>
                                    <input type="text" name="mobile_number" class="form-control" required value="<?= htmlspecialchars($_POST['mobile_number'] ?? '', ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($_POST['address'] ?? '', ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">City</label>
                                    <input type="text" name="city" class="form-control" value="<?= htmlspecialchars($_POST['city'] ?? '', ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">State</label>
                                    <input type="text" name="state" class="form-control" value="<?= htmlspecialchars($_POST['state'] ?? '', ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Local Government Area</label>
                                    <input type="text" name="local_government_area" class="form-control" value="<?= htmlspecialchars($_POST['local_government_area'] ?? '', ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Ward</label>
                                    <input type="text" name="ward" class="form-control" value="<?= htmlspecialchars($_POST['ward'] ?? '', ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Polling Unit</label>
                                    <input type="text" name="polling_unit" class="form-control" value="<?= htmlspecialchars($_POST['polling_unit'] ?? '', ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Senatorial District</label>
                                    <input type="text" name="senatorial_district" class="form-control" value="<?= htmlspecialchars($_POST['senatorial_district'] ?? '', ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">House of Representative</label>
                                    <input type="text" name="house_of_representative" class="form-control" value="<?= htmlspecialchars($_POST['house_of_representative'] ?? '', ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Occupation</label>
                                    <input type="text" name="occupation" class="form-control" value="<?= htmlspecialchars($_POST['occupation'] ?? '', ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Level of Education</label>
                                    <select name="level_of_education" class="form-select">
                                        <option value="">Select level</option>
                                        <?php
                                        $levels = ['Olevel', 'ND', 'HND', 'BSc', 'Masters', 'Doctorate'];
                                        foreach ($levels as $level) {
                                            $selected = (($_POST['level_of_education'] ?? '') === $level) ? 'selected' : '';
                                            echo '<option value="' . $level . '" ' . $selected . '>' . $level . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Annual Monthly Income</label>
                                    <input type="text" name="annual_income" class="form-control" value="<?= htmlspecialchars($_POST['annual_income'] ?? '', ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="date_of_birth" class="form-control" value="<?= htmlspecialchars($_POST['date_of_birth'] ?? '', ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">BVN</label>
                                    <input type="text" name="bvn" class="form-control" value="<?= htmlspecialchars($_POST['bvn'] ?? '', ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">NIN</label>
                                    <input type="text" name="nin" class="form-control" value="<?= htmlspecialchars($_POST['nin'] ?? '', ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">6 Digit PIN</label>
                                    <input type="password" name="six_digit_pin" maxlength="6" class="form-control" value="<?= htmlspecialchars($_POST['six_digit_pin'] ?? '', ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Driver License Number</label>
                                    <input type="text" name="driver_license_number" class="form-control" value="<?= htmlspecialchars($_POST['driver_license_number'] ?? '', ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Voters Card Number</label>
                                    <input type="text" name="voters_card_number" class="form-control" value="<?= htmlspecialchars($_POST['voters_card_number'] ?? '', ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Join WhatsApp Group?</label>
                                    <select name="whatsapp_group_opt_in" class="form-select">
                                        <option value="yes" <?= (($_POST['whatsapp_group_opt_in'] ?? '') === 'yes') ? 'selected' : ''; ?>>Yes</option>
                                        <option value="no" <?= (($_POST['whatsapp_group_opt_in'] ?? '') === 'no') ? 'selected' : ''; ?>>No</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Are you an APC member?</label>
                                    <select name="apc_member" class="form-select">
                                        <option value="yes" <?= (($_POST['apc_member'] ?? '') === 'yes') ? 'selected' : ''; ?>>Yes</option>
                                        <option value="no" <?= (($_POST['apc_member'] ?? '') === 'no') ? 'selected' : ''; ?>>No</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Unique Identification Number</label>
                                    <input type="text" name="unique_identification_number" class="form-control" value="<?= htmlspecialchars($_POST['unique_identification_number'] ?? '', ENT_QUOTES); ?>" placeholder="e.g., IB/2025/MEM0001">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" required value="<?= htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES); ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" name="confirm_password" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="accepted_terms" value="1" id="termsCheck" <?= isset($_POST['accepted_terms']) ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="termsCheck">I agree to the <a href="/Pages/terms-and-conditions" target="_blank">Terms &amp; Conditions</a> and <a href="/Pages/privacy-policy" target="_blank">Privacy Policy</a>.</label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 w-100">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nationalitySelect = document.getElementById('nationality');
        const countryField = document.getElementById('countryField');
        const defaultCountry = 'Nigeria';

        function updateCountryField() {
            if (nationalitySelect.value === 'non-nigerian') {
                countryField.removeAttribute('readonly');
                countryField.value = countryField.value || '';
            } else {
                countryField.value = defaultCountry;
                countryField.setAttribute('readonly', 'readonly');
            }
        }

        nationalitySelect.addEventListener('change', updateCountryField);
        updateCountryField();
    });
</script>
<?php include __DIR__ . '/../Includes/Footer.php'; ?>
