<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Infrastructure\Repository;


use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;
use Webmozart\Assert\Assert;

class DoctrineUserRepository extends EntityRepository
{
    /**
     * @param User $user
     * @throws ORMException
     */
    public function add(User $user): void
    {
        $this->_em->persist($user);
    }

    /**
     * @param User $user
     * @throws ORMException
     */
    public function remove(User $user): void
    {
        $this->_em->remove($user);
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
        Assert::notEmpty($email);
        /** @var User|null $user */
        $user =  $this->findOneBy(['email' => $email]);
        return $user;
    }
}