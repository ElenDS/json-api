FROM php:8.2-fpm

RUN apt-get update && apt-get install -y libzip-dev

RUN pecl install redis \
    && docker-php-ext-enable redis

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY . /var/www/html

EXPOSE 9000
