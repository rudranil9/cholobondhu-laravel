#!/usr/bin/env bash

echo "Running deployment script..."

# Install composer dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Clear and cache Laravel configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
php artisan migrate --force

echo "Deployment completed!"
