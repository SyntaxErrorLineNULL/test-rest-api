<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Infrastructure\Repository;


use App\Application\Domain\Entity\User;
use App\Application\Domain\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;

class DoctrineUserRepository extends EntityRepository implements UserRepository
{

    /**
     * @inheritDoc
     * @throws \Doctrine\ORM\ORMException
     */
    public function add(User $user): void
    {
        $this->_em->persist($user);
    }

    /**
     * @param User $user
     * @throws \Doctrine\ORM\ORMException
     */
    public function remove(User $user): void
    {
        $this->_em->remove($user);
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): User
    {
        /** @var User|null $user */
        $user = $this->find($id);
        if ($user === null) {
            throw new DomainRecordNotFoundException('User is not found');
        }
        return $user;
    }

    /**
     * @inheritDoc
     */
    public function findByEmail(string $email): ?User
    {
        // TODO: Implement findByEmail() method.
    }

    /**
     * @inheritDoc
     */
    public function findByEmailAndPassword(string $email, string $password): ?User
    {
        // TODO: Implement findByEmailAndPassword() method.
    }
}