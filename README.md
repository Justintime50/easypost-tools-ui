# EasyPost UI

This project allows someone to easily interact with the EasyPost API to order one-off packages/labels.

## Setup

### Laravel

Setup your .env variables. Use the .env.example template file for the basic setup. These are found in the laravel folder. NOTE: The DB host must be the DB Docker container name.

Install project dependencies. Navigate to the directory of the project and run:
```bash
php composer.phar install

> OR 

composer install
```

Generate a Laravel key:

```bash
php artisan key:generate
```

Start up docker containers:

```bash
docker-compose up -d

> OR (will require separate DB hosting)

php artisan serve
```

Migrate and create the database (do so inside the Docker container):

```bash
php artisan migrate
```
