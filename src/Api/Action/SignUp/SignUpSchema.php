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
     * @Assert\NotBlank
     * @Assert\Email(message="Данный email '{{ value }}' является неверным",normalizer="strtolower")
     * @OA\Property
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