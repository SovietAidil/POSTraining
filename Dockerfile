FROM php:8.2-cli

# Install system dependencies (IMPORTANT: includes libsqlite3-dev)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libsqlite3-dev \
    curl \
    && docker-php-ext-install pdo pdo_sqlite zip gd

# Install Node.js (for npm)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Build frontend assets
RUN npm install && npm run build

# Create SQLite database file
RUN mkdir -p /tmp && touch /tmp/database.sqlite

# Expose Render port
EXPOSE 10000

# Start Laravel
CMD php -S 0.0.0.0:10000 -t public
