<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Infrastructure\Repository;


use App\Application\Domain\DomainException\DomainRecordNotFoundException;
use App\Application\Domain\Entities\User;
use App\Application\Domain\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ObjectRepository;

class DoctrineUserRepository implements UserRepository
{
    private EntityManagerInterface $_em;
    /** @var ObjectRepository|EntityRepository<User> */
    private ObjectRepository $entity;

    /**
     * DoctrineUserRepository constructor.
     * @param EntityManagerInterface $_em
     */
    public function __construct(EntityManagerInterface $_em)
    {
        $this->_em = $_em;
        $this->entity = $_em->getRepository(User::class);
    }

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
        $user = $this->entity->find($id);
        if ($user === null) {
            throw new DomainRecordNotFoundException('User is not found');
        }
        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        /** @var User|null $user */
        $user =  $this->entity->findOneBy(['email' => $email]);
        return $user;
    }

    public function findByEmailAndPassword(string $email, string $password): ?User
    {
        /** @var User|null $user */
        $user =  $this->entity->findOneBy(['email' => $email, 'password' => $password]);
        return $user;
    }
}