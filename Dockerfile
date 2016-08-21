FROM php:5.6-apache

RUN apt-get update
RUN apt-get install -y curl git-core libmcrypt-dev && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD . /var/www/html

RUN docker-php-ext-install mysql mysqli pdo pdo_mysql mcrypt

RUN composer install --no-interaction

ADD entrypoint.sh /usr/local/bin

ADD php.ini /usr/local/etc/php

RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 0770 /var/www/html

EXPOSE 80

CMD entrypoint.sh
