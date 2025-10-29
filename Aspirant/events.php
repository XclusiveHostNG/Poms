<?php
require_once __DIR__ . '/../config/config.php';
include __DIR__ . '/Includes/header.php';
?>
<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/Includes/sidebar.php'; ?>
        <main class="col-lg-9 ms-auto px-4 py-4">
            <h1 class="h3 text-capitalize"><?= ucfirst(str_replace('-', ' ', basename(__FILE__, '.php'))); ?></h1>
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-muted">Configure the <?= str_replace('-', ' ', basename(__FILE__, '.php')); ?> module for aspirants here.</p>
                </div>
            </div>
        </main>
    </div>
</div>
<?php include __DIR__ . '/Includes/footer.php'; ?>
