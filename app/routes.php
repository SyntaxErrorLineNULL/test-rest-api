<?php
declare(strict_types=1);

use App\Application\Actions\Auth\SignUp\SignUpHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });


    $app->post('/name', function (Request $request, Response $response, $args): Response {
        $data = $request->getBody()->getContents();
        $html = var_export($data, true);
        $response->getBody()->write($html);
        return $response;
    });

    $app->group('/api', function (Group $group) {
        $group->post('/sign_up', SignUpHandler::class);
    });
};
