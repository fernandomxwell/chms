# Production Stage
FROM php:8.2-fpm-alpine AS builder

WORKDIR /var/www/html

RUN apk add --no-cache \
    composer \
    nodejs \
    npm \
    git \
    zip \
    unzip \
    libzip-dev \
    oniguruma-dev \
    mysql-client

RUN docker-php-ext-configure zip && \
    docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql \
    opcache \
    zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --optimize-autoloader --no-dev --no-interaction

RUN npm ci --production && npm run build

# Production Stage
FROM php:8.2-fpm-alpine AS production

WORKDIR /var/www/html

RUN apk add --no-cache \
    libzip \
    oniguruma \
    mysql-client \
    nginx

COPY --from=builder /var/www/html /var/www/html

RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

RUN echo "<?php return ['enabled' => true, 'driver' => 'file', 'path' => '../storage/framework/views'];" > /var/www/html/bootstrap/cache/views.php

COPY nginx.conf /etc/nginx/http.d/default.conf

EXPOSE 8080

CMD ["php-fpm"]