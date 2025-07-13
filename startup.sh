#!/bin/bash
set -e

echo "🚀 Starting Laravel application..."

test_db_connection() {
    php -r "
    try {
        \$pdo = new PDO(
            'mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'),
            getenv('DB_USERNAME'),
            getenv('DB_PASSWORD'),
            [PDO::ATTR_TIMEOUT => 5]
        );
        echo 'Connected successfully';
        exit(0);
    } catch (Exception \$e) {
        echo 'Connection failed: ' . \$e->getMessage();
        exit(1);
    }
    " 2>/dev/null
}

echo "⏳ Waiting for database connection..."
until test_db_connection; do
    echo "Database not ready, waiting 3 seconds..."
    sleep 3
done

echo "✅ Database connection established!"

if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
fi

echo "🔄 Running database migrations..."
php artisan migrate --force --no-interaction

echo "🧹 Clearing and caching configuration..."
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan view:clear
php artisan view:cache

if [ ! -L /var/www/html/public/storage ]; then
    echo "🔗 Creating storage symlink..."
    php artisan storage:link
fi

echo "🔐 Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Seed database (uncomment if you have seeders)
# echo "🌱 Seeding database..."
# php artisan db:seed --force --no-interaction

echo "✅ Laravel application setup complete!"

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/laravel.conf
