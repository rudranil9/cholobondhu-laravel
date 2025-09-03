# Stage 1: Build the application with all dependencies
FROM php:8.2-cli as builder

# Install system dependencies for building
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    nodejs \
    npm \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies and build assets
RUN npm ci && npm run build

# ---

# Stage 2: Setup the production environment
FROM php:8.2-fpm

# Install production system dependencies with dev packages for extension compilation
RUN apt-get update && apt-get install -y \
    nginx \
    default-mysql-client \
    libonig5 \
    libonig-dev \
    libpng16-16t64 \
    libpng-dev \
    libxml2 \
    libxml2-dev \
    && rm -rf /var/lib/apt/lists/*

# Install production PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Set working directory
WORKDIR /app

# Copy built application from the builder stage
COPY --from=builder /app .

# Copy Nginx configuration
COPY docker/nginx/default.conf /etc/nginx/sites-enabled/default

# Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Set permissions
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache
RUN chmod -R 775 /app/storage /app/bootstrap/cache

# Expose port
EXPOSE ${PORT}

# Set entrypoint
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
