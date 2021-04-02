<?php

/**
 * https://insights.project-a.com/serializing-data-in-php-a-simple-primer-on-the-jms-serializer-and-fos-rest-f469d7d5b902
 */
namespace App\Application\Handlers\Auth\SignIn;


use App\Core\Service\RequestData;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SignInHandler implements RequestHandlerInterface
{

    private RequestData $data;

    /**
     * SignInHandler constructor.
     * @param RequestData $data
     */
    public function __construct(RequestData $data)
    {
        $this->data = $data;
    }


    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var SignInRequest $data */
        $data = $this->data->getData($request, SignInRequest::class);

        $email = $data->email;

        return new JsonResponse($data->email);
    }
}