<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Settings;

use Doctrine\ORM\EntityManager;

class Flusher
{
    private EntityManager $em;

    /**
     * Flusher constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function flusher(): void
    {
        $this->em->flush();
    }

}