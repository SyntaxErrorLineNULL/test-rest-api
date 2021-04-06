<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Actions\Auth\SignUp;


use App\Application\Entities\User;
use App\Core\Domain\Repository\UserRepository;
use App\Core\Service\PasswordService;
use App\Core\Service\RequestData;
use Laminas\Diactoros\Response\EmptyResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SignUpHandler implements RequestHandlerInterface
{
    private RequestData $data;
    private UserRepository $userRepository;
    private PasswordService $passwordService;

    /**
     * SignUpHandler constructor.
     * @param RequestData $data
     * @param UserRepository $userRepository
     * @param PasswordService $passwordService
     */
    public function __construct(RequestData $data, UserRepository $userRepository, PasswordService $passwordService)
    {
        $this->data = $data;
        $this->userRepository = $userRepository;
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

        return new EmptyResponse(201);
    }
}