<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Settings;

interface PasswordServiceInterface
{
    /**
     * @param string $password
     * @return string
     */
    public function hash(string $password): string;

    /**
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function validate(string $password, string $hash): bool;
}