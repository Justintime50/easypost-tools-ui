# EasyPost UI

Easily interact with the EasyPost API to order one-off packages and labels via a simple UI.

## Setup

**EasyPost API:** You'll need a test or production API key from [EasyPost's website](https://easypost.com). Create an account and grab the API key you'd like to use. If using your production API key, make sure to setup billing info on your EasyPost account.

This project requires [Docker](https://www.docker.com/products/docker-desktop), [PHP 7.2+](https://www.php.net/downloads.php), and [Composer](https://getcomposer.org).

**Run Script:** To setup EasyPost UI, simply open `setup.command` and it will setup everything for you! All you'll need to do is add your API key to the `.env` file.

If you want manual setup instructions, see our [SETUP.md](/SETUP.md) file. <i>This project can be deployed without Docker and just PHP if these steps are followed.</i>

## Usage

Once the project is setup, navigate to `localhost:8000` and you'll arrive at the app. Use the various links to interact with the API via a UI.

Simply run `docker-compose up -d` in the project root directory for future deployments.

## How it Works

The EasyPost API creates a label once it receives a `from_address`, `to_address`, and `parcel`. We verify the addresses and select the cheapest rate for USPS and return a label URL. Print the label, slap it on your package, and drop it off at a USPS location. That's it!

## Roadmap

The following are future features planned to be incorproated:
- Support multiple carriers
- Support multiple rates/shipping speeds
- Insurance object
- Tracking object
