<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Domain\Entity;


use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use DomainException;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="confirmation_token")
 */
class ConfirmationToken
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int|null
     */
    public ?int $id = null;

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
}