FROM php:8.2-apache

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

RUN docker-php-ext-install mysqli

RUN mkdir -p /var/lib/php/sessions && chown -R www-data:www-data /var/lib/php/sessions && chmod -R 777 /var/lib/php/sessions

RUN apt-get update && apt-get install -y python3 python3-pip iputils-ping

EXPOSE 80