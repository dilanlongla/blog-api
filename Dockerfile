FROM php:8.2-fpm-alpine as build

# Install dependencies
RUN apk add --no-cache \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Set working directory and copy application files
WORKDIR /app
COPY . /app

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Production Stage
FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /app

# Copy the app from the build stage
COPY --from=build /app /app

# Install runtime dependencies
RUN apk add --no-cache \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Clean up unnecessary files
RUN rm -rf /var/lib/apt/lists/*

# Command to run the application
CMD ["php-fpm"]
