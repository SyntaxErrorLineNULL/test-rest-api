<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Domain\Repository;


use App\Application\Domain\Entity\User;

interface UserRepository
{
    /**
     * @param User $user
     */
    public function add(User $user): void;

    /**
     * @param User $user
     */
    public function remove(User $user): void;

    /**
     * @param int $id
     * @return User
     */
    public function getById(int $id): User;

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;
}