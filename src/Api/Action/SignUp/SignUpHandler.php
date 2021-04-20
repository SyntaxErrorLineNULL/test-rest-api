<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Api\Action\SignUp;


use App\Application\Domain\DomainException\DomainNotEmptyEmailException;
use App\Application\Domain\Entity\User;
use App\Application\Domain\Repository\UserRepository;
use App\Application\Infrastructure\DoctrineFlusher;
use App\Core\Service\PasswordService;
use App\Core\Service\RequestSchema;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SignUpHandler implements RequestHandlerInterface
{
    private UserRepository $userRepository;
    private PasswordService $passwordService;
    private DoctrineFlusher $flusher;
    private RequestSchema $schema;

    /**
     * SignUpHandler constructor.
     * @param UserRepository $userRepository
     * @param PasswordService $passwordService
     * @param DoctrineFlusher $flusher
     * @param RequestSchema $schema
     */
    public function __construct(UserRepository $userRepository, PasswordService $passwordService, DoctrineFlusher $flusher, RequestSchema $schema)
    {
        $this->userRepository = $userRepository;
        $this->passwordService = $passwordService;
        $this->flusher = $flusher;
        $this->schema = $schema;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var SignUpSchema $requestSchema */
        $requestSchema = $this->schema->deserializeBySchema($request, SignUpSchema::class);

        $user = $this->userRepository->findByEmail($requestSchema->email);
        if ($user !== null) {
            throw new DomainNotEmptyEmailException('this email is already in use');
        }

        $user = new User($requestSchema->email, $requestSchema->name, $requestSchema->password, $this->passwordService);

        $this->userRepository->add($user);
        $this->flusher->flush();

        return new EmptyResponse(201);
    }
}