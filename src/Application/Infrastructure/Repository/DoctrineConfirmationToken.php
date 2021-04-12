<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Infrastructure\Repository;


use App\Application\Domain\Entity\ConfirmationToken;
use App\Application\Domain\Repository\ConfirmationTokenRepository;
use Doctrine\ORM\EntityRepository;

class DoctrineConfirmationToken extends EntityRepository implements ConfirmationTokenRepository
{

    /**
     * @param \App\Application\Domain\Entity\ConfirmationToken $token
     * @throws \Doctrine\ORM\ORMException
     */
    public function add(ConfirmationToken $token): void
    {
        $this->_em->persist($token);
    }

    /**
     * @param \App\Application\Domain\Entity\ConfirmationToken $token
     * @throws \Doctrine\ORM\ORMException
     */
    public function remove(ConfirmationToken $token): void
    {
        $this->_em->remove($token);
    }

    /**
     * @param string $token
     * @return \App\Application\Domain\Entity\ConfirmationToken|null
     */
    public function findByToken(string $token): ?ConfirmationToken
    {
        /** @var ConfirmationToken|null $confirmToken */
        $confirmToken =  $this->findOneBy(['value' => $token]);
        return $confirmToken;
    }
}