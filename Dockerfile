FROM justintime50/nginx-php:8.3-19

ARG PROD

COPY --chown=www-data:www-data ./src /var/www/html

RUN if [ ! -z "$PROD" ]; then \
    # Setup prod env
    composer install -q --no-ansi --no-interaction --no-scripts --no-plugins --no-progress --prefer-dist --optimize-autoloader --no-dev \
    && npm install -s --omit=dev \
    && npm run build \
    && php artisan optimize; \
    # Setup dev env
    else \
    composer install \
    && npm install \
    && php artisan optimize:clear; \
    fi \
    # Setup shared env
    && php artisan storage:link
