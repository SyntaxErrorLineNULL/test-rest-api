<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return [
    LoggerInterface::class => static function (ContainerInterface $container) {
        $settings = $container->get('settings')['logger'];

        // Logger::DEBUG : Logger::INFO
        $level = $settings['level'];
        $logger = new Logger($settings['name']);

        $processor = new UidProcessor();
        $logger->pushProcessor($processor);

        $logger->pushHandler(new StreamHandler($settings['path'], $level));

        return $logger;
    },
];