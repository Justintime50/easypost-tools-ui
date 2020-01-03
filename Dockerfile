FROM justintime50/nginx-php:7.4

COPY --chown=www-data:www-data ./src /var/www/html
COPY nginx.conf /etc/nginx/conf.d/default.conf
RUN php composer.phar install -q --no-ansi --no-interaction --no-scripts --no-suggest --no-progress --prefer-dist \
    && chmod -R 775 storage \
    && php artisan storage:link \
    && chmod -R 775 bootstrap/cache
