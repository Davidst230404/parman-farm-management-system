#!/bin/sh

# Change Apache listening port dynamically to match Render's $PORT env variable (default to 80 if not set)
PORT="${PORT:-80}"
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/g" /etc/apache2/sites-available/000-default.conf

# Cache laravel configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Execute CMD
exec "$@"
