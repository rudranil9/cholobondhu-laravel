#!/bin/bash

echo "=== Build Script Starting ==="

# Install dependencies
echo "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

echo "Installing NPM dependencies..."
npm ci

echo "Building assets..."
npm run build

echo "=== Build Script Complete ==="
