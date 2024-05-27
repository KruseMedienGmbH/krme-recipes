<?php

declare(strict_types=1);

/*
 * (c) KruseMedien GmbH <info@krusemedien.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symplify\EasyCodingStandard\Configuration\ECSConfigBuilder;

// Include custom ECS configuration
$customConfigPath = __DIR__ . '/vendor-bin/cs/custom_ecs.php';

/**
 * @var ECSConfigBuilder $customEcsConfig
 */
$customEcsConfig = include $customConfigPath;

return $customEcsConfig->withCache(
    $_SERVER['SHOPWARE_TOOL_CACHE_ECS'] ?? 'var/cache/cs_fixer',
    'Shopware6Theme'
)
    ->withParallel();