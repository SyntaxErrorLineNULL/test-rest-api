<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use App\Core\Service\JWTService;
use Psr\Container\ContainerInterface;

return [
    JWTService::class => static function (ContainerInterface $container): JWTService
    {
        $setting = $container->get('settings');

        return new JWTService($setting['secretKey']);
    }
];