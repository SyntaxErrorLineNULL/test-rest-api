<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Api\Components\Validator\Password;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Password extends Constraint
{
    public string $message = 'Неверно введен пароль, пароль должен содержать(минимум 1 число, буквы или спец символы и иметь длину от 5 до 16)';
}