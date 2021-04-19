<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Api\Action\SignUp;


use App\Application\Domain\Repository\UserRepository;
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
    private RequestSchema $schema;

    /**
     * SignUpHandler constructor.
     * @param UserRepository $userRepository
     * @param PasswordService $passwordService
     * @param RequestSchema $schema
     */
    public function __construct(UserRepository $userRepository, PasswordService $passwordService, RequestSchema $schema)
    {
        $this->userRepository = $userRepository;
        $this->passwordService = $passwordService;
        $this->schema = $schema;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var SignUpSchema $requestSchema */
        $requestSchema = $this->schema->deserializeBySchema($request, SignUpSchema::class);

        return new JsonResponse($requestSchema->name);
    }
}