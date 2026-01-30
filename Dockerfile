FROM php:8.2-cli

# System deps
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    npm \
    && docker-php-ext-install pdo pdo_sqlite zip gd

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# PHP + frontend deps
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# SQLite database file
RUN mkdir -p /tmp && touch /tmp/database.sqlite

EXPOSE 10000

# Run migrations once during build
RUN php artisan migrate --force

# Start Laravel
CMD php -S 0.0.0.0:10000 -t public
