## About E-Commerce API

This example API allows you to integrate your prototype system of E-Commerce. You can manage products, orders, and shops using all APIs that we provided in this document. Lumen E-Commerce API Services is a JSON-based OAuth2 API. All requests must be secure (http) and authenticated.

## Requirements
- PHP >= 7.3.0
- Laravel/Lumen

## Usage
1. Fork this repository.
2. Duplicate `.env.example` and rename it to `.env` then make  changes according to your development server configuration.
3. Run the command `composer install` in the project folder of this repository.
4. Run the command `php artisan key:generate`
5. Create a database called `db_ecommerce` (match with your .env) on your development server
6. Run the command `php artisan migrate:fresh --seed`
7. Run the app `php -S localhost:8000 -t public`
