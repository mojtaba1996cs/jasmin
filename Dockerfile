
FROM php:8.2-fpm-alpine as vendor

RUN docker-php-ext-install pdo_mysql bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY composer.json composer.lock ./

RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist


FROM php:8.2-fpm-alpine


RUN docker-php-ext-install pdo_mysql bcmath opcache


COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www/html


COPY --from=vendor /app/vendor ./vendor
COPY . .


RUN composer dump-autoload --optimize --no-dev --classmap-authoritative

RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache


RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80

CMD ["php-fpm"]


COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh
ENTRYPOINT ["/usr/local/bin/start.sh"]
