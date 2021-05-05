<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use App\Api\Components\Auth\AuthenticationMiddleware;
use App\Core\Http\Middleware\ValidationExceptionHandler;
use Slim\App;

return function (App $app) {
    $app->add(ValidationExceptionHandler::class);
    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();
    $app->add(AuthenticationMiddleware::class);
};