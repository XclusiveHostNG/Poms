<?php
require_once __DIR__ . '/../../config/Database.php';

$database = Database::getInstance();
$siteSettings = $siteSettings ?? $database->fetchSiteSettings();
$config = require __DIR__ . '/../../config/config.php';
$baseUrl = $config['app']['base_url'];
$pageTitle = $pageTitle ?? 'Admin Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle); ?> | Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= $baseUrl; ?>assets/css/admin.css">
    <link rel="stylesheet" href="<?= $baseUrl; ?>assets/css/app.css">
</head>
<body>
<div class="d-flex">
    <?php require __DIR__ . '/sidebar.php'; ?>
    <div class="flex-grow-1">
        <header class="bg-white border-bottom shadow-sm p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h5 mb-0"><i class="fa-solid fa-gauge-high me-2"></i><?= htmlspecialchars($pageTitle); ?></h1>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted small"><i class="fa-solid fa-user-shield me-2"></i>Admin Panel</span>
                    <a href="<?= $baseUrl; ?>auth/logout" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-right-from-bracket me-1"></i>Logout</a>
                </div>
            </div>
        </header>
        <main class="p-4">
