<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use Monolog\Logger;

return [
    'settings' => [
        // Logger metadata
        'logger' => [
            'name' => 'rest-api',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => Logger::DEBUG,
        ],

        'doctrine' => [
            'development' => true,
            // if true, metadata caching is forcefully disabled
            'dev_mode' => true,
            'cache_dir' => __DIR__ . '/../../var/cache/doctrine/cache',
            'proxy_dir' => __DIR__ . '/../../var/cache/doctrine/proxy',
            'useSimpleAnnotationReader' => false,

            // you should add any other path containing annotated entity classes
            'metadata_dirs' => [__DIR__ . '/../../src/Application/Domain'],

            'connection' => [
                'driver' => 'pdo_pgsql',
                'host' => getenv('DB_HOST'),
                'user' => getenv('DB_USER'),
                'password' => getenv('DB_PASSWORD'),
                'dbname' => getenv('DB_NAME'),
                'charset' => 'utf-8',
            ]
        ],

        // JWT service config
        'secretKey' => 'MTkN6mQVu7AsSHHmX7jDhpW0bbBT3C4p',
    ]
];