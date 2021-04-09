<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Domain\Entity;


use App\Application\Domain\Service\PasswordService;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Application\Infrastructure\Repository\DoctrineUserRepository;

/**
 * @ORM\Entity(repositoryClass=DoctrineUserRepository::class)
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer",nullable=false)
     * @var int
     */
    public int $id;

    /**
     * @ORM\Column(type="string",length=50)
     * @var string|null
     */
    public ?string $name;

    /**
     * @ORM\Column(type="string",nullable=false,length=32,options={"fixed"=true},unique=true)
     * @var string
     */
    public string $email;

    /**
     * @ORM\Column(type="text",nullable=false)
     * @var string
     */
    public string $password_hash;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    public bool $activated;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @var DateTimeImmutable|null
     */
    public ?DateTimeImmutable $createdAt;

    /**
     * User constructor.
     * @param string $email
     * @param string|null $name
     * @param string $password
     * @param PasswordService $passwordService
     */
    public function __construct(string $email, ?string $name, string $password, PasswordService $passwordService)
    {
        $this->email = $email;
        $this->name = $name;
        $this->password_hash = $passwordService->hash($password);
        $this->activated = false;
    }

    public function isActive(): void
    {
        $this->activated = true;
        $this->createdAt = new DateTimeImmutable();
    }
}