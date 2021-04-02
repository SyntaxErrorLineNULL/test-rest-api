<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use App\Infrastructure\Repository\DoctrineUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

return [
    UserRepository::class => function (ContainerInterface $c) {
        /** @var EntityManagerInterface $em */
        $em = $c->get(EntityManagerInterface::class);

        /** @var EntityRepository<User> $entity */
        $entity = $c->get(User::class);
        return new DoctrineUserRepository($entity, $em);
    },


];