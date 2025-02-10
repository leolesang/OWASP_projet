FROM php:8.2-apache

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
	
RUN mkdir -p /var/lib/php/sessions && chown -R www-data:www-data /var/lib/php/sessions && chmod -R 777 /var/lib/php/sessions


RUN docker-php-ext-install mysqli

EXPOSE 80
