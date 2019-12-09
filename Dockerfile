FROM php:fpm

# RUN docker-php-ext-install mysqli pdo pdo_mysql
COPY --chown=1000:1000 ./laravel /var/www/html
WORKDIR /var/www/html
RUN php composer.phar install
# COPY ./.env.example ./.env
RUN php artisan key:generate
