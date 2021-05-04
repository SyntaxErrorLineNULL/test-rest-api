<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Api\Action\SignUp;


use App\Api\Other\Validator\Password\Password;

class SignUpSchema
{
    /**
     *
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public string $name;

    /**
     * @Password()
     * @var string
     */
    public string $password;
}