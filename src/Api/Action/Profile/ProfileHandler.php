<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Api\Action\Profile;


use App\Core\Http\Authentication;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ProfileHandler implements RequestHandlerInterface
{
    use Authentication;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $this->authIdentityId($request);

        return new JsonResponse([$id]);
    }
}