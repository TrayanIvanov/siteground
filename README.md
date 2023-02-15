# SiteGround assignment

Create solution for supermarket checkout.
- Promotion price is available for {n} products of specific type
- User should be able to see list of products, submit choosen ones and see receipt
- Receipt is stored in database
- Console should be available for the same checkout process

## Setup

### Install backend dependencies

`composer install`

### Run containers

`docker compose up -d`

### Set up environment variables

No sesitive keys included in .env - ready for dev environment

### Execute migrations and seed database

`docker exec app php bin/console doctrine:migrations:migrate`

## Usage

Application can be reached on: http://localhost/

### Command
- `docker exec app php bin/console app:checkout {listOfProducts}` - same checkout behaviour as application (Example list of products - AACBA)

## Run tests

`docker exec app vendor/bin/phpunit   `