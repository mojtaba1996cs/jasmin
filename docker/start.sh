#!/bin/bash
set -e

# مسح الكاش القديم قبل إعادة البناء (احتياطي)
php artisan config:clear
php artisan route:clear

# تخزين الكاش لتحسين الأداء
php artisan config:cache
php artisan route:cache
php artisan view:cache

# تشغيل المايجريشن تلقائياً عند كل نشر
php artisan migrate --force

# تشغيل php-fpm في الخلفية
php-fpm -D

# تشغيل nginx في المقدمة (يبقيه العملية الأساسية للحاوية)
nginx -g "daemon off;"