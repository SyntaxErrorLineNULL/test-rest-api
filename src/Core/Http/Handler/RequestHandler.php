<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Core\Http\Handler;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RequestHandlerInvocationStrategyInterface;

class RequestHandler implements RequestHandlerInvocationStrategyInterface
{
    /**
     * @var bool
     */
    protected bool $appendRouteArgumentsToRequestAttributes;

    /**
     * @param bool $appendRouteArgumentsToRequestAttributes
     */
    public function __construct(bool $appendRouteArgumentsToRequestAttributes = false)
    {
        $this->appendRouteArgumentsToRequestAttributes = $appendRouteArgumentsToRequestAttributes;
    }

    public function __invoke(callable $callable, ServerRequestInterface $request, ResponseInterface $response, array $routeArguments): ResponseInterface
    {
        if ($this->appendRouteArgumentsToRequestAttributes) {
            foreach ($routeArguments as $key => $value) {
                $request = $request->withAttribute($key, $value);
            }
        }

        return $callable($request);
    }
}