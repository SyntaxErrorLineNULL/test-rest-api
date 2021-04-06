<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Infrastructure\Repository;


use App\Core\Domain\DomainException\DomainRecordNotFoundException;
use App\Application\Entities\User;
use App\Core\Domain\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

class DoctrineUserRepository extends EntityRepository implements UserRepository
{
    /**
     * @param User $user
     * @throws ORMException
     */
    public function add(User $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @param User $user
     * @throws ORMException
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

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        /** @var User|null $user */
        $user =  $this->findOneBy(['email' => $email]);
        return $user;
    }

    /**
     * @param string $email
     * @param string $password
     * @return User|null
     */
    public function findByEmailAndPassword(string $email, string $password): ?User
    {
        /** @var User|null $user */
        $user =  $this->findOneBy(['email' => $email, 'password' => $password]);
        return $user;
    }
}