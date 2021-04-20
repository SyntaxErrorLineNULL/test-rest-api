<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use DI\ContainerBuilder;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;

return [
    EntityManagerInterface::class => static function (ContainerInterface $container): EntityManagerInterface {
        $settings = $container->get('settings')['doctrine'];

        $cache = null;
        if (!$settings['development']) {
            $cache = $settings['cache_dir'] ? new FilesystemCache($settings['cache_dir']) : new ArrayCache();
        }

        $config = Setup::createAnnotationMetadataConfiguration(
            $settings['metadata_dirs'],
            $settings['dev_mode'],
            $settings['proxy_dir'],
            $cache,
            $settings['useSimpleAnnotationReader'],
        );

        $config->setMetadataDriverImpl(
            new AnnotationDriver(
                new AnnotationReader(),
                $settings['metadata_dirs']
            )
        );

        return EntityManager::create($settings['connection'], $config);
    }
];