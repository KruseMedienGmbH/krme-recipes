<?php
// rector.php

declare(strict_types=1);

use Frosh\Rector\Rule\ClassConstructor\RemoveArgumentFromClassConstructRector;
use Frosh\Rector\Rule\ClassMethod\AddArgumentToClassWithoutDefaultRector;
use Frosh\Rector\Set\ShopwareSetList;
use Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector;
use Rector\DeadCode\Rector\Cast\RecastingRemovalRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodRector;
use Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector;
use Rector\Privatization\Rector\ClassMethod\PrivatizeFinalClassMethodRector;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\Privatization\Rector\Property\PrivatizeFinalClassPropertyRector;
use Rector\Config\RectorConfig;
use Rector\ValueObject\PhpVersion;


return RectorConfig::configure()
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        privatization: true,
        naming: true,
        instanceOf: true,
        strictBooleans: true,
        symfonyCodeQuality: true
    )
    ->withSymfonyContainerPhp(__DIR__ . '/tests/RectorSymfonyContainerBootstrap.php')
    ->withSymfonyContainerXml(__DIR__ . '/../../../var/cache/phpstan_dev/Shopware_Core_DevOps_StaticAnalyze_StaticAnalyzeKernelPhpstan_devDebugContainer.xml')
    ->withPaths([
        __DIR__ . '/src',
    ])
    ->withSkip(
        []
    )
    ->withBootstrapFiles([
        __DIR__ . '/tests/PHPStanBootstrap.php',
    ])
    ->withPhpVersion(PhpVersion::PHP_82)
    ->withAutoloadPaths([
        __DIR__ . '/../../../vendor/store.shopware.com',
    ])
    ->withPhpSets(
        php83: true
    )
    ->withSets([
        ShopwareSetList::SHOPWARE_6_6_0,
        ShopwareSetList::SHOPWARE_6_5_0,
    ])
    ->withParallel();
