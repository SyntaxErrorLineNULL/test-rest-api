<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Actions\Auth\SignUp;


use App\Application\Domain\Entities\User;
use App\Application\Domain\Repository\UserRepository;
use App\Application\Settings\NormalizationSchema;
use App\Application\Settings\PasswordServiceInterface;
use App\Core\Service\PasswordService;
use App\Core\Service\RequestData;
use Laminas\Diactoros\Response\EmptyResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SignUpHandler implements RequestHandlerInterface
{
    private PasswordServiceInterface $passwordService;
    private UserRepository $repository;

    /**
     * SignUpHandler constructor.
     * @param PasswordServiceInterface $passwordService
     * @param UserRepository $repository
     */
    public function __construct(PasswordServiceInterface $passwordService, UserRepository $repository)
    {
        $this->passwordService = $passwordService;
        $this->repository = $repository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var SignUpRequest $requestSchema */
        #$requestSchema = $this->data->getData($request, SignUpRequest::class);



        return new EmptyResponse(201);
    }
}