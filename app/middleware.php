<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use Slim\App;

return function (App $app) {
    $app->addBodyParsingMiddleware();
    $app->add(\App\Api\Other\Auth\AuthenticationMiddleware::class);
};