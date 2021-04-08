<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Infrastructure\Repository;


use App\Application\Domain\Repository\ConfirmationTokenRepository;
use Doctrine\ORM\EntityRepository;
use App\Application\Domain\Entities\ConfirmationToken;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class DoctrineConfirmationToken extends EntityRepository implements ConfirmationTokenRepository
{
    /**
     * @param ConfirmationToken $token
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ConfirmationToken $token): void
    {
        $this->_em->persist($token);
        $this->_em->flush();
    }

    /**
     * @param ConfirmationToken $token
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(ConfirmationToken $token): void
    {
        $this->_em->remove($token);
        $this->_em->flush();
    }

    /**
     * @param string $token
     * @return ConfirmationToken|null
     */
    public function findByToken(string $token): ?ConfirmationToken
    {
        /** @var ConfirmationToken|null $confirmToken */
        $confirmToken =  $this->findOneBy(['value' => $token]);
        return $confirmToken;
    }
}