FROM dockware/shopware-essentials:latest AS dockware

ARG SHOPWARE_STORE_ACCOUNT_EMAIL
ARG SHOPWARE_STORE_ACCOUNT_PASSWORD
ENV SHOPWARE_STORE_ACCOUNT_EMAIL=$SHOPWARE_STORE_ACCOUNT_EMAIL
ENV SHOPWARE_STORE_ACCOUNT_PASSWORD=$SHOPWARE_STORE_ACCOUNT_PASSWORD

USER dockware

COPY --chown=33:33 . /var/www/html

RUN echo "DOCKWARE: decompressing NVM..." && \
    sudo zstd -d /var/www/nvm.tar.zst -o /var/www/nvm.tar && \
    sudo tar -xf /var/www/nvm.tar -C /var/www/.nvm && \
    sudo rm /var/www/nvm.tar && \
    sudo chown 33:33 /var/www/.nvm -R && \
    echo "DOCKWARE: NVM decompression completed successfully"

RUN echo '1:composer-update' && \
    sudo composer self-update && \
    composer install --no-scripts

RUN echo '2:base-install' && \
    sudo service mysql start && \
    SHOPWARE_DEPLOYMENT_TIMEOUT=900 INSTALL_LOCALE=de-DE SHOPWARE_USAGE_DATA_CONSENT=revoked vendor/bin/shopware-deployment-helper run --skip-assets-install --skip-theme-compile && \
    service mysql stop

RUN echo '3:insert-dump' && \
    sudo apt-get update -y && \
    sudo apt-get install -y pigz && \
    pigz -9 bin/localhost.sql && \
    tmpfile="$(mktemp)" && \
    printf "%s\n" \
      "[mysqld]" \
      "innodb_buffer_pool_size=1G" \
      "innodb_log_file_size=512M" \
      "innodb_flush_method=O_DIRECT" \
      "innodb_flush_log_at_trx_commit=2" \
      "innodb_doublewrite=0" \
      "sync_binlog=0" > "$tmpfile" && \
    sudo install -o root -g root -m 644 "$tmpfile" /etc/mysql/mysql.conf.d/zz-imprt.cnf && \
    rm -f "$tmpfile" && \
    sudo service mysql start && \
    MYSQL_PWD=root mysql -h 127.0.0.1 -u root shopware -e "SET FOREIGN_KEY_CHECKS=0; SET UNIQUE_CHECKS=0; SET autocommit=0;" && \
    zcat bin/localhost.sql.gz | MYSQL_PWD=root mysql -h 127.0.0.1 -u root shopware --default-character-set=utf8mb4 --force --max-allowed-packet=512M && \
    MYSQL_PWD=root mysql -h 127.0.0.1 -u root shopware -e "COMMIT; SET FOREIGN_KEY_CHECKS=1; SET UNIQUE_CHECKS=1; SET autocommit=1;" && \
    MYSQL_PWD=root mysql -h 127.0.0.1 -u root shopware -e "SET GLOBAL innodb_fast_shutdown = 0" && \
    service mysql stop && \
    sudo rm -f /etc/mysql/mysql.conf.d/zz-imprt.cnf && \
    tmpfile="$(mktemp)" && \
    printf "%s\n" \
      "[mysqld]" \
      "innodb_buffer_pool_size=1G" \
      "innodb_log_file_size=512M" > "$tmpfile" && \
    sudo install -o root -g root -m 644 "$tmpfile" /etc/mysql/mysql.conf.d/zz-imprt.cnf && \
    rm -f "$tmpfile" && \
    sudo killall mysqld || true && \
    sudo rm -f "/var/run/mysqld/mysqld.sock.lock" && \
    sudo chown -R mysql:mysql /var/lib/mysql /var/run/mysqld

RUN echo '4:install' && \
    sudo service mysql start && \
    chmod +x bin/* && \
    touch install.lock && \
    bin/console sales-channel:update:domain localhost && \
    MYSQL_PWD=root mysql -h 127.0.0.1 -u root shopware -e "UPDATE sales_channel_domain SET url = REPLACE(url, 'https', 'http') WHERE url LIKE 'https:%'" && \
    bin/console theme:dump -n && \
    vendor/bin/platform-tools misc:update_shopware_cli && \
    shopware-cli project admin-build && \
    bin/build-storefront.sh && \
    shopware-cli project storefront-build && \
    rm bin/localhost.sql.gz && \
    vendor/bin/shopware-deployment-helper run && \
    service mysql stop

RUN tar -cf - -C /var/www/html . | zstd --ultra -22 -o /var/www/shopware.tar.zst && \
    find /var/www/html -mindepth 1 -delete && \
    # we need the zst in the html folder. if existing entrypoint.sh will decompress it \
    # it has to be in html, because users might mount that folder, and if its not inside, it would \
    # always exist and therefore always overwrite the users custom-mount html folder \
    mv /var/www/shopware.tar.zst /var/www/html/shopware.tar.zst && \
    echo ". /etc/profile" >> /var/www/.bashrc

FROM ubuntu:24.04

COPY --from=dockware / /

USER dockware

# make the apache folder the working directory
WORKDIR /var/www/html

ENTRYPOINT ["/bin/bash", "/entrypoint.sh"]