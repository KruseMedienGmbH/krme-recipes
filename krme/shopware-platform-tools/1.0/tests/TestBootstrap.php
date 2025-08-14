<?php declare(strict_types=1);

require __DIR__ . '/../vendor/shopware/core/TestBootstrapper.php';
require __DIR__ . '/../vendor/shopware/core/Framework/Adapter/Kernel/KernelFactory.php';

use Shopware\Core\Framework\Adapter\Kernel\KernelFactory;
use Shopware\Core\TestBootstrapper;

$loader = (new TestBootstrapper())
    ->setDatabaseUrl('mysql://root:root@127.0.0.1:3306/shopware')
    ->setLoadEnvFile(true)
    ->setPlatformEmbedded(false)
    ->bootstrap()
    ->getClassLoader();

$loader->addPsr4('Plugin\\Tests\\', __DIR__ . '/../custom/static-plugins/Plugin/tests');

return $loader;