#!/bin/bash

cd /var/www/html
rm -f config.yaml

echo "env: '${APP_ENV}'" >> config.yaml
echo "host: '${APP_ENV}'" >> config.yaml
echo "db:" >> config.yaml
echo "  hostname: '${DB_HOSTNAME}'" >> config.yaml
echo "  username: '${DB_USERNAME}'" >> config.yaml
echo "  password: '${DB_PASSWORD}'" >> config.yaml
echo "  database: '${DB_DATABASE}'" >> config.yaml

cat config.yaml

echo Starting apache2-foreground ...
apache2-foreground
