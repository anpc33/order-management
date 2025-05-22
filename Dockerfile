FROM php:8.2-apache

# Cài extension PHP cần cho Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git curl libpq-dev gnupg \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd

# Cài Node.js (LTS) cho Vite
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Enable mod_rewrite
RUN a2enmod rewrite

# Set DocumentRoot → /public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Copy toàn bộ project
COPY . /var/www/html

WORKDIR /var/www/html

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --optimize-autoloader --no-dev

# Build Vite
RUN npm install && npm run build

# Set quyền
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
