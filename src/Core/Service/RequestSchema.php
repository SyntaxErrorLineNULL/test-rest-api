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
        $classMetaDataFactory = new ClassMetadataFactory(
            new AnnotationLoader(
                new AnnotationReader()
            )
        );
        $objectNormalizer = new ObjectNormalizer($classMetaDataFactory, null, null, new PhpDocExtractor());
        $this->serializer = new Serializer([
            new ArrayDenormalizer(),
            $objectNormalizer,
        ], [
            new JsonEncoder(),
        ]);
    }

    public function deserializeBySchema(ServerRequestInterface $request, string $schema) {
        return $this->serializer->deserialize($request->getBody(), $schema, 'json');
    }

    private function validate() {
        /** TODO validate schema */
    }
}