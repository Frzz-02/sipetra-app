FROM php:8.2-cli

# Install ekstensi yang diperlukan Laravel
RUN apt-get update && apt-get install -y unzip libzip-dev && \
    docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy semua file ke dalam image
COPY . .

# Install dependency Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
