<?php
require_once __DIR__ . '/Database.php';

date_default_timezone_set('Africa/Lagos');

$database = new Database();
$pdo = $database->getConnection();

function getSiteSettings(PDO $pdo): array
{
    $stmt = $pdo->prepare('SELECT `key`, `value` FROM site_settings');
    $stmt->execute();

    $settings = [];
    foreach ($stmt->fetchAll() as $row) {
        $settings[$row['key']] = $row['value'];
    }

    return $settings;
}

function getActiveNavigation(string $path): string
{
    $current = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/');
    $path = trim($path, '/');

    return $current === $path ? 'active' : '';
}
