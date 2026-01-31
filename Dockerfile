FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composer Install
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Working Directory
WORKDIR /app

# Project file copy
COPY . .

# Dependencies Install
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Permission
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000
