<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Api\Action\SignIn;


use App\Application\Domain\Repository\UserRepository;
use App\Application\Service\PasswordService;
use App\Core\Http\Request\RequestSchema;
use App\Core\Service\JWTService;
use App\Core\Service\Token;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SignInHandler implements RequestHandlerInterface
{
    private UserRepository $userRepository;
    private PasswordService $passwordService;
    private RequestSchema $schema;
    private JWTService $JWTService;

    /**
     * SignInHandler constructor.
     * @param UserRepository $userRepository
     * @param PasswordService $passwordService
     * @param RequestSchema $schema
     * @param JWTService $JWTService
     */
    public function __construct(UserRepository $userRepository, PasswordService $passwordService, RequestSchema $schema, JWTService $JWTService)
    {
        $this->userRepository = $userRepository;
        $this->passwordService = $passwordService;
        $this->schema = $schema;
        $this->JWTService = $JWTService;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws SignInException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var SignInSchema $requestSchema */
        $requestSchema = $this->schema->deserializeBySchema($request, SignInSchema::class);

        $user = $this->userRepository->findByEmailAndPassword($requestSchema->email, $requestSchema->password);

        if ($user === null) {
            throw new SignInException();
        }

        if (!$this->passwordService->validate($requestSchema->password, $user->passwordHash)){
            throw new SignInException();
        }

        return new JsonResponse(
            new Token($this->JWTService->encode([
                'id' => $user->id,
                'email' => $user->email,
                'createdAt' => new \DateTimeImmutable()
            ]))
        );
    }
}