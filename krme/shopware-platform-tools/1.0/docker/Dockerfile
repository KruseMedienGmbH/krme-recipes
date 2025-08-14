FROM krusemediendev/SHOP:6.6 AS builder

FROM ubuntu:22.04

COPY --from=builder / /

RUN echo "source /etc/profile" >> /var/www/.bashrc && \
    chown www-data:www-data -R /var/www/scripts && \
    chmod 755 /*.sh

USER dockware

# make the apache folder the working directory
WORKDIR /var/www/html

ENTRYPOINT ["/bin/bash", "/entrypoint.sh"]