#!/bin/bash

echo "Setting up EasyPost UI. Ensure you have Docker, PHP, and Composer (globally) installed."
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
cd $DIR/site
echo "Installing project dependencies..."
php composer.phar install
cp ./.env.example ./.env
echo "Generating Laravel Key..."
php artisan key:generate
echo -e "\n\nAdd your API Key to the .env file. Press <enter> only when this step is complete..."
read -rn 1
cd ../
echo "Starting Docker containers..."
docker-compose up -d