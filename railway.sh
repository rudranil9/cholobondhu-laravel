#!/usr/bin/env bash

echo "Starting Railway deployment..."

# Install composer dependencies
echo "Installing dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Create storage directories if they don't exist
echo "Setting up storage..."
mkdir -p storage/logs
mkdir -p storage/framework/{cache,sessions,views}
mkdir -p bootstrap/cache

# Set proper permissions (if possible)
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# Clear all caches first
echo "Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Generate application key if not set
echo "Generating app key..."
php artisan key:generate --force

# Run database migrations
echo "Running migrations..."
php artisan migrate --force

# Cache configuration for production
echo "Caching config..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Deployment completed successfully!"
