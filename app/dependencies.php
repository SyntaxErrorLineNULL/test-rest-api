<?php
declare(strict_types=1);

use App\Application\Domain\Entities\User;
use DI\ContainerBuilder;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
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

            $reader = new AnnotationReader();
            $driver = new AnnotationDriver($reader, $settings['metadata_dirs']);

            $config = Setup::createAnnotationMetadataConfiguration(
                $settings['metadata_dirs'],
                $settings['auto_generate_proxies'],
                $settings['proxy_dir'],
                $settings['cache_dir'] ? new FilesystemCache($settings['cache_dir']) : new ArrayCache(),
            );

            return EntityManager::create(
                $settings['connection'], $config
            );
        },

        \App\Application\Domain\Repository\UserRepository::class => function (ContainerInterface $container) {
            return $container->get(EntityManagerInterface::class)->getRepository(\App\Application\Domain\Entities\User::class);
        },
    ]);
};
