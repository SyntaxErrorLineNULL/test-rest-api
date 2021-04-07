<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Infrastructure\Repository;


use App\Application\Domain\Repository\UserRepository;
use App\Core\Domain\DomainException\DomainRecordNotFoundException;
use App\Application\Domain\Entities\User;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ObjectRepository;

final class DoctrineUserRepository implements UserRepository
{
    private EntityManager $em;
    /** @var ObjectRepository|EntityRepository<User> */
    private ObjectRepository $entity;

    /**
     * DoctrineUserRepository constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->entity = $em->getRepository(UserRepository::class);
    }

    /**
     * @param User $user
     * @throws ORMException
     */
    public function add(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @param User $user
     * @throws ORMException
     */
    public function remove(User $user): void
    {
        $this->em->remove($user);
        $this->em->flush();
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

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        /** @var User|null $user */
        $user =  $this->entity->findOneBy(['email' => $email]);
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
        $user =  $this->entity->findOneBy(['email' => $email, 'password' => $password]);
        return $user;
    }
}