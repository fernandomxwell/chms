#!/bin/sh
set -e

# Run Laravel optimizations
echo "Caching configuration and routes..."
php artisan optimize

# Run custom setup
php artisan app:setup

# Execute the CMD (starts Octane or PHP-FPM)
# 'exec "$@"' ensures the PHP process becomes PID 1 to handle signals correctly
echo "Starting application..."
exec "$@"