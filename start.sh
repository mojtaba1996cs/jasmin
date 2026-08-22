#!/bin/sh

# طباعة رسالة بدء التشغيل لتظهر في سجلات Render
echo "🚀 Starting Application Initialization..."

# 1. إنشاء رابط التخزين (Storage Link)
# استخدام --force يضمن إعادة إنشاء الرابط حتى لو كان موجوداً بشكل خاطئ
echo "🔗 Creating storage link..."
php artisan storage:link --force

# 2. تنفيذ المهاجرة (Migrations)
# استخدام --force إلزامي في وضع الإنتاج لتجاوز رسائل التأكيد
echo "🗄️ Running database migrations..."
php artisan migrate --force

# 3. تحسين الأداء (اختياري ولكنه يسرع الموقع)
echo "⚡ Optimizing configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. تشغيل خادم PHP الأساسي
# استخدام exec يجعل PHP هو العملية الأساسية لضمان استقرار الحاوية
echo "🏁 Starting PHP-FPM..."
exec php-fpm
