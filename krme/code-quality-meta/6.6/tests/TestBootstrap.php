<?php declare(strict_types=1);

require __DIR__ . '/../vendor/shopware/core/TestBootstrapper.php';
require __DIR__ . '/../vendor/shopware/core/Framework/Adapter/Kernel/KernelFactory.php';

use Shopware\Core\Framework\Adapter\Kernel\KernelFactory;
use Shopware\Core\TestBootstrapper;

$loader = (new TestBootstrapper())
    ->setProjectDir($_SERVER['PROJECT_ROOT'] ?? \dirname(__DIR__, 4))
    ->setLoadEnvFile(true)
    ->setPlatformEmbedded(false)
    ->bootstrap()
    ->getClassLoader();

return $loader;