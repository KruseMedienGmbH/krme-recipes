# =============================================================================
# Multi-Stage Build for Shopware 6
# =============================================================================
# This Dockerfile uses a multi-stage build approach to create an optimized
# production image. The first stage handles the complete build process,
# while the final stage provides a minimal runtime environment.
# =============================================================================

# -----------------------------------------------------------------------------
# Stage 1: Build Stage
# -----------------------------------------------------------------------------
FROM dockware/shopware-essentials:latest AS builder

LABEL org.opencontainers.image.title="Shopware 6 ##" \
      org.opencontainers.image.description="Multi-stage production build for Shopware 6 with ## theme" \
      org.opencontainers.image.version="1.0.0" \
      org.opencontainers.image.vendor="KruseMedien GmbH" \
      org.opencontainers.image.base.name="dockware/shopware-essentials:latest" \
      maintainer="internet@krusemedien.com" \
      build.date="##" \
      build.shopware.version="##"

# Build arguments for Shopware Store credentials
ARG SHOPWARE_STORE_ACCOUNT_EMAIL
ARG SHOPWARE_STORE_ACCOUNT_PASSWORD
ENV SHOPWARE_STORE_ACCOUNT_EMAIL=$SHOPWARE_STORE_ACCOUNT_EMAIL
ENV SHOPWARE_STORE_ACCOUNT_PASSWORD=$SHOPWARE_STORE_ACCOUNT_PASSWORD

USER dockware

COPY --chown=33:33 . /var/www/html

RUN echo "==> STEP 1: Decompressing NVM..." && \
    sudo zstd -d /var/www/nvm.tar.zst -o /var/www/nvm.tar && \
    sudo tar -xf /var/www/nvm.tar -C /var/www/.nvm && \
    sudo rm /var/www/nvm.tar && \
    sudo chown 33:33 /var/www/.nvm -R && \
    echo "==> NVM decompression completed"

RUN echo "==> STEP 2: Installing system dependencies and Composer packages..." && \
    sudo apt-get update -y && \
    sudo apt-get upgrade -y && \
    sudo apt-get install -y pigz && \
    sudo apt-get clean && \
    sudo rm -rf /var/lib/apt/lists/* && \
    sudo composer self-update && \
    composer install --no-scripts && \
    echo "==> System dependencies and Composer setup completed"

RUN echo "==> STEP 3: Removing specific config files..." && \
    find config/packages -maxdepth 1 \( \
        -type d \( -name 'dev' -o -name 'prod' -o -name 'test' \) -o \
        -type f \( -name 'framework.yaml' -o -name 'messenger.yaml' -o -name 'storefront.yaml' -o -name 'z-shopware.yaml' \) \
    \) -exec rm -rf {} + 2>/dev/null || true && \
    echo "==> Config cleanup completed"

RUN echo "==> STEP 4: Preparing and importing database dump..." && \
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
    MYSQL_PWD=root mysql -h 127.0.0.1 -u root -e "DROP DATABASE IF EXISTS shopware;" && \
    MYSQL_PWD=root mysql -h 127.0.0.1 -u root -e "CREATE DATABASE shopware CHARACTER SET utf8 COLLATE utf8_general_ci;" && \
    MYSQL_PWD=root mysql -h 127.0.0.1 -u root -e "SET FOREIGN_KEY_CHECKS=0; SET UNIQUE_CHECKS=0; SET autocommit=0;" && \
    zcat bin/localhost.sql.gz | MYSQL_PWD=root mysql -h 127.0.0.1 -u root shopware --default-character-set=utf8mb4 --force --max-allowed-packet=512M && \
    MYSQL_PWD=root mysql -h 127.0.0.1 -u root shopware -e "COMMIT; SET FOREIGN_KEY_CHECKS=1; SET UNIQUE_CHECKS=1; SET autocommit=1;" && \
    MYSQL_PWD=root mysql -h 127.0.0.1 -u root -e "SET GLOBAL innodb_fast_shutdown = 0;" && \
    sudo service mysql stop && \
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
    sudo chown -R mysql:mysql /var/lib/mysql /var/run/mysqld && \
    echo "==> Database import completed"

RUN echo "==> STEP 5: Building Shopware application..." && \
    sudo service mysql start && \
    chmod +x bin/* && \
    touch install.lock && \
    bin/console sales-channel:update:domain localhost && \
    MYSQL_PWD=root mysql -h 127.0.0.1 -u root shopware -e "UPDATE sales_channel_domain SET url = REPLACE(url, 'https', 'http') WHERE url LIKE 'https:%';" && \
    bin/console theme:dump -n && \
    vendor/bin/platform-tools misc:update_shopware_cli && \
    shopware-cli project admin-build && \
    bin/build-storefront.sh && \
    shopware-cli project storefront-build && \
    rm bin/localhost.sql.gz && \
    vendor/bin/shopware-deployment-helper run && \
    sudo service mysql stop && \
    echo "==> Shopware build completed"

COPY --chown=33:33 ./config /var/www/html/config

RUN echo "==> STEP 6: Cleaning up build artifacts..." && \
    sudo killall mysqld 2>/dev/null || true && \
    sudo rm -f /var/run/mysqld/mysqld.sock.lock && \
    sudo chown -R mysql:mysql /var/lib/mysql /var/run/mysqld && \
    rm -rf /var/www/{.nvm/.cache,.cache,.npm} \
           /var/www/html/var/{log,cache}/* \
           .git && \
    find /var/www/html -type d -name 'node_modules' -prune -exec rm -rf {} + 2>/dev/null || true && \
    find /var/www/html/custom -type d -name 'vendor' -prune -exec rm -rf {} + 2>/dev/null || true && \
    sudo apt-get autoremove --purge -y && \
    sudo apt-get clean && \
    sudo rm -rf /var/log/*.{gz,[0-9]} && \
    sudo truncate -s 0 /var/log/*.log 2>/dev/null || true && \
    sudo rm -rf /var/cache/* \
               /var/lib/apt/lists/* \
               /dockware/tmp \
               /tmp/* \
               /var/tmp/* && \
    echo "==> Cleanup completed"

RUN echo "==> STEP 7: Creating compressed application archive..." && \
    tar -cf - -C /var/www/html . | zstd -T0 -19 -o /var/www/shopware.tar.zst && \
    find /var/www/html -mindepth 1 -delete && \
    mv /var/www/shopware.tar.zst /var/www/html/shopware.tar.zst && \
    sudo sed -i 's/export \([^=]*\)=\(.*\)/export \1=${\1:-\2}/' /etc/profile && \
    echo ". /etc/profile" >> /var/www/.bashrc && \
    echo "==> Archive creation completed"

FROM ubuntu:24.04

COPY --from=builder / /

USER dockware

WORKDIR /var/www/html

ENTRYPOINT ["/bin/bash", "/entrypoint.sh"]