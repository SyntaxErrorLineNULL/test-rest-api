<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Core\Http\Validator;


use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator
{
    private ValidatorInterface $validator;

    /**
     * SymfonyRequestValidator constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param object $request
     * @throws ValidationException
     */
    public function validate(object $request): void
    {
        $violations = $this->validator->validate($request);
        if ($violations->count() > 0) {
            throw new ValidationException($violations);
        }
    }
}