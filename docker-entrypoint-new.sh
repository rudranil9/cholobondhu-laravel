#!/bin/sh

# Exit immediately if a command exits with a non-zero status.
set -e

# Set default PORT if not provided
PORT=${PORT:-8080}

echo "🚀 Starting Laravel application with Nginx + PHP-FPM..."

# Wait for the database to be ready
echo "⏳ Waiting for MySQL to be ready..."
max_attempts=30
attempt=1

while [ $attempt -le $max_attempts ]; do
    echo "Attempt $attempt/$max_attempts: Testing MySQL connection..."
    
    if php artisan tinker --execute="
        try {
            DB::connection()->getPdo();
            echo 'MySQL connection successful!';
            exit(0);
        } catch (Exception \$e) {
            echo 'MySQL not ready: ' . \$e->getMessage();
            exit(1);
        }
    " 2>/dev/null; then
        echo "✅ MySQL is ready!"
        break
    else
        if [ $attempt -eq $max_attempts ]; then
            echo "❌ MySQL connection failed after $max_attempts attempts"
            exit 1
        fi
        echo "⏳ MySQL not ready yet, waiting 10 seconds..."
        sleep 10
        attempt=$((attempt + 1))
    fi
done

echo "🗄️ Running database migrations..."
if php artisan migrate:fresh --force; then
    echo "✅ Migrations completed successfully!"
else
    echo "❌ Migration failed!"
    exit 1
fi

echo "⚙️ Configuring Nginx for port $PORT..."

# Update nginx configuration with the correct port
sed -i "s/listen 8080/listen $PORT/g" /etc/nginx/sites-enabled/default

echo "🚀 Starting PHP-FPM..."
# Start PHP-FPM in the background
php-fpm -D

echo "🌐 Starting Nginx on port $PORT..."
# Start Nginx in the foreground to keep container running
exec nginx -g "daemon off;"
