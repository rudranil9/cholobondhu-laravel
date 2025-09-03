FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nodejs \
    npm \
    git \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy the entire application first
COPY . .

# Install PHP dependencies (after artisan is available)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Install Node dependencies and build assets
RUN npm ci && npm run build

# Create storage directories
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Now run composer scripts (artisan is available)
RUN composer run-script post-autoload-dump

# Expose port
EXPOSE $PORT

# Start the application with MySQL wait
CMD echo "Waiting for MySQL..." && \
    sleep 30 && \
    echo "Testing MySQL connection..." && \
    php artisan tinker --execute="DB::connection()->getPdo(); echo 'Database connected!';" && \
    echo "Running migrations..." && \
    php artisan migrate:fresh --force && \
    echo "Starting Laravel server..." && \
    php serve.php
