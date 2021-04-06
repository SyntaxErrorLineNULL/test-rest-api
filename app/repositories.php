<?php
declare(strict_types=1);

use App\Core\Domain\User\UserRepository;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use DI\ContainerBuilder;

use function DI\factory;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => factory(InMemoryUserRepository::class),
        \App\Core\Domain\Repository\UserRepository::class => factory(\App\Infrastructure\Repository\DoctrineUserRepository::class)
    ]);
};
