#!/bin/bash

vendor/bin/platform-tools misc:install_dev_tools

sed -i s/APP_ENV=prod/APP_ENV=dev/g /var/www/html/.env