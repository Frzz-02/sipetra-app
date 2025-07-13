FROM php:8.2-fpm

RUN apt-get update \
  && apt-get install -y \
    curl git zip unzip libzip-dev libonig-dev libxml2-dev \
  && docker-php-ext-install pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /srv/app
COPY . /srv/app

RUN chown -R www-data:www-data storage bootstrap/cache \
  && find storage bootstrap/cache -type d -exec chmod 775 {} \; \
  && find storage bootstrap/cache -type f -exec chmod 664 {} \;

RUN composer install --no-dev --optimize-autoloader \
  && php artisan key:generate --ansi \
  && php artisan config:cache \
  && php artisan route:cache \
  && php artisan view:cache

RUN curl -sSL \
    "https://caddyserver.com/download/linux/amd64?p=personal&license=personal&modules=http.cache,http.git" \
  | tar -xz -C /usr/bin caddy && chmod +x /usr/bin/caddy

COPY Caddyfile /etc/caddy/Caddyfile

EXPOSE 80

CMD ["sh", "-c", "php-fpm & caddy run --config /etc/caddy/Caddyfile --adapter caddyfile"]
