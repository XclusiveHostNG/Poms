<?php
session_start();
session_unset();
session_destroy();

$config = require __DIR__ . '/../config/config.php';
$baseUrl = $config['app']['base_url'];
header('Location: ' . $baseUrl . 'auth/login');
exit;
