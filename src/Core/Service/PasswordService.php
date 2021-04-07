<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Core\Service;

use App\Application\Settings\PasswordServiceInterface;
use Webmozart\Assert\Assert;

use RuntimeException;

class PasswordService implements PasswordServiceInterface
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
        Assert::notEmpty($password);

        $hash = password_hash($password, PASSWORD_ARGON2ID, [
            'value' => $this->value
        ]);

        if ($hash === null || $hash === false) {
            throw new RuntimeException('Invalid hash algorithm');
        }

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