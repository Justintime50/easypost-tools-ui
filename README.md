<div align="center">

# EasyPost UI

Create shipping labels, track, insure, and refund packages all from a simple UI.

[![Build Status](https://travis-ci.com/Justintime50/easypost-ui.svg?branch=master)](https://travis-ci.com/Justintime50/easypost-ui)
[![Coverage Status](https://coveralls.io/repos/github/Justintime50/easypost-ui/badge.svg?branch=master)](https://coveralls.io/github/Justintime50/easypost-ui?branch=master)
[![Licence](https://img.shields.io/github/license/justintime50/easypost-ui)](LICENSE)

<img src="assets/showcase.gif">

</div>

## What Can it Do?

- Create shipments and printable labels with upwards of 100 carriers
- Retrieve addresses, carriers, insurance, parcels, shipments, and trackers from EasyPost
- Track a package
- Insure a package
- Refund a shipment
- Support multiple users with unique logins and EasyPost API keys

## How it Works

The EasyPost API allows you to create shipping labels with some of the biggest parcel carriers in the space. Supply a `from_address`, `to_address`, `parcel`, and preferred shipping rate/method. Print the label, slap it on your package, and drop it off at your carrier's location. That's it!

## Install

**EasyPost API:** You'll need a test or production API key from [EasyPost's website](https://easypost.com). Create an account and grab the API key you'd like to use. If using your production API key, make sure to setup billing info on your EasyPost account.

```bash
# Copy the env file and db init file, then edit both before continuing. The DB values must match in both files
cp src/.env.example src/.env
cp init-db.env.example init-db.env

# Start the Docker containers (edit docker-compose.yml to your needs prior)
docker-compose up -d

# Generate a Laravel key
docker exec -it easypost-ui php artisan key:generate

# Run database migrations once the database container is up and able to access connections
docker exec -it easypost-ui php artisan migrate
```

## Usage

Navigate to `localhost:8000` in a browser. Register an account and add your API Key on the `/account` page. You're all set!

Once the project is setup, simply interact with the various links in the app to interact with the API. Create records, retrieve them, and purchase shipping labels all without needing to do the hard work of mapping an API.

## Development

**NOTE:** To use dev dependencies, you'll need to install project dependencies outside of the Docker container on your machine.

```bash
# Install dev dependencies
cd src && php composer.phar install -q --no-ansi --no-interaction --no-scripts --no-suggest --no-progress --prefer-dist

# Run tests
./src/vendor/bin/phpunit
```
