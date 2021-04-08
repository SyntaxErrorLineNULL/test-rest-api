<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Infrastructure\Repository;


use App\Application\Domain\DomainException\DomainRecordNotFoundException;
use App\Application\Domain\Entities\User;
use App\Application\Domain\Entities\UserRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class DoctrineUserRepository extends EntityRepository implements UserRepository
{
    /**
     * @param User $user
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(User $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @param User $user
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(User $user): void
    {
        $this->_em->remove($user);
        $this->_em->flush();
    }

    /**
     * @param int $id
     * @return User
     * @throws DomainRecordNotFoundException
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

    public function findByEmail(string $email): ?User
    {
        /** @var User|null $user */
        $user =  $this->findOneBy(['email' => $email]);
        return $user;
    }

    public function findByEmailAndPassword(string $email, string $password): ?User
    {
        /** @var User|null $user */
        $user =  $this->findOneBy(['email' => $email, 'password' => $password]);
        return $user;
    }
}