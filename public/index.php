<?php
declare(strict_types=1);

# https://github.com/akrabat/slim4-pimple/blob/master/public/index.php - this pimple example

use App\Application\ResponseEmitter\ResponseEmitter;
use Pimple\Container;
use Pimple\Psr11\Container as Psr11Container;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

require __DIR__ . '/../vendor/autoload.php';

$settings = require __DIR__ . '/../app/settings.php';

/**
 * Small container
 */
$container = new Container(['settings' => $settings]);

// Instantiate the app
$app = AppFactory::create(null, new Psr11Container($container));
$callableResolver = $app->getCallableResolver();

// Set up dependencies
$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($container);

// Register middleware
$middleware = require __DIR__ . '/../app/middleware.php';
#$middleware($app);

// Register routes
$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

// Create Request object from globals
$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();


// Add Routing Middleware
$app->addRoutingMiddleware();

// Run App & Emit Response
$response = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);