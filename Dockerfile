FROM php:8.2-apache

# Cài PHP extension cần cho Laravel + PostgreSQL
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git curl libpq-dev gnupg \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd

# Cài Node.js LTS cho Vite
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Bật mod_rewrite & chỉnh lại DocumentRoot về public/
RUN a2enmod rewrite
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Sao chép mã nguồn Laravel vào container
COPY . /var/www/html

# Làm việc trong thư mục code
WORKDIR /var/www/html

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Cài npm và build Vite — PHẢI chạy SAU khi copy source
RUN npm install vite@5.2.10 --save-dev
RUN rm -rf public/build
RUN npm run build

# Laravel clear cache (dù lỗi vẫn bỏ qua)
RUN php artisan config:clear || true
RUN php artisan view:clear || true
RUN php artisan cache:clear || true

# Cấp quyền ghi cho Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/build
