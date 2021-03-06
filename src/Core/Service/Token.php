<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Core\Service;


class Token
{
    public string $token;

    /**
     * Token constructor.
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

}