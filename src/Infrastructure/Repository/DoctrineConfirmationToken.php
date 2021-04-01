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
    private EntityRepository $repositoryClass;
    private EntityManagerInterface $em;

    /**
     * DoctrineConfirmationToken constructor.
     * @param EntityRepository $repositoryClass
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityRepository $repositoryClass, EntityManagerInterface $em)
    {
        $this->repositoryClass = $repositoryClass;
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
        $confirmToken =  $this->repositoryClass->findOneBy(['value' => $token]);
        return $confirmToken;
    }
}