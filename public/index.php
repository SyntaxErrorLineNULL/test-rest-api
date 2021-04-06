<?php
declare(strict_types=1);

use App\Core\Service\Container;
use Nyholm\Psr7\Factory\Psr17Factory;
use Slim\App;

require __DIR__ . '/../vendor/autoload.php';

$setting = require __DIR__ . '/../app/settings.php';

/**
 * Small container
 */
$container = new Container($setting);

/**
 * Helper class to create PSR-7 server request
 */
$psrFactory = new Psr17Factory();

/**
 * Init application
 */
$app = new App($psrFactory, $container);

/**
 * Set up dependencies
 */
$dependencyFactory = require __DIR__ . '/../app/dependencies.php';
$dependencyFactory($container);

/**
 * Register middleware
 */
$middlewares = require __DIR__ . '/../app/middleware.php';
$app->add($middlewares);

/**
 * Register route factory
 */
$routeFactory = require __DIR__ . '/../app/routes.php';
$routeFactory($app);

/** TODO create ErrorAction */


$app->addRoutingMiddleware();
$app->run();