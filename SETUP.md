# Setup

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