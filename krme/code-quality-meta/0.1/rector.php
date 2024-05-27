<?php

declare(strict_types=1);

/*
 * (c) KruseMedien GmbH <info@krusemedien.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Rector\Config\RectorConfig;

$customConfigPath = __DIR__ . '/vendor-bin/rector/custom_rector.php';

/**
 * @var callable(RectorConfig): void $customRectorConfig
 */
$customRectorConfig = include $customConfigPath;

return static function (RectorConfig $rectorConfig) use ($customRectorConfig): void {
    // Apply the custom Rector configurations
    $customRectorConfig($rectorConfig);

};