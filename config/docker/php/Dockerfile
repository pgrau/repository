FROM php:8.1-cli

COPY --from=composer:2.2 /usr/bin/composer /usr/local/bin/composer

COPY opcache.ini /usr/local/etc/php/conf.d/

RUN apt-get update && apt-get upgrade -y \
    && apt-get install apt-utils -y \
    && apt-get install git zip vim libzip-dev libgmp-dev libffi-dev libssl-dev -y \
    && docker-php-ext-install -j$(nproc) sockets zip gmp pcntl bcmath ffi \
    && pecl install xdebug-3.1.5 \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && echo "apc.enabled=1" >> /usr/local/etc/php/conf.d/apcu.ini \
    && echo "apc.enable_cli=1" >> /usr/local/etc/php/conf.d/apcu.ini \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && docker-php-source delete \
    && apt-get autoremove --purge -y && apt-get autoclean -y && apt-get clean -y