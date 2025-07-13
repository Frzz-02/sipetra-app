FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nginx \
    supervisor \
    cron \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    opcache

RUN pecl install redis && docker-php-ext-enable redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --optimize-autoloader --no-dev

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

RUN rm /etc/nginx/sites-available/default
COPY nginx.conf /etc/nginx/sites-available/default

RUN sed -i 's/listen = 127.0.0.1:9000/listen = \/var\/run\/php\/php8.2-fpm.sock/g' /usr/local/etc/php-fpm.d/www.conf && \
    echo "listen.owner = www-data" >> /usr/local/etc/php-fpm.d/www.conf && \
    echo "listen.group = www-data" >> /usr/local/etc/php-fpm.d/www.conf && \
    echo "listen.mode = 0660" >> /usr/local/etc/php-fpm.d/www.conf && \
    mkdir -p /var/run/php

COPY <<EOF /usr/local/etc/php/conf.d/laravel.ini
; Production PHP configuration
memory_limit = 512M
max_execution_time = 300
max_input_vars = 3000
upload_max_filesize = 50M
post_max_size = 50M

; OPcache settings
opcache.enable = 1
opcache.memory_consumption = 128
opcache.interned_strings_buffer = 8
opcache.max_accelerated_files = 4000
opcache.revalidate_freq = 60
opcache.fast_shutdown = 1

; Session configuration
session.cookie_httponly = 1
session.cookie_secure = 1
session.cookie_samesite = "Strict"
EOF

COPY <<EOF /etc/supervisor/conf.d/laravel.conf
[supervisord]
nodaemon=true
user=root
logfile=/var/log/supervisor/supervisord.log
pidfile=/var/run/supervisord.pid

[program:nginx]
command=nginx -g "daemon off;"
autostart=true
autorestart=true
stderr_logfile=/var/log/nginx/error.log
stdout_logfile=/var/log/nginx/access.log

[program:php-fpm]
command=php-fpm -F
autostart=true
autorestart=true
stderr_logfile=/var/log/php-fpm.log
stdout_logfile=/var/log/php-fpm.log

[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/log/worker.log
stopwaitsecs=3600

[program:laravel-scheduler]
command=bash -c "while true; do php /var/www/html/artisan schedule:run --verbose --no-interaction; sleep 60; done"
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=/var/log/scheduler.log
EOF

COPY startup.sh /usr/local/bin/startup.sh

RUN chmod +x /usr/local/bin/startup.sh

RUN mkdir -p /var/log/supervisor /var/log/nginx && \
    touch /var/log/php-fpm.log /var/log/worker.log /var/log/scheduler.log

HEALTHCHECK --interval=30s --timeout=10s --start-period=60s --retries=3 \
    CMD curl -f http://localhost/ || exit 1

EXPOSE 80

CMD ["/usr/local/bin/startup.sh"]
