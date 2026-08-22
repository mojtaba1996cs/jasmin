#!/bin/sh

# 1. طباعة رسالة لبدء العملية (تظهر في سجلات Render)
echo "🚀 Starting application initialization..."

# 2. إنشاء رابط التخزين (Storage Link)
# استخدام --force يضمن إعادة إنشاء الرابط حتى لو كان موجوداً بشكل خاطئ
echo "🔗 Creating storage link..."
php artisan storage:link --force

# 3. تنفيذ المهاجرة (Migrations)
# استخدام --force إلزامي في وضع الإنتاج (Production) لتجاوز رسائل التأكيد
echo "🗄️ Running database migrations..."
php artisan migrate --force

# 4. تحسين الأداء (اختياري ولكن ينصح به)
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. تشغيل الخادم الأساسي
# استخدام exec يضمن أن يصبح PHP هو العملية الأساسية (PID 1)
echo "🏁 Starting PHP-FPM..."
exec php-fpm
