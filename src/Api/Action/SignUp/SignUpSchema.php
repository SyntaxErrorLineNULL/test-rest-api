<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Api\Action\SignUp;


class SignUpSchema
{
    /**
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $password;
}