<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Handlers\Auth\SignUp;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\AccessorOrder;

/**
 * @AccessorOrder("custom", custom = {"email","name","password"})
 * @Serializer\ExclusionPolicy("all")
 */
class SignUpRequest
{
    /**
     * @Serializer\Expose()
     * @Serializer\Type("string")
     * @var string
     */
    public string $email;
    /** TODO: validate email and password */

    /**
     * @Serializer\Expose()
     * @Serializer\Type("string")
     * @var string
     */
    public string $name;

    /**
     * @Serializer\Expose()
     * @Serializer\Type("string")
     * @var string
     */
    public string $password;
}