# Simple E-commerce Product [ Products - E-commerce Product Management Feature]


## BY

[![Laravel](https://img.shields.io/badge/-Laravel-white?style=flat-square&logo=laravel)](https://github.com/keroles19/)
[![mysql](https://img.shields.io/badge/-mysql-005C84?style=flat-square&logo=mysql&logoColor=white)](https://github.com/keroles19/)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white)](https://github.com/keroles19/)

# Requirments:

- PHP 8.1 or later.
- MySQL 5.7 or later.

## installation

after clone/ download the project file, `cd` into the project directory and follow the steps below:

- run `composer install` for download the required packages.
- if you don't see the `.env` file please do the following:
    - run `cp .env.example .env` to copy env file.
    - run `php artisan key:generate` to generate new app key.
- run `php artisan migrate` to run database migration.
- run `php artisan serve`   to run project.

### How Manually test using postman

- import `E-commerce Task.postman_collection.json` file into postman.
- replace `{{BASE_URL}}` with your base url.
- run the collection.
- you're done!
- you can view api documentation https://documenter.getpostman.com/view/32524285/2sAYHwJPuB
### Credentials


### NOTE

if you get any errors in this step, when seeding the database, related to existing data, please run the following:

- run `chmod ugo=rwx storage -R` to give permissions to storage folder for read/write actions.
- run `chown www-data storage -R` for the same reason described above.
- run `php artisan optimize:clear` to reset setting to is last good case.
