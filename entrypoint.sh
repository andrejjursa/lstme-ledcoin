#!/bin/bash

echo Configuring app ...

cd /var/www/html
rm -f config.yaml

echo "env: '${APP_ENV}'" >> config.yaml
echo "host: '${APP_HOST}'" >> config.yaml
echo "db:" >> config.yaml
echo "  hostname: '${DB_HOSTNAME}'" >> config.yaml
echo "  username: '${DB_USERNAME}'" >> config.yaml
echo "  password: '${DB_PASSWORD}'" >> config.yaml
echo "  database: '${DB_DATABASE}'" >> config.yaml

php index.php cli config_from_yaml
php index.php cli migration 0

echo Starting apache2-foreground ...
apache2-foreground
