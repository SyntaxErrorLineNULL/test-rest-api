<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Api\Action\SignUp;


use App\Api\Action\Other\Token;
use App\Application\Domain\DomainException\DomainNotEmptyEmailException;
use App\Application\Domain\Entity\ConfirmationToken;
use App\Application\Domain\Entity\User;
use App\Application\Domain\Repository\ConfirmationTokenRepository;
use App\Application\Domain\Repository\UserRepository;
use App\Application\Infrastructure\DoctrineFlusher;
use App\Core\Service\JWTService;
use App\Core\Service\PasswordService;
use App\Core\Service\RequestSchema;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ramsey\Uuid\Uuid;

class SignUpHandler implements RequestHandlerInterface
{
    private UserRepository $userRepository;
    private ConfirmationTokenRepository $confirmationTokenRepository;
    private PasswordService $passwordService;
    private DoctrineFlusher $flusher;
    private RequestSchema $schema;

    /**
     * SignUpHandler constructor.
     * @param UserRepository $userRepository
     * @param ConfirmationTokenRepository $confirmationTokenRepository
     * @param PasswordService $passwordService
     * @param DoctrineFlusher $flusher
     * @param RequestSchema $schema
     */
    public function __construct(UserRepository $userRepository, ConfirmationTokenRepository $confirmationTokenRepository, PasswordService $passwordService, DoctrineFlusher $flusher, RequestSchema $schema)
    {
        $this->userRepository = $userRepository;
        $this->confirmationTokenRepository = $confirmationTokenRepository;
        $this->passwordService = $passwordService;
        $this->flusher = $flusher;
        $this->schema = $schema;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws DomainNotEmptyEmailException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var SignUpSchema $requestSchema */
        $requestSchema = $this->schema->deserializeBySchema($request, SignUpSchema::class);

        $user = $this->userRepository->findByEmail($requestSchema->email);
        if ($user !== null) {
            /** TODO: new exception */
            throw new DomainNotEmptyEmailException('this email is already in use');
        }

        $user = new User($requestSchema->email, $requestSchema->name, $requestSchema->password, $this->passwordService);
        $token = Uuid::uuid4()->toString();
        $confirmationToken = new ConfirmationToken($token, $user);

        $this->userRepository->add($user);
        $this->confirmationTokenRepository->add($confirmationToken);

        $this->flusher->flush();

        return new JsonResponse(new Token($token), 201);
    }
}