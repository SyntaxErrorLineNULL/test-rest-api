<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Handlers\Auth\SignUp;


use App\Application\Settings\Flusher;
use App\Core\Service\PasswordService;
use App\Core\Service\RequestData;
use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use App\Infrastructure\Repository\DoctrineUserRepository;
use Laminas\Diactoros\Response\EmptyResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SignUpHandler implements RequestHandlerInterface
{
    private RequestData $data;
    private UserRepository $userRepository;
    private Flusher $flusher;
    private PasswordService $passwordService;

    /**
     * SignUpHandler constructor.
     * @param RequestData $data
     * @param UserRepository $userRepository
     * @param Flusher $flusher
     * @param PasswordService $passwordService
     */
    public function __construct(RequestData $data, UserRepository $userRepository, Flusher $flusher, PasswordService $passwordService)
    {
        $this->data = $data;
        $this->userRepository = $userRepository;
        $this->flusher = $flusher;
        $this->passwordService = $passwordService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var SignUpRequest $requestSchema */
        $requestSchema = $this->data->getData($request, SignUpRequest::class);

        $user = $this->userRepository->findByEmail($requestSchema->email);

        if ($user !== null) {
            /** TODO: create exception(status and message) */
            return new EmptyResponse(400);
        }

        $user = new User($requestSchema->email, $requestSchema->name, $requestSchema->password, $this->passwordService);
        $this->userRepository->add($user);
        $this->flusher->flusher();

        return new EmptyResponse(201);
    }
}