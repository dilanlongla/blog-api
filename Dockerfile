# Use official PHP image with FPM (FastCGI Process Manager) and Apache
FROM php:8.2-fpm

# Set working directory inside the container
WORKDIR /var/www/html

# Install system dependencies and PHP extensions required for Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mbstring

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the Laravel application into the container
COPY . /var/www/html

# Install dependencies using Composer
RUN composer install --no-dev --optimize-autoloader

# Expose port 9000 for the PHP-FPM service
EXPOSE 9000

# Command to start PHP-FPM server
CMD ["php-fpm"]
