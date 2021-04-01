<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Infrastructure\Repository;


use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineUserRepository implements UserRepository
{
    /** @var EntityRepository<User> */
    private EntityRepository $entityClass;
    private EntityManagerInterface $em;

    /**
     * DoctrineUserRepository constructor.
     * @param EntityRepository<User> $entityClass
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityRepository $entityClass, EntityManagerInterface $em)
    {
        $this->entityClass = $entityClass;
        $this->em = $em;
    }

    /**
     * @param User $user
     */
    public function add(User $user): void
    {
        $this->em->persist($user);
    }

    /**
     * @param User $user
     */
    public function remove(User $user): void
    {
        $this->em->remove($user);
    }

    /**
     * @param int $id
     * @return User
     * @throws DomainRecordNotFoundException
     */
    public function getById(int $id): User
    {
        /** @var User|null $user */
        $user = $this->entityClass->find($id);
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
        $user =  $this->entityClass->findOneBy(['email' => $email]);
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
        $user =  $this->entityClass->findOneBy(['email' => $email, 'password' => $password]);
        return $user;
    }
}