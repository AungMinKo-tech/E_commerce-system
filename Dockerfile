FROM php:8.2-cli

# လိုအပ်တဲ့ system dependencies များ
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip

# Node.js install လုပ်ခြင်း
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# PHP Extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# PHP Dependencies install လုပ်ခြင်း
RUN composer install --no-interaction --optimize-autoloader --no-dev

# NPM install လုပ်ပြီး Assets build ဆွဲခြင်း
RUN npm install && npm run build

RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
