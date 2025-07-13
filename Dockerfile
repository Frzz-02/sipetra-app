FROM php:8.2-apache

# Install extensions
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    git \
    && docker-php-ext-install pdo pdo_mysql zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy project files
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
 && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --optimize-autoloader --no-dev

# Laravel Commands
RUN php artisan config:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

EXPOSE 80
