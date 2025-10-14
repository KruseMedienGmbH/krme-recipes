#!/bin/bash

vendor/bin/platform-tools misc:install_dev_tools

sed -i 's/openBrowserWithUrl(`${proxyUrlEnv.origin}`);//g' /var/www/html/vendor/shopware/storefront/Resources/app/storefront/build/start-hot-reload.js
sed -i s/APP_ENV=prod/APP_ENV=dev/g /var/www/html/.env
rm -rf /var/www/html/var/cache/*