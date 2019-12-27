# EasyPost UI

[![Build Status](https://travis-ci.org/Justintime50/easypost-ui.svg?branch=master)](https://travis-ci.org/Justintime50/easypost-ui)
[![MIT Licence](https://badges.frapsoft.com/os/mit/mit.svg?v=103)](https://opensource.org/licenses/mit-license.php)

Easily interact with the EasyPost API to order one-off packages and labels via a simple UI.

## What Can it Do?

- Create shipments with carrier labels for you to print
- Create addresses, parcels, and trackers independantly
- Track a package
- Refund a shipment
- Retrieve addresses, parcels, shipments, insurance, and trackers from the EasyPost DB

## How it Works

The EasyPost API creates a label once it receives a `from_address`, `to_address`, `parcel`, and the user selects their preferred shipping rate/method. We verify the addresses and return a label for download. Print the label, slap it on your package, and drop it off at your carriers location. That's it!

## Setup

**EasyPost API:** You'll need a test or production API key from [EasyPost's website](https://easypost.com). Create an account and grab the API key you'd like to use. If using your production API key, make sure to setup billing info on your EasyPost account.

1) This project requires [Docker](https://www.docker.com/products/docker-desktop) and an account. Install and login to Docker.
2) Run `./setup.sh` in the project's root directory and provide your EasyPost API Key when prompted. Once the script is finished, you're all set!

## Usage

Once the project is setup, navigate to `localhost:8000` in a browser and you'll arrive at the app. Use the various links to interact with the API. *NOTE: this app is currently intended to be  hosted locally and not exposed to the internet as it currently does not allow for multiple users or API keys.*

- Simply run `docker-compose up -d` in the project's root directory for future production deployments.
- Run `docker-compose up -f docker-compose-dev.yml -d` in the project's root directory for development deployments. <i>You'll need to install project dependencies outside of the Docker container: `php composer.phar install`.</i>

## Testing & Development

### PHP Standards Fixer

PHP coding standards can be fixed automatically by running: 
```bash
php-cs-fixer fix laravel --verbose --show-progress=estimating
```

### Testing

Unit tests require a test API key added to the `phpunit.xml` file. Then, the tests can be run with the following:

```bash
./vendor/bin/phpunit
```

PHP linting and Docker build testing is handled via [Travis](https://travis-ci.org/Justintime50/easypost-ui).

## Roadmap

The following are future ideas that can be incorporated:
- Create Insurance feature
- USPS/Fedex/UPS predefined package selection
- Swap out json responses for graphical tables

## Disclaimer

This project is not endorsed or maintained by EasyPost.
