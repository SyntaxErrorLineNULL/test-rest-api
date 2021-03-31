<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Domain\Repository;


use App\Domain\Entity\ConfirmationToken;

interface ConfirmationTokenRepository
{
    /**
     * @param ConfirmationToken $token
     */
    public function add(ConfirmationToken $token): void;

    /**
     * @param ConfirmationToken $token
     */
    public function remove(ConfirmationToken $token): void;

    /**
     * @param string $token
     * @return ConfirmationToken|null
     */
    public function findByToken(string $token): ?ConfirmationToken;
}