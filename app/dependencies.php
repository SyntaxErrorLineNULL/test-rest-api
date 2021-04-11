<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

$aggregator = new ConfigAggregator([
    new PhpFileProvider(__DIR__ . '/setting/*.php'),
]);

return $aggregator->getMergedConfig();