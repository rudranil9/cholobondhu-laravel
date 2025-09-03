#!/bin/bash

echo "=== Starting Laravel Application ==="
echo "Waiting for services to be ready..."
sleep 20

echo "Clearing configuration cache..."
php artisan config:clear

echo "Running database migrations..."
php artisan migrate --force

if [ $? -eq 0 ]; then
    echo "Migrations completed successfully!"
    
    echo "Running database seeders..."
    php artisan db:seed --force --class=AdminUserSeeder
    
    echo "Caching configuration..."
    php artisan config:cache
    
    echo "Starting web server..."
    exec php artisan serve --host=0.0.0.0 --port=$PORT
else
    echo "Migration failed, but starting server anyway..."
    exec php artisan serve --host=0.0.0.0 --port=$PORT
fi
