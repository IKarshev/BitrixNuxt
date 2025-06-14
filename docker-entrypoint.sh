#!/usr/bin/env sh
php -f /var/www/scripts/databaseCheck.php
composer install --working-dir=/var/www/www/local/composer --no-interaction --optimize-autoloader --no-dev
exec "$@"