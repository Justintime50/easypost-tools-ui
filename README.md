# EasyPost UI

Easily interact with the EasyPost API to order one-off packages and labels via a simple UI.

## Setup

**EasyPost API:** You'll need a test or production API key from [EasyPost's website](https://easypost.com). Create an account and grab the API key you'd like to use. If using your production API key, make sure to setup billing info on your EasyPost account.

1) This project requires [Docker](https://www.docker.com/products/docker-desktop) and an account. Install and login to Docker.
2) Add your EasyPost API Key to the `.env` file found in `/laravel`. 
3) Run `cp .env.example .env` to create the file.
4) Run `docker-compose up -d` in the project's root directory and you'll be all set!

<i>Alternatively to setting up via Docker, you can install PHP and run `php artisan serve` in the `/laravel` directory to start up the web server.</i>

## Usage

Once the project is setup, navigate to `localhost:8000` in a browser and you'll arrive at the app. Use the various links to interact with the API.

Simply run `docker-compose up -d` in the project root directory for future deployments.

## How it Works

The EasyPost API creates a label once it receives a `from_address`, `to_address`, and `parcel`. We verify the addresses and select the cheapest rate from USPS and return a label URL. Print the label, slap it on your package, and drop it off at a USPS location. That's it!

## Roadmap

The following are future features planned to be incorproated:
- Support multiple carriers
- Support multiple rates/shipping speeds
- Insurance object
- Tracking object
