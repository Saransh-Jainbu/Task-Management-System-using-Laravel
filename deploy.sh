#!/bin/bash

# Railway Deployment Script
# This script runs automatically on Railway deployment

echo "🚀 Starting Railway deployment..."

# Check if MySQL is available
if [ -z "$MYSQL_URL" ]; then
    echo "❌ ERROR: MySQL database not found!"
    echo "Please add a MySQL database in Railway dashboard:"
    echo "1. Click '+ New' → 'Database' → 'MySQL'"
    echo "2. Railway will auto-link it to your app"
    exit 1
fi

echo "✅ MySQL database detected"

# Install dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Clear caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Run migrations
echo "🗄️  Running database migrations..."
php artisan migrate --force

echo "✅ Deployment complete!"
