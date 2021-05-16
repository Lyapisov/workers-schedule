FROM php:8.0-fpm

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql

WORKDIR /app

ARG XDEBUG_INI=/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo 'xdebug.remote_port=10000' >> ${XDEBUG_INI} \
    && echo 'xdebug.remote_enable=1' >> ${XDEBUG_INI} \
    && echo 'xdebug.remote_connect_back=0' >> ${XDEBUG_INI} \
    && echo 'xdebug.remote_autostart=1' >> ${XDEBUG_INI} \
    && echo 'xdebug.remote_handler=dbgp' >> ${XDEBUG_INI} \
    && echo 'xdebug.idekey=docker' >> ${XDEBUG_INI} \
    && echo 'xdebug.remote_host=192.168.0.2' >> ${XDEBUG_INI} \
    && echo 'xdebug.max_nesting_level=1024' >> ${XDEBUG_INI}
