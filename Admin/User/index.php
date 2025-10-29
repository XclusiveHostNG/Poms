<?php
require_once __DIR__ . '/../../config/config.php';
include __DIR__ . '/../Includes/header.php';
?>
<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../Includes/sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h3">User Management</h1>
                <a href="/Admin/User/create" class="btn btn-primary"><i class="fa-solid fa-user-plus me-2"></i>Add Member</a>
            </div>
            <?php
            $stmt = $pdo->query('SELECT id, first_name, last_name, email, mobile_number, unique_identification_number FROM users ORDER BY created_at DESC');
            $users = $stmt->fetchAll();
            ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Unique ID</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= (int) $user['id']; ?></td>
                                <td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name'], ENT_QUOTES); ?></td>
                                <td><?= htmlspecialchars($user['email'], ENT_QUOTES); ?></td>
                                <td><?= htmlspecialchars($user['mobile_number'], ENT_QUOTES); ?></td>
                                <td><?= htmlspecialchars($user['unique_identification_number'], ENT_QUOTES); ?></td>
                                <td>
                                    <a class="btn btn-sm btn-outline-secondary" href="/Admin/User/view?id=<?= (int) $user['id']; ?>">View</a>
                                    <a class="btn btn-sm btn-outline-primary" href="/Admin/User/edit?id=<?= (int) $user['id']; ?>">Edit</a>
                                    <a class="btn btn-sm btn-outline-success" href="/Admin/User/send-message?id=<?= (int) $user['id']; ?>">Message</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($users)): ?>
                            <tr><td colspan="6" class="text-center text-muted">No members found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
<?php include __DIR__ . '/../Includes/footer.php'; ?>
