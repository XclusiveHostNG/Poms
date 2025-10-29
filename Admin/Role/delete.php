<?php
require_once __DIR__ . '/../../config/config.php';
include __DIR__ . '/../Includes/header.php';
?>
<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../Includes/sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h1 class="h3 text-capitalize"><?= htmlspecialchars(str_replace('-', ' ', basename(dirname(__FILE__))), ENT_QUOTES); ?> <?= ucfirst(str_replace('-', ' ', basename(__FILE__, '.php'))); ?></h1>
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-muted">Design the <?= strtolower(str_replace('-', ' ', basename(__FILE__, '.php'))); ?> workflow for <?= strtolower(str_replace('-', ' ', basename(dirname(__FILE__)))); ?> in this section.</p>
                </div>
            </div>
        </main>
    </div>
</div>
<?php include __DIR__ . '/../Includes/footer.php'; ?>
