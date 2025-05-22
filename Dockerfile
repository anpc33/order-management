FROM php:8.2-apache

# Cài extension Laravel cần + PostgreSQL
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git curl libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy mã nguồn
COPY . /var/www/html

# Trỏ Apache về thư mục public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Bật mod_rewrite
RUN a2enmod rewrite

# Cấp quyền
RUN chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html

# Cài composer production
RUN composer install --no-dev --optimize-autoloader
