<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return [
    'settings' => [
        'displayErrorDetails' => true, // Should be set to false in production
        'logger' => [
            'name' => 'rest-api',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => Logger::DEBUG,
        ],

        'doctrine' => [
            'entity_path' => ['src/Application/Entities'],
            'auto_generate_proxies' => true,
            'cache' => null,
            'proxy_dir' => __DIR__ . '/../data/cache/proxies',
            'connection' => [
                'driver' => 'pdo_pgsql',
                'host' => 'db',
                'dbname' => 'rest',
                'user' => 'root',
                'password' => '12345',
                'charset' => 'utf-8'
            ],
        ],
    ],
];
