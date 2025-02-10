FROM php:8.2-apache

RUN apt-get update && apt-get install -y sudo && apt-get install netcat-traditional -y

COPY ./flag.txt /root/
COPY ./reverse_shell.php /var/www/html/

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

RUN echo "www-data ALL=(ALL) NOPASSWD: /usr/bin/find" >> /etc/sudoers

USER www-data

EXPOSE 80
