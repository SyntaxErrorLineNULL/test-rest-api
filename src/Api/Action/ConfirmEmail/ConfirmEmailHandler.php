<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Api\Action\ConfirmEmail;


use App\Api\Components\Exception\ConfirmEmailException;
use App\Application\Domain\Repository\ConfirmationTokenRepository;
use App\Application\Infrastructure\DoctrineFlusher;
use App\Core\Http\Request\RequestSchema;
use Laminas\Diactoros\Response\EmptyResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ConfirmEmailHandler implements RequestHandlerInterface
{
    private ConfirmationTokenRepository $confirmationTokenRepository;
    private DoctrineFlusher $flusher;
    private RequestSchema $schema;

    /**
     * ConfirmEmailHandler constructor.
     * @param ConfirmationTokenRepository $confirmationTokenRepository
     * @param DoctrineFlusher $flusher
     * @param RequestSchema $schema
     */
    public function __construct(ConfirmationTokenRepository $confirmationTokenRepository, DoctrineFlusher $flusher, RequestSchema $schema)
    {
        $this->confirmationTokenRepository = $confirmationTokenRepository;
        $this->flusher = $flusher;
        $this->schema = $schema;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws ConfirmEmailException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var ConfirmEmailSchema $requestSchema */
        $requestSchema = $this->schema->deserializeBySchema($request, ConfirmEmailSchema::class);
        $token = $this->confirmationTokenRepository->findByToken($requestSchema->token);

        if ($token === null) {
            throw new ConfirmEmailException('token is not found', 400);
        }

        $token->userId->isActive();
        $this->confirmationTokenRepository->remove($token);
        $this->flusher->flush();

        return new EmptyResponse(201);
    }
}