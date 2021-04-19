<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Core\Service;


use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class RequestSchema
{
    private Serializer $serializer;

    /**
     * RequestSchema constructor.
     * @param Serializer $serializer
     */
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function deserializeBySchema(ServerRequestInterface $request, string $schema) {
        return $this->serializer->deserialize($request, $schema, 'json');
    }

    private function validate() {
        /** TODO validate schema */
    }
}