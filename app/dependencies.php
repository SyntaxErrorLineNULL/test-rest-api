<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\Tools\Setup;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $container): LoggerInterface {
            $loggerSettings = $container->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },

        EntityManagerInterface::class => function (ContainerInterface $container): EntityManager {
            $settings = $container->get('doctrine');

            $config = Setup::createAnnotationMetadataConfiguration(
                $settings['metadata_dirs'],
                $settings['dev_mode'],
                $settings['proxy_dir'],
                $settings['cache_dir'] ? new FilesystemCache($settings['cache_dir']) : new ArrayCache(),
                false
            );

            $config->setNamingStrategy(new UnderscoreNamingStrategy());

            return EntityManager::create(
                $settings['connection'], $config
            );
        }
    ]);
};
