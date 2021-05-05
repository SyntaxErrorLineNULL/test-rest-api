<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Infrastructure\Repository;


use App\Application\Domain\Entity\ConfirmationToken;
use App\Application\Domain\Repository\ConfirmationTokenRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

class DoctrineConfirmationToken extends EntityRepository implements ConfirmationTokenRepository
{
    /**
     * @param ConfirmationToken $token
     * @throws ORMException
     */
    public function add(ConfirmationToken $token): void
    {
        $this->_em->persist($token);
    }

    /**
     * @param ConfirmationToken $token
     * @throws ORMException
     */
    public function remove(ConfirmationToken $token): void
    {
        $this->_em->remove($token);
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