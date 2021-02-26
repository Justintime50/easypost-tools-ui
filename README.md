<div align="center">

# EasyPost UI

Create shipping labels, track, insure, and refund packages all from a simple UI.

[![Build Status](https://github.com/Justintime50/easypost-ui/workflows/build/badge.svg)](https://github.com/Justintime50/easypost-ui/actions)
[![Licence](https://img.shields.io/github/license/justintime50/easypost-ui)](LICENSE)

<img src="assets/showcase.gif" alt="Showcase">

</div>

## What Can it Do?

The EasyPost UI is a proof of concept on how to build a complete shipping solution using the EasyPost API.

- Create shipments and printable labels with upwards of 100 carriers
- Retrieve addresses, carriers, insurance, parcels, shipments, and trackers from EasyPost
- Track a package
- Insure a package
- Refund a shipment
- Support multiple users with unique logins and EasyPost API keys

As this project is a proof of concept, it may be missing some EasyPost features. If you'd like to support its continued development, feel free to sponsor or star the project!

## How it Works

The EasyPost API allows you to create shipping labels with some of the biggest parcel carriers in the space. Supply a `from_address`, `to_address`, `parcel`, and preferred shipping rate/method. Print the label, slap it on your package, and drop it off at your carrier's location. That's it!

## Install

**EasyPost API:** You'll need a test or production API key from [EasyPost's website](https://easypost.com). Create an account and grab the API key you'd like to use. If using your production API key, make sure to setup billing info on your EasyPost account.

```bash
# Copy the env file and db init file, then edit both before continuing. The DB values must match in both files
cp src/.env.example src/.env
cp init-db.env.example init-db.env

# Run the dev environment (assumes you have Traefik setup)
docker-compose up -d

# Generate a Laravel key
cd src && php artisan key:generate

# Run database migrations once the database container is up and able to access connections
docker exec -it easypost-ui php artisan migrate
```

## Usage

Navigate to `easypostui.localhost` in a browser (you'll need to add this to your `/etc/hosts` file). Register an account and add your API Key on the `/account` page. You're all set!

Once the project is setup, simply interact with the various links in the app to interact with the API. Create records, retrieve them, and purchase shipping labels all without needing to do the hard work of mapping an API.

### Deploy to Production

```bash
# Deploy the project to production
docker-compose -f docker-compose.yml -f docker-compose-prod.yml up -d
```

## Development

**NOTE:** To use dev dependencies, you'll need to install project dependencies outside of the Docker container on your machine.

```bash
# Install dev dependencies
cd src && composer install -q --no-ansi --no-interaction --no-scripts --no-suggest --no-progress --prefer-dist

# Lint the project
./src/bin/phplint . --exclude=vendor

# Compile SASS and Javascript during development
npm run dev

# Compile for production
npm run prod

# Watch for CSS and Javascript changes
npm run watch
```
