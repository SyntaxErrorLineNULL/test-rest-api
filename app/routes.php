<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use App\Api\Action\SignUp\SignUpHandler;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->group('/api', function (Group $group) {
        $group->post('/sign_up', SignUpHandler::class);
    });
};