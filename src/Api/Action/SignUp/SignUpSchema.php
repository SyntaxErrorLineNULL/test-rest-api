<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Api\Action\SignUp;


use App\Api\Components\Validator\Password\Password;
use Symfony\Component\Validator\Constraints as Assert;

class SignUpSchema
{
    /**
     * @Assert\NotBlank
     * @Assert\Email(message="Данный email '{{ value }}' является неверным")
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