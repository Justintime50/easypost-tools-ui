FROM justintime50/nginx-php:8.1-9

COPY --chown=www-data:www-data ./src /var/www/html

RUN composer install -q --no-ansi --no-interaction --no-scripts --no-suggest --no-progress --prefer-dist \
    # Set proper permissions on directories and link storage dir
    && chmod -R 755 storage \
    && chmod -R 755 bootstrap/cache \
    && php artisan storage:link \
    # Clear Laravel's cache
    && php artisan optimize:clear
