FROM php:5.6-apache

RUN apt-get update
RUN apt-get install -y curl 
RUN apt-get install -y git-core 
RUN apt-get install -y unzip
RUN apt-get install -y libmcrypt-dev
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install mysql mysqli pdo pdo_mysql mcrypt

ADD php.ini /usr/local/etc/php

VOLUME /var/www/html

EXPOSE 80

CMD /var/www/html/entrypoint.sh


