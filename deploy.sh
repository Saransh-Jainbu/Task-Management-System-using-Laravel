#!/bin/bash

# Exit on error
set -e

echo "🚀 Starting deployment..."

# Create storage directories
mkdir -p storage/framework/{sessions,views,cache}
mkdir -p storage/logs
chmod -R 775 storage bootstrap/cache

# Clear and optimize
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
echo "🗄️  Running database migrations..."
php artisan migrate --force

echo "✅ Deployment complete!"
