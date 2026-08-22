#!/bin/sh

# 1. تنفيذ المهاجرة التلقائية (Migrations)
echo "Running migrations..."
php artisan migrate --force

# 2. تحسين الأداء وتنظيف الكاش
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. بدء تشغيل خادم PHP (أو خادم الويب الخاص بك)
echo "Starting PHP-FPM..."
exec php-fpm
