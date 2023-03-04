FROM justintime50/nginx-php:8.1-14

COPY --chown=www-data:www-data ./src /var/www/html

RUN composer install -q --no-ansi --no-interaction --no-scripts --no-plugins --no-progress --prefer-dist \
    && chmod -R 755 storage bootstrap/cache \
    && php artisan storage:link \
    && php artisan optimize:clear \
    && npm install -s \
    && npm run build
