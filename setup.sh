#!/bin/bash

# The following script will setup the project for the first time
# To run the project in the future, simply run `docker compose up -d`

setup() {
    cd src || exit 1

    # Install dependencies
    composer install
    npm install

    # Generate a Laravel key
    php artisan key:generate

    cd .. || exit 1

    # Spin up the project (assumes you already have Traefik setup)
    docker compose up -d --build --quiet-pull

    # Run database migrations once the database container is up and able to accept connections
    for ((ATTEMPT = 0; ATTEMPT <= 10; ATTEMPT += 1)); do
        if ! healthcheck; then
            echo "Database is not ready for connections with attempt #$ATTEMPT, retrying..."
            sleep 1
        else
            cd src || exit 1
            composer migrate-seed
            echo "Setup complete!"
            exit 0
        fi
    done

    exit 1
}

healthcheck() {
    docker ps | grep -q easypost-tools-ui-easypost-tools-ui-1
    docker ps | grep -q easypost-tools-ui-easypost-tools-db-1
    docker exec -t easypost-tools-ui-easypost-tools-db-1 mysql -uroot -ppassword -e "show databases;" &>/dev/null || false
}

setup
