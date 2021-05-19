FROM php:8.0-fpm-alpine

RUN apk add --update --no-cache unzip \
    postgresql-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && rm -rf /root/.composer/cache

WORKDIR /app

ENV PATH="~/.composer/vendor/bin:./vendor/bin:${PATH}"

RUN adduser --uid 1000 --disabled-password userapp

RUN mkdir -p /home/userapp/.composer \
   && chown -R userapp /home/userapp/.composer \
   && chgrp -R userapp /home/userapp/.composer

USER userapp
