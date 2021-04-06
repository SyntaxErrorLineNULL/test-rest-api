<?php
declare(strict_types=1);

use App\Application\Domain\Entities\ConfirmationToken;
use App\Application\Domain\Repository\UserRepository;
use App\Application\Infrastructure\Repository\DoctrineConfirmationToken;
use App\Application\Infrastructure\Repository\DoctrineUserRepository;
use App\Core\Service\Container;
use Doctrine\ORM\EntityManager;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\App;
use Slim\Factory\AppFactory;

return function (Container $container) : void
{
    $container[App::class] = function(ContainerInterface $container) {
        AppFactory::setContainer($container);
        return AppFactory::create();
    };

    $container[LoggerInterface::class] = function (Container $container) {
        $settings = $container->get('settings');
        $loggerSettings = $settings->get('logger');
        $logger = new Logger($loggerSettings['name']);

        $processor = new UidProcessor();
        $logger->pushProcessor($processor);

        $logger->pushHandler(new StreamHandler($loggerSettings['path'], $loggerSettings['level']));

        return $logger;
    };

    $container[UserRepository::class] = function (Container $container) {
        $em = $container->get(EntityManager::class);
        return new DoctrineUserRepository($em);
    };

    $container[ConfirmationToken::class] = function (Container $container) {
        $em = $container->get(EntityManager::class);
        return new DoctrineConfirmationToken($em);
    };
};
