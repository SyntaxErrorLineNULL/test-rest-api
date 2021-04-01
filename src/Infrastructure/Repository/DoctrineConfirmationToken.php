<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Infrastructure\Repository;


use App\Domain\Entity\ConfirmationToken;
use App\Domain\Repository\ConfirmationTokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineConfirmationToken implements ConfirmationTokenRepository
{

    /** @var EntityRepository<ConfirmationToken> */
    private EntityRepository $entityClass;
    private EntityManagerInterface $em;

    /**
     * DoctrineConfirmationToken constructor.
     * @param EntityRepository<ConfirmationToken> $entityClass
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityRepository $entityClass, EntityManagerInterface $em)
    {
        $this->entityClass = $entityClass;
        $this->em = $em;
    }

    /**
     * @param ConfirmationToken $token
     */
    public function add(ConfirmationToken $token): void
    {
        $this->em->persist($token);
    }

    /**
     * @param ConfirmationToken $token
     */
    public function remove(ConfirmationToken $token): void
    {
        $this->em->remove($token);
    }

    public function findByToken(string $token): ?ConfirmationToken
    {
        /** @var ConfirmationToken|null $confirmToken */
        $confirmToken =  $this->entityClass->findOneBy(['value' => $token]);
        return $confirmToken;
    }
}