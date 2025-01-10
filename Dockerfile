# Use a smaller Alpine-based PHP image
FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install system dependencies in steps for better debugging
RUN apk update && apk add --no-cache \
    curl \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libonig-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd \
    && docker-php-ext-enable opcache

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Set appropriate permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Install app dependencies
RUN composer install --no-dev --optimize-autoloader --prefer-dist

# Expose port 9000
EXPOSE 9000

CMD ["php-fpm"]
