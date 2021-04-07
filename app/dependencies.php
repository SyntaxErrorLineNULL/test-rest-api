<?php
declare(strict_types=1);

use App\Application\Actions\Auth\SignUp\SignUpHandler;
use App\Application\Domain\Repository\ConfirmationTokenRepository;
use App\Application\Domain\Repository\UserRepository;
use App\Application\Infrastructure\Repository\DoctrineConfirmationToken;
use App\Application\Infrastructure\Repository\DoctrineUserRepository;
use App\Application\Settings\PasswordServiceInterface;
use App\Application\Settings\SettingsInterface;
use App\Core\Service\Container;
use App\Core\Service\PasswordService;
use App\Core\Service\RequestData;
use DI\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Slim\App;
use Slim\Factory\AppFactory;


return static function (Container $container) : void
{
    $container[App::class] = function(ContainerInterface $container) {
        AppFactory::setContainer($container);
        return AppFactory::create();
    };

    $container[LoggerInterface::class] = static function (Container $container) {
        $settings = $container->get('settings');
        $loggerSettings = $settings->get('logger');
        $logger = new Logger($loggerSettings['name']);

        $processor = new UidProcessor();
        $logger->pushProcessor($processor);

        $logger->pushHandler(new StreamHandler($loggerSettings['path'], $loggerSettings['level']));

        return $logger;
    };

    $container[EntityManager::class] = static function (Container $container): EntityManager {
        $settings = $container->get('settings')['doctrine'];

        $config = Setup::createAnnotationMetadataConfiguration(
            $settings['metadata_dirs'],
            $settings['auto_generate_proxies'],
            $settings['proxy_dir'],
            $settings['cache'],
            false
        );

        return EntityManager::create($settings['connection'], $config);
    };

    $container[UserRepository::class] = static function (Container $container): DoctrineUserRepository {
        $em = $container->get(EntityManager::class);
        return new DoctrineUserRepository($em);
    };

    $container[ConfirmationTokenRepository::class] = static function (Container $container): DoctrineConfirmationToken {
        $em = $container->get(EntityManager::class);
        return new DoctrineConfirmationToken($em);
    };

    /*$container[RequestData::class] = function (): RequestData {
        return new RequestData();
    };*/

    $container[PasswordService::class] = function (): PasswordService {
        return new PasswordService();
    };

    $container[SignUpHandler::class] = function (Container $container): RequestHandlerInterface {
        return new SignUpHandler(
            $container->get(PasswordService::class),
            $container->get(UserRepository::class)
        );
    };
};
