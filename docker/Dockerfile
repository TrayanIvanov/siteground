FROM php:8.2-apache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get update && apt-get install -y git libzip-dev unzip \
    && docker-php-ext-install zip pdo_mysql \
    && a2enmod rewrite headers

COPY .. /var/www/html
