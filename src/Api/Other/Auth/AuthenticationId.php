<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Api\Other\Auth;


class AuthenticationId
{
    const REQUEST_ATTRIBUTE = "userId";

    private ?int $id;

    /**
     * Identity constructor.
     * @param int|null $id
     */
    public function __construct(?int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }
}