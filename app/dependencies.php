<?php
declare(strict_types=1);

use App\Application\Actions\Auth\SignUp\SignUpHandler;
use App\Application\Domain\Entities\ConfirmationToken;
use App\Application\Domain\Repository\UserRepository;
use App\Application\Infrastructure\Repository\DoctrineConfirmationToken;
use App\Application\Infrastructure\Repository\DoctrineUserRepository;
use App\Core\Service\Container;
use App\Core\Service\PasswordService;
use App\Core\Service\RequestData;
use Doctrine\ORM\EntityManager;
use JMS\Serializer\SerializerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
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

    $container[UserRepository::class] = function (Container $container): DoctrineUserRepository {
        $em = $container->get(EntityManager::class);
        return new DoctrineUserRepository($em);
    };

    $container[ConfirmationToken::class] = function (Container $container): DoctrineConfirmationToken {
        $em = $container->get(EntityManager::class);
        return new DoctrineConfirmationToken($em);
    };

    /*$container[RequestData::class] = function (Container $container) {
        $serializerBuilder = $container->get(SerializerBuilder::class);
        return new RequestData($serializerBuilder);
    };*/

    $container[SignUpHandler::class] = function (Container $container): RequestHandlerInterface {
        return new SignUpHandler(
            $container->get(PasswordService::class)
        );
    };
};
