FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files and run composer install
COPY composer.json composer.lock* ./
RUN composer install --no-scripts

# Copy the rest of the application
COPY . .

# # Generate the autoloader
# RUN composer dump-autoload

# Set permissions
RUN chown -R www-data:www-data /var/www

# Ensure artisan file is executable
RUN chmod +x /var/www/artisan

# Expose port and start server
EXPOSE 8080
CMD php artisan serve --host=0.0.0.0 --port=8880
