<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

use Doctrine\Common\Annotations\AnnotationRegistry;
use Psr\Container\ContainerInterface;
use Symfony\Component\Translation\Loader\PhpFileLoader;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

return [
    ValidatorInterface::class => static function(ContainerInterface $container): ValidatorInterface {
        AnnotationRegistry::registerLoader('class_exists');

        $translator = $container->get(TranslatorInterface::class);

        return Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->setTranslator($translator)
            ->setTranslationDomain('validators')
            ->getValidator();
    },

    TranslatorInterface::class => DI\get(Translator::class),

    Translator::class => static function (ContainerInterface $container): Translator {
        /**
         * @var array{lang:string,resources:array<string[]>} $config
         */
        $config = $container->get('settings')['translator'];

        $translator = new Translator($config['lang']);
        $translator->addLoader('xlf', new XliffFileLoader());

        $translator->addResource('xlf', $config['xlf-ru'], 'ru');
        $translator->addResource('xlf', $config['xlf-en'], 'en');

        return $translator;
    },
];