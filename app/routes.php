<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use App\Api\Action\ConfirmEmail\ConfirmEmailHandler;
use App\Api\Action\Profile\ProfileHandler;
use App\Api\Action\SignIn\SignInHandler;
use App\Api\Action\SignUp\SignUpHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    $app->post('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/api', function (Group $group) {
        $group->post('/sign_up', SignUpHandler::class);
        $group->post('/confirm_email', ConfirmEmailHandler::class);
        $group->post('/sign_in', SignInHandler::class);
        $group->get('/profile', ProfileHandler::class);
    });
};