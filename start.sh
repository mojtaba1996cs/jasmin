#!/bin/sh


echo "Running migrations..."
php artisan migrate --force


echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache


echo "Starting PHP-FPM..."
exec php-fpm
