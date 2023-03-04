# CHANGELOG

## Next Release

- Fixes bugs where the request wasn't set correctly for parcels. users, or search
- Fixes the input of creating a parcel from strings to numbers
- Temporarily downgrade to PHP 8.1 in Dockerfile

## v0.9.1 (2023-02-24)

- Fixes address fields on forms with address input to contain the necessary fields for the object in question (removed some fields from buying a stamp, added back a few for insurances from bad copy-pasta)
- Fixes the redirect when buying a stamp to go back to the shipment page

## v0.9.0 (2023-02-24)

- Upgrades from Laravel 9 to Laravel 10
  - Bumps all dependencies
  - Migrates from Webpack to Vite
- Rewrote the whole app's routing system
  - All endpoints/urls now follow proper REST conventions (endpoint names, ids, verbs, etc)
  - The app no longer functions as a psuedo single-page-app, instead, you have to select a resource from the sidebar which takes you to that resources page where there are now buttons to take actions against that type of resource. The initial landing page of each resrouce will retrieve all the records of that resource
- Shipments can now be bought if they were previously created and unpurchased. Previously, you would need to make a new shipment as once you navigated away from the rates page, the buy option for that shipment was lost
  - Removed the ability to purchase a shipment by providing a shipment and rate ID since you can now purchase shipments directly from the individual shipment page
- Hides the buy shipping label buttons from the shipment page once a shipment has been purchased
  - The `selected_rate` row is now highlighted once purchased so you know which rate was bought
- Adds a new `/refunds` page where you can view all your refunded shipments
- Removes sidebar links to EasyPost resources that weren't supported in this project to avoid confusion
- Fixes a syntax error for refunding a shipment due to v6 EasyPost lib upgrade
- Removes address verification from creating an insurance
- Various other bug fixes and improvements

## v0.8.2 (2023-02-17)

- Fix Shipment buy method call

## v0.8.1 (2023-02-17)

- Fix create insurance, and parcel routing
- Fix search object lookup that wasn't migrated when we moved from EasyPost PHP lib v5 to v6

## v0.8.0 (2023-02-10)

- Bumps EasyPost library from v5 to v6 which introduces thread-safety and various other improvements

## v0.7.0 (2023-02-10)

- Bumps PHP from 8.1 to 8.2
- Bumps all minor dependency versions
- Completely overhauls all app routing to fix various bugs with GET vs POST and the names of pages which also corrects various workflows like purchasing a shipment
- Removes all individual "retrieve x" modals and logic and replaces it with a global search by ID form. Now you can lookup any EasyPost object by its public ID
- Adds missing `name` and `email` properties to Address forms
- Various other bug fixes and cleanup throughout

## v0.6.1 (2022-08-29)

- Fixes a Sentry error where retrieving all shipments could error when there is no to/from or parcel objects set on a shipment because it would try accessing properties of null, now there is a check in place prior to displaying data
- Shows name and company on all shipment addresses
- Fixes a bug where recaptcha was required in development mode

## v0.6.0 (2022-06-15)

- Adds recaptcha to registration (when keys/secrets are present in the env)
- Cleans up and unifies styles for project

## v0.5.0 (2022-03-22)

- Add the ability to buy a USPS stamp (uses the first USPS carrier account on file, USA addresses only)
- Cleaned up error handling with shipment API calls
- Adds `sentry` integration
- Bumps MariaDB from `10.6.5` to `10.6.7`

## v0.4.0 (2022-03-01)

- Bumps Laravel from v6 to v9
- Bumps PHP from 7.4 to 8.1
- Bumps all dependencies
- Fixed a bug where the `create insurance` modal wouldn't open

## v0.3.1 (2021-02-12)

- Now using Laravel Mix to compile assets
- Bumped dependencies

## v0.3.0 (2021-02-09)

- Remove `composer.phar` from repo (storing binaries in git is bad) and use updated Docker image that contains composer installed
- Switch from Travis CI to GitHub Actions
- Bumped dependencies

## v0.2.2 (2020-12-11)

- Fixed links to nowhere from opening in a new tab (closes #31)
- Swapped text/image order on nav links so pictures come first making it look more uniform
- Overhauled setup instructions in README
- Allow project to run on PHP 8
- Updated Composer and NPM dependencies
- Added register link to login page

# v0.2.1 (2020)

- Removed the address verification on shipment creation

# v0.2.0 (2019)

- Reworked the entire UI to be simpler, more verbose, and contain navigation
- New shipment workflow allowing you to select from a table of rates
- Login system

# v0.1.0 (2019)

- Initial release
- Create labels
- Track packages
- Insure packages
- Refund shipments
- Retrieve EasyPost records
