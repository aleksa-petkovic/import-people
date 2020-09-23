# Import people application

The purpose of this app is to import people from CSV file. 

## Server Requirements

- PHP Version: 7.4
 
## Installation

- Run `composer install`
- Copy `.env.example` to `.env` file and change database (and other) configs.
- Run `php artisan key:generate` to generate app key.
- Run `php artisan migrate --step --seed` to migrate and seed DB in one run.

## Usage

Login: /login

Register: /register

Admin Panel URL: /admin
 
#### Default admin user credentials: 
- email: admin@admin.com
- password: admin

### API Documentation
https://documenter.getpostman.com/view/11345857/TVKEXcaF
