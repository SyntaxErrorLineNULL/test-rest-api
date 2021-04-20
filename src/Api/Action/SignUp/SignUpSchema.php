<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Api\Action\SignUp;

use Symfony\Component\Validator\Constraints as Assert;

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