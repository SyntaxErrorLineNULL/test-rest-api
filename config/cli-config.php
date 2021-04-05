<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\FilesystemCache;
use Dotenv\Dotenv;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require __DIR__ . './../vendor/autoload.php';

$dotEnv = Dotenv::createImmutable(__DIR__ . '/..');
$dotEnv->load();

$settings = require 'settings.php';
$doctrineSettings = $settings['settings']['doctrine'];

$config= Setup::createAnnotationMetadataConfiguration(
    $doctrineSettings['entity_path'],
    $doctrineSettings['auto_generate_proxies'],
    $doctrineSettings['proxy_dir'],
    $doctrineSettings['cache'],
    FALSE
);

$em = EntityManager::create($doctrineSettings['connection'], $config);

return ConsoleRunner::createHelperSet($em);