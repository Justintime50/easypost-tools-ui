FROM php:fpm

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN apt-get update \
    && apt-get install -y --no-install-recommends --no-install-suggests \
        openssl \
        git \
        unzip \
        zip
COPY --chown=1000:1000 ./laravel /var/www/html
WORKDIR /var/www/html
RUN php composer.phar install --no-scripts
