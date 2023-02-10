# CHANGELOG

## v0.7.0 (2022-09-10)

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
