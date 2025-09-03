#!/bin/bash

echo "🚀 Starting Railway deployment..."

# Set environment for artisan commands
export APP_ENV=production

echo "🧹 Clearing Laravel caches..."
php artisan config:clear
php artisan cache:clear  
php artisan view:clear
php artisan route:clear

echo "⏳ Waiting for database to be ready..."
sleep 30

echo "🔌 Testing database connection..."
php artisan tinker --execute="
try {
    DB::connection()->getPdo();
    echo 'Database connected successfully!';
} catch (Exception \$e) {
    echo 'Database connection failed: ' . \$e->getMessage();
    exit(1);
}
"

echo "🗄️ Running fresh migrations..."
php artisan migrate:fresh --force

if [ $? -eq 0 ]; then
    echo "✅ Migrations completed successfully!"
else
    echo "❌ Migration failed!"
    exit 1
fi

echo "🌟 Starting Laravel application..."
exec php artisan serve --host=0.0.0.0 --port=$PORT
