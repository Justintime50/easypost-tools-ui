FROM justintime50/nginx-php:latest

COPY --chown=www-data:www-data ./laravel /var/www/html
RUN php composer.phar install --no-scripts

WORKDIR /var/www/html

RUN chmod -R 775 storage \
    && php artisan storage:link \
    && chmod -R 775 bootstrap/cache
    
