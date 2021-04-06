<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();

// Set up settings
$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);

// Set up doctrine
$doctrine = require __DIR__ . '/../app/bootstrap.php';
$doctrine($containerBuilder);

// Set up repositories
$repositories = require __DIR__ . '/../app/repositories.php';
$repositories($containerBuilder);

// Build PHP-DI Container instance
return $containerBuilder->build();