<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],

                'doctrine' => [
                    'metadata_dirs' => __DIR__ . '/../src/Domain/Entity',
                    'auto_generate_proxies' => true,
                    'proxy_dir' => __DIR__ . '/../data/cache/proxies',
                    'cache' => null,
                    'connection' => [
                        'driver' => getenv('DB_DRIVER') ?: 'pdo_pgsql',
                        'host' => getenv('DB_HOST') ?: 'localhost',
                        'port' => getenv('DB_PORT') ?: 5432,
                        'dbname' => getenv('DB_NAME') ?: 'test',
                        'user' => getenv('DB_USER') ?: 'root',
                        'password' => getenv('DB_PASSWORD') ?: ''
                    ],
                    'charset' => 'utf-8',
                    'collation' => 'utf8_unicode_ci',
                ]
            ]);
        }
    ]);
};
