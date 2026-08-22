#!/bin/bash


chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache


echo "Running migrations..."
php artisan migrate --force


echo "Starting Apache..."
apache2-foreground
