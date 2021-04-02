<?php
declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use App\Domain\Entity\ConfirmationToken;
use App\Domain\Entity\User;
use App\Domain\Repository\ConfirmationTokenRepository;
use App\Domain\Repository\UserRepository;
use App\Infrastructure\Repository\DoctrineConfirmationToken;
use App\Infrastructure\Repository\DoctrineUserRepository;
use DI\ContainerBuilder;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Setup;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
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

            $reader = new AnnotationReader();
            $driver = new AnnotationDriver($reader, $doctrineSettings['metadata_dirs']);

            $config = Setup::createAnnotationMetadataConfiguration(
                $doctrineSettings['metadata_dirs'],
                $doctrineSettings['auto_generate_proxies'],
                $doctrineSettings['proxy_dir'],
                $doctrineSettings['cache'],
                FALSE
            );
            $config->setMetadataDriverImpl($driver);

            return EntityManager::create($doctrineSettings['connection'], $config);
        },

        #Repository
        UserRepository::class => function (ContainerInterface $c) {
            /** @var EntityManagerInterface $em */
            $em = $c->get(EntityManagerInterface::class);

            /** @var EntityRepository<User> $entity */
            $entity = $c->get(User::class);
            return new DoctrineUserRepository($entity, $em);
        },

        ConfirmationTokenRepository::class => function (ContainerInterface $c) {
            /** @var EntityManagerInterface $em */
            $em = $c->get(EntityManagerInterface::class);

            /** @var EntityRepository<ConfirmationToken> $entity */
            $entity = $c->get(ConfirmationToken::class);
            return new DoctrineConfirmationToken($entity, $em);
        },

        /** TODO: create factory repository */

    ]);

};
