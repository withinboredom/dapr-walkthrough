FROM php:8-fpm

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN apt-get update && apt-get install -y wget git unzip && apt-get clean
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions curl zip opcache && mkdir -p /app
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY composer.json /app/composer.json
COPY composer.lock /app/composer.lock
WORKDIR /app
RUN composer install --no-dev -o -n

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY images/opcache.ini /tmp/opcache.ini
RUN cat /tmp/opcache.ini >> $PHP_INI_DIR/php.ini
COPY images/fpm.conf /usr/local/etc/php-fpm.d/www.conf

COPY src /app/src
