<?php
declare(strict_types=1);

use App\Application\Domain\User\UserRepository;
use App\Application\Infrastructure\Persistence\User\InMemoryUserRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
        \App\Application\Domain\Repository\UserRepository::class => \DI\factory(\App\Application\Infrastructure\DoctrineRepositoryFactory::class)
    ]);
};
