<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use Dotenv\Dotenv;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Monolog\Logger;

require_once (__DIR__ . '../vendor/autoload.php');

$dotEnv = Dotenv::createImmutable(__DIR__ . '../');
$dotEnv->load();

$setting = require_once (__DIR__ . 'settings.php');
$doctrineSettings = $setting['doctrine'];

$config= Setup::createAnnotationMetadataConfiguration(
    $doctrineSettings['entity_path'],
    $doctrineSettings['auto_generate_proxies'],
    $doctrineSettings['proxy_dir'],
    $doctrineSettings['cache'],
    FALSE
);

$em = EntityManager::create($doctrineSettings['connection'], $config);

return ConsoleRunner::createHelperSet($em);