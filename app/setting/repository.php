<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use App\Application\Domain\Entity\User;
use App\Application\Domain\Repository\UserRepository;
use App\Application\Infrastructure\Repository\DoctrineUserRepository;
use DI\ContainerBuilder;
use Doctrine\ORM\EntityManagerInterface;

return [
    UserRepository::class => function (\Psr\Container\ContainerInterface $container) {
        $em = $container->get(EntityManagerInterface::class);

        $repository = $em->getRepository(User::class);
        return new DoctrineUserRepository($em, $repository);
    }
];