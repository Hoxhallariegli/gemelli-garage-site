#!/bin/bash
# Gemelli Garage Production Deployment Pipeline

echo "🚀 Starting Gemelli Garage production deployment..."

git pull origin main

php artisan migrate --force
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan queue:restart

echo "✅ Deployment completed successfully!"
