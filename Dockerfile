# المرحلة الأولى: بناء المكتبات (Build Stage)
FROM php:8.2-fpm-alpine as vendor

# تثبيت الإضافات الضرورية للبناء
RUN docker-php-ext-install pdo_mysql bcmath

WORKDIR /app
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./

# تثبيت المكتبات مع تجاهل قيود المنصة لضمان التوافق مع ملف lock الخاص بك
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --ignore-platform-reqs

# المرحلة الثانية: الصورة النهائية (Production Stage)
FROM php:8.2-fpm-alpine

# تثبيت الإضافات الضرورية للتشغيل
RUN docker-php-ext-install pdo_mysql bcmath opcache

WORKDIR /var/www/html

# نسخ المكتبات من المرحلة الأولى
COPY --from=vendor /app/vendor ./vendor
COPY . .

# تحسين أداء لارافيل
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# حل مشكلة الصلاحيات (UnableToCreateDirectory)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# إنشاء الرابط الرمزي للتخزين (في حال كنت تستخدم التخزين المحلي)
RUN php artisan storage:link --force

EXPOSE 80

CMD ["php-fpm"]



COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh
ENTRYPOINT ["/usr/local/bin/start.sh"]
