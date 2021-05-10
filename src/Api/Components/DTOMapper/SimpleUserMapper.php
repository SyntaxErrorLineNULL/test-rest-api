<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Api\Components\DTOMapper;


use App\Api\Components\DTO\SimpleUser;
use App\Application\Domain\Entity\User as UserEntity;
use App\Core\Service\DateFormat;

class SimpleUserMapper
{
    use DateFormat;

    /**
     * @param UserEntity $entity
     * @return SimpleUser
     */
    public function map(UserEntity $entity): SimpleUser
    {
        return new SimpleUser(
            $entity->name,
            $entity->email,
            $this->dateFormat($entity->createdAt)
        );
    }
}