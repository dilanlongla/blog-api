# Build Stage
FROM php:8.2-fpm-alpine as build

# Install build dependencies
RUN apk add --no-cache git unzip libpng-dev libjpeg-turbo-dev freetype-dev \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Set working directory and copy application files
WORKDIR /app
COPY . /app

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Production Stage
FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /app

# Copy built application files from the build stage
COPY --from=build /app /app

# Install runtime dependencies
RUN apk add --no-cache libpng-dev libjpeg-turbo-dev freetype-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Expose port for PHP-FPM
EXPOSE 9000

# Command to start PHP-FPM
CMD ["php-fpm"]
