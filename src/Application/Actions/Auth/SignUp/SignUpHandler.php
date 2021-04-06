<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Actions\Auth\SignUp;


use App\Application\Domain\Entities\User;
use App\Application\Domain\Repository\UserRepository;
use App\Core\Service\PasswordService;
use App\Core\Service\RequestData;
use Laminas\Diactoros\Response\EmptyResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SignUpHandler implements RequestHandlerInterface
{
    private PasswordService $passwordService;

    /**
     * SignUpHandler constructor.
     * @param PasswordService $passwordService
     */
    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var SignUpRequest $requestSchema */
        #$requestSchema = $this->data->getData($request, SignUpRequest::class);



        return new EmptyResponse(201);
    }
}