<?php

declare(strict_types=1);

/*
 * (c) KruseMedien GmbH <info@krusemedien.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Frosh\Rector\Set\ShopwareSetList;
use Rector\Config\RectorConfig;
use Rector\ValueObject\PhpVersion;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector;
use Rector\Set\ValueObject\SetList;
use Rector\Symfony\Set\SymfonySetList;
use Rector\Symfony\Set\TwigSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/ecs.php',
        __DIR__ . '/rector.php',
        __DIR__ . '/src',
    ]);

    $rectorConfig->skip([]);

    $rectorConfig->sets([
        SymfonySetList::SYMFONY_52,
        SymfonySetList::SYMFONY_53,
        SymfonySetList::SYMFONY_54,
        SymfonySetList::SYMFONY_CODE_QUALITY,
        TwigSetList::TWIG_240,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        SetList::NAMING,
        SetList::DEAD_CODE,
        SetList::PHP_72,
        SetList::PHP_73,
        SetList::PHP_74,
        SetList::PHP_80,
        SetList::PHP_81,
        SetList::PHP_82,
        SetList::TYPE_DECLARATION,
        SetList::PRIVATIZATION,
        ShopwareSetList::SHOPWARE_6_6_0,
        ShopwareSetList::SHOPWARE_6_5_0,
    ]);

    $rectorConfig->phpVersion(PhpVersion::PHP_82);

    $rectorConfig->skip([
        AddLiteralSeparatorToNumberRector::class => [
            __DIR__ . '/src/Migration/Migration*.php',
        ],
        RenamePropertyToMatchTypeRector::class => [
            __DIR__ . '/src/**/Subscriber/*Subscriber.php',
        ],
    ]);

    $rectorConfig->parallel();
};
