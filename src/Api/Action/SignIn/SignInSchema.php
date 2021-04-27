<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Api\Action\SignIn;


class SignInSchema
{
    /**
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public string $password;
}