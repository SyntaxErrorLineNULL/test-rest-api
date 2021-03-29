<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Core\Service;


use JMS\Serializer\SerializerBuilder;
use Psr\Http\Message\ServerRequestInterface;

class RequestData
{

    private SerializerBuilder $serializerBuilder;

    /**
     * RequestData constructor.
     * @param SerializerBuilder $serializerBuilder
     */
    public function __construct(SerializerBuilder $serializerBuilder)
    {
        $this->serializerBuilder = $serializerBuilder;
    }

    /**
     * @param ServerRequestInterface $request
     * @param string $object
     * @return object
     */
    public function getData(ServerRequestInterface $request, string $object): object
    {
        $serializer = $this->serializerBuilder->build();
        return $serializer->deserialize((string)$request->getBody(), $object, 'json');
    }

    /** TODO: what if the data doesn't match the schema? */
}