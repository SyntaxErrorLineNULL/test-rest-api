<?php
declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Doctrine\Common\Cache\Cache;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $logger->pushHandler(new StreamHandler($loggerSettings['path'], $loggerSettings['level']));

            return $logger;
        },

        # ORM
        EntityManager::class => function (ContainerInterface $c) {
            $setting = $c->get(SettingsInterface::class);

            $doctrineSettings = $setting->get('doctrine');

            $cache = $setting->get(Cache::class);

            # doctrine setting
            $doctrineConfiguration = new Configuration();
            $doctrineConfiguration->setProxyDir('data/doctrine');
            $doctrineConfiguration->setQueryCacheImpl($cache);
            $doctrineConfiguration->setHydrationCacheImpl($cache);
            $doctrineConfiguration->setMetadataCacheImpl($cache);
            $doctrineConfiguration->setResultCacheImpl($cache);

            $em = EntityManager::create($doctrineSettings['doctrine']['connection'], $doctrineConfiguration);

            return $em;
        },
    ]);

};
