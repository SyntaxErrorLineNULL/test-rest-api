<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Core\Http;


use App\Api\Components\Auth\AuthenticationId;
use Psr\Http\Message\ServerRequestInterface;

trait Authentication
{
    /**
     * @param ServerRequestInterface $request
     * @return AuthenticationId
     */
    public function getAttribute(ServerRequestInterface $request): AuthenticationId
    {
        return $request->getAttribute(AuthenticationId::ATTRIBUTE);
    }

    /**
     * @param ServerRequestInterface $request
     * @return int
     */
    public function getId(ServerRequestInterface $request): int
    {
        $user = $this->getAttribute($request);
        return $user->id();
    }
}