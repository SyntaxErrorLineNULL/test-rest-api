<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Api\Components\DTO;


class SimpleUser
{
    public string $name;

    public string $email;

    public string $createdAt;

    /**
     * SimpleUser constructor.
     * @param string $name
     * @param string $email
     * @param string $createdAt
     */
    public function __construct(string $name, string $email, string $createdAt)
    {
        $this->name = $name;
        $this->email = $email;
        $this->createdAt = $createdAt;
    }

}