#!/bin/bash

cd laravel || exit
cp .env.example .env
docker-compose up --build -d
echo "Enter your EasyPost API Key: "
read -r APIKEY
shopt -s dotglob # ensure we can replace the hidden .env file
sed -i '' -e "s/EASYPOST_API_KEY=/EASYPOST_API_KEY=$APIKEY/g" .env
docker exec -it easypost-ui php artisan key:generate
history -c
