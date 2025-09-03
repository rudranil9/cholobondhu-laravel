#!/bin/sh

# Exit immediately if a command exits with a non-zero status.
set -e

# Set default PORT if not provided
PORT=${PORT:-8080}

# Ensure production environment
export APP_ENV=production
export APP_DEBUG=false

echo "🚀 Starting Laravel application with Nginx + PHP-FPM..."
echo "📁 Checking build assets..."

# Debug: Check if assets exist
if [ -f "/app/public/build/assets/app-BCXFDP9b.css" ]; then
    echo "✅ CSS file exists: $(ls -la /app/public/build/assets/app-BCXFDP9b.css)"
else
    echo "❌ CSS file missing! Listing build directory:"
    ls -la /app/public/build/assets/ || echo "Build assets directory doesn't exist"
fi

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

echo "🗄️ Checking database status..."

# Check if migrations table exists (indicating database is already set up)
if php artisan tinker --execute="
    try {
        \$tables = DB::select('SHOW TABLES');
        \$migrationTableExists = false;
        foreach (\$tables as \$table) {
            \$tableName = array_values((array) \$table)[0];
            if (\$tableName === 'migrations') {
                \$migrationTableExists = true;
                break;
            }
        }
        if (\$migrationTableExists) {
            echo 'Database already initialized';
            exit(0);
        } else {
            echo 'Database needs initialization';
            exit(1);
        }
    } catch (Exception \$e) {
        echo 'Database check failed: ' . \$e->getMessage();
        exit(1);
    }
" 2>/dev/null; then
    echo "✅ Database already initialized, running incremental migrations..."
    if php artisan migrate --force; then
        echo "✅ Incremental migrations completed successfully!"
    else
        echo "❌ Migration failed!"
        exit 1
    fi
else
    echo "🆕 Fresh database detected, running initial setup..."
    if php artisan migrate:fresh --force; then
        echo "✅ Fresh database setup completed successfully!"
    else
        echo "❌ Fresh database setup failed!"
        exit 1
    fi
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
