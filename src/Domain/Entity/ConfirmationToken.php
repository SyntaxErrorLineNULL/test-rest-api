<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Domain\Entity;


use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DoctrineUserRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="confirmation_token")
 */
class ConfirmationToken
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer",nullable=false)
     * @var int
     */
    public int $id;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    public string $value;

    /**
     * @ORM\Column(type="datetime_immutable",nullable=true)
     * @var DateTimeImmutable|null
     */
    public ?DateTimeImmutable $createAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @var User
     */
    public User $userId;

    /**
     * ConfirmationToken constructor.
     * @param string $value
     * @param User $userId
     */
    public function __construct(string $value, User $userId)
    {
        $this->value = $value;
        $this->userId = $userId;

        $this->createAt = new DateTimeImmutable();
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function isEqualTo(string $value): bool
    {
        return $this->value === $value;
    }

    private function isExpiredTo(DateTimeImmutable $time): bool
    {
        return $this->createAt <= $time;
    }

}