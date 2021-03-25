<?php


namespace App\Application\Handlers\SignIn;


use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SignInHandler implements RequestHandlerInterface
{

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getBody();

        $body = json_decode($data, true);

        return new JsonResponse([$body]);
    }
}