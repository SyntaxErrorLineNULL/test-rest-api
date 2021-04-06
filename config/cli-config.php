<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use DI\Container;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

/** @var Container $container */
$container = require_once __DIR__ . '/../app/container.php';

$entityManager = $container->get(EntityManagerInterface::class);

return ConsoleRunner::createHelperSet($entityManager);