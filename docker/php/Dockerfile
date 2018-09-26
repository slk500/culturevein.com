FROM php:7.0-apache

RUN apt-get update

RUN apt-get install -y libpq-dev \
    &&  docker-php-ext-install pdo pdo_mysql