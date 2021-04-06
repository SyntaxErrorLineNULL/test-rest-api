<?php
declare(strict_types=1);

use App\Core\Http\Handler\RequestHandler;
use App\Core\Service\Container;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
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
 *
 */
$app->getRouteCollector()->setDefaultInvocationStrategy(new RequestHandler());

/**
 * Set up dependencies
 */
$dependencyFactory = require __DIR__ . '/../app/dependencies.php';
$dependencyFactory($container);

/**
 * Register middleware
 */
$middlewares = require __DIR__ . '/../app/middleware.php';


/**
 * Register route factory
 */
$routeFactory = require __DIR__ . '/../app/routes.php';
$routeFactory($app);

/** TODO create ErrorAction */

$requestCreator = new ServerRequestCreator(
    $psrFactory, # ServerRequestFactory
    $psrFactory, # UriFactory
    $psrFactory, # UploadedFileFactory
    $psrFactory  # StreamFactory
);

$app->addRoutingMiddleware();
$app->run($requestCreator->fromGlobals());