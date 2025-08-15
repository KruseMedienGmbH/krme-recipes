#!/usr/bin/env bash

sudo killall mysqld || true && \
sudo rm -f "/var/run/mysqld/mysqld.sock.lock" && \
sudo chown -R mysql:mysql /var/lib/mysql /var/run/mysqld && \

# Update
apt-get update -y && \
apt-get upgrade -y && \

# Update cli
curl -1sLf 'https://dl.cloudsmith.io/public/friendsofshopware/stable/setup.deb.sh' | sudo -E bash && \
sudo apt install shopware-cli && \

dpkg --get-selections | grep php8.2 | cut -f1 | sed 's/php8.2/php8.3/g' | xargs sudo apt-get install -y && \

/var/www/.nvm/install.sh && \

sed -i 's/__PHP__FOLDER__ID/20230831/g' /etc/php/8.3/fpm/conf.d/20-xdebug.ini || true && \
sed -i 's/__PHP_VERSION__/8.3/g' /etc/php/8.3/fpm/conf.d/20-xdebug.ini || true && \
sed -i 's/__PHP__FOLDER__ID/20230831/g' /etc/php/8.3/cli/conf.d/20-xdebug.ini || true && \
sed -i 's/__PHP_VERSION__/8.3/g' /etc/php/8.3/cli/conf.d/20-xdebug.ini || true && \

export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"  # This loads nvm
[ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion" && \

nvm install 22 && \

# Löscht alte Node.js Versionen
rm -rf /var/www/.nvm/versions/node/v12* && \
rm -rf /var/www/.nvm/versions/node/v14* && \
rm -rf /var/www/.nvm/versions/node/v16* && \
rm -rf /var/www/.nvm/versions/node/v18* && \
rm -rf /var/www/.nvm/.cache/* && \

# Autoremove nicht mehr benötigte Pakete
apt autoremove --purge -y && \

# Löscht Protokolldateien und loggt sie zurück
rm -rf /var/log/*.gz /var/log/*.[0-9] && \
truncate -s 0 /var/log/*.log && \

# Bereinigt APT Cache
apt-get clean && \
apt-get autoremove --purge -y && \

# Löscht .git, Cache und node_modules
rm -rf .git && \
rm -rf /var/cache/* && \
find /var/www/html -type d -name 'node_modules' -exec rm -rf {} + && \
find /var/www/html/custom -type d -name 'vendor' -exec rm -rf {} + && \
rm -rf /var/www/.cache/* && \
rm -rf /var/www/.npm/* && \
rm -rf /var/www/html/var/log/* && \
rm -rf /var/www/html/var/cache/* && \

# Löscht temporäre Dateien
rm -rf /tmp/* && \

sudo service mysql stop && \
sudo rm -f "/var/run/mysqld/mysqld.sock.lock" && \
sudo chown -R mysql:mysql /var/lib/mysql /var/run/mysqld && \
sudo service mysql start