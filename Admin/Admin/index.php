<?php
require_once __DIR__ . '/../../config/config.php';
include __DIR__ . '/../Includes/header.php';
?>
<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../Includes/sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h3">Administrators</h1>
                <a href="/Admin/Admin/create" class="btn btn-primary"><i class="fa-solid fa-user-shield me-2"></i>Add Admin</a>
            </div>
            <?php
            $stmt = $pdo->query('SELECT id, first_name, last_name, email, mobile_number FROM administrators ORDER BY created_at DESC');
            $admins = $stmt->fetchAll();
            ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($admins as $admin): ?>
                            <tr>
                                <td><?= (int) $admin['id']; ?></td>
                                <td><?= htmlspecialchars($admin['first_name'] . ' ' . $admin['last_name'], ENT_QUOTES); ?></td>
                                <td><?= htmlspecialchars($admin['email'], ENT_QUOTES); ?></td>
                                <td><?= htmlspecialchars($admin['mobile_number'], ENT_QUOTES); ?></td>
                                <td>
                                    <a class="btn btn-sm btn-outline-secondary" href="/Admin/Admin/view?id=<?= (int) $admin['id']; ?>">View</a>
                                    <a class="btn btn-sm btn-outline-primary" href="/Admin/Admin/edit?id=<?= (int) $admin['id']; ?>">Edit</a>
                                    <a class="btn btn-sm btn-outline-success" href="/Admin/Admin/send-message?id=<?= (int) $admin['id']; ?>">Message</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($admins)): ?>
                            <tr><td colspan="5" class="text-center text-muted">No administrators found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
<?php include __DIR__ . '/../Includes/footer.php'; ?>
