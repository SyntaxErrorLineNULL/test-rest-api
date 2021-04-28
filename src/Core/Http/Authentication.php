<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Core\Http;


use App\Api\Other\Auth\AuthenticationId;
use Psr\Http\Message\ServerRequestInterface;

trait Authentication
{
    /**
     * @param ServerRequestInterface $request
     * @return AuthenticationId
     */
    public function authIdentity(ServerRequestInterface $request): AuthenticationId
    {
        return $request->getAttribute(AuthenticationId::REQUEST_ATTRIBUTE);
    }

    /**
     * @param ServerRequestInterface $request
     * @return int
     */
    public function authIdentityId(ServerRequestInterface $request): int
    {
        $user = $this->authIdentity($request);
        return (int)$user->id();
    }
}