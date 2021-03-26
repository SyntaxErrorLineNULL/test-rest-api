<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Core\Service;


use RuntimeException;

class PasswordService
{
    private int $value;

    /**
     * PasswordService constructor.
     * @param int $value
     */
    public function __construct(int $value = PASSWORD_ARGON2_DEFAULT_MEMORY_COST)
    {
        $this->value = $value;
    }

    /**
     * @param string $password
     * @return string
     */
    public function hash(string $password): string
    {
        $hash = '';

        if (!empty($password)) {
            throw new RuntimeException('Password is empty');
        }

        $hash = password_hash($password, PASSWORD_ARGON2ID, [
            'value' => $this->value
        ]);

        return $hash;
    }

    /**
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function validate(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}