# CHANGELOG

## NEXT RELEASE

* Bumps Laravel from v6 to v9
* Bumps PHP from 7.4 to 8.1
* Bumps all dependencies

## v0.3.1 (2021-02-12)

* Now using Laravel Mix to compile assets
* Bumped dependencies

## v0.3.0 (2021-02-09)

* Remove `composer.phar` from repo (storing binaries in git is bad) and use updated Docker image that contains composer installed
* Switch from Travis CI to GitHub Actions
* Bumped dependencies

## v0.2.2 (2020-12-11)

* Fixed links to nowhere from opening in a new tab (closes #31)
* Swapped text/image order on nav links so pictures come first making it look more uniform
* Overhauled setup instructions in README
* Allow project to run on PHP 8
* Updated Composer and NPM dependencies
* Added register link to login page

# v0.2.1 (2020)

* Removed the address verification on shipment creation

# v0.2.0 (2019)

* Reworked the entire UI to be simpler, more verbose, and contain navigation
* New shipment workflow allowing you to select from a table of rates
* Login system


# v0.1.0 (2019)

* Initial release
* Create labels
* Track packages
* Insure packages
* Refund shipments
* Retrieve EasyPost records
