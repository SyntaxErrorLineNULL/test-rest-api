<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

    $containerBuilder->addDefinitions([
        'displayErrorDetails' => true, // Should be set to false in production
        'logger' => [
            'name' => 'slim-config',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/config.log',
            'level' => Logger::DEBUG,
        ],

        'doctrine' => [
            'auto_generate_proxies' => true,
            'cache' => null,
            'cache_dir' => __DIR__ . '/../data/cache/doctrine/cache',
            'proxy_dir' => __DIR__ . '/../data/cache/proxies',
            'connection' => [
                'driver' => 'pdo_pgsql',
                'host' => '127.0.0.1',
                'dbname' => 'config',
                'user' => 'postgres',
                'password' => '12345',
                'charset' => 'utf-8'
            ],
            'metadata_dirs' => [
                __DIR__ . '/../src/Application/Domain/Entity/'
            ],
        ],
    ]);
};
