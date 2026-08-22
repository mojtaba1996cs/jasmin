# المرحلة الأولى: بناء المكتبات (Build Stage)
FROM php:8.2-fpm-alpine as vendor
RUN apk add --no-cache git unzip zip postgresql-dev
RUN docker-php-ext-install pdo_pgsql pdo_mysql bcmath

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --ignore-platform-reqs

# المرحلة الثانية: الصورة النهائية (Production Stage)
FROM php:8.2-fpm-alpine

# تثبيت إضافات PostgreSQL للتشغيل
RUN apk add --no-cache postgresql-dev libpq \
    && docker-php-ext-install pdo_pgsql pdo_mysql bcmath opcache \
    && apk del postgresql-dev \
    && apk add --no-cache postgresql-libs

WORKDIR /var/www/html

# نسخ كافة ملفات المشروع مباشرة من المستودع (GitHub) لضمان وجود 'artisan'
COPY . .

# نسخ مجلد 'vendor' فقط من مرحلة البناء الأولى
COPY --from=vendor /app/vendor ./vendor

# تحسين الأداء (أوامر Artisan ستعمل الآن لأن الملف موجود في المجلد الحالي)
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# ضبط الصلاحيات
RUN chown -R www-data:www-data storage bootstrap/cache && chmod -R 775 storage bootstrap/cache

# إعداد ملف التشغيل
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh
RUN sed -i 's/\r$//' /usr/local/bin/start.sh

EXPOSE 80
CMD ["/usr/local/bin/start.sh"]
