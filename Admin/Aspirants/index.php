<?php
require_once __DIR__ . '/../../config/config.php';
include __DIR__ . '/../Includes/header.php';
?>
<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../Includes/sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h3">Aspirant Management</h1>
                <a href="/Admin/Aspirants/create" class="btn btn-primary"><i class="fa-solid fa-user-tie me-2"></i>Add Aspirant</a>
            </div>
            <?php
            $stmt = $pdo->query('SELECT id, first_name, last_name, email, mobile_number, unique_identification_number FROM aspirants ORDER BY created_at DESC');
            $aspirants = $stmt->fetchAll();
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
                        <?php foreach ($aspirants as $aspirant): ?>
                            <tr>
                                <td><?= (int) $aspirant['id']; ?></td>
                                <td><?= htmlspecialchars($aspirant['first_name'] . ' ' . $aspirant['last_name'], ENT_QUOTES); ?></td>
                                <td><?= htmlspecialchars($aspirant['email'], ENT_QUOTES); ?></td>
                                <td><?= htmlspecialchars($aspirant['mobile_number'], ENT_QUOTES); ?></td>
                                <td><?= htmlspecialchars($aspirant['unique_identification_number'], ENT_QUOTES); ?></td>
                                <td>
                                    <a class="btn btn-sm btn-outline-secondary" href="/Admin/Aspirants/view?id=<?= (int) $aspirant['id']; ?>">View</a>
                                    <a class="btn btn-sm btn-outline-primary" href="/Admin/Aspirants/edit?id=<?= (int) $aspirant['id']; ?>">Edit</a>
                                    <a class="btn btn-sm btn-outline-success" href="/Admin/Aspirants/send-message?id=<?= (int) $aspirant['id']; ?>">Message</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($aspirants)): ?>
                            <tr><td colspan="6" class="text-center text-muted">No aspirants found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
<?php include __DIR__ . '/../Includes/footer.php'; ?>
