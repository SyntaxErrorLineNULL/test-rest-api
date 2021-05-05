<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Api\Components\Auth;


use App\Core\Service\JWTService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface;

class AuthenticationMiddleware implements Middleware
{
    private JWTService $JWTService;

    /**
     * AuthenticationMiddleware constructor.
     * @param JWTService $JWTService
     */
    public function __construct(JWTService $JWTService)
    {
        $this->JWTService = $JWTService;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->hasHeader('Authorization')) {
            $header = $request->getHeaderLine('Authorization');
            $request = $this->getAuthenticationToken($header, $request);
        } else {
            $request = $request->withAttribute(AuthenticationId::ATTRIBUTE, new AuthenticationId(null));
        }

        return $handler->handle($request);
    }

    /**
     * @param string $authorizationHeader
     * @param ServerRequestInterface $request
     * @return ServerRequestInterface
     */
    private function getAuthenticationToken(string $authorizationHeader, ServerRequestInterface $request): ServerRequestInterface
    {
        $token = $this->JWTService->decode($authorizationHeader);
        return $request->withAttribute(AuthenticationId::ATTRIBUTE, new AuthenticationId($token->id));
    }
}