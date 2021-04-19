<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use App\Application\Domain\Entity\User;
use App\Application\Domain\Repository\UserRepository;
use App\Application\Infrastructure\Repository\DoctrineUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

return [
    UserRepository::class => function (ContainerInterface $container) {
        $em = $container->get(EntityManagerInterface::class);

        $repository = $em->getRepository(User::class);
        return new DoctrineUserRepository($em, $repository);
    }
];