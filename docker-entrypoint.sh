#!/bin/bash

echo "🚀 Starting Laravel application..."

# Wait for MySQL to be ready
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
        ((attempt++))
    fi
done

echo "🗄️ Running database migrations..."
if php artisan migrate:fresh --force; then
    echo "✅ Migrations completed successfully!"
else
    echo "❌ Migration failed!"
    exit 1
fi

echo "🌟 Starting Laravel development server..."
exec php artisan serve --host=0.0.0.0 --port=$PORT
