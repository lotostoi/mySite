FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    mysql-client

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files (optional, we use volumes)
# COPY . /var/www

# Set permissions will be done after volume mount

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

