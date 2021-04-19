<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;

return function (ContainerInterface $container) {
    $app = AppFactory::createFromContainer($container);
    (require __DIR__ . '/middleware.php')($app);
    (require __DIR__ . '/routes.php')($app);
    return $app;
};