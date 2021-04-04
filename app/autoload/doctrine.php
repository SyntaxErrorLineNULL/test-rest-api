<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use DI\ContainerBuilder;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\EventManager;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        EntityManagerInterface::class => function (ContainerInterface $container): EntityManagerInterface
        {

            $settings = $container->get('config')['doctrine'];

            $config = Setup::createAnnotationMetadataConfiguration(
                $settings['metadata_dirs'],
                $settings['dev_mode'],
                $settings['proxy_dir'],
                $settings['cache_dir'] ? new FilesystemCache($settings['cache_dir']) : new ArrayCache(),
                false
            );

            $config->setNamingStrategy(new UnderscoreNamingStrategy());

            $eventManager = new EventManager();

            foreach ($settings['subscribers'] as $name) {
                /** @var EventSubscriber $subscriber */
                $subscriber = $container->get($name);
                $eventManager->addEventSubscriber($subscriber);
            }

            return EntityManager::create(
                $settings['connection'],
                $config,
                $eventManager
            );
        },

        'config' => [
            'doctrine' => [
                'auto_generate_proxies' => true,
                'cache' => null,
                'cache_dir' => __DIR__ . '/../../var/cache/doctrine/cache',
                'proxy_dir' => __DIR__ . '/../../var/cache/doctrine/proxy',
                'connection' => [
                    'driver' => getenv('DB_DRIVER') ?: 'pdo_pgsql',
                    'host' => getenv('DB_HOST') ?: 'localhost',
                    'port' => getenv('DB_PORT') ?: 5432,
                    'dbname' => getenv('DB_NAME') ?: 'test',
                    'user' => getenv('DB_USER') ?: 'root',
                    'password' => getenv('DB_PASSWORD') ?: '',
                    'charset' => 'utf-8'
                ],
                'subscribers' => [],
                'metadata_dirs' => [
                    __DIR__ . '/../../src/Domain/Entity'
                ],
            ],
        ],
    ]);
};