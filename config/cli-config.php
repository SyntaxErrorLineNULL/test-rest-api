<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;

$settings = require 'settings.php';
$doctrineSettings = $settings['doctrine'];

$config = Setup::createAnnotationMetadataConfiguration(
    $doctrineSettings['metadata_dirs'],
    $doctrineSettings['auto_generate_proxies'],
);


$entityManager = EntityManager::create($doctrineSettings['connection'], $config);

return ConsoleRunner::createHelperSet($entityManager);