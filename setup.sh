#!/bin/bash

docker-compose up --build -d
cd laravel
cp .env.example .env
echo "Enter your EasyPost API Key: "
read -r APIKEY
sed -i '' -e "s/EASYPOST_API_KEY=/EASYPOST_API_KEY=$APIKEY/g" .env
