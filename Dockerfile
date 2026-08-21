# المرحلة الأولى: بناء الاعتمادات (Dependencies)
FROM php:8.2-fpm-alpine as vendor

# تثبيت الإضافات الضرورية فقط
RUN docker-php-ext-install pdo_mysql bcmath

# نسخ ملفات Composer أولاً للاستفادة من الـ Caching
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY composer.json composer.lock ./

# تثبيت المكتبات بدون ملفات التطوير وبشكل محسن
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# المرحلة الثانية: الصورة النهائية (Production Image)
FROM php:8.2-fpm-alpine

# تثبيت الإضافات الضرورية للتشغيل
RUN docker-php-ext-install pdo_mysql bcmath opcache

# نسخ الإعدادات المحسنة لـ PHP (OpCache)
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www/html

# نسخ المكتبات من المرحلة الأولى
COPY --from=vendor /app/vendor ./vendor
COPY . .

# تشغيل الـ Autoloader وتحسين الأداء
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative

# تحسين لارافيل (تخزين الإعدادات والمسارات في الذاكرة المؤقتة)
# هذه الخطوة توفر الكثير من وقت المعالجة عند كل طلب
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# تأمين المجلدات
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80

CMD ["php-fpm"]


COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh
ENTRYPOINT ["/usr/local/bin/start.sh"]
