# EasyPost UI

Easily interact with the EasyPost API to order one-off packages and labels via a simple UI.

## Setup

This project requires [Docker](https://www.docker.com/products/docker-desktop). After installing and logging in, follow the instructions below:

### Laravel

Navigate to the `site` directory of the project and run:
```bash
php composer.phar install

// OR 

composer install
```

Generate a Laravel key:

```bash
cp .env.example .env

php artisan key:generate
```

**Ensure you have added your EasyPost API key to the .env file.**

Start up docker containers in project root directory:

```bash
docker-compose up -d

// OR

php artisan serve
```

## Usage

Navigate to `localhost:8000` and you'll arrive at the app. Use the various links to interact with the API via a UI.