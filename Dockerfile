FROM justintime50/nginx-php:8.5-36

ARG PROD
ENV PROD=$PROD

COPY --chown=www-data:www-data ./src /var/www/html

RUN if [ -n "$PROD" ]; then \
    # Setup prod env
    composer install -q --no-ansi --no-interaction --no-scripts --no-plugins --no-progress --prefer-dist --optimize-autoloader --no-dev \
    && npm install -s --omit=dev \
    && npx vite build; \
    # Setup dev env
    else \
    composer install \
    && npm install; \
    fi \
    # Setup shared env
    && php artisan storage:link

ENTRYPOINT ["/bin/sh", "-c", "if [ -n \"$PROD\" ]; then php artisan optimize; else php artisan optimize:clear; fi; exec supervisord"]
