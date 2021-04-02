<?php
declare(strict_types=1);

use App\Application\Handlers\Auth\SignUp\SignUpHandler;
use App\Application\Settings\Flusher;
use App\Application\Settings\SettingsInterface;
use App\Core\Service\PasswordService;
use App\Core\Service\RequestData;
use App\Domain\Entity\ConfirmationToken;
use App\Domain\Entity\User;
use App\Domain\Repository\ConfirmationTokenRepository;
use App\Domain\Repository\UserRepository;
use App\Infrastructure\Repository\DoctrineConfirmationToken;
use App\Infrastructure\Repository\DoctrineUserRepository;
use DI\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Setup;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
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
        EntityManagerInterface::class => function (ContainerInterface $c) {
            $setting = $c->get(SettingsInterface::class);

            $doctrineSettings = $setting->get('doctrine');

            $config = Setup::createAnnotationMetadataConfiguration(
                $doctrineSettings['entity_path'],
                $doctrineSettings['auto_generate_proxies'],
                $doctrineSettings['proxy_dir'],
                $doctrineSettings['cache'],
                FALSE
            );

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

        # SignUpHandler
        RequestHandlerInterface::class => function (ContainerInterface $c) {
            return new SignUpHandler(
                $c->get(RequestData::class),
                $c->get(UserRepository::class),
                $c->get(Flusher::class),
                $c->get(PasswordService::class),
            );
        },

    ]);

};
