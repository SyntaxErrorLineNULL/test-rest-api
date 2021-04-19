<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Infrastructure\Repository;


use App\Application\Domain\DomainException\DomainRecordNotFoundException;
use App\Application\Domain\Entity\User;
use App\Application\Domain\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineUserRepository implements UserRepository
{

    private EntityRepository $repository;
    private EntityManagerInterface $_em;

    /**
     * DoctrineUserRepository constructor.
     * @param EntityRepository $repository
     * @param EntityManagerInterface $_em
     */
    public function __construct(EntityManagerInterface $_em, EntityRepository $repository)
    {
        $this->_em = $_em;
        $this->repository = $repository;
    }

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
     * @param int $id
     * @return \App\Application\Domain\Entity\User
     */
    public function getById(int $id): User
    {
        /** @var User|null $user */
        $user = $this->repository->find($id);
        if ($user === null) {
            throw new DomainRecordNotFoundException('User is not found');
        }
        return $user;
    }

    /**
     * @param string $email
     * @return \App\Application\Domain\Entity\User|null
     */
    public function findByEmail(string $email): ?User
    {
        /** @var User|null $user */
        $user =  $this->repository->findOneBy(['email' => $email]);
        return $user;
    }

    /**
     * @param string $email
     * @param string $password
     * @return \App\Application\Domain\Entity\User|null
     */
    public function findByEmailAndPassword(string $email, string $password): ?User
    {
        /** @var User|null $user */
        $user =  $this->repository->findOneBy(['email' => $email, 'password' => $password]);
        return $user;
    }
}