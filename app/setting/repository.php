<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use App\Application\Domain\Entity\ConfirmationToken;
use App\Application\Domain\Entity\User;
use App\Application\Domain\Repository\ConfirmationTokenRepository;
use App\Application\Domain\Repository\UserRepository;
use App\Application\Infrastructure\Repository\DoctrineConfirmationToken;
use App\Application\Infrastructure\Repository\DoctrineUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

return [
    UserRepository::class => function (ContainerInterface $container): DoctrineUserRepository {
        $em = $container->get(EntityManagerInterface::class);

        $entity = $em->getMetadataFactory()->getMetadataFor(User::class);
        return new DoctrineUserRepository($em, $entity);
    },

    ConfirmationTokenRepository::class => function (ContainerInterface $container) {
        $em = $container->get(EntityManagerInterface::class);

        $entity = $em->getMetadataFactory()->getMetadataFor(ConfirmationToken::class);
        return new DoctrineConfirmationToken($em, $entity);
    }
];