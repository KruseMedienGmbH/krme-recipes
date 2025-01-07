<?php

declare(strict_types=1);
/*
 * (c) KruseMedien GmbH <info@krusemedien.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * (c) KruseMedien GmbH <info@krusemedien.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Shopware\Core\TestBootstrapper;

require_once __DIR__ . '/../../../../vendor/shopware/core/TestBootstrapper.php';

putenv('TEST_TOKEN=none');
putenv('APP_ENV=test');

$bootstrapper = (new TestBootstrapper())
    ->setProjectDir($_SERVER['PROJECT_ROOT'] ?? \dirname(__DIR__, 4))
    ->bootstrap();

$bootstrapper
    ->getClassLoader();

return $bootstrapper->getStaticAnalyzeKernel()->getContainer();
