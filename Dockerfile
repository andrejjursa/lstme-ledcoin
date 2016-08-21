FROM php:5.6-apache

RUN apt-get update && \
    apt-get install -y curl git-core && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD . /var/www/html

RUN composer install --no-interaction

ADD entrypoint.sh /usr/local/bin

EXPOSE 80

CMD entrypoint.sh
