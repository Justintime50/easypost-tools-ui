<div align="center">

# EasyPost Tools UI

Create shipping labels, track, insure, and refund packages all from a simple UI.

[![Build Status](https://github.com/Justintime50/easypost-tools-ui/workflows/build/badge.svg)](https://github.com/Justintime50/easypost-tools-ui/actions)
[![Licence](https://img.shields.io/github/license/justintime50/easypost-tools-ui)](LICENSE)

<img src="https://raw.githubusercontent.com/justintime50/assets/main/src/easypost-tools-ui/showcase.gif" alt="Showcase">

</div>

## What Can it Do?

The EasyPost Tools UI is a proof of concept on how to build a complete shipping solution using the EasyPost API.

- Create shipments and printable parcel labels & envelope stamps with upwards of 100 carriers
- Retrieve addresses, carriers, insurance, parcels, shipments, and trackers from EasyPost
- Track a package
- Insure a package
- Refund a shipment
- Support multiple users with unique logins and EasyPost API keys

As this project is a proof of concept, it may be missing some EasyPost features. If you'd like to support its continued development, feel free to sponsor or star the project!

**See the accompanying [EasyPost Tools](https://github.com/Justintime50/easypost-tools) repo for additional tooling not available via the UI.**

## How it Works

The EasyPost API allows you to create shipping labels with some of the biggest parcel carriers in the space. Supply a `from_address`, `to_address`, `parcel`, and preferred shipping rate/method. Print the label, slap it on your package, and drop it off at your carrier's location. That's it!

## Install

```bash
# Copy the env files, edit as needed
cp src/.env-example src/.env && cp .env-example .env

# Run the setup script which will bootstrap all the requirements, spin up the service, and migrate the database
./setup.sh
```

## Usage

Navigate to `easyposttools.localhost` locally or https://easyposttools.com in production.

Once the project is setup, simply interact with the various links in the app to interact with the API. Create records, retrieve them, and purchase shipping labels all without needing to do the hard work of mapping an API.

**EasyPost API:** You'll need a test or production API key from [EasyPost's website](https://easypost.com). Create an account and grab the API key you'd like to use. If using your production API key, make sure to setup billing info on your EasyPost account.

### Deploy

```bash
# Deploy the project locally
docker compose up -d

# Deploy the project in production
docker compose -f docker-compose.yml -f docker-compose-prod.yml up -d
```

## Development

**NOTE:** To use dev dependencies, you'll need to install project dependencies outside of the Docker container on your machine.

```bash
# Install dependencies
composer install

# Migrate the database
composer migrate
composer migrate-fresh

# Clean the database
composer db-clean

# Seed the database
composer seed

# Lint the project
composer lint

# Compile SASS and Javascript during development
npm run dev

# Compile for production
npm run prod

# Watch for CSS and Javascript changes
npm run watch
```
