
FROM php:8.2-fpm-alpine as vendor

RUN apk add --no-cache git unzip zip postgresql-dev

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY composer.json composer.lock ./


RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --ignore-platform-reqs


FROM php:8.2-fpm-alpine

RUN apk add --no-cache postgresql-dev libpq \
    && docker-php-ext-install pdo_pgsql pdo_mysql bcmath opcache \
    && apk del postgresql-dev \
    && apk add --no-cache postgresql-libs

WORKDIR /var/www/html

COPY . .
COPY --from=vendor /app/vendor ./vendor


RUN php artisan config:cache && php artisan route:cache && php artisan view:cache


RUN chown -R www-data:www-data storage bootstrap/cache && chmod -R 775 storage bootstrap/cache

COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh
RUN sed -i 's/\r$//' /usr/local/bin/start.sh

EXPOSE 80
CMD ["/usr/local/bin/start.sh"]
