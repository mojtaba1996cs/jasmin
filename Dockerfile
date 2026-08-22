
FROM php:8.2-fpm-alpine as vendor


RUN apk add --no-cache git unzip zip postgresql-dev


RUN docker-php-ext-install pdo_pgsql pdo_mysql bcmath

WORKDIR /app
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./

RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --ignore-platform-reqs



FROM php:8.2-fpm-alpine

RUN apk add --no-cache postgresql-dev \
    && docker-php-ext-install pdo_pgsql pdo_mysql bcmath opcache \
    && apk del postgresql-dev \
    && apk add --no-cache postgresql-libs

WORKDIR /var/www/html

COPY --from=vendor /app .


RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh
RUN sed -i 's/\r$//' /usr/local/bin/start.sh

EXPOSE 80
CMD ["/usr/local/bin/start.sh"]
