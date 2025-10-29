<?php
if (!isset($pdo)) {
    require_once __DIR__ . '/../config/config.php';
}

$settings = $settings ?? getSiteSettings($pdo);
$siteTitle = $settings['site_title'] ?? 'Political Organisation Management System';
$siteTagline = $settings['site_tagline'] ?? 'Empowering democratic participation';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= htmlspecialchars($siteTagline, ENT_QUOTES); ?>">
    <title><?= htmlspecialchars($siteTitle, ENT_QUOTES); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="/Assets/Css/style.css">
</head>
<body>
<header class="sticky-top bg-white shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="/">
                <i class="fa-solid fa-landmark me-2"></i><?= htmlspecialchars($siteTitle, ENT_QUOTES); ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link <?= getActiveNavigation(''); ?>" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link <?= getActiveNavigation('Pages/about'); ?>" href="/Pages/about">About</a></li>
                    <li class="nav-item"><a class="nav-link <?= getActiveNavigation('Pages/manifestoes'); ?>" href="/Pages/manifestoes">Manifestoes</a></li>
                    <li class="nav-item"><a class="nav-link <?= getActiveNavigation('Pages/blog'); ?>" href="/Pages/blog">Blog</a></li>
                    <li class="nav-item"><a class="nav-link <?= getActiveNavigation('Pages/contact'); ?>" href="/Pages/contact">Contact</a></li>
                    <li class="nav-item"><a class="nav-link <?= getActiveNavigation('Pages/faq'); ?>" href="/Pages/faq">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link" href="/Auth/login">Login</a></li>
                    <li class="nav-item"><a class="btn btn-primary ms-lg-2" href="/Auth/register">Join Us</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<main>
