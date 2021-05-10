<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Api\Action\Profile;


use App\Api\Components\DTOMapper\SimpleUserMapper;
use App\Application\Domain\Repository\UserRepository;
use App\Core\Http\Authentication;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ProfileHandler implements RequestHandlerInterface
{
    use Authentication;

    private UserRepository $userRepository;
    private SimpleUserMapper $simpleUserMapper;

    /**
     * ProfileHandler constructor.
     * @param UserRepository $userRepository
     * @param SimpleUserMapper $simpleUserMapper
     */
    public function __construct(UserRepository $userRepository, SimpleUserMapper $simpleUserMapper)
    {
        $this->userRepository = $userRepository;
        $this->simpleUserMapper = $simpleUserMapper;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $this->getId($request);
        $user = $this->userRepository->getById($id);

        if ($user === null) {
            return new EmptyResponse(403);
        }

        $items = $this->simpleUserMapper->map($user);

        return new JsonResponse($items);
    }
}