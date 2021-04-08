<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Actions\Auth\SignUp;


use App\Application\Domain\Repository\UserRepository;
use App\Application\Domain\Service\RequestData;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SignUpHandler implements RequestHandlerInterface
{
    private RequestData $data;
    private UserRepository $userRepository;

    /**
     * SignUpHandler constructor.
     * @param RequestData $data
     * @param UserRepository $userRepository
     */
    public function __construct(RequestData $data, UserRepository $userRepository)
    {
        $this->data = $data;
        $this->userRepository = $userRepository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var Schema $schema */
        $schema = $this->data->getData($request, Schema::class);

        return new JsonResponse($schema->email);
    }
}