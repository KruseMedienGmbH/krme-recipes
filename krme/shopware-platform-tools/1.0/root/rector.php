<?php

// rector.php

declare(strict_types=1);

/*
 * (c) KruseMedien GmbH <info@krusemedien.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Frosh\Rector\Rule\ClassConstructor\RemoveArgumentFromClassConstructRector;
use Frosh\Rector\Rule\ClassMethod\AddArgumentToClassWithoutDefaultRector;
use Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\Cast\RecastingRemovalRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodRector;
use Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\Privatization\Rector\ClassMethod\PrivatizeFinalClassMethodRector;
use Rector\Privatization\Rector\Property\PrivatizeFinalClassPropertyRector;
use Rector\ValueObject\PhpVersion;
use Frosh\Rector\Set\ShopwareSetList;

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
    ->withSymfonyContainerXml(__DIR__ . '/var/cache/static_phpstan_dev/Shopware_Core_DevOps_StaticAnalyze_StaticAnalyzeKernelPhpstan_devDebugContainer.xml')
    ->withSkip(
        []
    )
    ->withBootstrapFiles([
        __DIR__ . '/vendor/shopware/core/DevOps/StaticAnalyze/phpstan-bootstrap.php',
    ])
    ->withPhpVersion(PhpVersion::PHP_83)
    ->withAutoloadPaths([
        __DIR__ . '/vendor/store.shopware.com',
    ])
    ->withPhpSets(
        php83: true
    )
    ->withSets([
        ShopwareSetList::SHOPWARE_6_7_0,
        ShopwareSetList::SHOPWARE_6_6_0,
        ShopwareSetList::SHOPWARE_6_5_0,
    ])
    ->withSkip(
        [
            RenamePropertyToMatchTypeRector::class,
            RemoveArgumentFromClassConstructRector::class,
            AddArgumentToClassWithoutDefaultRector::class,
            PrivatizeFinalClassPropertyRector::class,
            RemoveArgumentFromClassConstructRector::class,
            AddArgumentToClassWithoutDefaultRector::class,
            RenamePropertyToMatchTypeRector::class,
            RecastingRemovalRector::class,
        ]
    )
    ->withParallel();
