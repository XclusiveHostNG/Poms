<?php
require_once __DIR__ . '/../../config/Database.php';
$database = Database::getInstance();
$config = require __DIR__ . '/../../config/config.php';
$baseUrl = $config['app']['base_url'];
$siteSettings = $siteSettings ?? $database->fetchSiteSettings();
$pageTitle = $pageTitle ?? 'Aspirant Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle); ?> | Aspirant Area</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= $baseUrl; ?>assets/css/app.css">
</head>
<body class="bg-light">
<div class="container-fluid">
    <div class="row flex-nowrap">
        <?php require __DIR__ . '/sidebar.php'; ?>
        <div class="col py-4">
            <header class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h4 mb-0"><i class="fa-solid fa-user-tie me-2"></i><?= htmlspecialchars($pageTitle); ?></h1>
                <a href="<?= $baseUrl; ?>auth/logout" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-right-from-bracket me-1"></i>Logout</a>
            </header>
