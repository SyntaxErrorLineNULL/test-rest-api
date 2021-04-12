<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Psr\Container\ContainerInterface;

require 'vendor/autoload.php';

/** @var ContainerInterface $container */
$container = require __DIR__ . '/../app/container.php';

// replace with mechanism to retrieve EntityManager in your app
$entityManager = $container->get(EntityManagerInterface::class);

return ConsoleRunner::createHelperSet($entityManager);