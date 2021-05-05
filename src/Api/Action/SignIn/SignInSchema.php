<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Api\Action\SignIn;


use Symfony\Component\Validator\Constraints as Assert;

class SignInSchema
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
    public string $password;
}