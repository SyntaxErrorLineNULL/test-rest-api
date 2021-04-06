<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use DI\Container;
use DI\ContainerBuilder;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

return function (ContainerBuilder $containerBuilder) {

    $containerBuilder->addDefinitions([
        EntityManagerInterface::class => function (Container $container) {

            $settings = $container->get('settings')['doctrine'];

            $config = Setup::createAnnotationMetadataConfiguration(
                $settings['metadata_dirs'],
                $settings['auto_generate_proxies'],
                $settings['proxy_dir'],
                $settings['cache'],
                false
            );

            $connection = $settings['connection'];

            return EntityManager::create($connection, $config);
        },

        Connection::class => function (EntityManagerInterface $entityManager) {
            return $entityManager->getConnection();
        },

        PDO::class => function (Connection $connection) {
            return $connection->getWrappedConnection();
        },
    ]);
};