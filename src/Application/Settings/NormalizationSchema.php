<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Application\Settings;


use Psr\Http\Message\ServerRequestInterface;

interface NormalizationSchema
{
    /**
     * @param ServerRequestInterface $request
     * @param string $schema
     * @return object
     */
    public function deserializeBySchema(ServerRequestInterface $request, string $schema): object;

    /**
     * @param string $schema
     * @return string
     */
    public function serializeByEntity(string $schema): string;
}