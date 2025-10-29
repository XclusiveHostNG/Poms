<?php
require_once __DIR__ . '/../../config/config.php';
include __DIR__ . '/../Includes/header.php';
?>
<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../Includes/sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h3">WhatsApp Groups</h1>
                <a href="/Admin/Whatsapp%20Groups/create" class="btn btn-success"><i class="fa-brands fa-whatsapp me-2"></i>Add Group Link</a>
            </div>
            <?php
            $stmt = $pdo->query('SELECT id, state, region, group_link FROM whatsapp_groups ORDER BY state ASC');
            $groups = $stmt->fetchAll();
            ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>State</th>
                            <th>Region</th>
                            <th>WhatsApp Link</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($groups as $group): ?>
                            <tr>
                                <td><?= (int) $group['id']; ?></td>
                                <td><?= htmlspecialchars($group['state'], ENT_QUOTES); ?></td>
                                <td><?= htmlspecialchars($group['region'], ENT_QUOTES); ?></td>
                                <td><a href="<?= htmlspecialchars($group['group_link'], ENT_QUOTES); ?>" target="_blank">Join Group</a></td>
                                <td>
                                    <a class="btn btn-sm btn-outline-primary" href="/Admin/Whatsapp%20Groups/edit?id=<?= (int) $group['id']; ?>">Edit</a>
                                    <a class="btn btn-sm btn-outline-danger" href="/Admin/Whatsapp%20Groups/delete?id=<?= (int) $group['id']; ?>">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($groups)): ?>
                            <tr><td colspan="5" class="text-center text-muted">No WhatsApp groups configured yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
<?php include __DIR__ . '/../Includes/footer.php'; ?>
