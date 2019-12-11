FROM justintime50/nginx-php:latest

COPY --chown=www-data:www-data ./laravel /var/www/html
COPY nginx.conf /etc/nginx/conf.d/default.conf
RUN php composer.phar install

RUN chmod -R 775 storage \
    && php artisan storage:link \
    && chmod -R 775 bootstrap/cache
