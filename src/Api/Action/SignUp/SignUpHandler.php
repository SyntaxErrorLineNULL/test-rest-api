<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Api\Action\SignUp;


use App\Api\Other\Exception\SignUpException;
use App\Application\Domain\Entity\ConfirmationToken;
use App\Application\Domain\Entity\User;
use App\Application\Domain\Repository\ConfirmationTokenRepository;
use App\Application\Domain\Repository\UserRepository;
use App\Application\Infrastructure\DoctrineFlusher;
use App\Application\Service\PasswordService;
use App\Core\Http\Request\RequestSchema;
use App\Core\Service\Token;
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
     * @throws SignUpException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var SignUpSchema $requestSchema */
        $requestSchema = $this->schema->deserializeBySchema($request, SignUpSchema::class);

        $user = $this->userRepository->findByEmail($requestSchema->email);
        if ($user !== null) {
            /** TODO: new exception */
            throw new SignUpException('this email is already in use', 400);
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