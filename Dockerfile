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

COPY .env.example .env

RUN composer install --no-dev --optimize-autoloader \
  && php artisan key:generate --ansi \
  && php artisan config:cache \
  && php artisan route:cache \
  && php artisan view:cache

RUN curl -fsSL -o /usr/bin/caddy \
     https://github.com/caddyserver/caddy/releases/download/v2.8.4/caddy_2.8.4_linux_amd64.tar.gz \
  && chmod +x /usr/bin/caddy

COPY Caddyfile /etc/caddy/Caddyfile

EXPOSE 80

CMD ["sh", "-c", "php-fpm & caddy run --config /etc/caddy/Caddyfile --adapter caddyfile"]
