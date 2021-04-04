<?php
declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use DI\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
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

        RequestHandlerInterface::class => function (ContainerInterface $c) {
            return new \App\Application\Handlers\Auth\SignUp\SignUpHandler(
                $c->get(\App\Core\Service\RequestData::class),
                $c->get(UserRepository::class),
                $c->get(\App\Core\Service\PasswordService::class)
            );
        }
    ]);

};
