<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Core\Service;


use Doctrine\Common\Annotations\AnnotationReader;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class RequestSchema
{
    private Serializer $serializer;

    /**
     * RequestSchema constructor.
     */
    public function __construct()
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(null, null, null, new PhpDocExtractor()), new ArrayDenormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public function deserializeBySchema(ServerRequestInterface $request, string $schema) {
        return $this->serializer->deserialize($request->getBody(), $schema, 'json');
    }

    private function validate() {
        /** TODO validate schema */
    }
}