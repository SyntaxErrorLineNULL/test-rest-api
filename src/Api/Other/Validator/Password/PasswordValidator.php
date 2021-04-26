<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Api\Other\Validator\Password;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PasswordValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        if ($value !== null) {
            if (preg_match('/^(?=.*\d)(?=.*[A-z])(?=.*[A-z])(?=.*[a-zA-Z]).{5,16}$/', $value) !== 1) {
                /** @var Password $constraint */
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }
}