#!/bin/sh
php artisan migrate --force
php artisan storage:link --force
exec php-fpm
