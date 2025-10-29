<?php
return [
    'database' => [
        'driver' => 'mysql',
        'host' => getenv('POMS_DB_HOST') ?: 'localhost',
        'port' => getenv('POMS_DB_PORT') ?: '3306',
        'name' => getenv('POMS_DB_NAME') ?: 'poms',
        'user' => getenv('POMS_DB_USER') ?: 'root',
        'password' => getenv('POMS_DB_PASSWORD') ?: '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
    ],
    'app' => [
        'base_url' => getenv('POMS_BASE_URL') ?: '/',
        'default_timezone' => 'Africa/Lagos',
    ],
];
