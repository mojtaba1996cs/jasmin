
FROM php:8.2-fpm-alpine as vendor


RUN docker-php-ext-install pdo_mysql bcmath

WORKDIR /app
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./


RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --ignore-platform-reqs


FROM php:8.2-fpm-alpine


RUN docker-php-ext-install pdo_mysql bcmath opcache

WORKDIR /var/www/html

COPY --from=vendor /app/vendor ./vendor
COPY . .

RUN composer dump-autoload --optimize --no-dev --classmap-authoritative
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

RUN php artisan storage:link --force

EXPOSE 80

CMD ["php-fpm"]



COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh
ENTRYPOINT ["/usr/local/bin/start.sh"]
