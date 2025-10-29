<?php
require_once __DIR__ . '/../config/Database.php';

$appConfig = require __DIR__ . '/../config/config.php';
date_default_timezone_set($appConfig['app']['default_timezone']);

$database = Database::getInstance();
$siteSettings = $siteSettings ?? $database->fetchSiteSettings();
$siteName = $siteSettings['site_name'] ?? 'Political Organisation Management System';
$siteTagline = $siteSettings['site_tagline'] ?? '';
$baseUrl = $appConfig['app']['base_url'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars(($pageTitle ?? $siteName) . ' | ' . $siteName); ?></title>
    <meta name="description" content="<?= htmlspecialchars($siteTagline); ?>">
    <link rel="icon" type="image/png" href="<?= htmlspecialchars($siteSettings['favicon_path'] ?? $baseUrl . 'assets/images/favicon.png'); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= $baseUrl; ?>assets/css/style.css">
    <?php if (!empty($extraStyles ?? [])) : ?>
        <?php foreach ($extraStyles as $style): ?>
            <link rel="stylesheet" href="<?= htmlspecialchars($style); ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary py-3 shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?= $baseUrl; ?>">
            <i class="fa-solid fa-people-group me-2"></i>
            <span class="fw-bold text-uppercase"><?= htmlspecialchars($siteName); ?></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="<?= $baseUrl; ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $baseUrl; ?>pages/about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $baseUrl; ?>pages/manifestoes">Manifestoes</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $baseUrl; ?>pages/blog">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $baseUrl; ?>pages/faq">FAQ</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $baseUrl; ?>pages/contact">Contact</a></li>
            </ul>
            <div class="d-flex ms-lg-3">
                <a class="btn btn-light btn-sm me-2" href="<?= $baseUrl; ?>auth/login"><i class="fa-solid fa-right-to-bracket me-1"></i> Login</a>
                <a class="btn btn-warning btn-sm" href="<?= $baseUrl; ?>auth/register"><i class="fa-solid fa-user-plus me-1"></i> Sign Up</a>
            </div>
        </div>
    </div>
</nav>
<main class="flex-grow-1">
