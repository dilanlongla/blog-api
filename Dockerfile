# Use an official PHP image as a base image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install necessary system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    curl \
    libonig-dev \
    libpng-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl \
    && docker-php-ext-enable opcache

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Set appropriate permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Install app dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port 9000 and start PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]