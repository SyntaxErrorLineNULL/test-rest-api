<?php
declare(strict_types=1);

use Dotenv\Dotenv;
use Psr\Container\ContainerInterface;

require __DIR__ . '/../vendor/autoload.php';

// load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

/** @var ContainerInterface $container */
$container = require __DIR__ . '/../app/container.php';

$app = (require __DIR__ . '/../app/application.php')($container);
$app->run();