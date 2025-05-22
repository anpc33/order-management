FROM php:8.2-apache

# Cài PHP extensions cho Laravel + PostgreSQL
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git curl libpq-dev gnupg \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd

# Cài Node.js (bản LTS) để build Vite
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Enable mod_rewrite + chỉnh DocumentRoot về public/
RUN a2enmod rewrite
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Copy source code vào container
COPY . /var/www/html

# Làm việc trong thư mục code Laravel
WORKDIR /var/www/html

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Cài npm dependencies và build Vite
RUN npm install && npm run build

# Dọn cache Laravel (bỏ lỗi nếu không có DB)
RUN php artisan config:clear || true
RUN php artisan view:clear || true
RUN php artisan cache:clear || true

# Cấp quyền ghi cho Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
