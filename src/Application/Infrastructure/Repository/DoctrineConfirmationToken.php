<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Infrastructure\Repository;


use App\Application\Domain\Repository\ConfirmationTokenRepository;
use App\Application\Domain\Entities\ConfirmationToken;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ObjectRepository;

class DoctrineConfirmationToken implements ConfirmationTokenRepository
{
    private EntityManager $em;
    /** @var ObjectRepository|EntityRepository<ConfirmationToken> */
    private ObjectRepository $entity;

    /**
     * DoctrineConfirmationToken constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->entity = $em->getRepository(ConfirmationToken::class);
    }

    /**
     * @param ConfirmationToken $token
     * @throws ORMException
     */
    public function add(ConfirmationToken $token): void
    {
        $this->em->persist($token);
        $this->em->flush();
    }

    /**
     * @param ConfirmationToken $token
     * @throws ORMException
     */
    public function remove(ConfirmationToken $token): void
    {
        $this->em->remove($token);
        $this->em->flush();
    }

    public function findByToken(string $token): ?ConfirmationToken
    {
        /** @var ConfirmationToken|null $confirmToken */
        $confirmToken =  $this->entity->findOneBy(['value' => $token]);
        return $confirmToken;
    }
}