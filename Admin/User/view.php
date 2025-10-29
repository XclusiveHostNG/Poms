<?php
require_once __DIR__ . '/../../config/config.php';
include __DIR__ . '/../Includes/header.php';
?>
<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../Includes/sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h1 class="h3 text-capitalize">User <?= ucfirst(str_replace('-', ' ', basename(__FILE__, '.php'))); ?></h1>
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-muted">This page provides the <?= str_replace('-', ' ', basename(__FILE__, '.php')); ?> functionality for members. Integrate form handling and validation as required.</p>
                </div>
            </div>
        </main>
    </div>
</div>
<?php include __DIR__ . '/../Includes/footer.php'; ?>
