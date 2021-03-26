<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Core\Service;

use Firebase\JWT\JWT;
use Webmozart\Assert\Assert;

class JWTService
{
    private string $token;

    /**
     * JWTService constructor.
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function encode(array $value): string
    {
        Assert::notEmpty($value);
        return JWT::encode($value, $this->token, 'RS256');
    }

    public function decode(string $key): object
    {
        Assert::notEmpty($key);
        return JWT::decode($key, $this->token, ['RS256']);
    }

}