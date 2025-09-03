#!/bin/bash
echo "Running release script..."
php artisan migrate --force
php artisan db:seed --force --class=AdminUserSeeder
echo "Release script complete!"
