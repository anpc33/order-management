FROM php:8.2-apache

# Cài PHP extensions cho Laravel + PostgreSQL
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git curl libpq-dev gnupg \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd

# Cài Node.js (bản LTS) để build Vite
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Bật mod_rewrite + chỉnh DocumentRoot về /public
RUN a2enmod rewrite
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Copy source code
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Cài composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --optimize-autoloader --no-dev

# Cài npm dependencies và build Vite
RUN npm install && npm run build

# Xóa cache Laravel cũ nếu có
RUN php artisan config:clear && php artisan view:clear && php artisan cache:clear

# Cấp quyền cho storage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
