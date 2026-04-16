# Stage 1: Composer dependencies only
FROM php:8.4-alpine AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN apk add --no-cache git unzip libzip-dev \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Stage 2: Final Production Image
FROM php:8.4-alpine
WORKDIR /var/www/html

# Install PHP extensions
RUN apk add --no-cache libpng-dev libzip-dev icu-dev oniguruma-dev \
    && curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions -o /usr/local/bin/install-php-extensions \
    && chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions pdo_mysql mbstring zip exif pcntl bcmath gd intl opcache redis swoole

# Copy vendor from Stage 1
COPY --chown=www-data:www-data --from=vendor /app/vendor ./vendor
# Copy application code
COPY --chown=www-data:www-data . .

# Finalize Laravel
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer dump-autoload --optimize --no-dev --classmap-authoritative --no-scripts \
    && php artisan storage:link \
    && chown -R www-data:www-data storage bootstrap/cache public/storage \
    && chmod -R 775 storage bootstrap/cache

# Copy the entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Switch to the non-root user
USER www-data

# Define the entrypoint
ENTRYPOINT ["docker-entrypoint.sh"]

CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=0.0.0.0", "--port=8000"]