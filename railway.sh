#!/usr/bin/env bash

echo "=== Railway Deploy Script Starting ==="

# Wait a moment for database to be ready
echo "Waiting for database..."
sleep 5

# Clear any cached config first
echo "Clearing configuration cache..."
php artisan config:clear

# Set environment
echo "Setting up environment..."
php artisan key:generate --force

# Create storage directories and set permissions
echo "Setting up storage..."
mkdir -p storage/logs
mkdir -p storage/framework/{cache,sessions,views}
mkdir -p bootstrap/cache
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force

# Run database seeders
echo "Running database seeders..."
php artisan db:seed --force

# Cache configuration for production
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== Railway Deploy Script Complete ==="
