FROM php:8.2-apache

COPY . /var/www/html/


RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html


RUN mkdir -p /var/lib/php/sessions && chown -R www-data:www-data /var/lib/php/sessions && chmod -R 777 /var/lib/php/sessions

RUN docker-php-ext-install mysqli

RUN a2enmod rewrite

RUN echo "<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" >> /etc/apache2/sites-available/000-default.conf

EXPOSE 80
