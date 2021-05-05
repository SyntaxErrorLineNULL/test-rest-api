<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Api\Components\Validator\Name;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Name extends Constraint
{
    public string $message = '';
}