<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Infrastructure\Repository;


use App\Domain\Entity\ConfirmationToken;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

class DoctrineConfirmationToken extends EntityRepository
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
}