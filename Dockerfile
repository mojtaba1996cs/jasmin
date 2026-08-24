FROM php:8.4-fpm

# تثبيت الحزم المطلوبة
RUN apt-get update && apt-get install -y \
    git curl libpq-dev libzip-dev zip unzip nginx \
    && rm -rf /var/lib/apt/lists/*

# تثبيت إضافات PHP المطلوبة
RUN docker-php-ext-install pdo pdo_pgsql zip

# نسخ composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# نسخ ملفات المشروع
COPY . .

# تثبيت الحزم
RUN composer install --optimize-autoloader --no-dev --no-interaction

# صلاحيات storage و cache
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# إعداد nginx
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf
RUN rm -f /etc/nginx/sites-enabled/default

# سكربت التشغيل
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 10000

CMD ["/start.sh"]
