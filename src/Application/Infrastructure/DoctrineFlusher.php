<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Infrastructure;


use Doctrine\ORM\EntityManagerInterface;

class DoctrineFlusher
{
    private EntityManagerInterface $entityManager;

    /**
     * DoctrineFlusher constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}