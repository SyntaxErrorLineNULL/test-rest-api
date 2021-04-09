<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Infrastructure;

use DI\Factory\RequestedEntry;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineRepositoryFactory
{
    public function __invoke(EntityManagerInterface $em, RequestedEntry $entry): \Doctrine\Persistence\ObjectRepository
    {
        // Entities MUST be defined in the same namespace as repositories.
        $entityClass = str_replace(["\\Repository\\", "Repository"], ["\\Entity\\", ""], $entry->getName());

        return $em->getRepository($entityClass);
    }
}