# Gunakan base image PHP dengan Apache
FROM php:8.2-apache

# Install ekstensi PHP yang dibutuhkan Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Atur direktori kerja
WORKDIR /var/www/html

# Salin semua file dari proyek ke dalam container
COPY . .

# Jalankan hanya composer install
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copy file konfigurasi Apache Laravel
COPY ./docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Aktifkan mod_rewrite Apache
RUN a2enmod rewrite
