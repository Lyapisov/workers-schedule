FROM php:8.0-cli-alpine

RUN apk add --update --no-cache unzip \
    postgresql-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql


# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --quiet \
    && rm -rf /root/.composer/cache
ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /app
