FROM php:8.3.11-fpm-alpine3.20 as app_php

RUN apk add --no-cache \
    curl \
    wget \
    git \
    bash \
    libzip-dev \
    libpq-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/40-custom.ini

RUN mkdir /usr/src/cache
WORKDIR /usr/src/cache

COPY ./composer.json ./
COPY ./composer.lock ./
COPY ./symfony.lock ./

RUN composer validate \
    && composer check-platform-reqs \
    && composer install --prefer-dist --no-dev --no-progress --no-scripts --no-autoloader --no-interaction \
    && composer clear-cache

COPY  ./ /var/www/app
WORKDIR /var/www/app
